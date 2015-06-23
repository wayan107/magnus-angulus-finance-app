<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Agentcommission extends CI_Controller{
			private $page_name='Agent Commission';
			private $limit=10;
			private $controller='agentcommission';
			private $view='agentcommision';
			private $textbox=array('id','name','prefix');
			private $primary='id';
			//private $table = 'agent_commission';
			
		public function __construct(){
			parent::__construct();
			$this->load->model('dealsmodel');
		}
		
		public function index($offset=0){
			if($this->myci->is_user_logged_in()){
				$this->_view($offset);
			}
		}
		
		public function _view($offset=0){
			$data['_page_title'] = $this->page_name;
			$where ='where 1=1';
			$agent = '';
			
			//limit the sales agent view
			if($this->myci->user_role=='sales'){
				$q = $this->db->query('SELECT relatedaccount from fn_users where username="'.$this->myci->get_user_logged_in().'"');
				$q = $q->row();
				$where .= ' and ag.id="'.$q->relatedaccount.'"';
			}
			
			if(!empty($_POST['find'])){
				if(!empty($_POST['date-start']) && !empty($_POST['date-end'])){
					$date_start=new DateTime($_POST['date-start'].' 00:00:00');
					$date_start=$date_start->format('Y-m-d');
					
					$date_end=new DateTime($_POST['date-end'].' 00:00:00');
					$date_end=$date_end->format('Y-m-d');
					$where .= ' and d.deal_date between "'.$date_start.'" and "'.$date_end.'"';
				}
				
				if($_POST['paid']!=''){
					$where .= ' and ac.paid="'.$_POST['paid'].'"';
				}
				
				if($this->myci->user_role!='sales'){
					if($_POST['agent']!=''){
						$agent = ' and ag.id="'.$_POST['agent'].'"';
					}
				}
			}
			
			$usd_rate = $this->myci->get_currency_rate('USD','IDR',1);
			$eur_rate = $this->myci->get_currency_rate('EUR','IDR',1);
			$aud_rate = $this->myci->get_currency_rate('AUD','IDR',1);
			
			$fields = 'd.deal_date,d.villa_code,ag.name as agent,
						ac.paid as comm_paid, ag.id as agent_id,
						ag.occupation as type,ac.id as comm_paid_id, contract_number, ref_number,
						(CASE
							WHEN ac.commission_type="sales agent commission" THEN
								CONCAT(consult_fee_currency," ",CAST(FORMAT((pp.amount*ag.commission/100),0) as CHAR))
							
							WHEN ac.commission_type="listing agent commission" THEN
								case when 
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<99999999 then "IDR 500,000"
										
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<149999999 then "IDR 750,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<299999999 then "IDR 1,000,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<499999999 then "IDR 1,500,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<749999999 then "IDR 2,000,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<999999999 then "IDR 2,500,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<1999999999 then "IDR 3,000,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<2999999999 then "IDR 4,000,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<3999999999 then "IDR 5,000,000"
											
									when
										(case
											when d.deal_price_currency="USD" then d.deal_price*'.$usd_rate.'
											when d.deal_price_currency="EUR" then d.deal_price*'.$eur_rate.'
											when d.deal_price_currency="AUD" then d.deal_price*'.$aud_rate.'
											else d.deal_price
										end)<4999999999 then "IDR 6,000,000"
											
									else "IDR 7.000.000" end
							
							WHEN ac.commission_type="sales manager commission" THEN
								CONCAT(consult_fee_currency," ",CAST(FORMAT((pp.amount*5/100),0) as CHAR))
						END) as comm_amount
						';

			$query = $this->db->query('SELECT d.id,ac.id as ac_id,
							'.$fields.'
							from fn_agent_commission ac
							inner join fn_deals d on ac.deal_id=d.id
							inner join fn_agent ag on ag.id=ac.agent
							left join fn_payment_plan pp on (pp.deal_id=ac.deal_id and ac.pp_ref=pp.ref_number and pp.type="fee")
							'.$where.$agent.'
							group by ac.id
							limit '.$offset.' , '.$this->limit.'
						');
			
			$query_paging = $this->db->query('SELECT ac.id
							from fn_agent_commission ac
							inner join fn_deals d on ac.deal_id=d.id
							inner join fn_agent ag on ag.id=ac.agent
							left join fn_payment_plan pp on (pp.deal_id=ac.deal_id and ac.pp_ref=pp.ref_number and pp.type="fee")
							'.$where.$agent.'
							group by ac.id
						');
						
			$total_page=$query_paging->num_rows();
			$table_header='Deal Date,Villa Code,Contract Number,Agent,Commission';
			$field='deal_date,villa_code,contract_number,agent,comm_amount';
			$data['page']=$this->myci->page2($total_page,$this->limit,$this->controller,3);
			$data['tabel']=$this->myci->table_active2($query,$field,$table_header,$this->controller,$this->primary,'comm_paid','Payment Status');

			$this->myci->display_adm('theme/'.$this->view,$data);
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
		
		public function opensetform(){
			$this->load->view('theme/agentcommission-set-paid',array('rel'=>$_POST['rel'],'data_type'=>$_POST['data-type']));
		}
		
		public function _update_commision_paid_status($data,$id){
			$this->db->update('deals',$data,'id='.$id);
		}
		
		public function activate(){
			$rel=explode('-',$_POST['id']);
			$date=new DateTime($this->input->post('pay_date'). ' 00:00:00');
			$data['amount_paid']=$this->input->post('paid_amount');
			$data['currency']=$this->input->post('currency');
			$data['pay_date']=$date->format('Y-m-d');
			$data['payment_via']=$this->input->post('payment_via');
			$data['paid']=1;
			
			$this->_set_commision_payment_status($rel[0],$data);
		}
		
		public function deactivate(){
			$rel=explode('-',$_POST['rel']);
			$data['amount_paid']=0;
			$data['currency']='';
			$data['pay_date']='';
			$data['payment_via']='';
			$data['paid']=0;
			
			$this->_set_commision_payment_status($rel[0],$data);
		}
		
		public function viewdetail($id){
			$query=$this->db->query('select ac.pay_date,ac.payment_via,
									CONCAT (ac.currency," ",CAST(FORMAT(ac.amount_paid,0) AS CHAR)) as amount_paid,
									CONCAT(d.consult_fee_currency," ",CAST(FORMAT(d.consult_fee,0) as CHAR)) as fee_amount, CONCAT(d.deal_price_currency," ",CAST(FORMAT(d.deal_price,0) as CHAR)) as deal_amount
									from fn_agent_commission ac
									left join fn_deals d on d.id=ac.deal_id
									where ac.id="'.$id.'"');
			$data['row']=$query->row();
			$this->load->view('theme/agentcommission-paid-details',$data);
		}
		
		private function _set_commision_payment_status($ac_id,$data){
			$this->db->update('fn_agent_commission',$data,array('id'=>$ac_id));
		}
		
		public function delete($id){
			$this->db->delete('fn_agent_commission',array('id'=>$id));
			redirect($this->controller);
		}
	}
?>
