<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="pop-up-window">
	<div class="wrapper">
	<i class="fa fa-close close"></i>
	<?php
	foreach($query->result_array() as $dt){
		?>
		<div class="row">
			<div class="col-sm-3">
				<h3>Contract Number</h3>
				<p><?php echo $dt['contract_number']; ?></p>
			</div>
			<div class="col-sm-3">
				<h3>Payment Status</h3>
				<p>
					<?php
						if($is_payment_complete){
							$class="status-complete";
							$title="Complete";
							$status_class="fa-check-square";
						}else{
							$class="status-on-going";
							$title="On Going";
							$status_class="fa-refresh";
						}
					?>
					<span title="<?php echo $title; ?>" class="<?php echo $class; ?>">
						<i class="fa fa-4x <?php echo $status_class; ?>"></i>
					</span>
				</p>
			</div>
			<div class="col-sm-3">
				<h3>Deposit In</h3>
				<p><?php echo $dt['deposit_currency'].' '.number_format($dt['deposit'],0,'.',','); ?></p>
			</div>
			<div class="col-sm-3">
				<h3>Deposit Date in</h3>
				<p><?php echo $dt['deposit_in']; ?></p>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="row">
			<div class="col-sm-3">
				<h3>Villa Details</h3>
				<p>
					<label>Villa Code</label> <?php echo $dt['villa_code']; ?>
				</p>
				<p>
					<label>Area</label> <?php echo $dt['area_name']; ?>
				</p>
				<p>
					<label>Owner</label> <?php echo $dt['owner_name']; ?>
				</p>
			</div>
			<div class="col-sm-3">
				<h3>Client Details</h3>
				<p>
					<label>Client</label> <?php echo $dt['client_name']; ?>
				</p>
				<p>
					<label>Check In</label> <?php echo $dt['checkin_date']; ?>
				</p>
				<p>
					<label>Check Out</label> <?php echo $dt['checkout_date']; ?>
				</p>
				<p>
					<label>Rental Type</label> <?php if($dt['rental_type']==0){ echo 'Yearly'; $duration='Year'; }else{ echo 'Monthly'; $duration='Month'; } ?>
				</p>
			</div>
			
			<div class="col-sm-3">
				<h3>Deal Date & Amount</h3>
				<p>
					<label>Deal Date</label> <?php echo $dt['deal_date']; ?>
				</p>
				<p>
					<label>Deal Amount</label> <?php echo $dt['deal_price_currency'].' '.number_format($dt['deal_price'],0,'.',','); ?>
				</p>
				<p>
					<label>Payment Via</label> <?php echo $dt['payment_via']; ?>
				</p>
				<p>
					<label>Rental Duration</label> <?php echo $dt['rental_duration'].' '.$duration; echo ($dt['rental_duration']>1) ? 's' : ''; ?>
				</p>
			</div>
			
			<div class="col-sm-3">
				<h3>Consult Fee & Agent</h3>
				<p>
					<label>Consult Fee</label> <?php echo $dt['consult_fee_currency'].' '.number_format($dt['consult_fee'],0,'.',','); ?>
				</p>
				<p>
					<label>Sales Agent</label> <?php echo $dt['sales']; ?>
				</p>
				<p>
					<label>Listing Agent</label> <?php echo (!empty($dt['listing'])) ? $dt['listing'] : 'Office'; ?>
				</p>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="row">
			<div class="col-sm-6">
				<h3>Deal Payment Plan</h3>
				<div class="row">
				<div class="col-sm-6">
					<label>Amount</label>
				</div>
				<div class="col-sm-6">
					<label>Due Date</label>
				</div>
				<?php
				foreach($deal_payment_plan->result_array() as $dpp){
					?>
					<div class="col-sm-6">
						<?php echo $dpp['currency'].' '.number_format($dpp['amount'],0,'.',','); ?>
					</div>
					<div class="col-sm-6">
						<?php echo $dpp['date']; ?>
					</div>
					<?php
				}
				?>
				</div>
			</div>
			
			<div class="col-sm-6">
				<h3>Fee Payment Plan</h3>
				<div class="row">
				<div class="col-sm-6">
					<label>Amount</label>
				</div>
				<div class="col-sm-6">
					<label>Due Date</label>
				</div>
				<?php
				foreach($fee_payment_plan->result_array() as $dpp){
					?>
					<div class="col-sm-6">
						<?php echo $dpp['currency'].' '.number_format($dpp['amount'],0,'.',','); ?>
					</div>
					<div class="col-sm-6">
						<?php echo $dpp['date']; ?>
					</div>
					<?php
				}
				?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	</div>
</div>