<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dealsmodel extends CI_Model{
	public function __construct()
	{
			parent::__construct();
	}
	
	public function get_client_dropdown(){
		$query=$this->db->query('select id,name from fn_client order by name ASC');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_owner_dropdown(){
		$query=$this->db->query('select id,name from fn_owner order by name ASC');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_agent_dropdown($occupation,$default='Choose'){
		$where_or = ($occupation=='Sales Agent') ? ' OR occupation="Sales manager"' : '';
		$query=$this->db->query('select id,name from fn_agent where occupation="'.$occupation.'" '.$where_or);
		
		if(!empty($default))
		$return=array(''=>$default);
	
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function get_area_dropdown(){
		$query=$this->db->query('select id,name from fn_area order by name ASC');
		$return=array(''=>'Choose');
		foreach($query->result_array() as $dt){
			$return[$dt['id']]=$dt['name'];
		}
		return $return;
	}
	
	public function add_client($data){
		$query = $this->db->query('select id from fn_client where name like "%'.$data['name'].'%"');
		if($query->num_rows()>0){
			$q = $query->row();
			return $q->id;
		}else{
			$this->db->insert('client',$data);
			return $this->db->insert_id();
		}
	}
	
	public function add_owner($data){
		$query = $this->db->query('select id from fn_owner where name like "%'.$data['name'].'%"');
		if($query->num_rows()>0){
			$q = $query->row();
			return $q->id;
		}else{
			$this->db->insert('owner',$data);
			return $this->db->insert_id();
		}
	}
}
?>