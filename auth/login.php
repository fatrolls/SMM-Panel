<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);   
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}

if ($_POST) {
	$data = array('username', 'password');
	if (check_input($_POST, $data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$input_post = array(
			'username' => mysqli_real_escape_string($db, strtolower(trim($_POST['username']))),
			'password' => mysqli_real_escape_string($db, trim($_POST['password'])),
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			$check_user = $model->db_query($db, "*", "users", "BINARY username = '".$input_post['username']."'");
			if ($check_user['count'] == 1) {
				if (password_verify($input_post['password'], $check_user['rows']['password']) == true) {
					$model->db_insert($db, "login_logs", array('user_id' => $check_user['rows']['id'], 'ip_address' => get_client_ip(), 'created_at' => date('Y-m-d H:i:s')));
					$_SESSION['login'] = $check_user['rows']['id'];
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Login successfully!', 'msg' => 'WELCOME '.$check_user['rows']['username'].'! Have a Happy and Enjoyable Day!');
					exit(header("Location: ".$config['web']['base_url']));
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Incorrect username or password.');
				}
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Incorrect username or password.');
			}
		}
	}
}
require '../lib/header.php';
?>
						<div class="row">
							<div class="offset-lg-3 col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-sign-in fa-fw"></i> Login</h4>
									<form class="form-horizontal" method="post">
										<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
										<div class="form-group">
											<label>Username</label><input type="text" class="form-control" name="username">
										</div>
										<div class="form-group">
											<label>Password</label><input type="password" class="form-control" name="password">
										</div>
										<div class="form-group">
												<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
												<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
												<a href="<?php echo $config['web']['base_url'] ?>auth/forgotpw.php" class="btn btn-primary"><i class="fa fa-arrow-left fa-fw"></i> Forgot pw</a>
										</div>
									</form>
								</div>
							</div>
						</div>
<?php
require '../lib/footer.php';
?>