<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Auth extends CI_Controller{
	private $tabel='users';
	private $textbox=array('username','password','display_name');
			
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$this->myci->is_logged_in();
	}
	
	public function login(){
		$this->myci->login($this->tabel,$this->textbox);
	}
		
	public function logout(){
		$this->myci->logout('auth');
	}
}
?>