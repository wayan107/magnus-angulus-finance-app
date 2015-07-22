<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
	echo form_open($action,array('id'=>'deals-form'));
	?>
	<input type="hidden" name="post-status" value="finalized-deal">
	<div class="row"><!--start Row-->
		<div class="col-sm-4 section">
			<div class="title">Contract Number</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-12">
						<input type="text" name="contract_number" class="form-control" value="<?php echo $contract_number; ?>" required >
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-3 section">
			<div class="title">Deposit</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-4" style="padding-right: 0;">
						<?php 
						echo form_dropdown('deposit_currency',unserialize(CURRENCY),$deposit_currency,'style="width:60px;" class="form-control small-currency-box"');
						?>
					</div>
					<div class="col-sm-8" style="padding-left: 0;">
						<?php
						$f = array(
							'name'        => 'deposit',
							'id'			=> 'deposit',
							'value'       => $deposit,
							'type'		=> 'number',
							'class'		=> 'form-control'
							);
						echo form_input($f);
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-3 section">
			<div class="title">Deposit in</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-12">
						<?php
						$f = array(
							'name'        => 'deposit_in',
							'id'			=> 'deposit_in',
							'value'       => $deposit_in,
							'type'		=> 'text',
							'class'		=> 'form-control datepicker'
							);
						echo form_input($f);
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-2 section">
			<div class="title">Payment Status</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-12">
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
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12 section">
			<div class="title">Villa Details</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-3">
						<label>Villa Code</label>
						<?php
						$f = array(
							'name'        => 'villa_code',
							'id'			=> 'villa_code',
							'value'       => $villa_code,
							'required'	=> 'required',
							'class'		=> 'form-control'
							);
						echo form_input($f);
						?>
					</div>
					
					<div class="col-sm-3">
						<label>Area</label>
						<?php
						$options=$this->dealsmodel->get_area_dropdown();
						echo form_dropdown('area',$options,$area,'class="form-control" required');
						?>
					</div>
					
					<div class="col-sm-3">
						<label>Owner <a href="javascript:;" title="Click to add new owner instantly" id="add-owner"><i class="fa fa-plus-circle"></i></a></label>
						<?php
						$options=$this->dealsmodel->get_owner_dropdown();
						echo form_dropdown('owner',$options,$owner,'id="owner-box" class="form-control" required');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 section">
			<div class="title">Client Details</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-3">
					<label>Client <a href="javascript:;" title="Click to add new client instantly" id="add-client"><i class="fa fa-plus-circle"></i></a></label>
						<?php
						$options=$this->dealsmodel->get_client_dropdown();
						echo form_dropdown('client',$options,$client,'id="client-box" class="form-control" required');
						?>
					</div>
					
					<div class="col-sm-3">
					<label>Check in Date</label>
						<?php
							$f = array(
							'name'        => 'checkin_date',
							'id'			=> 'checkin_date',
							'value'       => $checkin_date,
							'required'	=>'required',
							'type'		=> 'text',
							'class'		=> 'form-control datepicker'
							);
							echo form_input($f);
						?>
					</div>
					
					<div class="col-sm-3">
					<label>Check out Date</label>
						<?php
							$f = array(
							  'name'        => 'checkout_date',
							  'id'			=> 'checkout_date',
							  'value'       => $checkout_date,
							  'required'	=> 'required',
							  'type'		=> 'text',
							  'class'		=> 'form-control datepicker'
							);
							echo form_input($f);
						?>
					</div>
					
					<div class="col-sm-3">
						<label>Rental Type</label>
						<?php
							$options=array(
											'0'	=> 'Yearly',
											'1' => 'Monthly'
										);
							echo form_dropdown('rental_type',$options,$rental_type,'id="rental-type" class="form-control"');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 section">
			<div class="title">Deal Date & Amount</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-3">
					<label>Deal date</label>
					<?php
						$f = array(
						'name'        => 'deal_date',
						'id'			=> 'deal_date',
						'value'       => $deal_date,
						'required'	=>'required',
						'type'		=> 'text',
						'class'		=> 'form-control datepicker'
						);
						echo form_input($f);
					?>
					</div>
					
					<div class="col-sm-3">
					<label>Deal Amount</label>
					<?php
						$f = array(
						'name'        => 'deal_price',
						'id'			=> 'deal_price',
						'value'       => $deal_price,
						'required'	=>'required',
						'type'		=> 'number',
						'class'		=> 'form-control'
						);
						echo form_input($f);
					?>
					</div>
					
					<div class="col-sm-3">
					<label>Deal Amount Currency</label>
						<?php
						echo form_dropdown('deal_price_currency',unserialize(CURRENCY),$deal_price_currency,'class="form-control" required');
						?>
					</div>
					
					<div class="col-sm-3">
						<label>Rental Duration</label>
						<?php
							$options=array(
											'1'	=> '1',
											'2' => '2',
											'3'	=> '3',
											'4' => '4',
											'5'	=> '5',
											'6' => '6',
											'7'	=> '7',
											'8' => '8',
											'9'	=> '9',
											'10'	=> '10',
											'11'	=> '11',
											'12'	=> '12'
										);
							echo form_dropdown('rental_duration',$options,$rental_duration,'class="form-control"');
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-12 section">
			<div class="title">Consult Fee & Agent</div>
			<div class="row">
				<div class="block">
					<div class="col-sm-3">
					<label>Consult fee</label>
					<?php
						$f = array(
						'name'        => 'consult_fee',
						'id'			=> 'consult_fee',
						'value'       => $consult_fee,
						'required'	=>'required',
						'type'		=> 'number',
						'class'		=> 'form-control'
						);
						echo form_input($f);
					?>
					</div>
					
					<div class="col-sm-3">
					<label>Consult fee currency</label>
						<?php
							echo form_dropdown('consult_fee_currency',unserialize(CURRENCY),$consult_fee_currency,'class="form-control" required');
						?>
					</div>
					
					<div class="col-sm-3">
					<label>Sales Agent</label>
						<?php
							$options=$this->dealsmodel->get_agent_dropdown('Sales Agent');
							echo form_dropdown('sales_agent',$options,$sales_agent,'class="form-control" required');
						?>
					</div>
					
					<div class="col-sm-3">
					<label>Listing Agent</label>
						<?php
							$options=$this->dealsmodel->get_agent_dropdown('Listing Agent');
							echo form_dropdown('listing_agent',$options,$listing_agent,'class="form-control"');
						?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-sm-6 section">
			<div class="title margin-bot-30">Deal Payment Plan</div>
			<div class="row">
				<div class="col-sm-5">
					<label>Amount</label>
				</div>
				<div class="col-sm-2">
					<label>Currency</label>
				</div>
				<div class="col-sm-4">
					<label>Date</label>
				</div>
			</div>
			<div class="row">
				<div class="plan">
					<div class="col-sm-5">
						<input type="hidden" name="deal_plan_payment_id[]" value="<?php echo (!empty($deal_plan_payment_id)) ? $deal_plan_payment_id : 'null'; ?>">
						<?php if(!empty($deal_plan_payment_id)){ ?>
							<input type="hidden" name="deal_plan_paid[]" value="<?php echo $deal_plan_paid; ?>">
							<input type="hidden" name="deal_plan_ref_number[]" value="<?php echo $deal_plan_ref_number; ?>">
						<?php } ?>
						<input type="number" name="deal_plan_amount[]" value="<?php echo (!empty($deal_plan_amount)) ? $deal_plan_amount : ''; ?>" required class="form-control small-common-box">
					</div>
					<div class="col-sm-2">
						<?php
						$selected = (!empty($deal_plan_currency)) ? $deal_plan_currency : '';
						echo form_dropdown('deal_plan_currency[]',unserialize(CURRENCY),$selected,'class="form-control small-currency-box" required');
						?>
					</div>
					<div class="col-sm-4">
						<input type="text" name="deal_plan_date[]" value="<?php echo (!empty($deal_plan_date)) ? $deal_plan_date : ''; ?>" required class="datepicker form-control small-common-box">
					</div>
				</div>
				<?php
					if(!empty($deal_payment_plan_query)){
						$skipped=false;
						foreach($deal_payment_plan_query as $q){
							if($skipped){
							?>
							<div class="plan">
								<div class="col-sm-5">
									<input type="hidden" name="deal_plan_payment_id[]" value="<?php echo $q['id']; ?>">
									<input type="hidden" name="deal_plan_paid[]" value="<?php echo $q['paid']; ?>">
									<input type="hidden" name="deal_plan_ref_number[]" value="<?php echo $q['ref_number']; ?>">
									<input type="number" name="deal_plan_amount[]" value="<?php echo $q['amount']; ?>" required class="form-control small-common-box">
								</div>
								<div class="col-sm-2">
									<?php
									echo form_dropdown('deal_plan_currency[]',unserialize(CURRENCY),$q['currency'],'class="form-control small-currency-box" required');
									?>
								</div>
								<div class="col-sm-4">
									<input type="text" name="deal_plan_date[]" value="<?php echo $q['date']; ?>" required class="datepicker form-control small-common-box">
								</div>
								<div class="col-sm-1"><i class="fa fa-minus-circle remove-plan" rel="<?php echo $q['id']; ?>"></i></div>
							</div>
							<?php
							}
							$skipped=true;
						}
					}
				?>
				<span class="add-plan" rel="deal_plan_"><i class="fa fa-plus-circle"></i> Add</span>
			</div>
		</div>
		
		<div class="col-sm-6 section">
			<div class="title margin-bot-30">Fee Payment Plan</div>
			<div class="row">
				<div class="col-sm-5">
					<label>Amount</label>
				</div>
				<div class="col-sm-2">
					<label>Currency</label>
				</div>
				<div class="col-sm-4">
					<label>Date</label>
				</div>
			</div>
			<div class="row">
				<div class="plan">
					<div class="col-sm-5">
						<input type="hidden" name="fee_plan_payment_id[]" value="<?php echo (!empty($fee_plan_payment_id)) ? $fee_plan_payment_id : 'null'; ?>">
						<?php if(!empty($fee_plan_payment_id)){ ?>
							<input type="hidden" name="fee_plan_paid[]" value="<?php echo $fee_plan_paid; ?>">
							<input type="hidden" name="fee_plan_ref_number[]" value="<?php echo $fee_plan_ref_number; ?>">
						<?php } ?>
						<input type="number" name="fee_plan_amount[]" required value="<?php echo (!empty($fee_plan_amount)) ? $fee_plan_amount : ''; ?>" class="form-control small-common-box">
					</div>
					<div class="col-sm-2">
						<?php
						$selected = (!empty($fee_plan_currency)) ? $fee_plan_currency : '';
						echo form_dropdown('fee_plan_currency[]',unserialize(CURRENCY),$selected,'class="form-control small-currency-box" required');
						?>
					</div>
					<div class="col-sm-4">
						<input type="text" name="fee_plan_date[]" value="<?php echo (!empty($fee_plan_date)) ? $fee_plan_date : ''; ?>" required class="datepicker form-control small-common-box">
					</div>
				</div>
				<?php
					if(!empty($fee_payment_plan_query)){
						$skipped=false;
						foreach($fee_payment_plan_query as $q){
							if($skipped){
								?>
								<div class="plan">
									<div class="col-sm-5">
										<input type="hidden" name="fee_plan_payment_id[]" value="<?php echo $q['id']; ?>">
										<input type="hidden" name="fee_plan_paid[]" value="<?php echo $q['paid']; ?>">
										<input type="hidden" name="fee_plan_ref_number[]" value="<?php echo $q['ref_number']; ?>">
										<input type="number" name="fee_plan_amount[]" value="<?php echo $q['amount']; ?>" required class="form-control small-common-box">
									</div>
									<div class="col-sm-2">
										<?php
										echo form_dropdown('fee_plan_currency[]',unserialize(CURRENCY),$q['currency'],'class="form-control small-currency-box" required');
										?>
									</div>
									<div class="col-sm-4">
										<input type="text" name="fee_plan_date[]" value="<?php echo $q['date']; ?>" required class="datepicker form-control small-common-box">
									</div>
									<div class="col-sm-1"><i class="fa fa-minus-circle remove-plan" rel="<?php echo $q['id']; ?>"></i></div>
								</div>
								<?php
							}
							$skipped=true;
						}
					}
				?>
				<span class="add-plan" rel="fee_plan_"><i class="fa fa-plus-circle"></i> Add</span>
			</div>
			
		</div>
		
		<div class="col-sm-12 section">
			<br>
			<div class="title margin-bot-30">Remark</div>
			<textarea name="remark" class="remark"><?php echo $remark ?></textarea>
		</div>
		
		<div class="form-button-control text-right col-sm-12">
			<a href="<?php echo base_url(); ?>deals/" class="btn btn-primary">Cancel</a>
			<input type="submit" class="btn btn-primary" name="save-deal" value="<?php echo $tombol; ?>"/>
		</div>
	</div><!--end row-->
	<?php
	//echo form_submit('submit',$tombol,'class="btn btn-primary pull-right"');
	echo form_close();
	
	$this->load->view('theme/add-client-owner-ajax');
}elseif($show=='data'){
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo $add; ?>
			<div class="<?php echo $filter_class; ?> filter">
				<form method="post">
				Filter:
				<input type="text" class="datepicker" name="date-start" value="<?php if (!empty($_POST['date-start'])) echo $_POST['date-start'];; ?>">
				to
				<input type="text" class="datepicker" name="date-end" value="<?php if(!empty($_POST['date-end'])) echo $_POST['date-end']; ?>">
				<?php
				$options=$this->dealsmodel->get_area_dropdown();
				$default=(!empty($_POST['area'])) ? $_POST['area'] : '';
				echo form_dropdown('area',$options,$default);
				
				$search=(!empty($_POST['search'])) ? $_POST['search'] : '';
				?>
				<input type="text" name="search" placeholder="Search" value="<?php echo $search; ?>">
				<input type="submit" class="btn btn-primary" name="filter" value="Submit"/>
				</form>
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row"><?php echo $tabel; ?></div>
				<div class="row text-right">
					<div class="paging">
						<?php echo $page; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
		<div class="panel-footer">
			<div class="text-right">
				<a href="<?php echo base_url(); ?>/deals/import" class="btn btn-primary">Import Data Deal</a>
			</div>
		</div>
	</div>
	<?php
}
?>