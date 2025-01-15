<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';
?>
						<div class="row">
							<div class="col-lg-6">
							<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-user"></i> Profile</h4>
<form class="form-horizontal" method="post" action="<?php echo $config['web']['base_url'] ?>user/post-settings.php?action=profile">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Username</label>
		<input type="text" class="form-control" value="<?php echo $login['username'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Full Name</label>
		<input type="text" class="form-control" name="full_name" value="<?php echo $login['full_name'] ?>">
	</div>
	<div class="form-group">
		<label>Password</label>
		<input type="password" class="form-control" name="password"><small class="text-danger">*Password is required to change profile.</small>
	</div>
	<div class="form-group">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
									</div>
								</div>
							<div class="col-lg-6">
								<div class="ibox">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-key"></i> Password</h4>
<form class="form-horizontal" method="post" action="<?php echo $config['web']['base_url'] ?>user/post-settings.php?action=password">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Current Password</label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label>New Password</label>
		<input type="password" class="form-control" name="new_password">
	</div>
	<div class="form-group">
		<label>Confirm New Password</label>
		<input type="password" class="form-control" name="new_password2">
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