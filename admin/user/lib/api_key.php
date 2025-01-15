<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Request not accepted.');
}  else {
	$data_target = $model->db_query($db, "*", "users", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_update($db, "users", array('api_key' => str_rand(30)), "id = '".$_GET['id']."'") == true) {
			$result_msg = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'API Key successfully changed.');
		} else {
			$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'API Key failed to change.');
		}
	}
}
require '../../../lib/result.php';