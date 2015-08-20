<!DOCTYPE html>
<html lang="en">
<head>
<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
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
	  height: 340px;
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
	
	input.login-button {
	  background: #5bb75b;
	  color: #fff;
	    padding: 10px 25px;
	  border: solid 1px rgba(0, 0, 0, 0.22);
	  border-radius: 3px;
	  cursor: pointer;
	}
	
	input.login-button:hover{
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
</style>
</head>

<body>
<form action="<?php echo base_url(); ?>auth/login/" method="POST">
<div class="login">
	<div class="top">
		<h1>Login</h1>
	</div>
	<div class="mid">
		<input type="text" placeholder="Username" required name="username">
		<input type="password" placeholder="Password" required name="password">
		<p><a href="<?php echo base_url() ?>users/resetpassword/">Forget your password?</a></p>
	</div>
	<div class="bot">
		<div class="section left">
			<input type="checkbox" value="1" id="remember" name="remember-me"> <label for="remember">Remember me?</label>
		</div>
		<div class="section right">
			<input type="submit" name="login" class="login-button" value="Login">
		</div>
	</div>
</div>
</form>
</body>
</html>