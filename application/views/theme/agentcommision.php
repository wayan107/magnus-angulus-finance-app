<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<div class="panel panel-default">
		<div class="panel-heading filter">
			<form method="post" id="find">
				From : <input type="text" name="date-start" class="datepicker" value="<?php echo (!empty($_POST['date-start'])) ? $_POST['date-start'] : ''; ?>">
				Until : <input type="text" name="date-end" class="datepicker" value="<?php echo (!empty($_POST['date-end'])) ? $_POST['date-end'] : ''; ?>">
				<?php echo form_dropdown('paid',array(''=>'All','0'=>'Unpaid','1'=>'Paid')); ?>
				
				<input type="submit" class="btn btn btn-primary" name="find" value="Find">
			</form>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row">
					<?php echo $tabel; ?>
				</div>
				<div class="row text-right">
					<div class="paging">
						<?php echo $page; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
	</div>