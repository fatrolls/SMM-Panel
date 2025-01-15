<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';
if (!isset($_GET['id']) OR !isset($_GET['status'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Request not accepted.');
} else if (in_array($_GET['status'], array('Waiting','Closed','Responded')) == false) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
} else {
	$data_target = $model->db_query($db, "*", "tickets", "id = '".mysqli_real_escape_string($db, $_GET['id'])."' AND status IN ('Waiting')");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_update($db, "tickets", array('status' => $_GET['status']), "id = '".$_GET['id']."'") == true) {
			$result_msg = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Status changed successfully.');
		} else {
			$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Status failed to change.');
		}
	}
}
require '../../../lib/result.php';