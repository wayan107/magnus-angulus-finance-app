<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Blauk Blonk :v
class Myci{
	var $ci;
	private $session, $auth_page, $dashboard;
	
	function __construct(){
		$this->ci=& get_instance();
		$this->session = 'logged_in_user'; //store logged in user data
		$this->auth_page = 'auth'; //authentication controller
		$this->dashboard = 'dashboard'; //default page if user is logged in
	}
	
	//Authentication begin <-------------------------------
	function login($tabel,$textboxs){
		ob_start();
			$data=$this->ci->myci->post($textboxs);
			$this->ci->db->select($textboxs[0].','.$textboxs[2]);
			$this->ci->db->where(array($textboxs[0]=>$data[$textboxs[0]],$textboxs[1]=>md5($data[$textboxs[1]])));
			$query=$this->ci->db->get($tabel);
			
			$session_age='86500';
			if($this->ci->myci->post('remember-me')){
				$session_age='2592000';
			}
			
			if($query->num_rows()>0){
				$rs=$query->row();
				$session = array(
					'name' => $this->session,
					'value' => $rs->$textboxs[0],
					'expire'=> $session_age
            	);
				
				$session_name = array(
					'name' => $this->session.'_name',
					'value' => $rs->$textboxs[2],
					'expire'=> $session_age
            	);
			$this->ci->input->set_cookie($session);
			$this->ci->input->set_cookie($session_name);
			
			redirect($this->dashboard);
			}else{
				echo"<script>alert('Username dan password salah'); window.history.back();</script>";

			}
	}
	
	function logout($redirect){
		$this->ci->input->set_cookie($this->session);
		$this->ci->input->set_cookie($this->session.'_name');
		redirect($redirect);
	}
	
	function is_logged_in($target=''){
		if(empty($target)) $target = $this->dashboard;
		$auth=$this->ci->input->cookie($this->session);
		if(!empty($auth)){
				redirect($target);
		}else{
				$this->ci->load->view('login');
		}
	}
	
	function is_user_logged_in(){
		$auth=$this->ci->input->cookie($this->session);
		if(!empty($auth)) return true;
		
		$this->ci->load->view('login');
		return false;
	}
	//Authentication end ---------------------------------->
	
	
	//Form data begin <---------------------------
	function post($dt){
			
			for($i=0;$i<=count($dt)-1;$i++){
				$data[$dt[$i]]=$this->ci->input->post($dt[$i]);
			}
			return $data;
	}
	//Form data end --------------------------->
	
	
	//Direct page and message begin <-----------------
	function alert($msg){
		echo"<script>alert('$msg');</script>";
	}
	
	function direct($link){
		echo"<script>window.location='$link';</script>";
	}
	//Direct page and message end ----------------->
	
	
	//Form element render begin <--------------------
	function combobox($name,$query,$field,$selected=0,$opt=''){
			$option[0]=" --Choose-- ";
			$f=explode(',',$field);
			foreach($query->result() as $rs){
				$option[$rs->$f[0]]=$rs->$f[1];
			}
			echo form_dropdown($name,$option,$selected,$opt);
	}
	
	function combobox_number($name,$begin,$end,$selected=1){
			
			for($i=$begin;$i>$end;$i--){
				$option[$i]=$i;
			}
			echo form_dropdown($name,$option,$selected);
	}
	//Form element render begin ---------------------->
	
	//Date Coversion begin <--------------------
	function to_ymd($tgl,$pattern){
		$tanggal=split($pattern,$tgl);
	
		$ymd=date($tanggal[2].$pattern.$tanggal[1].$pattern.$tanggal[0]);
		return $ymd;
	}

	function to_dmy($tgl,$pattern){
		$tanggal=split($pattern,$tgl);
	
		$dmy=date($tanggal[2].$pattern.$tanggal[1].$pattern.$tanggal[0]);
		return $dmy;
	}
	//Date Coversion  end --------------->
	
