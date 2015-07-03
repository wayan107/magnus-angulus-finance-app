<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="wrapper">
	<i class="fa fa-close close"></i>
	<?php
	foreach($query->result_array() as $dt){
		?>
		<div class="row secions">
			<div class="col-sm-2">
				<h3>Inquiry Date</h3>
				<p><?php echo $dt['inquiry_date']; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Client</h3>
				<p><?php echo $dt['client_name']; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Plan</h3>
				<p><?php echo ($dt['plan']=='0') ? 'Rent' : 'Buy'; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Budget</h3>
				<p><?php echo ($dt['plan']=='0') ? $rental_budget[$dt['budget']] : $sale_budget[$dt['budget']]; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Assigned To</h3>
				<p><?php echo $dt['agent'] ?></p>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="row secions">
			<div class="col-sm-2">
				<h3>Plan Move In</h3>
				<p><?php echo $dt['plan_move_in']; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Bedroom</h3>
				<p><?php echo $dt['bedroom']; ?> Bedroom</p>
			</div>
			<div class="col-sm-2">
				<h3>Furnishing</h3>
				<p><?php switch ($dt['furnishing']){
									case '1'	: echo 'Furnished';
									break;
									
									case '2'	: echo 'Semi-Furnished';
									break;
									
									case '3'	: echo 'Unfurnished';
									break;
								}; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Living</h3>
				<p><?php echo ($dt['living']=='1') ? 'Open Living' : 'Close living'; ?></p>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="row secions">
			<div class="col-sm-12">
				<h3>Preferable Areas</h3>
				<ul class="area-list">
					<?php
					foreach($areas as $area){
						?>
						<li><?php echo $area; ?></li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
		<?php
	}
	?>
	</div>
</div>