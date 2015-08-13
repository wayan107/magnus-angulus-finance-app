<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="wrapper">
	<i class="fa fa-close close"></i>
		<h1 class="text-center">Income This Month</h1>
		<table border='0' class="table table-striped table-bordered table-hover data-table">
			<tr>
				<th>No</th>
				<th>Deal Date</th>
				<th>Agent</th>
				<th>Consult Fee</th>
				<th>Client</th>
				<th>Owner</th>
				<th>Rental type</th>
				<th>Duration</th>
			</tr>
		<?php
		foreach($query as $q){
			switch($q['rental_type']){
				case '0'	: $rental_type = 'Yearly';
								$duration_text = 'Year';
				break;
				
				case '1'	: $rental_type = 'Monthly';
								$duration_text = 'Month';
				break;
				
				case '2'	: $rental_type = 'Freehold';
								$duration_text = '';
				break;
				
				case '3'	: $rental_type = 'Leasehold';
								$duration_text = 'Year';
				break;
			}
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $q['deal_date'] ?></td>
				<td><?php echo $q['agent'] ?></td>
				<td><?php echo $q['consult_fee'] ?></td>
				<td><?php echo $q['client'] ?></td>
				<td><?php echo $q['owner'] ?></td>
				<td><?php echo $rental_type; ?></td>
				<td><?php if($q['rental_type']!='2'){
								echo $q['rental_duration'];
								echo ($q['rental_duration']>1) ? 's' : '';
							}?>
				</td>
			</tr>
			<?php
		}
		?>
		</table>
	</div>
</div>