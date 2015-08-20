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
			<a class="dashboard-see-details" href="<?php echo base_url() ?>dashboard/openincomedetails">
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
			<a class="dashboard-see-details" href="<?php echo base_url() ?>dashboard/openmoneyindetails/1">
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
			<a class="dashboard-see-details" href="<?php echo base_url() ?>dashboard/openmoneyindetails/0">
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
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Inquiry Stat
				<div class="pull-right">
					<div class="btn-group">
						<?php
						$date = new DateTime();
						$today = $date->format('m/d/Y');
						$date->modify('last month');
						$last_month = $date->format('m/d/Y');
						?>
						From <input type="text" id="from" class="year-period" name="from" value="<?php echo $last_month; ?>">
						to <input type="text" id="to" class="year-period" name="to" value="<?php echo $today; ?>">
					</div>
					<input type="button" id="inquiry-date-range" class="green-button" value="Apply">
					<div class="btn-group">
						<select id="inquiry-year-period" class="year-period">
							<option value="day">Day</option>
							<option value="week">Week</option>
							<option value="month">Month</option>
						</select>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="inquiry-loading-layer panel-body">
				<div id="inquiry-area-chart"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Monthly Sales Turnover
				<div class="pull-right">
					<div class="btn-group">
						<select id="year-period" class="year-period">
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
	
	<div class="col-sm-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Inquiry vs Deal
				<div class="pull-right">
					<select class="year-period" id="ivd-month">
						<?php
						$this_month = (int)date('m');
						$month = array('Jan','Feb','Mar','Apr','Mey','Jun','Jul','Aug','Sep','Oct','Nov','Des');
						foreach($month as $key=>$val){
							?>
							<option value="<?php echo ($key+1) ?>" <?php echo ($this_month == ($key+1)) ? 'selected' : ''; ?>><?php echo $val; ?></option>
							<?php
						}
						?>
					</select>
					<select class="year-period" id="ivd-year">
						<?php
						for($i=date('Y'); $i>=2015;$i--){
							?>
							<option value="<?php echo $i ?>"><?php echo $i; ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="inquiryvsdeal-loading-layer panel-body">
				<div id="chart2"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Agent Deal Rate
			</div>
			<!-- /.panel-heading -->
			<div class="dealrate-loading-layer panel-body">
				<div id="dealrate"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> Area Popularity In Last 30 Days
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="popular-area"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
</div>