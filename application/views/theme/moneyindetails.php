<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="wrapper">
	<i class="fa fa-close close"></i>
		<h1 class="text-center"><?php echo ($type==1) ? 'Money In This Month' : 'On Going Money' ?></h1>
		<table border='0' class="table table-striped table-bordered table-hover data-table">
			<tr>
				<th>No</th>
				<th><?php echo ($type==1) ? 'Date In' : 'Will In on'; ?></th>
				<th>Agent</th>
				<th>Amount</th>
				<th>Client</th>
				<th>Owner</th>
			</tr>
		<?php
		foreach($query as $q){ ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo ($type==1) ? $q['pay_date'] : $q['date']; ?></td>
				<td><?php echo $q['agent'] ?></td>
				<td><?php echo ($type==1) ? $q['paid_amount'] : $q['amount']; ?></td>
				<td><?php echo $q['client'] ?></td>
				<td><?php echo $q['owner'] ?></td>
			</tr>
			<?php
		}
		?>
		</table>
	</div>
</div>