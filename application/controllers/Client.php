<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Client extends CI_Controller{
		private $page_name='Client';
		private $tabel='fn_client';
		private $limit=10;
		private $redirect='client/';
		private $primary='id';
		private $controller='client';
		private $view='client';
		private $textbox=array('id','name','phone','email');
		
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
	
	public function ajax_insert(){
		$data=$this->myci->post($this->textbox);
		$id = $this->mydb->insert($this->tabel,$data);
		if(!empty($id)){
			echo $id;
		}else{
			echo 'Something went wrong when saving the data. Please try again or reload the page.';
		}
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
		$where = 'where 1=1';
		if(!empty($_POST['filter'])){
			$where .= ' and (name like "%'.$_POST['s'].'%" or email like "%'.$_POST['s'].'%")';
		}
		
		$field='name,phone,email';
		$data['_page_title'] = $this->page_name;
		$sql = "select id,$field from ".$this->tabel." ".$where;
		$query=$this->db->query($sql." order by name asc limit $offset , ".$this->limit);
		
		$page_query = $this->db->query($sql);
		$data['page']=$this->myci->page2($page_query->num_rows(),$this->limit,$this->controller,3);
		$data['show']='data';
		$data['tabel']=$this->myci->table_admin($query,$field,$field,$this->controller,$this->primary);
		$this->myci->display_adm('theme/'.$this->view,$data);
	}
	
	public function details($id){
		$query = $this->db->query('
							SELECT name,phone,email FROM fn_client WHERE id="'.$id.'"
						');
		$this->load->view('theme/client-detail',array('query'=>$query));
	}
}
?>
