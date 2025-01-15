<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
require '../lib/csrf_token.php';

if (!isset($_GET['action'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	exit(header("Location: ".$config['web']['base_url']."user/settings.php"));
} elseif (in_array($_GET['action'], array('profile','password', 'api_key')) == false) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	exit(header("Location: ".$config['web']['base_url']."user/settings.php"));
}

if ($_GET['action'] == 'profile') {
	if ($_POST) {
		$input_data = array('full_name', 'password');
		if (check_input($_POST, $input_data) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
		} else {
			$input_post = array(
				'full_name' => $_POST['full_name'],
				'password' => $_POST['password'],
			);
			if (check_empty($input_post) == true) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
			} else {
				if (password_verify($input_post['password'], $login['password']) == false) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Wrong password.');
				} else {
					if ($model->db_update($db, "users", array('full_name' => $input_post['full_name']), "id = '".$login['id']."'")) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Profile changed successfully.');
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Profile failed to change.');
					}
				}
			}
		}
	}
	exit(header("Location: ".$config['web']['base_url']."user/settings.php"));
} elseif ($_GET['action'] == 'password') {
	if ($_POST) {
		$input_data = array('password', 'new_password', 'new_password2');
		if (check_input($_POST, $input_data) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
		} else {
			$input_post = array(
				'password' => $_POST['password'],
				'new_password' => $_POST['new_password'],
				'new_password2' => $_POST['new_password2'],
			);
			if (check_empty($input_post) == true) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
			} else {
				if (password_verify($input_post['password'], $login['password']) == false) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Wrong password.');
				} elseif (strlen($input_post['new_password']) < 5) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password must be at least 5 characters.');
				} elseif ($input_post['new_password'] <> $input_post['new_password2']) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Confirm New Password is incorrect.');
				} else {
					if ($model->db_update($db, "users", array('password' => password_hash($input_post['new_password'], PASSWORD_DEFAULT)), "id = '".$login['id']."'")) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Password changed successfully.');
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password change failed.');
					}
				}
			}
		}
	}
	exit(header("Location: ".$config['web']['base_url']."user/settings.php"));
} elseif ($_GET['action'] == 'api_key') {
	$model->db_update($db, "users", array('api_key' => str_rand(30)), "id = '".$login['id']."'");
	$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'API Key successfully regenerated.');
	exit(header("Location: ".$config['web']['base_url']."api/documentation.php"));
}
?>