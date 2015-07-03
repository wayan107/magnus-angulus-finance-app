<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inquiries extends CI_Controller{
		private $page_name='Inquiries';
		private $tabel;
		private $limit=10;
		private $redirect='inquiries';
		private $primary='id';
		private $controller='inquiries';
		private $view='inquiries';
		private $textbox=array('id','inquiry_date','client','budget','plan','plan_move_in','bedroom',
								'furnishing','living','interested_villa','inquiry_msg');
		private $rental_budget, $sale_budget;
		
	public function __construct(){
		parent::__construct();
		$this->tabel=$this->db->dbprefix('deals');
		$this->load->model('dealsmodel');
		$this->load->model('area');
		$this->config->load('inquiry_config');
		
		$this->rental_budget = array(
									''	=> 'Choose',
									'1'	=> 'IDR 0 - IDR 100 M',
									'2'	=> 'IDR 100 - IDR 200 M',
									'3'	=> 'IDR 200 - IDR 300 M',
									'4'	=> 'IDR 300+ M'
								);
		
		$this->sale_budget = array(
									''	=> 'Choose',
									'1'	=> 'USD 0 - USD 250 K',
									'2'	=> 'USD 250 - USD 500 K',
									'3'	=> 'USD 500 - USD 750 K',
									'4'	=> 'USD 750 - USD 1000 K',
									'5'	=> 'USD 1000+ K'
								);
	}
	
	public function index($offset=0){
		if($this->myci->is_user_logged_in()){
			$this->_view($offset);
		}
	}
	
	public function add(){
		$data=$this->myci->post($this->textbox);
		
		//---------------------------------------------
		//$data['is_payment_complete'] = false;
		$data['_page_title'] = $this->page_name;
		$data['readonly']='';
		$data['show']='form';
		$data['tombol']='Save';
		$data['initial_budget']=$this->rental_budget;
		$data['action']=$this->controller.'/insert';
		$data['cancel']=base_url().$this->controller;
		$data['areas_prefer'] = array();
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function insert(){
		$data=$this->myci->post($this->textbox);
		
		$date = new DateTime($data['inquiry_date'].' 00:00:00');
		$data['inquiry_date'] = $date->format('Y-m-d');
		
		$date = new DateTime($data['plan_move_in'].' 00:00:00');
		$data['plan_move_in'] = $date->format('Y-m-d');
		
		$data['post_status'] = 'Prospect';
		$data['interested_villa'] = $this->_format_interested_villa();
		$deal_id = $this->mydb->insert($this->tabel,$data);
		$this->_save_area($deal_id);
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
		
		//$data['is_payment_complete'] = $this->_is_payment_complete($id);
		$data['_page_title'] = $this->page_name;
		$data['readonly']='readonly';
		$data['show']='form';
		$data['tombol']='Update';
		$data['action']=$this->controller.'/run_update/'.$id;
		$data['cancel']=base_url().$this->controller;
		$data['areas_prefer'] = $this->area->get_area_basedon_inquiry($id);
		if($data['plan']=='0'){
			$data['initial_budget']=$this->rental_budget;
		}else{
			$data['initial_budget']=$this->sale_budget;
		}
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function run_update($id){
		$data=$this->myci->post($this->textbox);
		$data['id']=$id;
		$date = new DateTime($data['inquiry_date'].' 00:00:00');
		$data['inquiry_date'] = $date->format('Y-m-d');
		
		$date = new DateTime($data['plan_move_in'].' 00:00:00');
		$data['plan_move_in'] = $date->format('Y-m-d');
		
		$data['interested_villa'] = $this->_format_interested_villa();
		$this->mydb->update($this->tabel,$data,$this->primary,$id);
		$this->_delete_area($id);
		$this->_save_area($id);
		echo"<script>alert('Data Updated Successfully'); window.location='".base_url().$this->redirect."'</script>";
	}
	
	public function delete($id){
		$this->_delete_area($id);
		$this->mydb->delete($this->tabel,$this->primary,$id);
		
		redirect($this->redirect);
	}
	
	private function _view($offset=0){
		$data['add']=($this->myci->user_role=='sales_manager') ? anchor($this->controller.'/add','Add New',array('class'=>'btn btn-primary')) : '';
		$data['filter_class'] = ($this->myci->user_role=='sales_manager') ? 'pull-right' : '';
		$field='inquiry_date,(if(plan=0,"Rent","Buy")) as plan,plan_move_in,ag.name as agent,post_status';
		$data['_page_title'] = $this->page_name;
		$inquiry_status = $this->config->item('inquiry');
		$where='where post_status IN ("'.implode('","',$inquiry_status).'") and 1=1';
		if(!empty($_POST['filter'])){
			if($_POST['agent']){
				$where .= " and sales_agent='".$_POST['agent']."'";
			}
			
			if($_POST['date-start'] && $_POST['date-end']){
				$date_start=new DateTime($_POST['date-start'] .' 00:00:00');
				$date_end=new DateTime($_POST['date-end'] .' 00:00:00');
				$where .=' and inquiry_date between CAST("'.$date_start->format('Y-m-d').'" as DATE) and CAST("'.$date_end->format('Y-m-d').'" as DATE)';
			}
		}
		
		$query=$this->db->query("select fn_deals.id,$field,c.name as client_name
								from ".$this->tabel."
								inner join fn_client c on c.id=fn_deals.client
								left join fn_agent ag on ag.id=fn_deals.sales_agent
								$where
								order by inquiry_date DESC
								limit $offset , ".$this->limit);
		$table_header='Inquiry Date,Client,Plan,Plan Move in,Assigned To,Last Status';
		$field='inquiry_date,client_name,plan,plan_move_in,agent,post_status';
		$data['page']=$this->myci->page($this->tabel,$this->limit,$this->controller,4);
		$data['show']='data';
		$data['tabel']=$this->myci->table_inquiry($query,$field,$table_header,$this->controller,$this->primary,true);
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function viewdetail($id){
		$data['query']=$this->db->query('select d.inquiry_date,d.budget,d.plan,d.plan_move_in,d.bedroom,d.furnishing,d.living,c.name as client_name,ag.name as agent
											from fn_deals d
											inner join fn_client c on c.id=d.client
											left join fn_agent ag on ag.id=d.sales_agent
											where d.id="'.$id.'"');
		$data['rental_budget'] = $this->rental_budget;
		$data['sale_budget'] = $this->sale_budget;
		$data['areas'] = $this->area->get_area_basedon_inquiry($id,true);
		$this->load->view('theme/inquiries-view-detail',$data);
	}
	
	public function get_budget(){
		if($_POST['type']=='0'){
			echo form_dropdown('budget',$this->rental_budget,'','class="form-control" required');
		}else{
			echo form_dropdown('budget',$this->sale_budget,'','class="form-control" required');
		}
	}
	
	private function _save_area($deal_id){
		$areas = $this->input->post('area');
		if(!empty($areas)){
			$data = array();
			foreach($areas as $area){
				$data[]=array(
							'area_code' => $area,
							'deal_id'	=> $deal_id
						);
			}
			$this->db->insert_batch('areas_prefer',$data);
		}
	}
	
	private function _delete_area($deal_id){
		$this->db->delete('areas_prefer',array('deal_id'=>$deal_id));
	}
	
	public function assign($id){
		$data['id']=$id;
		$data['action']=base_url().'inquiries/saveassign';
		$this->load->view('theme/assign-inquiry',$data);
	}
	
	public function saveassign(){
		$data['sales_agent'] = $_POST['agent'];
		$this->db->update('deals',$data,array('id'=>$_POST['id']));
		echo 1;
	}
	
	public function setstatus($id){
		$data['id']=$id;
		$data['action']=base_url().'inquiries/savestatus';
		$data['status'] = $this->config->item('status_dropdown_list');
		$data['lost_case'] = $this->config->item('lost_cases');
		$this->load->view('theme/setstatus-inquiry',$data);
	}
	
	public function savestatus(){
		$data['post_status'] = $_POST['status'];
		if(!empty($_POST['lost_case'])){ $data['lost_case'] = $_POST['lost_case'];}
		if(!empty($_POST['dealdate'])){
			$deal_date = new DateTime($_POST['dealdate'] . ' 00:00:00');
			$data['deal_date'] = $deal_date->format('Y-m-d');
			$data['lost_case'] = '';
		}
		$this->db->update('deals',$data,array('id'=>$_POST['id']));
		echo 1;
	}
	
	public function sendemaillabel($id){
		
	}
	
	public function insertcurl(){
		$data=$this->myci->post($this->textbox);
		
		//$date = date('Y-m-d');//new DateTime($data['inquiry_date'].' 00:00:00');
		$data['inquiry_date'] = date('Y-m-d');//$date->format('Y-m-d');
		
		$date = new DateTime($data['plan_move_in'].' 00:00:00');
		$data['plan_move_in'] = $date->format('Y-m-d');
		
		$data['post_status'] = 'Prospect';
		$data['inquiry_msg'] = 
		$deal_id = $this->mydb->insert($this->tabel,$data);
		$this->_save_area_curl($deal_id);
		echo"<script>alert('Data Saved Successfully'); window.location='".base_url().$this->redirect."'</script>";
	}
	
	private function _save_area_curl($id){
		$areas = json_decode(stripslashes($this->input->post('area')));
		if(!empty($areas)){
			$data = array();
			foreach($areas as $area){
				$data[]=array(
							'area_code' => $area,
							'deal_id'	=> $deal_id
						);
			}
			$this->db->insert_batch('areas_prefer',$data);
		}
	}
	
	private function _format_interested_villa(){
		$interested_villa = $this->input->post('interested_villa');
		$interested_villa = array('price'=>'','villalink' => explode(',',$interested_villa));
		$interested_villa = serialize($interested_villa);
		
		return $interested_villa;
	}
}
?>
