<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agent extends CI_Controller{
		private $page_name='Agent';
		private $tabel='fn_agent';
		private $limit=10;
		private $redirect='agent/';
		private $primary='id';
		private $controller='agent';
		private $view='agent';
		private $textbox=array('id','name','phone','email','commission','occupation');
		
	public function __construct(){
		parent::__construct();		
	}
	
	public function index($offset=0){
		if($this->myci->is_user_logged_in()){
			$this->_view($offset);
		}
	}
	
	public function add(){
		$data=$this->myci->post($this->textbox);
		//---------------------------------------------
		$data['_page_title'] = $this->page_name;
		$data['readonly']='';
		$data['show']='form';
		$data['tombol']='Save';
		$data['action']=$this->controller.'/insert';
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function insert(){
		$data=$this->myci->post($this->textbox);
		$this->mydb->insert($this->tabel,$data);
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
		$this->mydb->update($this->tabel,$data,$this->primary,$id);
		redirect($this->redirect);
	}
	
	public function delete($id){
		$this->mydb->delete($this->tabel,$this->primary,$id);
		redirect($this->redirect);
	}
	
	public function _view($offset=0){
		$data['add']=anchor($this->controller.'/add','Add New',array('class'=>'btn btn-primary'));
		$field='name,phone,email,commission,occupation';
		$data['_page_title'] = $this->page_name;
		$query=$this->db->query("select id,$field from ".$this->tabel." limit $offset , ".$this->limit);
		
		$column_header='name,phone,email,commission (%),occupation';
		$data['page']=$this->myci->page($this->tabel,$this->limit,$this->controller,3);
		$data['show']='data';
		$data['tabel']=$this->myci->table_admin($query,$field,$column_header,$this->controller,$this->primary);
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
}
?>
