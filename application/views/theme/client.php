<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
	echo form_open($action);
	echo"<table class='form'><tr>
		<td>Client Name </td><td>";
		$f = array(
		  'name'        => 'name',
		  'id'			=> 'name',
		  'value'       => $name,
		  'required'	=>'required',
		  'class'		=> 'form-control'
		);
		echo form_input($f);

		echo"</td></tr><tr><td>Phone </td><td>";
		$f = array(
		  'name'        => 'phone',
		  'id'			=> 'phone',
		  'value'       => $phone,
		  'class'		=> 'form-control'
		);
		echo form_input($f);
		
		echo"</td></tr><tr><td>Email </td><td>";
		$f = array(
		  'name'        => 'email',
		  'id'			=> 'email',
		  'value'       => $email,
		  'type'		=> 'email',
		  'class'		=> 'form-control'
		);
		echo form_input($f);
		
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