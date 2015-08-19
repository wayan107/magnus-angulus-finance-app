<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inquiries extends CI_Controller{
		private $page_name='Inquiries';
		private $tabel;
		private $limit=10;
		private $redirect='inquiries';
		private $primary='id';
		private $controller='inquiries';
		private $view='inquiries';
		private $textbox=array('id','inquiry_date','client','budget','plan','plan_move_in','plan_move_out','bedroom',
								'furnishing','living','interested_villa','inquiry_msg','hold');
		private $rental_budget, $sale_budget;
		
	public function __construct(){
		parent::__construct();
		$this->tabel=$this->db->dbprefix('deals');
		$this->load->model('dealsmodel');
		$this->load->model('area');
		$this->config->load('inquiry_config');
		
		$this->rental_budget = array(
									'1'	=> 'IDR 0 - 100M',
									'2'	=> 'IDR 100M - 200M',
									'3'	=> 'IDR 200M - 300M',
									'4'	=> 'IDR 300M+'
								);
		
		$this->sale_budget = array(
									'1'	=> 'USD 0 - 250K',
									'2'	=> 'USD 250K - 500K',
									'3'	=> 'USD 500K - 750K',
									'4'	=> 'USD 750K - 1000K',
									'5'	=> 'USD 1000K+'
								);
		
		$this->monthly_budget = array(
									'1'	=> 'IDR 0 - 10M',
									'2'	=> 'IDR 10 - 20M',
									'3'	=> 'IDR 20 - 30M',
									'4'	=> 'IDR 30 - 40M',
									'5'	=> 'IDR 40 - 50M',
									'6'	=> 'IDR 50M+'
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
		
		if($data['plan']==1){
			$data['living'] = 0;
		}else{
			$data['hold'] = 0;
		}
		
		$date = new DateTime($data['plan_move_in'].' 00:00:00');
		$data['plan_move_in'] = $date->format('Y-m-d');
		if(!empty($data['plan_move_out'])){
			$date = new DateTime($data['plan_move_out'].' 00:00:00');
			$data['plan_move_out'] = $date->format('Y-m-d');
		}else{
			$data['plan_move_out'] = '0000-00-00';
		}
		
		$data['budget'] = (!empty($data['budget'])) ? implode(',',$data['budget']) : '';
		$data['bedroom'] = (!empty($data['bedroom'])) ? implode(',',$data['bedroom']) : '';
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
		$data['budget'] = explode(',',$data['budget']);
		$data['bedroom'] = explode(',',$data['bedroom']);
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
		$data['budget'] = implode(',',$data['budget']);
		$data['bedroom'] = implode(',',$data['bedroom']);
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
		$field='inquiry_date,plan_move_in,ag.name as agent,post_status,ag.id as agent_id,
				(CASE
					WHEN plan="0" THEN "Rent"
					WHEN plan="1" THEN "Buy"
					WHEN plan="2" THEN "Monthly"
				END) as plan';
		$data['_page_title'] = $this->page_name;
		$inquiry_status = $this->config->item('inquiry');
		
		$where='where 1=1 and inquiry_date<>"0000-00-00"';
		$export_params ='?go=1';
		
		//limit the sales agent view
		if($this->myci->user_role=='sales'){
			$q = $this->db->query('SELECT relatedaccount from fn_users where username="'.$this->myci->get_user_logged_in().'"');
			$q = $q->row();
			$where .= ' and sales_agent="'.$q->relatedaccount.'"';
		}
			
		if(!empty($_POST['filter'])){
			if(!empty($_POST['agent']) && $this->myci->user_role=='sales_manager'){
				$where .= " and sales_agent='".$_POST['agent']."'";
				$export_params .= '&agent='.$_POST['agent'];
			}
			
			if($_POST['date-start'] && $_POST['date-end']){
				$date_start=new DateTime($_POST['date-start'] .' 00:00:00');
				$date_end=new DateTime($_POST['date-end'] .' 00:00:00');
				$where .=' and inquiry_date between CAST("'.$date_start->format('Y-m-d').'" as DATE) and CAST("'.$date_end->format('Y-m-d').'" as DATE)';
				$export_params .= '&datestart='.$date_start->format('Y-m-d').'&dateend='.$date_end->format('Y-m-d');
			}
			
			if(!empty($_POST['status'])){
				if($this->input->post('status')=='Deal'){
					$where .= ' and (post_status="'.$this->input->post('status').'" or post_status="Finalized Deal")';
					$export_params .= '&post_status='.$this->input->post('status');
				}else{
					$where .= ' and post_status="'.$this->input->post('status').'"';
					$export_params .= '&post_status='.$this->input->post('status');
				}
			}
			
			if(!empty($_POST['s'])){
				$where .= ' and c.name like "%'.$_POST['s'].'%"';
			}
		}
		
		$select = "select fn_deals.id,$field,c.name as client_name,c.id as client_id";
		$sql = " from ".$this->tabel."
				inner join fn_client c on c.id=fn_deals.client
				left join fn_agent ag on ag.id=fn_deals.sales_agent
				$where";
								
		$query=$this->db->query($select.$sql."
								order by inquiry_date DESC,fn_deals.id DESC
								limit $offset , ".$this->limit);
								
		$q_page = $this->db->query('select count(fn_deals.id) as total_rows'.$sql);
		$q_page = $q_page->row();
		
		$table_header='Inquiry Date,Client,Plan,Plan Move in,Assigned To,Last Status';
		$field='inquiry_date,client_name,plan,plan_move_in,agent,post_status';
		
		$data['page']=$this->myci->page2($q_page->total_rows,$this->limit,$this->controller,3);
		$data['show']='data';
		$data['tabel']=$this->myci->table_inquiry($query,$field,$table_header,$this->controller,$this->primary,true);
		$data['export_params'] = $export_params;
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function viewdetail($id){
		$data['query']=$this->db->query('select d.inquiry_date,d.budget,d.plan,d.plan_move_in,plan_move_out,d.bedroom,
											d.furnishing,d.living,c.name as client_name,ag.name as agent,
											d.post_status,d.lost_case,d.hold,d.interested_villa,d.inquiry_msg
											
											from fn_deals d
											inner join fn_client c on c.id=d.client
											left join fn_agent ag on ag.id=d.sales_agent
											where d.id="'.$id.'"');
		$data['rental_budget'] = $this->rental_budget;
		$data['sale_budget'] = $this->sale_budget;
		$data['rental_budget'] = $this->rental_budget;
		$data['monthly_budget'] = $this->monthly_budget;
		$data['areas'] = $this->area->get_area_basedon_inquiry($id,true);
		$this->load->view('theme/inquiries-view-detail',$data);
	}
	
	public function get_budget(){
		if($_POST['type']=='0'){
			echo form_dropdown('budget[]',$this->rental_budget,'','class="form-control" id="budget" multiple="multiple"');
		}elseif($_POST['type']=='1'){
			echo form_dropdown('budget[]',$this->sale_budget,'','class="form-control" id="budget" multiple="multiple"');
		}else{
			echo form_dropdown('budget[]',$this->monthly_budget,'','class="form-control" id="budget" multiple="multiple"');
		}
	}
	
	public function get_hold_living(){
		if($_POST['type']=='1'){
			echo '<label>Hold: </label>';
			$opts = array(
						'0'	=> 'Any Hold',
						'1'	=> 'Freehold',
						'2'	=> 'Leasehold'
					);
			echo form_dropdown('hold',$opts,'','class="form-control"');
		}else{
			echo '<label>Living: </label>';
			$opts = array(
						'0'	=> 'Any Living',
						'1'	=> 'Open Living',
						'2'	=> 'Close Living'
					);
			echo form_dropdown('living',$opts,'','class="form-control"');
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
		$email_sent = $this->_sendemaillabel($_POST['id']);
		echo $email_sent;
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
	
	private function _sendemaillabel($id){
		$status = false;
		$query = $this->db->query('
								SELECT ag.email as agent_email,cl.email as client_email,cl.name as client,
										d.interested_villa, d.inquiry_msg, d.plan_move_in, d.plan_move_out, d.bedroom, d.furnishing,
										d.living, d.plan,d.budget,d.hold
								FROM fn_deals d
								INNER JOIN fn_agent ag on ag.id=d.sales_agent
								INNER JOIN fn_client cl on cl.id=d.client
								WHERE d.id="'.$id.'"
							');
		if($query->num_rows()>0){
			$q = $query->row();
			$msg = '<p>Name : '.$q->client.'</p>';
			
			$interested_villas = unserialize($q->interested_villa);
			if(!empty($interested_villas['villacode'])){
				if(!empty($interested_villas['villalink'])){
					$villalink='';
					$index=0;
					foreach($interested_villas['villalink'] as $link){
						$villalink .= '<a href="'.$link.'" target="_blank">'.$interested_villas['villacode'][$index].'</a>, ';
					}
				}else{
					$villalink = implode(', ',$interested_villas['villacode']);
				}
				
				$msg .= '<p>Interested Villa : '.substr($villalink,0,strlen($villalink)-2).'</p>';
				if(!empty($interested_villas['price'])){
					$price = (is_array($interested_villas['price'])) ? implode(', ',$interested_villas['price']) : $interested_villas['price'];
					$msg .= '<p>Price :'.$price.'</p>';
				}
			}
			
			$additional_msg = '';
			if(!empty($q->plan_move_in)) $additional_msg .= '<p>Move in date : '.$q->plan_move_in.'</p>';
			if($q->plan_move_out!='0000-00-00') $additional_msg .= '<p>Check-out date : '.$q->plan_move_out.'</p>';
			
			$budgets_list = array();
			$additional_msg .= '<p>Plan : '; 
			if($q->plan=='0' || $q->plan=='2'){
				$additional_msg .= ($q->plan=='0') ? 'Rent</p>' : 'Monthly</p>';
				$budgets_list = ($q->plan=='0') ? $this->rental_budget : $this->monthly_budget;
				$cc = 'info@balilongtermrentals.com';
				
				$additional_msg .= '<p>Living : ';
				switch ($q->living){
					case '1'	: $additional_msg .= 'Open Living';
					break;
					
					case '2'	: $additional_msg .= 'Closed Living';
					break;
					
					default		: $additional_msg .= 'Any Living';
					break;
				}
				$additional_msg .= '</p>';
			}else{
				$additional_msg .= 'Buy</p>';
				$budgets_list = $this->sale_budget;
				$cc = 'info@balivillasales.com';
				$additional_msg .= '<p>Hold : ';
				switch ($q->hold){
					case '1'	: $additional_msg .= 'Freehold';
					break;
					
					case '2'	: $additional_msg .= 'Leasehold';
					break;
					
					default		: $additional_msg .= 'Any Hold';
					break;
				}
				$additional_msg .= '</p>';
			}
			
			if(!empty($q->budget)){
				$budgets = explode(',',$q->budget);
				$additional_msg .= '<p>Budget : ';
				foreach($budgets as $b){
					$additional_msg .= $budgets_list[$b].', ';
				}
				$additional_msg .= '</p>';
			}
			
			if(!empty($q->bedroom)) $additional_msg .= '<p>Bedrooms : '.$q->bedroom.'</p>';
			
			$additional_msg .= '<p>Furnishing : ';
			switch ($q->furnishing){
				case '1'	: $additional_msg .= 'Furnished';
				break;
				
				case '2'	: $additional_msg .= 'Semi-Furnished';
				break;
				
				case '3'	: $additional_msg .= 'Unfurnished';
				break;
				
				default		: $additional_msg .= 'Any Furnishing';
				break;
			}
			$additional_msg .= '</p>';
			
			$preferable_areas = $this->area->get_area_basedon_inquiry($id,true);
			if(!empty($preferable_areas)) $additional_msg .= '<p>Preferable Areas : '.implode(', ',$preferable_areas).'</p>';
			
			if(!empty($additional_msg)) $msg .= '<br><p><strong>Additional Information :</strong></p>'.$additional_msg;
			
			if(!empty($q->inquiry_msg)){
				$msg .= '<br><p><strong>Prospect Message :</strong></p>';
				$msg .= '<p>'.$q->inquiry_msg.'</p>';
			}
			
			// Mail it
			$to = $q->agent_email;
			$subject = 'New Inquiry';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			// Additional headers
			$headers .= 'From: '.$q->client.' <'.$q->client_email.'>' . "\r\n";
			$headers .= 'Cc: '.$cc. "\r\n";
			$status = mail($to, $subject, $msg, $headers);
		}
		return $status;
	}
	
	public function insertcurl(){
		$data=$this->myci->post($this->textbox);
		
		$inquiry_date = new DateTime('now',new DateTimeZone('Asia/Makassar'));
		$data['inquiry_date'] = $inquiry_date->format('Y-m-d');
		
		$date = new DateTime($data['plan_move_in'].' 00:00:00');
		$data['plan_move_in'] = $date->format('Y-m-d');
		
		if($data['plan_move_out']!='0000-00-00'){
			$date = new DateTime($data['plan_move_out'].' 00:00:00');
			$data['plan_move_out'] = $date->format('Y-m-d');
		}
		
		$data['post_status'] = 'Prospect';
		if($data['plan']=='2'){
			$data['rental_type'] = 1;
		}
		$data['interested_villa'] = stripslashes($data['interested_villa']);
		$client_data['name'] = $data['client'];
		$client_data['email'] = $_POST['email'];
		$client_data['phone'] = $_POST['phone'];
		$client_id = $this->_add_new_client($client_data);
		$data['client'] = $client_id;
		
		$deal_id = $this->mydb->insert($this->tabel,$data);
		$this->_save_area_curl($deal_id);
		return 'success';
		//echo"<script>alert('Data Saved Successfully'); window.location='".base_url().$this->redirect."'</script>";
	}
	
	private function _save_area_curl($deal_id){
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
		$interested_villa = array('price'=>'','villalink'=>'','villacode'=>explode(',',$interested_villa));
		$interested_villa = serialize($interested_villa);
		
		return $interested_villa;
	}
	
	private function _add_new_client($data){
		$q = $this->db->query('select id from fn_client where name="'.$data['name'].'"');
		if($q->num_rows()>0){
			$q = $q->row();
			return $q->id;
		}else{
			$this->db->insert('client',$data);
			return $this->db->insert_id();
		}
	}
	
	public function export(){
		$where = ' WHERE 1=1';
		$header = 'Sales Report';
		
		if(!empty($_GET['agent'])){
			$where .= " and sales_agent='".$_GET['agent']."'";
		}
		
		$date_field = 'inquiry_date';
		if(!empty($_GET['post_status'])){
			if($_GET['post_status']=='Deal'){
				$where .= ' and (post_status="'.$_GET['post_status'].'" or post_status="Finalized Deal")';
				$date_field = 'deal_date';
			}else{
				$where .= ' and post_status="'.$_GET['post_status'].'"';
			}
		}
		
		if(!empty($_GET['datestart']) && !empty($_GET['dateend'])){
			$where .=' and '.$date_field.' between CAST("'.$_GET['datestart'].'" as DATE) and CAST("'.$_GET['dateend'].'" as DATE)';
		}
		
		$filename = "Sales Report " . date('Y-m-d') . ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel");
		
		if(!empty($_GET['post_status']) && $_GET['post_status']=='Deal'){
			$this->_export_deals($where);
		}else{
			$this->_export_inquiry($where);
		}
		
		exit();
	}
	
	private function _export_inquiry($where){
		$sql = "select fn_deals.id,inquiry_date,plan,plan_move_in,ag.name as sales_agent,
				post_status,budget,c.name as client_name
				from ".$this->tabel."
				inner join fn_client c on c.id=fn_deals.client
				left join fn_agent ag on ag.id=fn_deals.sales_agent
				$where
				order by inquiry_date DESC, fn_deals.id DESC";
		$query = $this->db->query($sql);
		$no=1;
		$tab = "\t";
		$new_line="\r\n";
		echo 'No'.$tab.'Inquiry Date'.$tab.'Client Name'.$tab.'Plan'.$tab.'Plan Move In'.$tab.'Budget'.$tab.'Preferable Areas'.$tab.'Status'.$tab.'Sales Agent'.$new_line;
		foreach($query->result_array() as $q){
			if($q['plan']=='0'){
				$plan = 'Rent';
				$budget_list = $this->rental_budget;
			}else{
				$plan = 'Buy';
				$budget_list = $this->sale_budget;
			}
			
			$areas = $this->area->get_area_basedon_inquiry($q['id'],true);
			
			if(!empty($q['budget'])){
				$budgets = explode(',',$q['budget']);
				$budget = '';
				foreach($budgets as $b){
					$budget .= $budget_list[$b].', ';
				}
			}else{
				$budget = '';
			}
			
			
			echo $no . $tab.
				$q['inquiry_date'] .$tab.
				$q['client_name'] .$tab.
				$plan .$tab.
				$q['plan_move_in'] .$tab.
				substr($budget,0,strlen($budget)-2) .$tab.
				implode(', ',$areas) .$tab.
				$q['post_status'] .$tab.
				$q['sales_agent'];
				
				echo $new_line;
			$no++;
		}
	}
	
	private function _export_deals($where){
		$sql = "select fn_deals.id,deal_date,plan,plan_move_in,
				agl.name as listing_agent,ag.name as sales_agent,
				post_status,c.name as client_name,villa_code,
				CONCAT(consult_fee_currency,' ',CAST(FORMAT(consult_fee,0) as CHAR)) as consult_fee,
				CONCAT(deal_price_currency,CAST(FORMAT(deal_price,0) as CHAR)) as price,
				GROUP_CONCAT(DISTINCT CONCAT(pp.currency,CAST(FORMAT(pp.amount,0) as CHAR)) ORDER BY pp.date ASC SEPARATOR ' ') as incomming_fee,
				GROUP_CONCAT(pp.date ORDER BY pp.date ASC SEPARATOR ' ') as incomming_fee_date
				
				from ".$this->tabel."
				left join fn_client c on c.id=fn_deals.client
				left join fn_agent ag on ag.id=fn_deals.sales_agent
				left join fn_agent agl on agl.id=fn_deals.listing_agent
				left join fn_payment_plan pp on (pp.deal_id=fn_deals.id and pp.type='fee' and EXTRACT(MONTH FROM pp.date)='".date('m')."')
				$where
				GROUP BY fn_deals.id
				order by deal_date DESC";
		$query = $this->db->query($sql);
		$no=1;
		$tab = "\t";
		$new_line="\r\n";
		echo 'No'.$tab.'Deal Date'.$tab.'Client Name'.$tab.'Plan'.$tab.'Villa Code'.$tab.'Price'.$tab.'Consult Fee'.$tab.'Money that will in this month'.$tab.'Plan money in'.$tab.'Status'.$tab.'Sales Agent'.$tab.'Listing Agent'.$new_line;
		foreach($query->result_array() as $q){
			if($q['plan']=='0'){
				$plan = 'Rent';
			}else{
				$plan = 'Buy';
			}
			
			echo $no . $tab.
				$q['deal_date'] .$tab.
				$q['client_name'] .$tab.
				$plan .$tab.
				$q['villa_code'] .$tab.
				$q['price'] .$tab.
				$q['consult_fee'] .$tab.
				$q['incomming_fee'] .$tab.
				$q['incomming_fee_date'] .$tab.
				$q['post_status'] .$tab.
				$q['sales_agent'].$tab.
				$q['listing_agent'].$tab;
				
				echo $new_line;
			$no++;
		}
	}
}
?>
