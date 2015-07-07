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
				<p><?php $budget_list = ($dt['plan']=='0') ? $rental_budget : $sale_budget; 
					if(!empty($dt['budget'])){
					$budgets = explode(',',$dt['budget']);
						foreach($budgets as $budget){
							echo $budget_list[$budget].'<br>';
						}
					}
				?></p>
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
				<p><?php echo (!empty($dt['bedroom'])) ? $dt['bedroom'].' Bedrooms' : ''; ?></p>
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
									
									default		: echo 'Any Furnishing';
									break;
								}; ?></p>
			</div>
			<div class="col-sm-2">
				<h3>Living</h3>
				<p><?php //echo ($dt['living']=='1') ? 'Open Living' : 'Close living';
						switch ($dt['living']){
							case '1'	: echo 'Open Living';
							break;
							
							case '2'	: echo 'Closed Living';
							break;
							
							default		: echo 'Any Living';
							break;
						};
				?></p>
			</div>
			<div class="col-sm-2">
				<h3>Status</h3>
				<p><?php echo $dt['post_status']; ?></p>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="row secions">
			<?php if(!empty($dt['lost_case'])){ ?>
			<div class="col-sm-2">
				<h3>Lost case</h3>
				<p><?php echo $dt['lost_case']; ?></p>
			</div>
			<?php } ?>
			
			<div class="col-sm-4">
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