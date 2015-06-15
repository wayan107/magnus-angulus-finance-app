<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Users extends CI_Controller{
		private $page_name='Users';
		private $tabel='fn_users';
		private $limit=10;
		private $redirect='users/';
		private $primary='id';
		private $controller='users';
		private $view='theme/users';
		private $textbox=array('id','username','password','display_name','email','role');

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
			
			$data['readonly']='';
			$data['show']='form';
			$data['tombol']='Save';
			$data['_page_title'] = 'Add New User';
			$data['action']=$this->controller.'/insert';
			$this->myci->display_adm($this->view,$data);
		}
		
		public function insert(){
			$data=$this->myci->post($this->textbox);
			if($this->is_email_exist($data['email'])){
				echo"<script>alert('The email you enter is exist'); window.history.back();</script>";
				exit();
			}
			$data['password'] = md5($data['password']);
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
			$data['_page_title'] = 'Update User';
			$data['action']=$this->controller.'/run_update/'.$id;
			$this->myci->display_adm($this->view,$data);
		}
		
		public function run_update($id){
			$data=$this->myci->post($this->textbox);
			if($data['password']==''){
				unset($data['password']);
			}else{
				$data['password'] = md5($data['password']);
			}
			$data['id']=$id;
			$this->mydb->update($this->tabel,$data,$this->primary,$id);
			echo"<script>alert('Data Updated Successfully'); window.location='".base_url().$this->redirect."'</script>";
		}
		
		public function delete($id){
			$this->mydb->delete($this->tabel,$this->primary,$id);
			redirect($this->redirect);
		}
		
		public function _view($offset=0){
			$data['add']=anchor($this->controller.'/add','Add',array('class'=>'btn btn-primary'));
			$field='username,email,display_name,role';
			$query=$this->db->query("select id,$field from ".$this->tabel." limit $offset , ".$this->limit);
			
			$data['page']=$this->myci->page($this->tabel,$this->limit,$this->controller,4);
			$data['show']='data';
			$data['_page_title'] = 'Users';
			$data['tabel']=$this->myci->table_admin($query,$field,$field,$this->controller,$this->primary);
			//$this->load->view('bidang',$data);
			$this->myci->display_adm($this->view,$data);
		}
		
		private function is_email_exist($email){
			$q = $this->db->query('select id from fn_users where email="'.$email.'"');
			if($q->num_rows()>0){
				return true;
			}
			
			return false;
		}
		
		public function userprofile(){
			$user = $this->myci->get_user_logged_in();
			$query = $this->db->query('SELECT * from fn_users where username="'.$user.'"');
			$data['_page_title'] = 'User Profile';
			$data['user'] = $query->result_array();
			$data['action']=$this->controller.'/updateuserprofile/'.$data['user'][0]['id'];
			$this->myci->display_adm('theme/userprofile',$data);
		}
		
		public function updateuserprofile($id){
			$data=$this->myci->post(array(
									'id','password','display_name','email'
								));
			if($data['password']==''){
				unset($data['password']);
			}else{
				$data['password'] = md5($data['password']);
			}
			$data['id']=$id;
			$this->mydb->update($this->tabel,$data,$this->primary,$id);
			//redirect($this->controller.'/userprofile/');
			echo"<script>alert('Your profile saved successfully'); window.location='".base_url().$this->controller.'/userprofile/'."'</script>";
		}
		
		public function resetpassword(){
			$data['send'] = false;
			$data['error'] = '';
			if(!empty($_POST['send'])){
				$userfound = $this->_sendverificationemail($this->input->post('username'));
				
				if($userfound){
					$data['send'] = true;
					$data['msg'] = 'We sent an email verification to you. Please check and follow the instruction that you see on the email.';
				}else{
					$data['error'] = 'Username not found!';
				}
			}
			
			$this->load->view('resetpassword',$data);
		}
		
		private function _sendverificationemail($username){
			$q = $this->db->query('SELECT id,email,display_name from fn_users where username="'.$username.'"');
			if($q->num_rows()>0){
				$q = $q->result_array();
				$q=$q[0];
				
				$token = md5($username.date('Y-m-d H'));
				$to = $q['email'];
				$subject = 'Reset Password Verification | Magnus Angulus Finance Apps';
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.$q['display_name'].' <'.$q['email'].'>' . "\r\n";
				$headers .= 'From: Magnus Angulus App <no-reply@villasofbali.com>' . "\r\n";
				
				$msg = '<p>Click link below to reset your password</p>';
				$msg = '<a href="'.base_url().'/changepassword/'.$q['id'].'/'.$token.'"';
				// Mail it
				mail($to, $subject, $msg, $headers);
				return true;
			}
			
			return false;
		}
		
		public function changepassword($uid,$token){
			$this->load->view('changepassword');
		}
	}
?>
