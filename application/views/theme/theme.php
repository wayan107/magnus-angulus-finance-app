<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>
	
	 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>/asset/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>/asset/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        
		<?php echo $_menu; ?>

        <div id="page-wrapper" class="puput-bg">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $_page_title; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php echo $_content; ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	<script type="text/javascript">
		var baseurl = '<?php echo base_url(); ?>';
	</script>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/asset/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.1/jquery.form-validator.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>/asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>/asset/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <script src="<?php echo base_url(); ?>/asset/dist/js/my-js-small-plugin.js"></script>
	<script src="<?php echo base_url(); ?>/asset/dist/js/sb-admin-2.js"></script>
	
	<?php if($this->myci->is_home()){ ?>
		<script>
			var salesData = '<?php echo $datasales; ?>';
			salesData = JSON.parse(salesData);
		</script>
		 <!-- Morris Charts JavaScript -->
		<script src="<?php echo base_url(); ?>/asset/bower_components/raphael/raphael-min.js"></script>
		<script src="<?php echo base_url(); ?>asset/bower_components/morrisjs/morris.min.js"></script>
		<script src="<?php echo base_url(); ?>/asset/js/morris-data.js"></script>
	<?php }
		
		if(!$this->myci->is_home()){
			?>
			<script>
				jQuery(document).ready(function(){
					jQuery('#dashboard').removeClass('active');
				});
			</script>
			<?php
		}
	?>
	
    <!-- Custom Theme JavaScript -->
    
	<?php
	$url=$_SERVER['REQUEST_URI'];
	preg_match('/deals\/add/',$url,$deal_add);
	$url=$_SERVER['REQUEST_URI'];
	preg_match('/deals\/update/',$url,$deal_update);
	
	if(!empty($deal_add) || !empty($deal_update)){
	?>
	<script>
	jQuery(document).ready(function(){
		jQuery('.nav a').click(function(){
			window.onbeforeunload = confirmExit;
		});
		
		function confirmExit(){
			return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.";
		}
		
		$.validate({
			modules : 'html5'
		});
	});
	</script>
	<?php } ?>
</body>

</html>
