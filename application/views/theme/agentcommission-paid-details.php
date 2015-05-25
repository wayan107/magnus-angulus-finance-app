<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="form">
		<i class="fa fa-close close"></i>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<label>Paid Amount</label>
					<?php echo $row->amount_paid; ?>
				</p>
				
				<p>
					<label>Pay Date</label>
					<?php echo $row->pay_date; ?>
				</p>
				
				<p>
					<label>Payment Via</label>
					<?php echo $row->payment_via; ?>
				</p>
				
				<p>
					<label>Consult Fee</label>
					<?php echo $row->fee_amount; ?>
				</p>
				
				<p>
					<label>Deal Price</label>
					<?php echo $row->deal_amount; ?>
				</p>
			</div>
		</div>
	</div>
</div>