	//Menu Generator begin <------------------
	function menu(){
		$table='fn_menu';
		$field='id,slug,text,id_tag,class_tag';
		$query=$this->ci->db->query("select $field from $table order by sort");
		$f=explode(',',$field);
		$mnu="<ul class='$class'>";
			foreach($query->result_array() as $rs){
				$mnu.="<li>".anchor($rs['link'],$rs['menu'])."</li>";
				
				$sub_query=$this->ci->db->query("select $field from $table where parent='".$rs[$f[2]]."' order by sort");
				$mnu.="<ul>";
				foreach($sub_query->result_array() as $rs2){
					$mnu.="<li>".anchor($rs2['link'],$rs2['menu'])."</li>";
				}
				$mnu.="</ul>";
			}
			$mnu.="</ul>";
			
			return $mnu;
		}
	//Menu Generator end --------------->
	
	//Table Generator begin <------------------
	function table($query,$field='',$as=''){
			$this->ci->load->library('table');
			$tmpl = array (
                    'table_open'          => '<table border="0" class="table table-striped table-bordered table-hover data-table">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			//$heading[0]='No';
			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			//array_push($heading,'Action');
			$this->ci->table->set_heading($heading);
			$table_row=1;
			
			foreach($query->result_array() as $dts){
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)
				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					$item_row[$i+1]=$dts[$fields[$i]];
				}
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			}
			return $this->ci->table->generate();
			
	}
	
	function table_view($query,$field='',$as='',$controller,$primary){
			$this->ci->load->library('table');
			$tmpl = array (
                    'table_open'          => '<table border="0" class="grid">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			//$heading[0]='No';
			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,'Action');
			$this->ci->table->set_heading($heading);
			$table_row=1;
			foreach($query->result_array() as $dts){
			
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)

				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					
					$item_row[$i+1]=$dts[$fields[$i]];
					
				}
				$cel=array('data'=>anchor($controller.'/views/'.$dts[$primary],'Lihat',array('class'=>'button_edit')), 'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	
	function table_admin($query,$field='',$as='',$controller,$primary,$see_details=false){
			$this->ci->load->library('table');
			$tmpl = array (
                    'table_open'          => '<table border="0" class="table table-striped table-bordered table-hover data-table">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			//$heading[0]='No';
			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,'Action');
			$this->ci->table->set_heading($heading);
			$table_row=1;
			
			foreach($query->result_array() as $dts){
			
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)

				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					
					$item_row[$i+1]=$dts[$fields[$i]];
					
				}
				
				$buttons=array(
					anchor($controller.'/update/'.$dts[$primary],'<i class="fa fa-edit"></i>',array('class'=>'button_edit')),
					anchor($controller.'/delete/'.$dts[$primary],'<i class="fa fa-remove"></i>',array('class'=>'button_delete',"onClick"=>"return confirm('Sure want to delete this data?')"))
				);
				
				if($see_details) array_unshift($buttons,anchor($controller.'/viewdetail/'.$dts[$primary],'<i class="fa fa-search-plus"></i>',array('class'=>'button-view pop-up')));
				
				//$cel=array('data'=>anchor($controller.'/update/'.$dts[$primary],'<i class="fa fa-edit"></i>',array('class'=>'button_edit'))." ".anchor($controller.'/delete/'.$dts[$primary],'<i class="fa fa-remove"></i>',array('class'=>'button_delete',"onClick"=>"return confirm('Sure want to delete this data?')")), 'class'=>'aksi');
				$cel=array('data'=>implode(' ',$buttons),'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	
	function table_active($query,$field='',$as='',$controller,$primary,$value,$action_name){
			$this->ci->load->library('table');
			$tmpl = array (
				'table_open'          => '<table border="0" class="table table-striped table-bordered table-hover data-table">',

				'heading_row_start'   => '<tr>',
				'heading_row_end'     => '</tr>',
				'heading_cell_start'  => '<th>',
				'heading_cell_end'    => '</th>',

				'row_start'           => '<tr>',
				'row_end'             => '</tr>',
				'cell_start'          => '<td>',
				'cell_end'            => '</td>',

				'row_alt_start'       => '<tr>',
				'row_alt_end'         => '</tr>',
				'cell_alt_start'      => '<td>',
				'cell_alt_end'        => '</td>',

				'table_close'         => '</table>'
            );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,$action_name);
			$this->ci->table->set_heading($heading);
			$table_row=1;
			
			foreach($query->result_array() as $dts){
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)
				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					$item_row[$i+1]=$dts[$fields[$i]];
				}
				
				$button_class=($dts[$value]==0) ? 'activate' : 'deactivate';
				$button_title=($dts[$value]==0) ? 'Unpaid' : 'Paid';
				
				$buttons=array(
					anchor('#','&nbsp;',array('class'=>'circle-button status-toogle-'.$controller.'-'.$value.' '.$button_class,'title'=>$button_title,'rel'=>$dts[$primary])),
					anchor($controller.'/generateinvoice/'.$dts[$primary],'<i class="fa fa-file-pdf-o"></i>',array('title'=>'Export to PDF','target'=>'_blank'))
				);
				if($dts[$value]==1) array_push($buttons,anchor($controller.'/viewdetail/'.$dts[$primary],'<i class="fa fa-search-plus"></i>',array('class'=>'button-view pop-up','title'=>'see payment details')));
				
				//$cel=array('data'=>anchor($controller.'/update/'.$dts[$primary],'<i class="fa fa-edit"></i>',array('class'=>'button_edit'))." ".anchor($controller.'/delete/'.$dts[$primary],'<i class="fa fa-remove"></i>',array('class'=>'button_delete',"onClick"=>"return confirm('Sure want to delete this data?')")), 'class'=>'aksi');
				$cel=array('data'=>implode(' ',$buttons),'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	
	function table_active2($query,$field='',$as='',$controller,$primary,$value,$action_name){
			$this->ci->load->library('table');
			$tmpl = array (
				'table_open'          => '<table border="0" class="table table-striped table-bordered table-hover data-table">',

				'heading_row_start'   => '<tr>',
				'heading_row_end'     => '</tr>',
				'heading_cell_start'  => '<th>',
				'heading_cell_end'    => '</th>',

				'row_start'           => '<tr>',
				'row_end'             => '</tr>',
				'cell_start'          => '<td>',
				'cell_end'            => '</td>',

				'row_alt_start'       => '<tr>',
				'row_alt_end'         => '</tr>',
				'cell_alt_start'      => '<td>',
				'cell_alt_end'        => '</td>',

				'table_close'         => '</table>'
            );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,$action_name);
			$this->ci->table->set_heading($heading);
			$table_row=1;
			
			foreach($query->result_array() as $dts){
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)
				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					if($fields[$i]=='contract_number'){
						$item_row[$i+1]=anchor('deals/viewdetail/'.$dts['id'],$dts[$fields[$i]],array('class'=>'button-view pop-up','title'=>'see deal details'));
					}else{
						$item_row[$i+1]=$dts[$fields[$i]];
					}
					
				}
				
				$button_class=($dts[$value]==0) ? 'activate' : 'deactivate';
				$button_title=($dts[$value]==0) ? 'Unpaid' : 'Paid';
				//$rel=($dts[$value]==0) ? $dts[$primary].'-'.$dts['agent_id'] : $dts['comm_paid_id'];
				$buttons=array(
					anchor('#','&nbsp;',array('class'=>'circle-button status-toogle-'.$controller.'-'.$value.' '.$button_class,'title'=>$button_title,'rel'=>$dts[$primary].'-'.$dts['agent_id'],'data-type'=>$dts['type']))
				);
				if($dts[$value]==1) array_push($buttons,anchor($controller.'/viewdetail/'.$dts['comm_paid_id'],'<i class="fa fa-search-plus"></i>',array('class'=>'button-view pop-up','title'=>'see payment details')));
				
				//$cel=array('data'=>anchor($controller.'/update/'.$dts[$primary],'<i class="fa fa-edit"></i>',array('class'=>'button_edit'))." ".anchor($controller.'/delete/'.$dts[$primary],'<i class="fa fa-remove"></i>',array('class'=>'button_delete',"onClick"=>"return confirm('Sure want to delete this data?')")), 'class'=>'aksi');
				$cel=array('data'=>implode(' ',$buttons),'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	
	function table_admin_file($query,$field='',$as='',$controller,$primary,$file){
			$this->ci->load->library('table');
			$tmpl = array (
                    'table_open'          => '<table border="0" class="grid">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			//$heading[0]='No';
			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,'Action');
			$this->ci->table->set_heading($heading);
			$table_row=1;
			foreach($query->result_array() as $dts){
			
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)

				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					
					$item_row[$i+1]=$dts[$fields[$i]];
					
				}
				$cel=array('data'=>anchor($controller.'/update/'.$dts[$primary],'Ubah',array('class'=>'button_edit'))." ".anchor($controller.'/delete/'.$dts[$primary].'/'.$dts[$file],'Hapus',array('class'=>'button_delete',"onClick"=>"return confirm('Yakin akan menghapus data?')"))." ".anchor(base_url().'berkas/'.$dts[$file],'Lihat',array('class'=>'button_edit','target'=>'_blank')), 'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	
	function table_admin_lihat($query,$field='',$as='',$controller,$primary){
			$this->ci->load->library('table');
			$tmpl = array (
                    'table_open'          => '<table border="0" class="grid">',

                    'heading_row_start'   => '<tr>',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th>',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr>',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr>',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td>',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );
			
			$this->ci->table->set_template($tmpl); 
			$this->ci->table->set_empty('&nbsp;');

			//$heading[0]='No';
			if(!empty($field)){
				$heading=explode(',',$as);
				$fields=explode(',',$field);
			}else{
				$n=0;
				foreach($query->list_fields() as $fild){
					$fields[$n]=$fild;
					$heading[$n]=str_replace("_"," ", $fild);
					$n++;
				}
			}
			
			$jumField=count($fields);
			array_unshift($heading,'No');
			array_push($heading,'Action');
			$this->ci->table->set_heading($heading);
			$table_row=1;
			foreach($query->result_array() as $dts){
			
			//pembuatan baris data dlm bentuk array (data berasal dari dari query)

				$item_row[0]=$table_row; 
				$table_row++;
				for($i=0;$i<$jumField;$i++){
					
					$item_row[$i+1]=$dts[$fields[$i]];
					
				}
				$cel=array('data'=>anchor($controller.'/update/'.$dts[$primary],'Ubah',array('class'=>'button_edit'))." ".anchor($controller.'/delete/'.$dts[$primary],'Hapus',array('class'=>'button_delete',"onClick"=>"return confirm('Yakin akan menghapus data?')"))." ".anchor($controller.'/views/'.$dts[$primary],'Lihat',array('class'=>'button_edit')), 'class'=>'aksi');
				$item_row[$i+1]=$cel;
				
				//pembuatan baris pada tabel dan memasukkan data 
				$this->ci->table->add_row($item_row);
			
			}
			return $this->ci->table->generate();
			
	}
	//Table Generator begin ------------------->
	
	//Template display begin <-------------------
	function display($template,$data=null){ 
		$data['_content']=$this->ci->load->view($template,$data, true); 
		
		//$data['_header']=$this->_ci->load->view('template/header',$data, true); 
  		//$data['_top_menu']=$this->_ci->load->view('template/menu',$data, true); 

		//$data['_menu']=$this->ci->myci->menu('user_menu','Hdropdown'); 
		
		$this->ci->load->view('template.php',$data);
	}
	
	function display_adm($template,$data=null){
		$data['_content']=$this->ci->load->view($template,$data, true);
		//$data['_header']=$this->_ci->load->view('template/header',$data, true);
  		//$data['_top_menu']=$this->_ci->load->view('template/menu',$data, true);
		$data['_menu']=$this->ci->load->view('theme/menu',null, true);
		$this->ci->load->view('theme/theme.php',$data);
	} 
	//Template display end ------------------>
	
	//Paging generator begin <------------
	function page($table,$limit,$controller,$uri_segment){
			$this->ci->load->library('pagination');
			$config['total_rows']=$this->ci->db->count_all($table);
			$config['per_page']=$limit;
			$config['base_url']=site_url($controller.'/index');
			$config['num_links'] = 2;
			$config['uri_segment']=$uri_segment;
			
			$this->ci->pagination->initialize($config);
			return $this->ci->pagination->create_links();
	}
	
	function page2($total_rows,$limit,$controller,$uri_segment){
			$this->ci->load->library('pagination');
			$config['total_rows']=$total_rows;
			$config['per_page']=$limit;
			$config['base_url']=site_url($controller.'/index');
			$config['num_links'] = 2;
			$config['uri_segment']=$uri_segment;
			
			$this->ci->pagination->initialize($config);
			return $this->ci->pagination->create_links();
	}
	//Paging generator end ---------------->
	
	//Auto id generator begin <-----------------
	function setId($prefix,$tabel,$primary='id'){
		$query=$this->ci->db->query("select ".$primary." from $tabel where ".$primary." like '%$prefix%' order by ".$primary." DESC");
		$jum=1;
		if($query->num_rows()>0){
			$rs=$query->row();
			$jum=substr($rs->$primary,strlen($prefix),5);

			$jum+=1;
		}

		if($jum<10){
			$id=$prefix."0000".$jum;
		}elseif($jum<100){
			$id=$prefix."000".$jum;
		}elseif($jum<1000){
			$id=$prefix."00".$jum;
		}elseif($jum<10000){
			$id=$prefix."0".$jum;
		}elseif($jum<100000){
			$id=$prefix.$jum;
		}
		return $id;
	}
	//Auto Id Generator end ---------------------->
	
	//File upload Maneger begin ----------------->
	function do_upload($field_name,$file_name='',$path_upload,$file_type_allowed='gif|jpg|png')
	{
		$config['upload_path'] = './'.$path_upload.'/';
		$config['allowed_types'] = $file_type_allowed;
		$config['max_size']	= '1000';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
		$config['overwrite']= true;
		if($file_name<>""){
			$config['file_name']=$file_name;
		}
		
		$this->ci->load->library('upload', $config);
	
		if ( ! $this->ci->upload->do_upload($field_name))
		{
			$data['sukses']=false;
			$data['dt']=$this->ci->upload->display_errors();
			return $data;
		}	
		else
		{
			$data['sukses']=true;
			$data['dt']=$this->ci->upload->data();
			return $data;

		}
	}
	
	function wmimg($img){
			$this->ci->load->library('image_lib');
			$config['source_image']	=$img;
			$config['wm_type'] = 'overlay';
			$config['wm_overlay_path']= './images/watermark.png';
			$config['wm_opacity']=50;
			$config['wm_vrt_alignment'] = 'middle';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = '20';
		
		$this->ci->image_lib->initialize($config); 

		$this->ci->image_lib->watermark();
	}
	
	function generatePassword($lenght){
		$chars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');	
		$pass='';
		for($i=0;$i<$lenght;$i++){
			$index=rand(0,count($chars));	
			$pass.=$chars[$index];
			
		}
		return $pass;
	}
	//File upload manager end <---------------------
	
	function get_currency_rate($from_Currency, $to_Currency, $amount) {
		$amount = urlencode($amount);
		$from_Currency = urlencode($from_Currency);
		$to_Currency = urlencode($to_Currency);
		$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
		$ch = curl_init();
		$timeout = 0;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_USERAGENT,
					 "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$rawdata = curl_exec($ch);
		curl_close($ch);
		$data = explode('bld>', $rawdata);
		$data = explode($to_Currency, $data[1]);
		return $data[0];//round(floatval($data[0]),2);
	}
	
	function is_page($page_uri){
		$url=$_SERVER['REQUEST_URI'];
		preg_match('/'.$page_uri.'/',$url,$match);
		if(!empty($match))
			return true;
		else
			return false;
	}
	
	function is_home(){
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$baseurl = base_url();
		if($url == $baseurl)
			return true;
		else
			return false;
	}
}