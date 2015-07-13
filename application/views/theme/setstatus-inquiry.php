<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="form">
		<i class="fa fa-close close"></i>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<label>Choose Status</label>
					<?php
						array_unshift($status,'Choose');
						echo form_dropdown('status',$status,'','id="status" class="form-control" required onclick="showdesc()"');
					?>
				</p>
				<p id="case">
					<label>Lost case Analysis</label>
					<?php
						echo form_dropdown('case',$lost_case,'','id="lost-case" class="form-control" required onclick="showother()"');
					?>
				</p>
				<p id="casebox">
					<label>Other Reason</label>
					<textarea id="other-reason" name="other-reason" class="form-control"></textarea>
				</p>
				<p id="dealdatebox">
					<label>Deal Date</label>
					<input type="text" id="deal_date" class="form-control datepicker">
				</p>
			</div>
			
			<div class="col-sm-12">
				<input type="button" id="cancel" value="Cancel" class="btn btn-primary">
				<input type="button" rel="<?php echo $id; ?>" data-action="<?php echo $action; ?>" id="submit-status" value="Save" class="btn btn-primary">
				<i class="fa fa-circle-o-notch fa-spin hidden loading"></i>
			</div>
		</div>
	</div>
</div>

<script>
function showdesc(){
	if($('#status').val()=='Lost'){
		$('#case').slideDown().attr('required','required');
	}else{
		$('#case').slideUp().removeAttr('required');
		$('#casebox').slideUp().removeAttr('required');
	}
	
	if($('#status').val()=='Deal'){
		$('#dealdatebox').slideDown().attr('required','required');
		$( ".datepicker" ).datepicker();
	}else{
		$('#dealdatebox').slideUp().removeAttr('required');
	}
}

function showother(){
	if($('#lost-case').val()=='other'){
		$('#casebox').slideDown().attr('required','required');
	}else{
		$('#casebox').slideUp().removeAttr('required');
	}
}
</script>