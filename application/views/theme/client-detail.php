<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="wrapper">
	<i class="fa fa-close close"></i>
	<?php
	foreach($query->result_array() as $dt){
		?>
		<div class="row">
			<div class="col-sm-3">
				<h3>Client name</h3>
				<p><?php echo $dt['name']; ?></p>
			</div>
			<div class="col-sm-3">
				<h3>Email</h3>
				<p>
					<?php echo $dt['email']; ?>
				</p>
			</div>
			<div class="col-sm-3">
				<h3>Phone</h3>
				<p><?php echo $dt['phone']; ?></p>
			</div>
		</div>
		<?php
	}
	?>
	</div>
</div>