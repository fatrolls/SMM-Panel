<?php
// query list for paging
if (isset($_GET['search'])) {
	if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM provider WHERE name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else {
		$query_list = "SELECT * FROM provider ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM provider ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
// 
if (isset($_POST['add'])) {
	$input_name = array('name', 'api_key', 'api_url_order', 'api_url_status');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$input_post = array(
			'name' => strtoupper(trim($_POST['name'])),
			'api_key' => $_POST['api_key'],
			'api_url_order' => $_POST['api_url_order'],
			'api_url_status' => $_POST['api_url_status'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			if ($model->db_query($db, "name", "provider", "name = '".$input_post['name']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name Provider is already registered.');
			} else {
				if ($model->db_insert($db, "provider", $input_post) == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Add data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Add data failed.');
				}
			}
		}
	}
} else if (isset($_POST['edit'])) {
	$input_name = array('name', 'api_key', 'api_url_order', 'api_url_status');
	$check_data = $model->db_query($db, "*", "provider", "id = '".mysqli_real_escape_string($db, $_POST['id'])."'");
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		$input_post = array(
			'name' => strtoupper(trim($_POST['name'])),
			'api_key' => $_POST['api_key'],
			'api_url_order' => $_POST['api_url_order'],
			'api_url_status' => $_POST['api_url_status'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			if ($input_post['name'] <> $check_data['rows']['name'] AND $model->db_query($db, "name", "provider", "BINARY name = '".$input_post['name']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name Provider is already registered.');
			} else {
				if ($model->db_update($db, "provider", $input_post, "id = '".$_POST['id']."'") == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Change data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Change data failed.');
				}
			}
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "provider", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_delete($db, "provider", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Data deletion successful.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Delete data failed.');
		}
	}
}