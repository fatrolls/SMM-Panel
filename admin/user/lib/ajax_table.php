<?php
// query list for paging
if (isset($_GET['search']) AND isset($_GET['status'])) {
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
		$query_list = "SELECT * FROM users WHERE username LIKE '%".protect_input($_GET['search'])."%' OR full_name LIKE '%".protect_input($_GET['search'])."%' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM users WHERE username LIKE '%".protect_input($_GET['search'])."%' OR full_name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['status'])) {
		$query_list = "SELECT * FROM users WHERE status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM users ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM users ORDER BY id DESC"; // edit
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
	$input_name = array('level', 'username', 'password', 'full_name', 'email', 'balance');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'level' => $_POST['level'],
			'username' => trim($_POST['username']),
			'password' => trim($_POST['password']),
			'full_name' => $_POST['full_name'],
			'email' =>  $_POST['email']
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} elseif (strlen($validation['username']) < 5) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username must be at least 5 characters.');
		} elseif (strlen($validation['password']) < 5) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password must be at least 5 characters.');
		} elseif (in_array($validation['level'], array('Member','Reseller','Admin')) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Incorrect access rights.');
		} else if (!filter_var($validation['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid email.');
		} else {
			$input_post = array(
				'level' => $_POST['level'],
				'username' => strtolower(trim($_POST['username'])),
				'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
				'full_name' => $_POST['full_name'],
				'email' => $_POST['email'],
				'balance' => $_POST['balance'],
				'api_key' => str_rand(30),
				'created_at' => date('Y-m-d H:i:s')
			);
			if ($model->db_query($db, "username", "users", "username = '".$input_post['username']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username is already registered.');
			} else if ($model->db_query($db, "email", "users", "email = '".mysqli_real_escape_string($db, $input_post['email'])."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Email is already registered.');
			} else {
				if ($model->db_insert($db, "users", $input_post) == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Add data successful.');
				} else {
					die(mysqli_error($db));
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Add data failed.');
				}
			}
		}
	}
} else if (isset($_POST['edit'])) {
	$input_name = array('level', 'password', 'full_name', 'email', 'balance');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'level' => $_POST['level'],
			'full_name' => $_POST['full_name'],
			'email' => $_POST['email']
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else if (!empty($_POST['password']) AND strlen($_POST['password']) < 5) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password must be at least 5 characters.');
		} else if (!filter_var($validation['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid email.');
		} else {
			if (empty($_POST['password'])) {
				$input_post = array(
					'level' => $_POST['level'],
					'full_name' => $_POST['full_name'],
					'email' => $_POST['email'],
					'balance' => $_POST['balance']
				);
			} else {
				$input_post = array(
					'level' => $_POST['level'],
					'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
					'full_name' => $_POST['full_name'],
					'email' => $_POST['email'],
					'balance' => $_POST['balance']
				);
			}
			if ($model->db_update($db, "users", $input_post, "id = '".$_POST['id']."'") == true) {
				$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Change data successful.');
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Change data failed.');
			}
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "users", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'User not found.');
	} else {
		if ($model->db_delete($db, "users", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'User successfully deleted.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Delete data failed.');
		}
	}
}