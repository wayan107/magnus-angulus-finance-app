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
			$data['deal'] = $this->_get_number_of_deals();
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
	
	private function _get_number_of_deals(){
		$query = $this->db->query('SELECT COUNT(id) as total from fn_deals WHERE EXTRACT(MONTH FROM deal_date)="'.date('m').'"');
		return $query->row();
	}
}
