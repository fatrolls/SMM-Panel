<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Request not accepted.');
} else {
	$data_target = $model->db_query($db, "*", "deposit_methods", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal"  method="POST" id="form">
	<div class="form-group">
		<input type="hidden" class="form-control" name="id" value="<?php echo $data_target['rows']['id'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Payment</label>
		<select class="form-control" name="payment">
			<option value="0">Choose...</option>
			<option value="bank" <?php echo ($data_target['rows']['payment'] == 'bank') ? 'selected' : '' ?>>Bank</option>
			<option value="credit" <?php echo ($data_target['rows']['payment'] == 'credit') ? 'selected' : '' ?>>Credit</option>
		</select>
	</div>
	<div class="form-group">
		<label>Type</label>
		<select class="form-control" name="type">
			<option value="0">Choose...</option>
			<option value="manual" <?php echo ($data_target['rows']['type'] == 'manual') ? 'selected' : '' ?>>Manual</option>
			<option value="auto" <?php echo ($data_target['rows']['type'] == 'auto') ? 'selected' : '' ?>>Automatic</option>
		</select>
	</div>
	<div class="form-group">
		<label>Name Method</label>
		<input type="text" class="form-control" name="name" value="<?php echo $data_target['rows']['name'] ?>">
	</div>
	<div class="form-group">
		<label>Information</label>
		<textarea class="form-control" name="note"><?php echo $data_target['rows']['note'] ?></textarea>
	</div>
	<div class="form-group">
		<label>Rate</label>
		<input type="number" class="form-control" name="rate" value="<?php echo $data_target['rows']['rate'] ?>">
	</div>
	<div class="form-group">
		<label>Min. Deposit</label>
		<input type="number" class="form-control" name="min_amount" value="<?php echo $data_target['rows']['min_amount'] ?>">
	</div>
	<div class="form-group text-right">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" name="edit" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
<?php
	}
}
require '../../../lib/result.php';