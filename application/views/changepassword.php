<!DOCTYPE html>
<html lang="en">
<head>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style>
	body{background: lightgrey;font-family: 'Lato', sans-serif;}
	.login{
	  -webkit-border-radius: 15px;
	  -moz-border-radius: 15px;
	  -ms-border-radius: 15px;
	  -o-border-radius: 15px;
	  border-radius: 15px;
	  -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
	  -moz-box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
	  box-shadow: 0 0 8px rgba(0, 0, 0, 0.4);
	  position: absolute;
	  top: 50%;
	  left: 50%;
	  display: block;
	  margin-top: -185px;
	  margin-left: -235px;
	  padding: 25px;
	  width: 420px;
	  background: white;
	  text-align: center;
	}
	
	.top h1 {
	  margin: 0;
	}
	
	.top {
	  padding-bottom: 20px;
	  border-bottom: solid 1px #D2D2D2;
	  margin-bottom: 20px;
	}
	
	.mid {
	  text-align: center;
	    margin: 35px 0;
	}
	
	.mid input {
	  margin: 10px;
	   padding: 10px 15px;
	  width: 250px;
	}
	
	.login-button {
	  background: #5bb75b;
	  color: #fff;
	    padding: 10px 25px;
	  border: solid 1px rgba(0, 0, 0, 0.22);
	  border-radius: 3px;
	  cursor: pointer;
	}
	
	.login-button:hover{
		background:#387038;
	}
	
	.section {
	  margin: 15px;
	}
	
	.bot {
	  border-top: solid 1px #ccc;
	    padding: 10px;
	}
	
	.left{float:left}
	.right{float:right;text-align:right;}
	.error{color:red;}
</style>
</head>

<body>
<form action="<?php echo base_url(); ?>users/do_changepassword/" method="POST">
<div class="login">
	<div class="top">
		<h1>Change Password</h1>
	</div>
	<div class="mid">
		<?php echo $token; if(empty($error)){ ?>
		<input type="hidden" name="uid" value="<?php echo $uid; ?>">
		<input type="password" placeholder="Password" required name="password">
		<input type="password" placeholder="Confirm Password" required name="c_password">
		<p class="error">Password is different</p>
		<?php }else{
			echo "<p class='error'>$error</p>";
		}?>
	</div>
	<div class="bot">
		<div class="section right">
			<?php if(empty($error)){ ?>
			<input type="submit" id="submit" name="login" class="login-button" value="Save">
			<?php }else{ ?>
				<a href="<?php echo base_url(); ?>users/resetpassword/" class="login-button">Reset Password</a>
			<?php } ?>
		</div>
	</div>
</div>
</form>
<script>
	jQuery(document).ready(function(){
		function checkpass(){
			if(jQuery('#d1').val() != jQuery('#d2').val()){
				jQuery('.error').slideDown();
				jQuery('#submit').attr('disabled','disabled');
			}else{
				jQuery('.error').slideUp();
				jQuery('#submit').removeAttr('disabled');
			}
		}
		
		jQuery('#d1').onBlur(function(){checkpass();});
		jQuery('#d2').onBlur(function(){checkpass()});
	});
</script>
</body>
</html>