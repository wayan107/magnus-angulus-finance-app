<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dealsmodel extends CI_Model{
	public function __construct()
	{
			parent::__construct();
	}
	
	public function get_client_dropdown(){
		$query=$this->db->query('select id,name from fn_client');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_owner_dropdown(){
		$query=$this->db->query('select id,name from fn_owner');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_agent_dropdown($occupation){
		$query=$this->db->query('select id,name from fn_agent where occupation="'.$occupation.'"');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_area_dropdown(){
		$query=$this->db->query('select id,name from fn_area');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
}
?>