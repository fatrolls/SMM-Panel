<?php
require '../mainconfig.php';
require '../lib/check_session.php';
if ($_POST) {
	require '../lib/is_login.php';
    $input_name = array('subject', 'msg');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'subject' => $_POST['subject'],
			'msg' => $_POST['msg']
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else if (strlen($validation['subject']) > 200) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'SUBJECT cannot exceed 200 characters');	
        } else if (strlen($validation['msg']) > 500) {
            $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Messages must not exceed 500 characters');
        } else {
            $input_post = array(
				'user_id' => $login['id'],
				'subject' => protect_input($_POST['subject']),
				'msg' => protect_input($_POST['msg']),
				'status' => "Waiting",
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
            );
            if ($model->db_insert($db, "tickets", $input_post) == true) {
                $_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Tickets successfully sent.');
            } else {
                $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Tickets failed to send.');
            }
        }
    }
}
require '../lib/header.php';
?>
                        <div class="row">
                            <div class="offset-md-2 col-md-8">
                                <div class="card-box">
                                <h4 class="header-title m-t-0 m-b-30"><i class="fa fa-edit"></i> Send Tickets</h4>
                                <form method="post">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>" />
	<div class="form-group">
		<label>SUBJECT</label>
		<input type="text" class="form-control" name="subject" value="">
	</div>
	<div class="form-group">
		<label>Message</label>
		<textarea class="form-control" name="msg"></textarea>
	</div>
	<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
	<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
</form>

                                </div>
                            </div>
                        </div>
<?php 
include '../lib/footer.php';
?>             