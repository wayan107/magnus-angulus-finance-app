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
			$currency = 'payment_currency';
			$field = 'paid_amount';
			$where = 'pay_date';
			$paid_status = 1;
		}elseif($type=='on'){
			$currency = 'currency';
			$field = 'amount';
			$where = 'date';
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
									from fn_payment_plan
									WHERE EXTRACT(MONTH FROM '.$where.')="'.date('m').'" AND paid="'.$paid_status.'"');
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
}