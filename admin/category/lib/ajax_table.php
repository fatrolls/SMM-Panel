<?php
// query list for paging
if (isset($_GET['search'])) {
	if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM categories WHERE name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else {
		$query_list = "SELECT * FROM categories ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM categories ORDER BY id DESC"; // edit
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
	$input_name = array('name');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$input_post = array(
			'name' => $_POST['name'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			if ($model->db_query($db, "name", "categories", "name = '".$input_post['name']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name CATEGORY has been registered.');
			} else {
				if ($model->db_insert($db, "categories", $input_post) == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Add data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Add data failed.');
				}
			}
		}
	}
} else if (isset($_POST['edit'])) {
	$input_name = array('name');
	$check_data = $model->db_query($db, "*", "categories", "id = '".mysqli_real_escape_string($db, $_POST['id'])."'");
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		$input_post = array(
			'name' => $_POST['name'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			if ($input_post['name'] <> $check_data['rows']['name'] AND $model->db_query($db, "name", "categories", "BINARY name = '".$input_post['name']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name CATEGORY has been registered.');
			} else {
				if ($model->db_update($db, "categories", $input_post, "id = '".$_POST['id']."'") == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Change data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Change data failed.');
				}
			}
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "categories", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_delete($db, "categories", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Data deletion successful.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Delete data failed.');
		}
	}
}