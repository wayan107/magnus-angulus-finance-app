<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
	<div class="panel-heading">
		
	</div>
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<form action="<?php echo base_url(); ?>deals/<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
				<input name="FileInput" id="FileInput" type="file"/> <br>
				<input type="submit"  id="submit-btn" class="btn btn-primary" value="Import" />
				<img src="" id="loading-img" style="display:none;" alt="Please Wait"/>
			</form>
			<div id="progressbox">
				<div id="progressbar"></div >
				<div id="statustxt">0%</div>
			</div>
			<div id="output"></div>
		</div>
	</div>
</div>