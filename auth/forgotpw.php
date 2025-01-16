<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);   
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}

if ($_POST) {
	$data = array('username', 'email');
	
	if(check_input($_POST, $data)) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid email.');
		} else {
			$input_post = array(
				'username' => mysqli_real_escape_string($db, trim($_POST['username'])),
				'email' => mysqli_real_escape_string($db, trim($_POST['email']))	
			);
			$check_user = $model->db_query($db, "*", "users", "BINARY username = '".$input_post['username']."' AND email = '".$input_post['email']."'");
			if ($check_user['count'] == 1) {
				$_SESSION['result'] = array('alert' => 'success', 'title' => 'Success!', 'msg' => 'Email sent with new password.');
				$newPassword = str_rand(12);
				$input_post = array(
					'username' => mysqli_real_escape_string($db, trim($_POST['username'])),
					'email' =>  mysqli_real_escape_string($db, trim($_POST['email'])),
					'password' => mysqli_real_escape_string($db, trim(password_hash($newPassword, PASSWORD_DEFAULT)))
				);
				mail($check_user['rows']['email'], 'Your new Password for '.$config['web']['title'], "Your login information is\r\nUsername: ".$check_user['rows']['username']."\r\nPassword: ".$newPassword);
				$model->db_update($db, "users", $input_post, "username = '".$input_post['username']."'");
			} else {
				$_SESSION['result'] = array('alert' => 'warning', 'title' => 'Fail!', 'msg' => 'Email or username is incorrect.');
			}
		}
	}
}
require '../lib/header.php';
?>
						<div class="row">
							<div class="offset-lg-3 col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-sign-in fa-fw"></i> Forgot Password</h4>
									<form class="form-horizontal" method="post">
										<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
										<div class="form-group">
											<label>Username</label><input type="text" class="form-control" name="username">
										</div>
										<div class="form-group">
											<label>Email</label><input type="text" class="form-control" name="email">
										</div>
										<div class="form-group">
											<button class="btn btn-warning" name="submit"><i class="fa fa-check"></i> Forgot Password</button>
										</div>
									</form>
								</div>
							</div>
						</div>
<?php
require '../lib/footer.php';
?>