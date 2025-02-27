<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
if ($login['level'] == 'Member') {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Invalid Access Rights.');
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$input_data = array('username', 'amount');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$input_post = array(
			'username' => trim($_POST['username']),
			'amount' => $_POST['amount'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} elseif ($_POST['amount'] < 1) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Minimum balance transfer $ 1.');
		} elseif ($login['balance'] < $_POST['amount']) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Your balance is not sufficient to make a balance transfer.');
		} else {
			$user_target = $model->db_query($db, "*", "users", "username = '".mysqli_real_escape_string($db, $input_post['username'])."'");
			if ($user_target['count'] == 0) {
				$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Username not found.');
			} else {
				$model->db_update($db, "users", array('balance' => $login['balance'] - $_POST['amount']), "id = '".$login['id']."'");
				$model->db_update($db, "users", array('balance' => $user_target['rows']['balance'] + $_POST['amount']), "id = '".$user_target['rows']['id']."'");
				$model->db_insert($db, "balance_logs", array('user_id' => $login['id'], 'type' => 'minus', 'amount' => $_POST['amount'], 'note' => 'Balance transfer. Recipient: '.$input_post['username'].'.', 'created_at' => date('Y-m-d H:i:s')));
				$model->db_insert($db, "balance_logs", array('user_id' => $user_target['rows']['id'], 'type' => 'plus', 'amount' => $_POST['amount'], 'note' => 'Balance transfer. Sender: '.$login['username'].'.', 'created_at' => date('Y-m-d H:i:s')));
				$_SESSION['result'] = array('alert' => 'success', 'title' => 'Balance transfer successful!', 'msg' => '<br />Recipient: '.$input_post['username'].'<br />Balance Amount: $ '.number_format($_POST['amount'],0,',','.'));
			}
		}
	}
}
require '../lib/header.php';
?>
						<div class="row">
							<div class="offset-lg-3 col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-money"></i> Transfer Balance</h4>
<form class="form-horizontal" method="post">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Username Recipient</label>
		<input type="text" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label>Balance Amount</label>
		<input type="number" class="form-control" name="amount">
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