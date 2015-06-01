<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deals extends CI_Controller{
		private $page_name='Deals';
		private $tabel;
		private $limit=10;
		private $redirect='deals';
		private $primary='id';
		private $controller='deals';
		private $view='deals';
		private $textbox=array('id','villa_code','client','owner','checkin_date','checkout_date','deal_date',
								'deal_price','deal_price_currency','consult_fee','consult_fee_currency','area',
								'deposit','deposit_currency','deposit_in','contract_number','sales_agent','listing_agent',
								'date_created','remark');
		
	public function __construct(){
		parent::__construct();
		$this->tabel=$this->db->dbprefix('deals');
		$this->load->model('dealsmodel');
	}
	
	public function index($offset=0){
		if($this->myci->is_user_logged_in()){
			$this->_view($offset);
		}
	}
	
	public function add(){
		$data=$this->myci->post($this->textbox);
		$data['deal_plan_amount'] = '';
		$data['deal_plan_currency'] = '';
		$data['deal_plan_date'] = '';
		$data['fee_plan_amount'] = '';
		$data['fee_plan_currency'] = '';
		$data['fee_plan_date'] = '';
		//---------------------------------------------
		$data['is_payment_complete'] = false;
		$data['_page_title'] = $this->page_name;
		$data['readonly']='';
		$data['show']='form';
		$data['tombol']='Save';
		$data['action']=$this->controller.'/insert';
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function insert(){
		$data=$this->myci->post($this->textbox);
		$data['date_created']=date('Y-m-d');
		
		$date=new DateTime($data['checkin_date'].' 00:00:00');
		$data['checkin_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['checkout_date'].' 00:00:00');
		$data['checkout_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['deal_date'].' 00:00:00');
		$data['deal_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['deposit_in'].' 00:00:00');
		$data['deposit_in']=$date->format('Y-m-d');
		
		$deal_id = $this->mydb->insert($this->tabel,$data);
		$this->_save_payment_plans($deal_id);

		echo"<script>alert('Data Saved Successfully'); window.location='".base_url().$this->redirect."'</script>";
	}
	
	public function update($id){
		$query=$this->mydb->get_where($this->tabel,$this->primary,$id);
		$jum=count($this->textbox);
		foreach($query->result_array() as $dts){
			for($i=0;$i<$jum;$i++){
				$data[$this->textbox[$i]]=$dts[$this->textbox[$i]];
			}	
		}
		
		$query_deal_plan = $this->db->get_where('fn_payment_plan',array('deal_id'=>$id,'type'=>'deal'));
		if($query_deal_plan->num_rows()>0){
			$row = $query_deal_plan->row();
			$data['deal_plan_payment_id'] = $row->id;
			$data['deal_plan_amount'] = $row->amount;
			$data['deal_plan_currency'] = $row->currency;
			$data['deal_plan_date'] = $row->date;
			$data['deal_plan_ref_number'] = $row->ref_number;
			$data['deal_plan_paid'] = $row->paid;
		}
		$data['deal_payment_plan_query'] = $query_deal_plan->result_array();
		
		$query_fee_plan = $this->db->get_where('fn_payment_plan',array('deal_id'=>$id,'type'=>'fee'));
		if($query_fee_plan->num_rows()>0){
			$row = $query_fee_plan->row();
			$data['fee_plan_payment_id'] = $row->id;
			$data['fee_plan_amount'] = $row->amount;
			$data['fee_plan_currency'] = $row->currency;
			$data['fee_plan_date'] = $row->date;
			$data['fee_plan_ref_number'] = $row->ref_number;
			$data['fee_plan_paid'] = $row->paid;
		}
		$data['fee_payment_plan_query'] = $query_fee_plan->result_array();
		
		$data['is_payment_complete'] = $this->_is_payment_complete($id);
		$data['_page_title'] = $this->page_name;
		$data['readonly']='readonly';
		$data['show']='form';
		$data['tombol']='Update';
		$data['action']=$this->controller.'/run_update/'.$id;
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function run_update($id){
		$data=$this->myci->post($this->textbox);
		$data['id']=$id;
		$date=new DateTime($data['checkin_date'].' 00:00:00');
		$data['checkin_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['checkout_date'].' 00:00:00');
		$data['checkout_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['deal_date'].' 00:00:00');
		$data['deal_date']=$date->format('Y-m-d');
		
		$date=new DateTime($data['deposit_in'].' 00:00:00');
		$data['deposit_in']=$date->format('Y-m-d');
		
		$this->mydb->update($this->tabel,$data,$this->primary,$id);
		$this->_save_payment_plans($id);
		echo"<script>alert('Data Updated Successfully'); window.location='".base_url().$this->redirect."'</script>";
	}
	
	public function delete($id){
		$this->mydb->delete($this->tabel,$this->primary,$id);
		$this->_delete_payment_plans($id);
		redirect($this->redirect);
	}
	
	public function _view($offset=0){
		$data['add']=anchor($this->controller.'/add','Add New',array('class'=>'btn btn-primary'));
		$field='deal_date,villa_code,contract_number,CONCAT(deal_price_currency," ",CAST(FORMAT(deal_price,0) as CHAR)) as deal_amount';
		$data['_page_title'] = $this->page_name;
		$where='where 1=1';
		if(!empty($_POST['filter'])){
			if($_POST['area']){
				$where .= " and area='".$_POST['area']."'";
			}
			
			if($_POST['date-start'] && $_POST['date-end']){
				$date_start=new DateTime($_POST['date-start'] .' 00:00:00');
				$date_end=new DateTime($_POST['date-end'] .' 00:00:00');
				$where .=' and deal_date between CAST("'.$date_start->format('Y-m-d').'" as DATE) and CAST("'.$date_end->format('Y-m-d').'" as DATE)';
			}
			
			if(!empty($_POST['search'])){
				$s=$_POST['search'];
				$where .= ' and (c.name like "%'.$s.'%" or villa_code like "%'.$s.'%" or contract_number like "%'.$s.'%")';
			}
		}
		
		$query=$this->db->query("select fn_deals.id,$field,c.name as client_name
								from ".$this->tabel."
								inner join fn_client c on c.id=fn_deals.client
								$where
								order by deal_date DESC
								limit $offset , ".$this->limit);
		$table_header='Deal Date,Villa Code,Contract Number,Client,Deal Amount';
		$field='deal_date,villa_code,contract_number,client_name,deal_amount';
		$data['page']=$this->myci->page($this->tabel,$this->limit,$this->controller,3);
		$data['show']='data';
		$data['tabel']=$this->myci->table_admin($query,$field,$table_header,$this->controller,$this->primary,true);
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	private function _save_payment_plans($deal_id){
		$deal_payment_plan = $this->myci->post(array('deal_plan_amount','deal_plan_date','deal_plan_currency','deal_plan_paid','deal_plan_ref_number','deal_plan_payment_id'));
		$fee_payment_plan = $this->myci->post(array('fee_plan_amount','fee_plan_date','fee_plan_currency','fee_plan_paid','fee_plan_ref_number','fee_plan_payment_id'));

		$payment_plans=array();
		$pp_deal=1;
		$pp_fee=1;
		for($i=0; $i < count($deal_payment_plan['deal_plan_amount']); $i++){
			if($deal_payment_plan['deal_plan_payment_id'][$i]=='null'){
				$date=new DateTime($deal_payment_plan['deal_plan_date'][$i].' 00:00:00');
				$payment_plans_new[]=array(
									'amount'	=> $deal_payment_plan['deal_plan_amount'][$i],
									'date'		=> $date->format('Y-m-d'),
									'type'		=> 'deal',
									'deal_id'	=> $deal_id,
									'currency'	=> $deal_payment_plan['deal_plan_currency'][$i],
									'ref_number'=> ($pp_deal<10) ? '0'.$pp_deal : $pp_deal,
									'paid'		=> (!empty($deal_payment_plan['deal_plan_paid'][$i])) ? $deal_payment_plan['deal_plan_paid'][$i] : '0'
								);
			}else{
				$date=new DateTime($deal_payment_plan['deal_plan_date'][$i].' 00:00:00');
				$payment_plans[]=array(
									'id'		=> $deal_payment_plan['deal_plan_payment_id'][$i],
									'amount'	=> $deal_payment_plan['deal_plan_amount'][$i],
									'date'		=> $date->format('Y-m-d'),
									'currency'	=> $deal_payment_plan['deal_plan_currency'][$i],
								);
			}
			$pp_deal++;
			
			if(!empty($fee_payment_plan['fee_plan_amount'][$i])){
				if($fee_payment_plan['fee_plan_payment_id'][$i]=='null'){
					$date=new DateTime($fee_payment_plan['fee_plan_date'][$i].' 00:00:00');
					$payment_plans_new[]=array(
										'amount'	=> $fee_payment_plan['fee_plan_amount'][$i],
										'date'		=> $date->format('Y-m-d'),
										'type'		=> 'fee',
										'deal_id'	=> $deal_id,
										'currency'	=> $fee_payment_plan['fee_plan_currency'][$i],
										'ref_number'=> ($pp_fee<10) ? '0'.$pp_fee : $pp_fee,
										'paid'		=> (!empty($fee_payment_plan['fee_plan_paid'][$i])) ? $fee_payment_plan['fee_plan_paid'][$i] : '0'
									);
				}else{
					$payment_plans[]=array(
									'id'		=> $fee_payment_plan['fee_plan_payment_id'][$i],
									'amount'	=> $fee_payment_plan['fee_plan_amount'][$i],
									'date'		=> $date->format('Y-m-d'),
									'currency'	=> $fee_payment_plan['fee_plan_currency'][$i],
								);
				}
			}
			$pp_fee++;
		}
		
		if(!empty($payment_plans_new)) $this->db->insert_batch('payment_plan',$payment_plans_new);
		if(!empty($payment_plans)) $this->db->update_batch('payment_plan',$payment_plans,'id');
	}
	
	private function _delete_payment_plans($deal_id){
		$this->mydb->delete('payment_plan','deal_id',$deal_id);
	}
	
	public function delete_payment_plan(){
		$this->mydb->delete('payment_plan','id',$_POST['id']);
	}
	
	public function viewdetail($id){
		$data['query']=$this->db->query('select d.*,c.name as client_name,o.name as owner_name,s.name as sales,l.name as listing,a.name as area_name
											from fn_deals d
											left join fn_client c on c.id=d.client
											left join fn_owner o on o.id=d.owner
											left join fn_area a on a.id=d.area
											left join fn_agent s on (s.id=d.sales_agent and s.occupation="Sales Agent")
											left join fn_agent l on (l.id=d.listing_agent and l.occupation="Listing Agent")
											where d.id="'.$id.'"');
		$data['deal_payment_plan']=$this->db->query('select * from fn_payment_plan where deal_id="'.$id.'" and type="deal"');
		$data['fee_payment_plan']=$this->db->query('select * from fn_payment_plan where deal_id="'.$id.'" and type="fee"');
		$data['is_payment_complete'] = $this->_is_payment_complete($id);
		$this->load->view('theme/deal-view-detail',$data);
	}
	
	private function _is_payment_complete($id){
		$query = $this->db->query('select count(id) as unpaid from fn_payment_plan where deal_id="'.$id.'" and paid="0" and type="fee"');
		$row = $query->row();
		if($row->unpaid>0)
			return false;
		
		return true;
	}
}
?>
