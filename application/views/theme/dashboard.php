<div class="row">
	<div class="col-lg-4 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-dollar fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">IDR <?php echo $fee->consult_fee; ?></div>
						<div>Income This Month</div>
					</div>
				</div>
			</div>
			<a href="<?php echo base_url() ?>deals/">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-download fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">IDR <?php echo $money_in; ?></div>
						<div>Cash In This Month</div>
					</div>
				</div>
			</div>
			<a href="#">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-refresh fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">IDR <?php echo $money_on_going; ?></div>
						<div>On Going Money</div>
					</div>
				</div>
			</div>
			<a href="#">
				<div class="panel-footer">
					<span class="pull-left">View Details</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Sales Graph
				<div class="pull-right">
					<div class="btn-group">
						<select id="year-period">
							<?php 
								for($i=2015;$i>=2014;$i--){
									?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="loading-layer panel-body">
				<div id="morris-area-chart"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
</div>
			