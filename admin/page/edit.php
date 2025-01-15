<?php
/**
 * Penulis Kode - SMM Panel script
 * Domain: http://penuliskode.com/
 * Documentation: http://penuliskode.com/smm/script/version-n1/documentation.html
 *
 */

require '../../mainconfig.php';
require '../../lib/check_session_admin.php';
if (!isset($_GET['id'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	exit(header("Location: ".$config['web']['base_url']."admin/page"));
}
$data_target = $model->db_query($db, "*", "pages", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
if ($data_target['count'] == 0) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	exit(header("Location: ".$config['web']['base_url']."admin/page"));
}
if ($_GET['id'] == '1') {
	$page = "Contact";
	$table = 1;
} elseif ($_GET['id'] == '2') {
	$page = "Terms of Service";
	$table = 2;
} elseif ($_GET['id'] == '3') {
	$page = "Frequently Asked Questions";
	$table = 3;
}
if ($_POST) {
	$input_data = array('content');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		if ($model->db_update($db, "pages", array('content' => $_POST['content']), "id = '".$_GET['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Succeed!', 'msg' => 'Page successfully changed.');
			if ($_GET['id'] == '1') {
				exit(header("Location: ".$config['web']['base_url']."admin/page/edit.php?id=1"));
			} else if ($_GET['id'] == '2') {
				exit(header("Location: ".$config['web']['base_url']."admin/page/edit.php?id=2"));
			} else if ($_GET['id'] == '3') {
				exit(header("Location: ".$config['web']['base_url']."admin/page/edit.php?id=3"));
			}
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Page failed to change.');
		}
	}
}
require '../../lib/header_admin.php';
?>
						<div class="row">
							<div class="col-lg-12">
								<a href="<?php echo $config['web']['base_url'] ?>admin/page" class="btn btn-primary" style="margin-bottom: 20px;"><i class="fa fa-arrow-left fa-fw"></i> Return</a>
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-file"></i> Change Page <?php echo $page ?></h4>
<form class="form-horizontal" method="post">
	<div class="form-group">
	<textarea class="form-control" name="content" rows="15"><?php echo $data_target['rows']['content'] ?></textarea></div>
	
	<div class="form-group">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" name="edit" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
							<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-file"></i> Results/Page Details <?php echo $page ?></h4>
<?php
$page = $model->db_query($db, "*", "pages", "id = '$table'");
echo ($page['count'] == 1) ? nl2br($page['rows']['content']) : '';
?>
									</div>
								</div>
							</div>
						</div>
<?php
require '../../lib/footer.php';
?>