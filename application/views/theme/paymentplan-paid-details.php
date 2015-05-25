<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="form">
		<i class="fa fa-close close"></i>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<label>Paid Amount</label>
					<?php echo number_format($row->paid_amount,0,'.',','); ?>
				</p>
				
				<p>
					<label>Currency</label>
					<?php echo $row->payment_currency; ?>
				</p>
				
				<p>
					<label>Pay Date</label>
					<?php echo $row->pay_date; ?>
				</p>
				
				<p>
					<label>Payment Via</label>
					<?php echo $row->payment_via; ?>
				</p>
			</div>
		</div>
	</div>
</div>