<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="form">
		<i class="fa fa-close close"></i>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<label>Choose Agent</label>
					<?php
						$options=$this->dealsmodel->get_agent_dropdown('Sales Agent','None');
						echo form_dropdown('agent',$options,'','id="agent" class="form-control" required');
					?>
				</p>
			</div>
			
			<div class="col-sm-12">
				<input type="button" id="cancel" value="Cancel" class="btn btn-primary">
				<input type="button" rel="<?php echo $id; ?>" data-action="<?php echo $action; ?>" id="submit" value="Assign" class="btn btn-primary">
				<i class="fa fa-circle-o-notch fa-spin hidden loading"></i>
			</div>
		</div>
	</div>
</div>