<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
if ($login['level'] == 'Member') {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid Access Rights.');
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$input_data = array('full_name', 'username', 'password');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'full_name' => $_POST['full_name'],
			'username' => trim($_POST['username']),
			'password' => trim($_POST['password']),
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} elseif (strlen($validation['username']) < 5) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username must be at least 5 characters.');
		} elseif (strlen($validation['password']) < 5) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Password must be at least 5 characters.');
		} elseif ($login['balance'] < $config['register']['price']['reseller']) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Your balance is not sufficient to register as a Member.');
		} else {
			$input_post = array(
				'level' => 'Reseller',
				'username' => strtolower($validation['username']),
				'password' => password_hash($validation['password'], PASSWORD_DEFAULT),
				'full_name' => $_POST['full_name'],
				'balance' => $config['register']['bonus']['reseller'],
				'api_key' => str_rand(30),
				'created_at' => date('Y-m-d H:i:s')
			);
			if ($model->db_query($db, "username", "users", "username = '".mysqli_real_escape_string($db, $input_post['username'])."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username is already registered.');
			} else {
				if ($model->db_insert($db, "users", $input_post) == true) {
					$model->db_update($db, "users", array('balance' => $login['balance'] - $config['register']['price']['reseller']), "id = '".$login['id']."'");
					$model->db_insert($db, "balance_logs", array('user_id' => $login['id'], 'type' => 'minus', 'amount' => $config['register']['price']['reseller'], 'note' => 'Register Member. Username: '.$input_post['username'].'.', 'created_at' => date('Y-m-d H:i:s')));
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Reseller successfully registered!', 'msg' => '<br />Username: '.$input_post['username'].'<br />Password: '.$validation['password']);
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Member failed to register.');
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
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-plus"></i> Plus Reseller</h4>
<div class="alert alert-info"><b>Registration fee:</b> $ <?php echo number_format($config['register']['price']['reseller'],0,',','.') ?><br /><b>Bonus Balance:</b> $ <?php echo number_format($config['register']['bonus']['reseller'],0,',','.') ?></div>
<form class="form-horizontal" method="post">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Full Name</label>
		<input type="text" class="form-control" name="full_name">
	</div>
	<div class="form-group">
		<label>Username</label>
		<input type="text" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
								</div>
							</div>
						</div>
<?php
require '../lib/footer.php';
?>