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
			$data['inquiryanddeal'] = $this->inquiryanddeal();
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
		if(empty($_POST['year'])){
			$year = date('Y');
		}else{
			$year = $_POST['year'];
		}
		$query = $this->db->query('
					SELECT (CASE EXTRACT(MONTH FROM inquiry_date)
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
						WHERE EXTRACT(YEAR FROM inquiry_date) = "'.$year.'"
						GROUP BY month
						ORDER BY EXTRACT(MONTH FROM inquiry_date)
				');
		
		if($return)
			return json_encode($query->result_array());
		else
			echo json_encode($query->result_array());
	}
	
	function inquiryanddeal(){
		$month = (int) date('m');
		$query = $this->db->query('
					SELECT
						(
							SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM deal_date)="'.$month.'"
						) as deal,
						(
							SELECT count(id) from fn_deals where sales_agent=ag.id and EXTRACT(MONTH FROM inquiry_date)="'.$month.'"
						) as inquiry,
						ag.name as agent
					FROM fn_agent ag
					WHERE occupation="Sales Agent" or occupation="Sales manager"
				');
		return json_encode($query->result_array());
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
}