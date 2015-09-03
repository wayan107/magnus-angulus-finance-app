<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Magnus Angulus Finance App</title>
	
	 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>/asset/dist/css/timeline.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>/asset/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>/asset/dist/css/sb-admin-2.css" rel="stylesheet">
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

        <div id="page-wrapper" class="<?php echo ($userrole=='admin') ? 'puput-bg' : ''; ?>">
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
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>asset/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>asset/bower_components/metisMenu/dist/metisMenu.min.js"></script>
    
    <script src="<?php echo base_url(); ?>asset/dist/js/my-js-small-plugin.js"></script>
	<script src="<?php echo base_url(); ?>asset/dist/js/jquery.form.js"></script>
	<script src="<?php echo base_url(); ?>asset/dist/js/sb-admin-2.js"></script>
	
	<?php if($this->myci->is_home()){ ?>
		<script>
			var salesData = '<?php echo $datasales; ?>';
			salesData = JSON.parse(salesData);
			
			var inquiryData = '<?php echo $datainquiry; ?>';
			inquiryData = JSON.parse(inquiryData);
			
			var inquiryanddealData = '<?php echo $inquiryanddeal; ?>';
			inquiryanddealData = JSON.parse(inquiryanddealData);
			
			var popularAreaData = '<?php echo $popularareadata; ?>';
			popularAreaData = JSON.parse(popularAreaData);
			
			var dealrate = '<?php echo $dealrate; ?>';
			dealrate = JSON.parse(dealrate);
		</script>
		 <!-- Morris Charts JavaScript -->
		<script src="<?php echo base_url(); ?>asset/bower_components/raphael/raphael-min.js"></script>
		<script src="<?php echo base_url(); ?>asset/bower_components/morrisjs/morris.min.js"></script>
		
		<link href="<?php echo base_url(); ?>/asset/jqplot/jquery.jqplot.min.css" rel="stylesheet">
		<script src="<?php echo base_url(); ?>asset/jqplot/jquery.jqplot.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/jqplot/plugins/jqplot.barRenderer.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/jqplot/plugins/jqplot.pointLabels.min.js"></script>
		
		<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>asset/bower_components/flot/jquery.flot.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>asset/bower_components/flot/jquery.flot.pie.js"></script>

		<script src="<?php echo base_url(); ?>asset/dist/js/dashboard.js"></script>
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
	//$url=$_SERVER['REQUEST_URI'];
	preg_match('/deals\/update/',$url,$deal_update);
	preg_match('/inquiries/',$url,$inquiries);
	
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
	});
	</script>
	<?php }
	
	if(!empty($inquiries)){
		?>
		<script src="<?php echo base_url(); ?>asset/dist/js/inquiries.js"></script>
		<?php
	}
	?>
	<?php preg_match('/inquiries/',$url,$inquiry_add);
		if(!empty($inquiry_add)){ ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/multiselect/jquery.multiselect.css">
		<script src="<?php echo base_url(); ?>asset/multiselect/src/jquery.multiselect.min.js"></script>
		<script>
			jQuery(document).ready(function(){
				$("select#budget").multiselect({
					selectedList: 1,
					noneSelectedText: 'Any Budget',
					header: false
				});
				
				$("select#bedroom").multiselect({
					selectedList: 1,
					noneSelectedText: 'Any Bedroom',
					header: false
				});
			});
		</script>
		<?php } ?>
</body>

</html>
