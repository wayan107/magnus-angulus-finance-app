<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html>
<head>
<style>
.wrapper {
  position: relative;
  width: 595px;
  margin: auto;
  padding: 20px 30px;
    font-family: sans-serif;
  font-size: 12px;
}

.header {
  text-align: center;
}

.header p {
  margin: 5px 0 0 0;
}

.header img {
  margin-bottom: 10px;
  width: 220px;
}

.row {
  display: block;
}

.col2 {
  width: 49%;
  display: inline-block;
  vertical-align: text-top;
}

label {
  width: 100px;
  display: inline-block;
}

table td {
  text-align: center;
  padding: 5px 0;
}

table {
  border-collapse: collapse;
  width: 550px;
  margin: 10px auto 30px auto;
  font-size: 12px;
}

.border{
	border: 2px solid #333;
	padding: 0 20px;
}
h2 {
  font-size: 15px;
}
.special{padding-left: 17%;
  width: 32%;}
</style>
</head>

<body>
	<div class="wrapper">
		<div class="row header">
			<img src="<?php echo getcwd(); ?>/asset/Villasofbali.jpg">
			<p>Magnus Angulus PT</p>
			<p>Jalan Beraban No. 70B, Seminyak, Bali</p>
			<p>+62 821 1159 8787</p>
		</div>
		
		<h2>INVOICE</h2>
		<div class="row">
			<div class="col2">
				<div class="block">
					<p>
						<label>Att To</label>:
						<?php echo $query->owner; ?>
					</p>
					<p>
						<label>Email</label>:
						<?php echo $query->email; ?>
					</p>
				</div>
				<div class="block">
					<p>
						<label>Accommodation</label>:
						<?php echo $query->villa_code; ?>
					</p>
					<p>
						<label>Period Of Stay</label>:
						<?php echo $query->period; ?>
					</p>
				</div>
			</div>
			<div class="col2">
				<div class="block">
					<p>
						<label>Date</label>:
						<?php echo $query->date; ?>
					</p>
					<p>
						<label>Guest Name</label>:
						<?php echo $query->client; ?>
					</p>
				</div>
				<div class="block">
					<p>
						<label>Ref. No</label>:
						<?php echo $query->ref_number; ?>
					</p>
				</div>
			</div>
		</div>
		
		<div class="row">
			<table border="1">
				<tr>
					<td>Period Of Stay</td>
					<td>Rate</td>
					<td>Total</td>
				</tr>
				<tr>
					<td><?php echo $query->period; ?></td>
					<td><?php echo $query->deal_price; ?></td>
					<td><?php echo $query->deal_price; ?></td>
				</tr>
				<tr>
					<td>Consult Fee</td>
					<td>&nbsp;</td>
					<td><?php echo $query->consult_fee; ?></td>
				</tr>
			</table>
		</div>
		
		<h2>Payment should be paid within 7 days to the bank account below:</h2>
		<div class="row">
			<div class="border">
				<div class="col2">
					<p><label>Name</label>: Bank International Indonesia</p>
					<p><label>Address</label>: Denpasar</p>
					<p><label>Beneficiary name</label>: Magnus Angulus PT</p>
					<p><label>Swift Code</label>: IBBKIDJA</p>
				</div>
				<div class="col2 special">
					<p>Account Number</p>
					<p><label>IDR</label>: 2111900227</p>
					<p><label>USD</label>: 2111211006</p>
					<p><label>EURO</label>: 2111210007</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>