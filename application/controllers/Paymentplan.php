<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Paymentplan extends CI_Controller{
			private $page_name='Payment Plan';
			private $tabel='fn_payment_plan';
			private $limit=10;
			private $controller='paymentplan';
			private $view='paymentplan';
			private $primary='id';
			
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
			$where='where p.type="fee"';
			
			if(!empty($_POST['find'])){
				if(!empty($_POST['s']))
				$where .= ' and (d.villa_code like "%'.$_POST['s'].'%" or d.contract_number like "%'.$_POST['s'].'%")';
			
				if(!empty($_POST['date-start']) && !empty($_POST['date-end'])){
					$date_start=new DateTime($_POST['date-start'].' 00:00:00');
					$date_start=$date_start->format('Y-m-d');
					
					$date_end=new DateTime($_POST['date-end'].' 00:00:00');
					$date_end=$date_end->format('Y-m-d');
					
					$where .= ' and p.date between "'.$date_start.'" and "'.$date_end.'"';
				}
				
				if($_POST['paid']!=''){
					$where .= ' and p.paid='.$_POST['paid'];
				}
			}
			
			$field='d.deal_date,d.villa_code,CONCAT(d.contract_number,"-",p.ref_number) as contract_number,CONCAT(p.currency," ",CAST(FORMAT(p.amount,0) as CHAR)) as ppamount, p.date,p.paid';
			$query=$this->db->query('select p.id,'.$field.',d.post_status
									from fn_payment_plan p
									inner join fn_deals d on d.id=p.deal_id
									'.$where.'
									order by paid ASC, date ASC
									limit '.$offset.' , '.$this->limit);

			$query_paging=$this->db->query('select COUNT(p.id) as num
									from fn_payment_plan p
									inner join fn_deals d on d.id=p.deal_id
									'.$where);
			$query_paging=$query_paging->row();
			$total_page=$query_paging->num;
			$table_header='Deal Date,Villa Code,Contract Number,Amount,Due Date';
			$field='deal_date,villa_code,contract_number,ppamount,date';
			$data['page']=$this->myci->page2($total_page,$this->limit,$this->controller,3);
			$data['tabel']=$this->myci->table_active($query,$field,$table_header,$this->controller,$this->primary,'paid','Payment Status');
			$this->myci->display_adm('theme/'.$this->view,$data);
		}
		
		public function update($data,$id){
			//$data['paid']=$data['status'];
			$this->mydb->update($this->tabel,$data,$this->primary,$id);
		}
		public function activate(){
			$date=new DateTime($this->input->post('pay_date'). ' 00:00:00');
			$data['paid_amount']=$this->input->post('paid_amount');
			$data['payment_currency']=$this->input->post('currency');
			$data['pay_date']=$date->format('Y-m-d');
			$data['payment_via']=$this->input->post('payment_via');
			$data['paid']=1;
			$id=$this->input->post('id');
			$this->update($data,$id);
		}
		
		public function deactivate($id){
			$data['paid']=0;
			$this->update($data,$id);
		}
		
		public function viewdetail($id){
			$this->db->select('paid_amount,payment_currency,pay_date,payment_via');
			$query=$this->db->get_where('fn_payment_plan',array('id'=>$id));
			$data['row']=$query->row();
			$this->load->view('theme/paymentplan-paid-details',$data);
		}
		
		public function opensetform($id){
			$query = $this->db->query('select amount,currency,date from fn_payment_plan where id="'.$id.'"');
			$this->load->view('theme/paymentplan-set-paid',array('id'=>$id,'row'=>$query->row()));
		}
		
		public function generateinvoice($id){
			
			$query=$this->db->query('SELECT ow.name as owner,ow.email,pp.date,c.name as client,CONCAT(d.contract_number,"-",pp.ref_number) as ref_number,
									CONCAT(d.checkin_date," until ",d.checkout_date) as period,d.villa_code,
									CONCAT(d.consult_fee_currency," ",CAST(FORMAT(d.consult_fee,0) as CHAR)) as consult_fee,
									CONCAT(d.deal_price_currency," ",CAST(FORMAT(d.deal_price,0) as CHAR)) as deal_price
									
									FROM fn_payment_plan pp
									INNER JOIN fn_deals d on d.id=pp.deal_id
									INNER JOIN fn_owner ow on ow.id=d.owner
									INNER JOIN fn_client c on c.id=d.client
									
									WHERE pp.id="'.$id.'"');
			$data['query'] = $query->row();
			$html=$this->load->view('theme/invoice',$data,true);
			$this->load->library('dompdfgenerator');
			$this->dompdfgenerator->generate($html,'invoice-'.str_replace('/','-',$data['query']->ref_number)); 
		}
	}
?>