<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Request not accepted.');
} else {
	$data_target = $model->db_query($db, "*", "categories", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add">
	<div class="form-group">
		<input type="hidden" class="form-control" name="id" value="<?php echo $data_target['rows']['id'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Name CATEGORY</label>
		<input type="text" class="form-control" name="name" value="<?php echo $data_target['rows']['name'] ?>">
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