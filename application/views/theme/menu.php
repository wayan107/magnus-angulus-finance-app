<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">Magnus Angulus Finance App</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
				<li>Hi <?php echo $user_display_name; ?></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url(); ?>users/userprofile/"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <!--<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>auth/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			
			<div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo base_url(); ?>" id="dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>deals/"><i class="fa fa-dollar fa-fw"></i> Deals</a>
                            <!-- /.nav-second-level -->
                        </li>
						
                        <?php if(in_array($userrole,unserialize(MASTERDATA))){ ?>
						<li>
                            <a href="#"><i class="fa fa-database fa-fw"></i> Master Data<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>area/">Area</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>agent/">Agent</a>
                                </li>
								<li>
                                    <a href="<?php echo base_url() ?>client/">Client</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>owner/">Owner</a>
                                </li>
								<?php if(in_array($userrole,unserialize(USERS))){ ?>
								<li>
                                    <a href="<?php echo base_url() ?>users/">Users</a>
                                </li>
								<?php } ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<?php } ?>
						
						<li>
							<a href="<?php echo base_url(); ?>paymentplan/"><i class="fa fa-money fa-fw"></i>Payment Plan</a>
						</li>
						
						<?php if(in_array($userrole,unserialize(REPORTS))){ ?>
						 <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if(in_array($userrole,unserialize(FINDTHEMONEY))){ ?>
								<li>
                                    <a href="<?php echo base_url(); ?>moneyin/">Find The Money</a>
                                </li>
								<?php } ?>
								
                                <li>
                                    <a href="<?php echo base_url(); ?>agentcommission">Agent Commission</a>
                                </li>
                            </ul>
                        </li>
						<?php } ?>
						<!--admin menu end-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>