<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
echo form_open($action);
	echo"<table class='form'><tr>
		<td>Username </td><td>";
		echo $user[0]['username'];

		echo"</td></tr><tr><td>Password </td><td>";
		$f = array(
		  'name'        => 'password',
		  'id'			=> 'password',
		  'value'       => '',
		  'type'		=> 'password',
		  'class'		=> 'form-control'
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Display Name </td><td>";
		$f = array(
		  'name'        => 'display_name',
		  'id'			=> 'display_name',
		  'value'       => $user[0]['display_name'],
		  'size'		=> '30',
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Email </td><td>";
		$f = array(
		  'name'        => 'email',
		  'id'			=> 'email',
		  'value'       => $user[0]['email'],
		  'size'		=> '30',
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td colspan=2 align=center>";
		echo form_submit('submit','Save','class="btn btn-primary"');
		echo"</td ></tr></table>";
	echo form_close();