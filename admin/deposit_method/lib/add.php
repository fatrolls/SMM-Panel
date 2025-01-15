<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form">
	<div class="form-group">
		<label>Payment</label>
		<select class="form-control" name="payment">
			<option value="0">Choose...</option>
			<option value="bank">Bank</option>
			<option value="credit">Credit</option>
		</select>
	</div>
	<div class="form-group">
		<label>Type</label>
		<select class="form-control" name="type">
			<option value="0">Choose...</option>
			<option value="manual">Manual</option>
			<option value="auto">Automatic</option>
		</select>
	</div>
	<div class="form-group">
		<label>Name Method</label>
		<input type="text" class="form-control" name="name">
	</div>
	<div class="form-group">
		<label>Information</label>
		<textarea class="form-control" name="note"></textarea>
	</div>
	<div class="form-group">
		<label>Rate</label>
		<input type="number" class="form-control" name="rate" value="1">
	</div>
	<div class="form-group">
		<label>Min. Deposit</label>
		<input type="number" class="form-control" name="min_amount" value="10000">
	</div>
	<div class="form-group text-right">
		<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
		<button class="btn btn-success" name="add" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>