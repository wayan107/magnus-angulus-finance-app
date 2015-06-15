<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
	echo form_open($action);
	echo"<table class='form'><tr>
		
		<td>Username </td><td>";
		$f = array(
		  'name'        => 'username',
		  'id'			=> 'username',
		  'value'       => $username,
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		);
		echo form_input($f);

		echo"</td></tr><tr><td>Password </td><td>";
		$f = array(
		  'name'        => 'password',
		  'id'			=> 'password',
		  'value'       => '',
		  'type'		=> 'password',
		  'class'		=> 'form-control'
		);
		if($readonly=='') $f['required'] = 'required';
		
		echo form_input($f);
		
		echo"</td></tr><tr><td>Display Name </td><td>";
		$f = array(
		  'name'        => 'display_name',
		  'id'			=> 'display_name',
		  'value'       => $display_name,
		  'size'		=> '30',
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Email </td><td>";
		$f = array(
		  'name'        => 'email',
		  'id'			=> 'email',
		  'value'       => $email,
		  'size'		=> '30',
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Role </td><td>";
		$opts=array(
					'viewer'		=> 'Viewer',
					'admin'			=> 'Admin',
					'superadmin'	=> 'Super Admin'
				);
		echo form_dropdown('role',$opts,$role,'class="form-control"');
				
		echo"</td></tr><tr><td colspan=2 align=center>";
		echo form_submit('submit',$tombol,'class="btn btn-primary"');
		echo"</td ></tr></table>";
	echo form_close();
	
}elseif($show=='data'){
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo $add; ?>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row"><?php echo $tabel; ?></div>
				<div class="row text-right">
					<?php echo $page; ?>
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
	</div>
	<?php
}
?>