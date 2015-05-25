<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="client-form" title="Create new user">
  <p class="validateTips">All form fields are required.</p>
  <form method="post">
    <fieldset>
<?php
	//echo form_open($action);
	echo"<table class='form'><tr>
		<td>Client Name </td><td>";
		$f = array(
		  'name'        => 'name',
		  'id'			=> 'name',
		  'value'       => '',
		  'required'	=>'required',
		  'class'		=> 'form-control'
		);
		echo form_input($f);

		echo"</td></tr><tr><td>Phone </td><td>";
		$f = array(
		  'name'        => 'phone',
		  'id'			=> 'phone',
		  'value'       => '',
		  'class'		=> 'form-control'
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Email </td><td>";
		$f = array(
		  'name'        => 'email',
		  'id'			=> 'email',
		  'value'       => '',
		  'type'		=> 'email',
		  'class'		=> 'form-control'
		);
		echo form_input($f);
		echo"</td ></tr></table>";
	//echo form_close();
?>
		<input type="submit" class="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>

<div id="owner-form" title="Add new owner">
  <p class="validateTips">All form fields are required.</p>
  <form>
    <fieldset>
<?php
	echo"<table class='form'><tr>
	<td>Owner Name </td><td>";
	$f = array(
	  'name'        => 'name',
	  'id'			=> 'name',
	  'value'       => '',
	  'required'	=>'required',
	  'class'		=> 'form-control'
	);
	echo form_input($f);

	echo"</td></tr><tr><td>Phone </td><td>";
	$f = array(
	  'name'        => 'phone',
	  'id'			=> 'phone',
	  'value'       => '',
	  'class'		=> 'form-control'
	);
	echo form_input($f);
	
	echo"</td></tr><tr><td>Email </td><td>";
	$f = array(
	  'name'        => 'email',
	  'id'			=> 'email',
	  'value'       => '',
	  'type'		=> 'email',
	  'class'		=> 'form-control'
	);
	echo form_input($f);
	echo"</td ></tr></table>";
?>
		<input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>