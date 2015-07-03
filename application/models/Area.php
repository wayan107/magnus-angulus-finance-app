<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Area extends CI_Model{
	public function __construct() {
		parent::__construct();
	}
	
	public function get_areas(){
		$q = $this->db->query('SELECT prefix,name from fn_area order by name');
		return $q->result_array();
	}
	
	public function get_area_basedon_inquiry($deal_id,$show_name=false){
		if($show_name){
			$field = 'name';
		}else{
			$field = 'area_code';
		}
		$q = $this->db->query('
								SELECT '.$field.'
								from fn_areas_prefer ap
								inner join fn_area a on a.prefix=ap.area_code
								where deal_id="'.$deal_id.'"
							');
		$data_return = array();
		foreach($q->result_array() as $area){
			$data_return[] = $area[$field];
		}
		
		return $data_return;
	}
}