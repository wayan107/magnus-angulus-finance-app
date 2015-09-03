<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="panel panel-default">
	<div class="panel-heading"></div>
	<div class="panel-body">
		<div class="dataTable_wrapper">
			<label>Plan</label> :
			<select id="plan" class="inputclass">
				<option value="0">Rent</option>
				<option value="1">Buy</option>
			</select>
			&nbsp;&nbsp;
			<input type="button" class="btn btn-primary" id="preview-email" value="Preview Email">
			<i class="fa fa-spinner fa-pulse loading loading-preview"></i>
			<div id="preview"></div>
			<div class="send-button-group">
				<input type="button" class="btn btn-primary" id="sendemailblast" value="Send Email">
				<br /><br />
				<div id="progress-bar"><div class="progress-label">Preparing...</div></div>
				
				<div id="result"></div>
			</div>
			
			<div class="test-email">
				<h3>Send test email to:</h3>
				<input type="email" name="email" class="inputclass" id="email"> <input type="button" class="btn btn-primary" id="test-email" value="Send test email">
				<i class="loading-test fa fa-spinner fa-pulse loading"></i>
				<div id="test-result"></div>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<div class="text-right">
		</div>
	</div>
</div>