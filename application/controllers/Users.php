<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users extends CI_Controller{
			private $page_name='Users';
			private $tabel='users';
			private $limit=1;
			private $redirect='users/';
			private $primary='id';
			private $controller='users';
			private $view='users';
			private $textbox=array('id','username','password','name');
			
			
			
		public function __construct(){
			parent::__construct();			
			
		}
		
		public function index($offset=0){
			if($this->myci->is_user_logged_in()){
				$data['_page_title'] = 'Users';
				$this->myci->display_adm('theme/users',$data);
			}
		}
		
		public function add(){
			$data=$this->myci->post($this->textbox);
			//---------------------------------------------
			
			$data['readonly']='';
			$data['show']='form';
			$data['tombol']='Save';
			$data['action']=$this->controller.'/insert';
			$this->myci->display_adm($this->view,$data);
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
			$data['readonly']='readonly';
			$data['show']='form';
			$data['tombol']='Update';
			$data['action']=$this->controller.'/run_update/'.$id;
			$this->myci->display_adm($this->controller,$data);
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
			$data['add']=anchor($this->controller.'/add','Add',array('class'=>'button'));
			$data['import']=anchor($this->controller.'/import','Import',array('class'=>'button'));
			$field='username,password,name';
			$query=$this->db->query("select id,$field from ".$this->tabel." limit $offset , ".$this->limit);
			
			$data['page']=$this->myci->page($this->tabel,$this->limit,$this->controller,4);
			$data['show']='data';
			$data['tabel']=$this->myci->table_admin($query,$field,$field,$this->controller,$this->primary);
			//$this->load->view('bidang',$data);
			$this->myci->display_adm($this->view,$data);
		}
		
	
	}
?>
