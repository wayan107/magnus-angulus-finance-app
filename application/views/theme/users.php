<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
//$atribut_form=array('id'=>'pelanggan','name'=>'pelanggan');
	echo form_open($action);
	echo"<table><tr>
		
		<td>Username </td><td>";
		$f = array(
		  'name'        => 'username',
		  'id'			=> 'username',
		  'value'       => $username,
		  'required'	=>'required'
		  
		  
		);
		echo form_input($f);

		echo"</td></tr><tr><td>Password </td><td>";
		$f = array(
		  'name'        => 'password',
		  'id'			=> 'password',
		  'value'       => $password,
		  'type'		=> 'password',
		  'required'	=>'required'
		  
		  
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Display Name </td><td>";
		$f = array(
		  'name'        => 'display_name',
		  'id'			=> 'display_name',
		  'value'       => $display_name,
		  'size'		=> '30',
		  'required'	=>'required'
		  
		  
		);
		echo form_input($f);
		
				
		echo"</td></tr><tr><td colspan=2 align=center>";
		echo form_submit('submit',$tombol);
		echo"</td ></tr></table>";
	echo form_close();
	
}elseif($show=='data'){
	echo $add;
	echo "<div>$tabel</div>";
	echo"<div align=center> $page</div>";
}
?>