<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mydb extends CI_Model{
	public function insert($tabel,$dt){
		$this->db->insert($tabel,$dt);
		return $this->db->insert_id();
	}
	
	public function update($tabel,$dt,$primary,$primary_value){
		$this->db->where($primary,$primary_value);
		$this->db->update($tabel,$dt);
	}	
	
	public function delete($tabel,$primary,$primary_value){
		$this->db->where($primary,$primary_value);
		$this->db->delete($tabel);
	}
	
	public function get_where($tabel,$primary,$primary_value){
		return $this->db->get_where($tabel,array($primary=>$primary_value));
	}
	
	public function get_menu($tabel){
		$this->db->where('parent','0');
		$this->db->where('aktif','y');
		$query= $this->db->get($tabel);
	}
}
?>