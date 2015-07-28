<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="panel panel-default">
		<div class="panel-heading filter">
			<form action="<?php echo base_url().$this->uri->segment(1); ?>" method="post" id="generate">
				Type <?php
					$options=array(''=>'Choose','1'=>'Deals','2'=>'Cash','3'=>'On going');
					$selected=(!empty($_POST['type'])) ? $_POST['type'] : '';
					echo form_dropdown('type',$options,$selected,'id="type" required');
				?>
				From <input type="text" class="datepicker" name="date-start" id="date-start" value="<?php echo date('Y-m').'-01'; ?>" max="<?php echo date('Y-m-d'); ?>">
				until <input type="text" class="datepicker" name="date-end" id="date-end" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
				<input type="submit" class="btn btn btn-primary" value="Generate">
			</form>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row data">
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
	</div>