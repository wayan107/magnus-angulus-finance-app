<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Moneyin extends CI_Controller{
			private $page_name='Find The Money';
			private $limit=10;
			private $controller='moneyin';
			private $view='moneyin';
			private $textbox=array('id','name','prefix');
			
		public function __construct(){
			parent::__construct();
		}
		
		public function index($offset=0){
			if($this->myci->is_user_logged_in()){
				$this->_view($offset);
			}
		}
		
		public function _view($offset=0){
			$data['_page_title'] = $this->page_name;
			$data['show']='filter';
			$this->myci->display_adm('theme/'.$this->view,$data);
		}
		
		public function generate(){
			$start=new DateTime($_POST['start'].' 00:00:00');
			$start=$start->format('Y-m-d');
			
			$end=new DateTime($_POST['end'].' 00:00:00');
			$end=$end->format('Y-m-d');
			
			if($_POST['type']=='2'){
				$select='d.villa_code,c.name as client_name,o.name as owner_name,CONCAT(d.deal_price_currency," ",CAST(FORMAT(d.deal_price,0) as CHAR)) as deal_amount,CONCAT(d.consult_fee_currency," ",CAST(FORMAT(d.consult_fee,0) as CHAR)) as consult_fee,';
				$select.="(SELECT GROUP_CONCAT(pp.pay_date SEPARATOR '<br>') AS date from fn_payment_plan pp where pp.deal_id=d.id and type='fee' and paid='1') as fee_date_in,
						(SELECT GROUP_CONCAT(CONCAT(pp.payment_currency,' ',CAST(FORMAT(pp.paid_amount,0)as CHAR)) SEPARATOR '<br>') as fee_amount from fn_payment_plan pp where pp.deal_id=d.id and type='fee' and paid='1') as fee_amount_in,";
				$select.="CONCAT(d.deposit_currency,' ',CAST(FORMAT(d.deposit,0) as CHAR)) as deposit,deposit_in,d.deal_date";
				$table_header='Villa Code,Client,Owner,Price,Comm,Date Comm in,Amount,Deposit,Date Deposit in,Deal Date';
				$field='villa_code,client_name,owner_name,deal_amount,consult_fee,fee_date_in,fee_amount_in,deposit,deposit_in,deal_date';
				$innerjoin='inner join fn_payment_plan payplan on (payplan.deal_id=d.id and payplan.paid="1")';
				$where="where payplan.pay_date between '$start' and '$end'";
			}elseif($_POST['type']=='1'){
				$select='d.villa_code,c.name as client_name,o.name as owner_name,d.deal_date,CONCAT(d.checkin_date," - ",d.checkout_date) as duration,';
				$select.="(SELECT GROUP_CONCAT(CONCAT(pp.currency,' ',CAST(FORMAT(pp.amount,0) as CHAR)) SEPARATOR '<br>') as fee_amount from fn_payment_plan pp where pp.deal_id=d.id and type='deal') as fee_amount_in,";
				$select.="CONCAT(d.deal_price_currency,' ',CAST(FORMAT(d.deal_price,0) as CHAR)) as deal_amount,CONCAT(d.consult_fee_currency,' ',CAST(FORMAT(d.consult_fee,0) as CHAR)) as consult_fee,a.name as agent,d.remark";
				$table_header='Villa Code,Client,Owner,Deal Date,Duration,Payment Plan,Price,Comm,Agent,Remark';
				$field='villa_code,client_name,owner_name,deal_date,duration,fee_amount_in,deal_amount,consult_fee,agent,remark';
				$innerjoin='left join fn_agent a on a.id=d.sales_agent';
				$where="where d.deal_date between '$start' and '$end' GROUP BY d.id";
			}elseif($_POST['type']=='3'){ 
				$field='villa_code,client_name,owner_name,deal_date,remain_payment,consult_fee,agent';
				$select='d.villa_code,c.name as client_name,o.name as owner_name,d.deal_date,
						CONCAT(pp.currency," ",CAST(
						FORMAT(
							SUM(
								pp.amount
							),0) as CHAR)) as remain_payment,
						CONCAT(d.consult_fee_currency," ",CAST(FORMAT(d.consult_fee,0) as CHAR)) as consult_fee,
						a.name as agent';
				
				$table_header = 'Villa Code,Client,Owner,Deal Date,Remain Unpaid Comm,Comm,Agent';
				$innerjoin = 'left join fn_agent a on a.id=d.sales_agent
							INNER JOIN fn_payment_plan pp on (pp.deal_id=d.id and pp.paid=0 and type="fee")';
				$where="where d.deal_date between '$start' and '$end'
						group by d.id";
			}
			
			$query=$this->db->query("select distinct $select
								from fn_deals d
								left join fn_client c on c.id=d.client
								left join fn_owner o on o.id=d.owner
								$innerjoin
								$where
								order by d.deal_date DESC
								");
			
			$data=$this->myci->table($query,$field,$table_header);
			setcookie('exportdata',serialize($query->result_array()),0,'/');
			setcookie('exportheader',$table_header,0,'/');
			echo $data;
			echo "<div class='col-sm-12 text-right'><a href='".base_url()."moneyin/exportexcel/' target='_blank' class='btn btn-primary'>Export</a></div>";
		}
		
		public function exportexcel(){
			$exportdata=unserialize($_COOKIE['exportdata']);
			$header=str_replace(',',"\t",$_COOKIE['exportheader']);

			$filename = "website_data_" . date('Ymd') . ".xls";

			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: application/vnd.ms-excel");
			
			echo "\r\n".$header. "\r\n"; //implode("\t", $header) . "\r\n";
			foreach($exportdata as $row){
				array_walk($row, array($this,'_cleanData'));
				$baris = implode("\t", array_values($row));
				$baris = str_replace('<br>',", ",$baris);
				echo $baris. "\r\n";
			}
			exit();
		}
		
		private function _cleanData(&$str)
		{
			$str = preg_replace("/\t/", "\\t", $str);
			$str = preg_replace("/\r?\n/", "\\n", $str);
			if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
		}
	}
?>
