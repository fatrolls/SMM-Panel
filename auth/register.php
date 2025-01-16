<?php
require '../mainconfig.php';

if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$data = array('full_name', 'email', 'username', 'password', 'confirm_password', 'g-recaptcha-response');
	if (check_input($_POST, $data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'full_name' => protect_input($_POST['full_name']),
			'email' => protect_input($_POST['email']),
			'username' => protect_input($_POST['username']),
			'password' => protect_input($_POST['password']),
			'confirm_password' => protect_input($_POST['confirm_password'])
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			$check_ip = $model->db_query($db, "ip_address", "register_logs", "ip_address = '".get_client_ip()."'");
			
			//Recaptcha
			$recaptchaResponse = $_POST['g-recaptcha-response'];
			$recaptchaSecretKey = $config['recaptcha']['private_key'];
			$remoteIp = get_client_ip();
			
			$recaptchaVerifyUrl = "https://www.google.com/recaptcha/api/siteverify";
			$data = array(
				'secret' => $recaptchaSecretKey,
				'response' => $recaptchaResponse,
				'remoteip' => $remoteIp
			);
			
			$options = array(
				'http' => array(
				'method'  => 'POST',
			    	'content' => http_build_query($data),
			    	'header'  => "Content-Type: application/x-www-form-urlencoded\r\n"
				)
			);
			$context  = stream_context_create($options);
			$response = file_get_contents($recaptchaVerifyUrl, false, $context);
			$result = json_decode($response);

		  	if (!$result->success) {
		  		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Captcha is wrong.');
		        } else if ($validation['password'] <> $validation['confirm_password']) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password confirmation is incorrect.');
			} else if (strlen($validation['username']) < 5 OR strlen($validation['password']) < 5) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username/Password must be at least 5 characters.');
			} else if (strlen($validation['username']) > 12 OR strlen($validation['password']) > 12) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username/Password maximum 12 characters.');
			} else if (!filter_var($validation['email'], FILTER_VALIDATE_EMAIL)) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid email.');
			} else {
				$input_post = array(
					'level' => 'Member',
					'username' => strtolower($validation['username']),
					'password' => password_hash($validation['password'], PASSWORD_DEFAULT),
					'full_name' => $_POST['full_name'],
					'email' => $_POST['email'],		
					'balance' => 0,
					'api_key' => str_rand(30),
					'created_at' => date('Y-m-d H:i:s')
				);
				if ($model->db_query($db, "username", "users", "username = '".mysqli_real_escape_string($db, $input_post['username'])."'")['count'] > 0) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username is already registered.');
				} else if ($model->db_query($db, "email", "users", "email = '".mysqli_real_escape_string($db, $input_post['email'])."'")['count'] > 0) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Email is already registered.');
				} else {
					$insert = $model->db_insert($db, "users", $input_post);
					if ($insert == true) {
						$model->db_insert($db, "register_logs", array('user_id' => $insert, 'ip_address' => get_client_ip(), 'created_at' => date('Y-m-d H:i:s')));
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => '<br />Username: '.$input_post['username'].'<br />Password: '.$validation['password']);
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Member failed to register.');
					}
				}
			}
		}
	}
}
require '../lib/header.php';
?>
						<div class="row">
							<div class="offset-lg-3 col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-plus fa-fw"></i>Register a account!</h4>
									<form class="form-horizontal" method="post">
										<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
										<div class="form-group">
											<label>Full Name</label><input type="text" class="form-control" name="full_name">
										</div>
										<div class="form-group">
											<label>Email</label><input type="text" class="form-control" name="email">
										</div>
                                        					<div class="form-group">
											<label>Username</label><input type="text" class="form-control" name="username">
										</div>
										<div class="form-group">
											<label>Password</label><input type="password" class="form-control" name="password">
										</div>
                                        					<div class="form-group">
											<label>Confirm Password</label><input type="password" class="form-control" name="confirm_password">
										</div>
										</script>
										<div class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha']['public_key']; ?>"></div>
										<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>
										<div class="form-group">
												<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
<?php
require '../lib/footer.php';
?>