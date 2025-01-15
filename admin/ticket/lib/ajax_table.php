<?php
// query list for paging
if (isset($_GET['search']) AND isset($_GET['status'])) {
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
		$query_list = "SELECT * FROM tickets WHERE msg LIKE '%".protect_input($_GET['search'])."%' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM tickets WHERE msg LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['status'])) {
		$query_list = "SELECT * FROM tickets WHERE status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM tickets ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM tickets ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
// 
if (isset($_POST['edit'])) {
    $input_name = array('msg');
    $check_data = $model->db_query($db, "*", "tickets", "id = '".mysqli_real_escape_string($db, $_POST['id'])."'");
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
        $validation = array(
            'msg' => $_POST['msg'],
        );
        if (check_empty($validation) == true) {
            $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
        } else if ($check_data['rows']['status'] == "Closed") {
            $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Tickets are closed.');
        } else if (strlen($validation['msg']) > 500){
            $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Messages must not exceed 500 characters.');
        } else {
            $input_post = array(
                'ticket_id' => $_POST['id'],
                'is_admin' => 1,
                'msg' => protect_input($_POST['msg']),
                'created_at' => date('Y-m-d H:i:s')
            );
            $insert = $model->db_insert($db, "ticket_replies", $input_post);
            $check_reply = $model->db_query($db, "*", "ticket_replies",  "ticket_id = '".$_POST['id']."' AND is_admin = '0'");
            if ($check_reply['count'] > 0) {
                $model->db_update($db, "ticket_replies", array('is_admin' => 1), "msg = '".$_POST['msg']."'");
            }
            if ($insert == true) {
                $model->db_update($db, "tickets", array('status' => "Responded", 'updated_at' => date('Y-m-d H:i:s')), "id = '".$_POST['id']."'");
                $_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!.', 'msg' => 'Ticket successfully replied');
            } else {
                $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Ticket failed to reply.');
            }
        }
    }
} else if (isset($_GET['id']) AND isset($_GET['status'])) {
	$validation = array(
		'id' => $_GET['id'],
		'status' => $_GET['status'],
	);
	if (check_empty($validation) == true) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
	} else if (in_array($_GET['status'], array('Pending','Processing','Partial','Error','Success')) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect. '.mysqli_error($db).'');
	
	} else {
		$input_post = array(
			'status' => $_GET['status']
		);
		if ($model->db_update($db, "orders", $input_post, "id = '".$_GET['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Change data successful.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Change data failed.');
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "tickets", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	} else {
		if ($model->db_delete($db, "tickets", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Data deletion successful.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Delete data failed.');
		}
	}
}