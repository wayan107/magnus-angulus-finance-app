<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div style="width:600px; margin:auto;">
	<div style="text-align:center;margin-bottom: 30px;">
		<a href="<?php echo $web_link; ?>"><img height="150px" src="<?php echo $logo; ?>"></a>
	</div>
	<div style="margin-bottom: 17px;">
		Dear our valued customer,<br><br>
Hereby we proudly present our newest listings, please don't hesitate to contact us if you have any questions regarding the listings or if you would like to book an inspection schedule, we would be very happy to assist you.
	</div>
	<?php
	foreach($villas as $villa){
		?>
		<div style="width:100%; display:table; margin-bottom: 20px;">
			<div style="width:40%; float:left; position:relative;">
				<div style="max-height:180px; overflow:hidden;
					border: solid 3px #99B506;
					box-shadow: 0px 0px 7px 2px #C3C3C3;
					box-sizing: border-box;
					border-radius: 4px;">
					<a href="<?php echo $villa['link']; ?>">
						<img style="width:100%;" src="<?php echo $villa['imgs']; ?>">
					</a>
				</div>
				<span style="font-size: 20px;
							color: #fff;
							display: block;
							background: #82A110;
							padding: 2px 15px;
							margin-bottom: 5px;
							text-align: center;
							margin-top: 10px;
							">
					<span style="text-transform:uppercase;">
						<?php echo $villa['currency']; ?>
					</span>
					<?php echo number_format($villa['price'],0,',','.');
						if($plan==0)
							echo '/Year';
						else{
							if($villa['holdtype']=='leasehold')
								echo ' /'.$villa['lol'].'Years';
						}
					?>
				</span>
			</div>
			<div style="width:55%; float:left;padding-left: 10px;">
				<h3 style="margin-top: 0;"><a href="<?php echo $villa['link']; ?>" style="color: #778E02;
					text-decoration: none;"><?php echo $villa['title']; ?></a></h3>
				
				<p><?php echo $villa['content']; ?></p>
				<div style="border: solid 1px #D0D0D0;
							border-left: 0;
							border-right: 0;
							text-align: center;
							padding: 8px 0;">
					<?php if($plan==0){ ?>
					<span style="margin-right:10px;
								background: url(http://www.balilongtermrentals.com/wp-content/themes/balilongtermrentals/images/icon/icon-5.png) no-repeat;
								padding-left: 10px;
								display: inline-block;
								text-align: left;">
						<?php echo $villa['land_size']; ?> M2
					</span>
					<span style="margin-right:10px;
								background: url(http://www.balilongtermrentals.com/wp-content/themes/balilongtermrentals/images/icon/icon-2.png) no-repeat;
								padding-left: 25px;
								display: inline-block;
								text-align: left;">
						<?php echo $villa['bedroom']; ?> Bedroom<?php if($villa['bedroom']>1) echo 's'; ?>
					</span>
					<span style="margin-right:10px;
								background: url(http://www.balilongtermrentals.com/wp-content/themes/balilongtermrentals/images/icon/chair_icon.png) no-repeat;
								padding-left: 25px;
								display: inline-block;
								text-align: left;">
						<?php
						if($villa['furnish']=='Y'){
							echo 'Furnished';
						}elseif($villa['furnish']=='N'){
							echo 'Unfurnished';
						}else{
							echo 'Semi Furnished';
						}
						?>
					</span>
					<?php }else{
						$width = 49;
					?>
					<span style="width:<?php echo $width; ?>%; display: inline-block;">
						<span style="background: url(http://www.balivillasales.com/wp-content/themes/villasofbali/images/icon/icon-5.png) no-repeat;
								padding-left: 10px;">
							<?php echo $villa['land_size']; ?> M2
						</span>
					</span>
					<span style="width:<?php echo $width; ?>%; display: inline-block;">
						<span style="background: url(http://www.balivillasales.com/wp-content/themes/villasofbali/images/icon/buildingsize.png) no-repeat;
								padding-left: 25px;">
							<?php echo $villa['buildingsize']; ?> M2
						</span>
					</span>
					<div style="height:10px;"></div>
					<span style="width:<?php echo $width; ?>%; display: inline-block;">
						<span style="background: url(http://www.balivillasales.com/wp-content/themes/villasofbali/images/icon/icon-2.png) no-repeat;
								padding-left: 25px;">
							<?php echo $villa['bedroom']; ?> Bedroom<?php if($villa['bedroom']>1) echo 's'; ?>
						</span>
					</span>
					<span style="width:<?php echo $width; ?>%; display: inline-block;">
						<span style="background: url(http://www.balivillasales.com/wp-content/themes/villasofbali/images/icon/key_icon.png) no-repeat;
								padding-left: 25px; padding-bottom: 16px; text-transform:capitalize;">
							<?php echo $villa['holdtype']; ?>
						</span>
					</span>
					<?php } ?>
				</div>
				<div style="margin-top:10px;">
					<?php if(!empty($villa['promotion_words'])){ ?>
					<div style="display:inline-block; z-index: 9;font-weight:bold;font-size:15px;color:#333;text-align:center;text-shadow:rgba(0, 0, 0, 1) 1px 1px 2px;padding:7px 0;left:-45px;top:35px;width:200px;background-color:#F76262;background-image:-webkit-gradient(linear, left top, left bottom, from(#F76262), to(#FF1D1D));background-image:-webkit-linear-gradient(top, #F76262, #FF1D1D);background-image:-moz-linear-gradient(top, #F76262, #FF1D1D);background-image:-ms-linear-gradient(top, #F76262, #FF1D1D);background-image:-o-linear-gradient(top, #F76262, #FF1D1D);color:#fff;-webkit-box-shadow:0px 0px 3px rgba(0,0,0,0.3);-moz-box-shadow:0px 0px 3px rgba(0,0,0,0.3);box-shadow:0px 0px 3px rgba(0,0,0,0.3);">
						<?php echo $villa['promotion_words']; ?>
					</div>
					<?php } ?>
					<span><a href="<?php echo $villa['link']; ?>" style="color: #778E02;
								text-decoration: none;
								font-size: 17px;">
						See more &raquo;
					</a></span>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<div style="text-align:center;margin-top:30px;">
		Warm Regards,<br>
		Team <?php echo $emaildata['namefrom']; ?><br>
		+62 821-1159-8787 | <?php echo $emaildata['mailfrom']; ?><br>
		​www.balilongtermrentals.com | www.balivillasales.com | www.villasofbali.com
	</div>
	<div style="margin:30px auto; text-align:center;">
		<a href="http://www.villasofbali.com/unsubscribe/?cid=<?php echo $cid; ?>">Click here</a> if you want to stop this email coming to you.
	</div>
	
</div>