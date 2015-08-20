<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	private $usd_rate;
	private $eur_rate;
	private $aud_rate;
	
	public function __construct(){
		parent::__construct();
		$this->usd_rate = $this->myci->get_currency_rate('USD','IDR',1);
		$this->eur_rate = $this->myci->get_currency_rate('EUR','IDR',1);
		$this->aud_rate = $this->myci->get_currency_rate('AUD','IDR',1);
	}
	
	public function index()
	{
		if($this->myci->is_user_logged_in()){
			$data['_page_title'] = 'Dashboard';
			$data['fee'] = $this->_get_total_income();
			$data['money_in'] = $this->money('in');
			$data['money_on_going'] = $this->money('on');
			$data['datasales'] = $this->get_sales_graph_data(true);
			$data['datainquiry'] = $this->get_inquiry_graph_data(true);
			$data['inquiryanddeal'] = $this->inquiryanddeal(true);
			$data['popularareadata'] = $this->getpopularareadata();
			$data['dealrate'] = $this->dealrate(true);
			$this->myci->display_adm('theme/dashboard',$data);
			
		}
	}
	
	private function _get_total_income(){

		$query = $this->db->query('SELECT FORMAT(SUM(
									CASE
										WHEN consult_fee_currency="USD" THEN consult_fee*'.$this->usd_rate.'
										WHEN consult_fee_currency="EUR" THEN consult_fee*'.$this->eur_rate.'
										WHEN consult_fee_currency="AUD" THEN consult_fee*'.$this->aud_rate.'
										ELSE consult_fee
									END
									),0) as consult_fee
									from fn_deals
									WHERE EXTRACT(MONTH FROM deal_date)="'.date('m').'"');
		return $query->row();
	}
	
	private function _get_total_amount_deal(){
		$query = $this->db->query('SELECT FORMAT(SUM(
									CASE
										WHEN deal_price_currency="USD" THEN deal_price*'.$this->usd_rate.'
										WHEN deal_price_currency="EUR" THEN deal_price*'.$this->eur_rate.'
										WHEN deal_price_currency="AUD" THEN deal_price*'.$this->aud_rate.'
										ELSE deal_price
									END
									),0) as deal_price
									from fn_deals
									WHERE EXTRACT(MONTH FROM deal_date)="'.date('m').'"');
		return $query->row();
	}
	
	private function money($type){
		if($type=='in'){
			$currency = 'pp.payment_currency';
			$field = 'pp.paid_amount';
			$where = 'AND EXTRACT(MONTH FROM pp.pay_date)="'.date('m').'"';
			$paid_status = 1;
		}elseif($type=='on'){
			$currency = 'pp.currency';
			$field = 'pp.amount';
			$where = '';
			$paid_status = 0;
		}
		
		$query = $this->db->query('SELECT FORMAT(SUM(
									CASE
										WHEN '.$currency.'="USD" THEN '.$field.'*'.$this->usd_rate.'
										WHEN '.$currency.'="EUR" THEN '.$field.'*'.$this->eur_rate.'
										WHEN '.$currency.'="AUD" THEN '.$field.'*'.$this->aud_rate.'
										ELSE '.$field.'
									END
									),0) as amount
									from fn_payment_plan pp
									WHERE pp.paid="'.$paid_status.'" AND pp.type="fee" '.$where);
		$row = $query->row();
		return $row->amount;
	}
	
	function get_sales_graph_data($return=false){
		if(empty($_POST['year'])){
			$year = date('Y');
		}else{
			$year = $_POST['year'];
		}
		$query = $this->db->query('
					SELECT (CASE EXTRACT(MONTH FROM deal_date)
								WHEN 1 THEN "Jan"
								WHEN 2 THEN "Feb"
								WHEN 3 THEN "Mar"
								WHEN 4 THEN "Apr"
								WHEN 5 THEN "May"
								WHEN 6 THEN "June"
								WHEN 7 THEN "July"
								WHEN 8 THEN "Aug"
								WHEN 9 THEN "Sept"
								WHEN 10 THEN "Oct"
								WHEN 11 THEN "Nov"
								WHEN 12 THEN "Dec"
							END
							) as month,
							SUM(
							CASE
								WHEN consult_fee_currency="USD" THEN consult_fee*'.$this->usd_rate.'
								WHEN consult_fee_currency="EUR" THEN consult_fee*'.$this->eur_rate.'
								WHEN consult_fee_currency="AUD" THEN consult_fee*'.$this->aud_rate.'
								ELSE consult_fee
							END
							) as income, COUNT(id) as sales
						FROM fn_deals
						WHERE EXTRACT(YEAR FROM deal_date) = "'.$year.'"
						GROUP BY month
						ORDER BY EXTRACT(MONTH FROM deal_date)
				');
		
		if($return)
			return json_encode($query->result_array());
		else
			echo json_encode($query->result_array());
	}
	
	function get_inquiry_graph_data($return=false){
		if(empty($_POST['period'])){
			$period = 'day';
		}else{
			$period = $_POST['period'];
		}
		
		if(!empty($_POST['from']) && !empty($_POST['to'])){
			$today = new DateTime($_POST['to']. ' 00:00:00');
			$today = $today->format('Y-m-d');
			
			$last_month = new DateTime($_POST['from']. ' 00:00:00');
			$last_month = $last_month->format('Y-m-d');
		}else{
			$date = new DateTime();
			$today = $date->format('Y-m-d');
			$date->modify('last month');
			$last_month = $date->format('Y-m-d');
		}
		$sql='';
		
		if($period=='day'){
			$sql='SELECT inquiry_date as month, COUNT(id) as inquiry
					FROM fn_deals
					WHERE inquiry_date between "'.$last_month.'" and "'.$today.'"
					GROUP BY inquiry_date
					ORDER BY inquiry_date ASC';
					
		}elseif($period=='week'){
			$weeks = $this->getWeeks($last_month,$today);
			$sql_array = array();
			foreach($weeks as $week){
				$sql_array[] ='SELECT "'.$week[0].' - '.$week[1].'" as month, COUNT(id) as inquiry
								FROM fn_deals
								WHERE inquiry_date between "'.$week[0].'" and "'.$week[1].'"';
			}
			$sql = implode(' UNION ',$sql_array);
			$sql .= ' GROUP BY month';
		}else{
			$sql = 'SELECT (CASE EXTRACT(MONTH FROM inquiry_date)
								WHEN 1 THEN "Jan"
								WHEN 2 THEN "Feb"
								WHEN 3 THEN "Mar"
								WHEN 4 THEN "Apr"
								WHEN 5 THEN "May"
								WHEN 6 THEN "June"
								WHEN 7 THEN "July"
								WHEN 8 THEN "Aug"
								WHEN 9 THEN "Sept"
								WHEN 10 THEN "Oct"
								WHEN 11 THEN "Nov"
								WHEN 12 THEN "Dec"
							END
							) as month,
							COUNT(id) as inquiry
						FROM fn_deals
						WHERE inquiry_date between "'.$last_month.'" and "'.$today.'"
						GROUP BY month
						ORDER BY EXTRACT(MONTH FROM inquiry_date)';
		}
		$query = $this->db->query($sql);
		
		if($return)
			return json_encode($query->result_array());
		else
			echo json_encode($query->result_array());
	}
	
	function getWeeks($start_date,$end_date){
		$weeks = array();
		$end_date1 = date('Y-m-d', strtotime($end_date.' + 6 days'));
		for($date = $start_date; $date <= $end_date1; $date = date('Y-m-d', strtotime($date. ' + 7 days'))){
			//echo getWeekDates($date, $start_date, $end_date);
			
			$week =  date('W', strtotime($date));
			$year =  date('Y', strtotime($date));
			$from = date("Y-m-d", strtotime("{$year}-W{$week}+0")); //Returns the date of monday in week
			if($from < $start_date) $from = $start_date;
			$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
			if($to > $end_date) $to = $end_date;
			$weeks[]=array($from,$to);
		}
		
		return $weeks;
	}
	
	function inquiryanddeal($return=false){
		$month = (empty($_POST['month'])) ? (int)date('m') : $_POST['month'];
		$year = (empty($_POST['year'])) ? (int)date('Y') : $_POST['year'];
		
		$query = $this->db->query('
					SELECT
						(
							SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'" and (post_status="Deal" or post_status="Finalized Deal")
						) as deal,
						(
							SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'"
						) as inquiry,
						(
							SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'" and post_status="Inspection"
						) as inspection,
						ag.name as agent
					FROM fn_agent ag
					WHERE (occupation="Sales Agent" or occupation="Sales manager") and ag.id<>13
				');
				
		$return_data=array();
		foreach($query->result_array() as $q){
			$return_data['agent'][]=$q['agent'];
			$return_data['deal'][]=(int)$q['deal'];
			$return_data['inquiry'][]=(int)$q['inquiry'];
			$return_data['inspection'][]=(int)$q['inspection'];
		}
		
		if($return)
			return json_encode($return_data);
		else
			echo json_encode($return_data);
	}
	
	function dealrate($return=false){
		$month = (empty($_POST['month'])) ? (int)date('m') : $_POST['month'];
		$year = (empty($_POST['year'])) ? (int)date('Y') : $_POST['year'];
		
		$query = $this->db->query('
			SELECT
				(
					SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'" and (post_status="Deal" or post_status="Finalized Deal")
				) as deal,
				(
					SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'"
				) as inquiry,
				(
					SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'" and EXTRACT(YEAR FROM inquiry_date)="'.$year.'" and post_status="Inspection"
				) as inspection,
				ag.name as agent
			FROM fn_agent ag
			WHERE (occupation="Sales Agent" or occupation="Sales manager") and ag.id<>13
			ORDER BY deal DESC, inquiry ASC
		');
		
		$return_data = array();
		foreach($query->result_array() as $q){
			$return_data['agent'][] = $q['agent'];
			$return_data['dealrate'][] = (!empty($q['inquiry']) && !empty($q['deal'])) ? (int)$q['inquiry']/(int)$q['deal']*100 : 0;
		}
		
		if($return)
			return json_encode($return_data);
		else
			echo json_encode($return_data);
	}
	
	public function openincomedetails(){
		$month = date('m');
		$query = $this->db->query('
					SELECT d.deal_date, CONCAT(consult_fee_currency," ",CAST(FORMAT(consult_fee,0) as CHAR)) as consult_fee,
							a.name as agent,c.name as client,o.name as owner, d.rental_type, d.rental_duration
					FROM fn_deals d
					INNER JOIN fn_client c on c.id=d.client
					INNER JOIN fn_owner o on o.id=d.owner
					INNER JOIN fn_agent a on a.id=d.sales_agent
					WHERE EXTRACT(MONTH FROM d.deal_date) = "'.$month.'"
				');
		$data['query']=$query->result_array();
		$this->load->view('theme/incomedetails',$data);
	}
	
	public function openmoneyindetails($type){
		$month = date('m');
		if($type){
			$where = ' and EXTRACT(MONTH FROM pp.pay_date) = "'.$month.'"';
		}
		$query = $this->db->query('
					SELECT pp.pay_date, pp.date, CONCAT(payment_currency," ",CAST(FORMAT(paid_amount,0) as CHAR)) as paid_amount,
							CONCAT(currency," ",CAST(FORMAT(amount,0) as CHAR)) as amount,
							a.name as agent,c.name as client,o.name as owner
					FROM fn_payment_plan pp
					INNER JOIN fn_deals d on d.id=pp.deal_id
					INNER JOIN fn_client c on c.id=d.client
					INNER JOIN fn_owner o on o.id=d.owner
					INNER JOIN fn_agent a on a.id=d.sales_agent
					WHERE pp.paid="'.$type.'" and pp.type="fee"'. $where);
		$data['query']=$query->result_array();
		$data['type'] = $type;
		$this->load->view('theme/moneyindetails',$data);
	}
	
	function getpopularareadata(){
		$month = date('m');
		$query = $this->db->query('
							SELECT COUNT(pa.area_code) as data, a.name as area
							FROM fn_areas_prefer pa
							INNER JOIN fn_deals d on d.id=pa.deal_id
							INNER JOIN fn_area a on a.prefix=pa.area_code
							WHERE EXTRACT(MONTH FROM d.inquiry_date) = "'.$month.'"
							GROUP BY pa.area_code
						');
		$dataReturn = array();
		foreach($query->result_array() as $d){
			$dataReturn[] = array(
								'label'	=> $d['area'],
								'data'	=> (int)$d['data']
							);
		}
		
		return json_encode($dataReturn);
	}
}