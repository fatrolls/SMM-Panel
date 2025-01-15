<?php
// query list for paging
if (isset($_GET['search']) AND isset($_GET['type'])) {
	if (!empty($_GET['search']) AND !empty($_GET['type'])) {
		$query_list = "SELECT * FROM deposit_methods WHERE name LIKE '%".protect_input($_GET['search'])."%' AND type LIKE '%".protect_input($_GET['type'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM deposit_methods WHERE name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['type'])) {
		$query_list = "SELECT * FROM deposit_methods WHERE type LIKE '%".protect_input($_GET['type'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM deposit_methods ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM deposit_methods ORDER BY id DESC"; // edit
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
	$input_name = array('payment', 'type', 'name', 'note', 'rate', 'min_amount');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'payment' => $_POST['payment'],
			'type' => $_POST['type'],
			'name' => $_POST['name'],
			'note' => $_POST['note'],
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else if (in_array($validation['payment'], array('credit','bank')) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Payment is not correct.');
		} else if (in_array($validation['type'], array('manual','auto')) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Type does not match.');
		} else {
			$input_post = array(
				'payment' => $_POST['payment'],
				'type' => $_POST['type'],
				'name' => $_POST['name'],
				'note' => $_POST['note'],
				'rate' => $_POST['rate'],
				'min_amount' => $_POST['min_amount'],
			);
			if ($model->db_query($db, "name", "deposit_methods", "BINARY name = '".$input_post['name']."' AND type = '".$input_post['type']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name Method Deposit has been registered.');
			} else {
				if ($model->db_insert($db, "deposit_methods", $input_post) == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Add data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Add data failed.');
				}
			}
		}
	}
} else if (isset($_POST['edit'])) {
	$input_name = array('payment', 'type', 'name', 'note', 'rate', 'min_amount');
	$check_data = $model->db_query($db, "*", "deposit_methods", "id = '".mysqli_real_escape_string($db, $_POST['id'])."'");
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		$validation = array(
			'payment' => $_POST['payment'],
			'type' => $_POST['type'],
			'name' => $_POST['name'],
			'note' => $_POST['note'],
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else if (in_array($validation['payment'], array('credit','bank')) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Payment is not correct.');
		} else if (in_array($validation['type'], array('manual','auto')) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Type does not match.');
		} else {
			$input_post = array(
				'payment' => $_POST['payment'],
				'type' => $_POST['type'],
				'name' => $_POST['name'],
				'note' => $_POST['note'],
				'rate' => $_POST['rate'],
				'min_amount' => $_POST['min_amount'],
			);
			if ($input_post['name'] <> $check_data['rows']['name'] AND $model->db_query($db, "name", "deposit_methods", "BINARY name = '".$input_post['name']."' AND type = '".$input_post['type']."'")['count'] > 0) {
				$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Name Method Deposit has been registered.');
			} else {
				if ($model->db_update($db, "deposit_methods", $input_post, "id = '".$_POST['id']."'") == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Change data successful.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Change data failed.');
				}
			}
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "deposit_methods", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_delete($db, "deposit_methods", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Data deletion successful.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Delete data failed.');
		}
	}
}