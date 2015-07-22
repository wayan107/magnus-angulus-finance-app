<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
//$atribut_form=array('id'=>'pelanggan','name'=>'pelanggan');
	echo form_open($action);
	echo"<table class='form'><tr>
		
		<td>Area Name </td><td>";
		$f = array(
		  'name'        => 'name',
		  'id'			=> 'name',
		  'value'       => $name,
		  'required'	=>'required',
		  'class'		=> 'form-control'
		  
		  
		);
		echo form_input($f);

		echo"</td></tr><tr><td>Prefix Code </td><td>";
		$f = array(
		  'name'        => 'prefix',
		  'id'			=> 'prefix',
		  'value'       => $prefix,
		  'required'	=>'required',
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
			<div class="pull-right filter">
				<form method="post">
					Search : 
					<input type="text" name="s" value="<?php echo (!empty($_POST['s'])) ? $_POST['s'] : ''; ?>">
					<input type="submit" class="btn btn-primary" name="filter" value="Submit"/>
				</form>
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row"><?php echo $tabel; ?></div>
				<div class="row text-right">
					<div class="paging">
						<?php echo $page; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
	</div>
	<?php
	
}
?>