<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="width:600px; margin:auto;">
	<div style="text-align:center;margin-bottom: 30px;">
		<img height="150px" src="http://www.balilongtermrentals.com/wp-content/uploads/2015/03/balilongtermrentals1.jpg">
	</div>
	<div style="margin-bottom: 17px;">
		We proudly present our top ten new listings for you.
	</div>
	<?php
	foreach($villas as $villa){
		?>
		<div style="width:100%; display:table; margin-bottom: 20px;">
			<div style="width:40%; max-height:180px; overflow:hidden; float:left; position:relative;
			    border: solid 3px #99B506;
				box-shadow: 0px 0px 7px 2px #C3C3C3;
				box-sizing: border-box;
				border-radius: 4px;">
				<img style="width:100%;" src="<?php echo $villa['imgs'][0]; ?>">
			</div>
			<div style="width:55%; float:left;padding-left: 10px;">
				<h3 style="margin-top: 0;"><?php echo $villa['title']; ?></h3>
				<p><?php echo $villa['content']; ?></p>
				<span><a href="<?php echo $villa['link']; ?>" style="color: #778E02;
					text-decoration: none;
					font-size: 17px;">See more &raquo;</a></span>
				<?php if(!empty($villa['promotion_words'])){ ?>
				<div style="z-index: 9;font-weight:bold;font-size:15px;color:#333;text-align:center;text-shadow:rgba(0, 0, 0, 1) 1px 1px 2px;-webkit-transform:rotate(-45deg)!important;-moz-transform:rotate(-45deg)!important;-ms-transform:rotate(-45deg)!important;-o-transform:rotate(-45deg)!important;position:relative;padding:7px 0;left:-45px;top:35px;width:200px;background-color:#F76262;background-image:-webkit-gradient(linear, left top, left bottom, from(#F76262), to(#FF1D1D));background-image:-webkit-linear-gradient(top, #F76262, #FF1D1D);background-image:-moz-linear-gradient(top, #F76262, #FF1D1D);background-image:-ms-linear-gradient(top, #F76262, #FF1D1D);background-image:-o-linear-gradient(top, #F76262, #FF1D1D);color:#fff;-webkit-box-shadow:0px 0px 3px rgba(0,0,0,0.3);-moz-box-shadow:0px 0px 3px rgba(0,0,0,0.3);box-shadow:0px 0px 3px rgba(0,0,0,0.3);">
					<?php echo $villa['promotion_words']; ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php
	}
	?>
</div>