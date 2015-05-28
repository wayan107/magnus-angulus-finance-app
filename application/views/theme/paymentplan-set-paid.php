<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="form">
		<i class="fa fa-close close"></i>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<label>Paid Amount</label>
					<input type="number" name="paid_amount" id="paid_amount" value="<?php echo $row->amount; ?>">
				</p>
				
				<p>
				<label>Currency</label>
				<?php echo form_dropdown('currency',unserialize(CURRENCY),$row->currency,'id="currency"'); ?>
				</p>
				
				<p>
				<label>Pay Date</label>
				<input type="text" name="pay_date" class="datepicker" id="pay_date" value="<?php echo $row->date; ?>">
				</p>
				
				<p>
				<label>Payment Via</label>
				<?php echo form_dropdown('payment_via',array('Cash'=>'Cash','Bank'=>'Bank'),'','id="payment_via"'); ?>
				</p>
			</div>
			
			<div class="col-sm-12">
				<input type="button" id="cancel" value="Cancel" class="btn btn-primary">
				<input type="button" rel="<?php echo $id; ?>" id="submit" value="Submit" class="btn btn-primary">
				<i class="fa fa-circle-o-notch fa-spin hidden loading"></i>
			</div>
		</div>
	</div>
</div>