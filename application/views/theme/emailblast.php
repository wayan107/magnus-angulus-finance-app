<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
	<div class="panel-heading"></div>
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<label>Plan</label> :
			<select id="plan">
				<option value="0">Rent</option>
				<option value="1">Buy</option>
			</select>
			<input type="button" id="sendemailblast" value="Send Email">
			
			<div id="result"></div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="text-right">
		</div>
	</div>
</div>