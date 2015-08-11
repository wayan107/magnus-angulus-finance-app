<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if($show=='form'){
	echo form_open($action);
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="text-right">
				<?php echo form_submit('submit',$tombol,'class="btn btn-primary"'); ?>
				<a href="<?php echo $cancel; ?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<div class="row secions">
					<div class="col-sm-4">
						<label>Inquiry date in</label>
						<input type="text" required class="form-control datepicker" name="inquiry_date" value="<?php echo $inquiry_date; ?>">
					</div>
					<div class="col-sm-4">
						<label>Client <a href="javascript:;" title="Click to add new client instantly" id="add-client"><i class="fa fa-plus-circle"></i></a></label>
						<?php
						$options=$this->dealsmodel->get_client_dropdown();
						echo form_dropdown('client',$options,$client,'id="client-box" class="form-control" required');
						?>
					</div>
					<div class="col-sm-4">
						<label>Plan: </label>
						<?php
							echo form_dropdown('plan',array('Rent','Buy','Monthly'),$plan,'id="plan" class="form-control" required');
						?>
					</div>
				</div>
				
				<div class="row secions">
					<div class="col-sm-4">
						<label>Budget: </label>
						<span id="budget">
						<?php
							echo form_dropdown('budget[]',$initial_budget,$budget,'class="form-control" id="budget" multiple="multiple"');
						?>
						</span>
					</div>
					<div class="col-sm-4">
						<label>Plan Move in: </label>
						<input type="text" class="form-control datepicker" name="plan_move_in" value="<?php echo $plan_move_in; ?>">
					</div>
					<div class="col-sm-4">
						<label>Bedroom: </label>
						<select name="bedroom[]" multiple="multiple" id="bedroom">
						<?php
							$bedroom_list = array(
												'1' => '1 Bedroom',
												'2'	=> '2 Bedrooms',
												'3'	=> '3 Bedrooms',
												'4'	=> '4 Bedrooms',
												'5+'	=> '5+ Bedrooms'
											);
							foreach($bedroom_list as $key=>$val){
								$selected = '';
								if(!empty($bedroom)){
									$selected = (in_array($key,$bedroom)) ? 'selected' : '';
								}
								?>
									<option value="<?php echo $key; ?>" <?php $selected ?>><?php echo $val; ?></option>
								<?php
							}
						?>
						</select>
					</div>
				</div>
				
				<div class="row secions">
					<div class="col-sm-4" id="planmoveout" <?php echo ($plan!=2) ? 'style="display:none;"' : ''; ?>>
						<label>Plan Move out: </label>
						<input type="text" class="form-control datepicker" name="plan_move_out" value="<?php echo $plan_move_out; ?>">
					</div>
					<div class="col-sm-4">
						<label>Furnishing: </label>
						<?php
							$opts = array(
										'0'	=> 'Any Furnishing',
										'1'	=> 'Furnished',
										'2'	=> 'Semi-Furnished',
										'3'	=> 'Unfurnished'
									);
							echo form_dropdown('furnishing',$opts,$furnishing,'class="form-control"');
						?>
					</div>
					<div class="col-sm-4">
						<span id="hold-living">
							<?php if($plan=='1'){ ?>
							<label>Hold: </label>
							<?php
								$opts = array(
											'0'	=> 'Any Hold',
											'1'	=> 'Freehold',
											'2'	=> 'Leasehold'
										);
								echo form_dropdown('living',$opts,$hold,'class="form-control"');
							?>
							<?php }else{ ?>
							<label>Living: </label>
							<?php
								$opts = array(
											'0'	=> 'Any Living',
											'1'	=> 'Open Living',
											'2'	=> 'Close Living'
										);
								echo form_dropdown('living',$opts,$living,'class="form-control"');
							}?>
						</span>
					</div>
					
					<div class="col-sm-4">
						<label>Interested Villas: </label>
						<?php
							$villas = '';
							$interested_villa = unserialize($interested_villa);
							if(!empty($interested_villa['villacode'])){
								$villas = implode(',',$interested_villa['villacode']);
							}
						?>
						<input type="text" class="form-control" name="interested_villa" value="<?php echo $villas; ?>" placeholder="ex. CA0025Y, UM0250Y, CA0120Y">
					</div>
					
				</div>
				
				<div class="row secions">
					<div class="col-sm-12">
						<label>Preferable Area: </label>
						<ul id="area-list">
						<?php
							$areas = $this->area->get_areas();
							foreach($areas as $area){
								$checked = (in_array($area['prefix'],$areas_prefer)) ? 'checked' : '';
								?>
								<li>
									<input type="checkbox" name="area[]" <?php echo $checked; ?> value="<?php echo $area['prefix'] ?>" id="<?php echo $area['prefix']; ?>">
									<label for="<?php echo $area['prefix']; ?>"><?php echo $area['name']; ?></label>
								</li>
								<?php
							}
						?>
						</ul>
					</div>
					<div class="col-sm-12">
						<label>Additional Message</label>
						<textarea name="inquiry_msg" rows='8' class="form-control"><?php echo $inquiry_msg; ?></textarea>
					</div>
				</div>
			</div>
		</div>
		<!-- /.panel-body -->
		<div class="panel-footer">
			<div class="text-right">
				<?php echo form_submit('submit',$tombol,'class="btn btn-primary"'); ?>
				<a href="<?php echo $cancel; ?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</div>
	<?php
	//echo form_submit('submit',$tombol,'class="btn btn-primary pull-right"');
	echo form_close();
	
	$this->load->view('theme/add-client-owner-ajax');
}elseif($show=='data'){
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-1"><?php echo $add; ?></div>
				<div class="col-sm-11 text-right <?php echo $filter_class; ?> filter">
					<form action="<?php echo base_url().$this->uri->segment(1); ?>" method="post">
					<span id="date-filter-label"><?php if (!empty($_POST['status']) && $_POST['status']=='Deal') echo 'Deal'; else echo 'Inquiry'; ?></span> Date From:
					<input type="text" class="datepicker" name="date-start" value="<?php if (!empty($_POST['date-start'])) echo $_POST['date-start'];; ?>">
					to
					<input type="text" class="datepicker" name="date-end" value="<?php if(!empty($_POST['date-end'])) echo $_POST['date-end']; ?>">
					<?php
					
					if($this->myci->user_role=='sales_manager'){
						$options=$this->dealsmodel->get_agent_dropdown('Sales Agent','All Agent');
						$default=(!empty($_POST['agent'])) ? $_POST['agent'] : '';
						echo form_dropdown('agent',$options,$default);
					}
						
					$options = $this->config->item('status_dropdown_list');
					array_unshift($options,'All Status');
					$default=(!empty($_POST['status'])) ? $_POST['status'] : '';
					echo form_dropdown('status',$options,$default,'id="filter-status"');
					
					//$search=(!empty($_POST['search'])) ? $_POST['search'] : '';
					?>
					<input type="submit" class="btn btn-primary" name="filter" value="Submit"/>
					</form>
				</div>
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
			<?php if(!empty($_POST['filter']) && $this->myci->user_role=='sales_manager'){ ?>
			<div class="row text-right">
				<div class="col-sm-12">
					<a href="<?php echo base_url(); ?>inquiries/export/<?php echo $export_params; ?>" class="btn btn-primary">Export to Excel</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php
}
?>