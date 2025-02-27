<?php
/**
 * Penulis Kode - SMM Panel script
 * Domain: http://penuliskode.com/
 * Documentation: http://penuliskode.com/smm/script/version-n1/documentation.html
 *
 */

if (isset($_SESSION['login']) AND $config['web']['maintenance'] == 1) {
	exit("<center><h1>SORRY, WEBSITE IS UNDER MAINTENANCE!</h1></center>");
}

require 'is_login.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo $config['web']['meta']['description'] ?>">
		<meta name="keywords" content="<?php echo $config['web']['meta']['keywords'] ?>">
		<meta name="author" content="<?php echo $config['web']['meta']['author'] ?>">
		<title><?php echo $config['web']['title2'] ?></title>
		<link href="<?php echo $config['web']['base_url'] ?>assets/plugins/morris/morris.css" rel="stylesheet" />
		<link href="<?php echo $config['web']['base_url'] ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $config['web']['base_url'] ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo $config['web']['base_url'] ?>assets/css/style.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/modernizr.min.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/jquery.min.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/popper.min.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/waves.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/js/jquery.slimscroll.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/plugins/morris/morris.min.js"></script>
		<script src="<?php echo $config['web']['base_url'] ?>assets/plugins/raphael/raphael-min.js"></script>
        <link href="<?php echo $config['web']['base_url'] ?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!--<link href="<?php echo $config['web']['base_url'] ?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        //<link href="<?php echo $config['web']['base_url'] ?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		//<script src="<?php echo $config['web']['base_url'] ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        //<script src="<?php echo $config['web']['base_url'] ?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script> -->
		<style type="text/css">.hide{display:none!important}.show{display:block!important}</style>
		<script type="text/javascript">
        function modal_open(type, url) {
			$('#modal').modal('show');
			if (type == 'add') {
				$('#modal-title').html('<i class="fa fa-plus-square"></i> Add Data');
			} else if (type == 'edit') {
				$('#modal-title').html('<i class="fa fa-edit"></i> Change Data');
			} else if (type == 'delete') {
				$('#modal-title').html('<i class="fa fa-trash"></i> Delete Data');
			} else if (type == 'detail') {
				$('#modal-title').html('<i class="fa fa-search"></i> Data Details');
			} else {
				$('#modal-title').html('Empty');
			}
        	$.ajax({
        		type: "GET",
        		url: url,
        		beforeSend: function() {
        			$('#modal-detail-body').html('Loading...');
        		},
        		success: function(result) {
        			$('#modal-detail-body').html(result);
        		},
        		error: function() {
        			$('#modal-detail-body').html('There is an error.');
        		}
        	});
        	$('#modal-detail').modal();
        }
		function update_data(url) {
			$('#modal-delete').modal('hide');
			$.ajax({
				type: "GET",
				url: url,
				dataType: "html",
				success: function($data) {
					$('#body-result').html($data);
					$('#datatable').DataTable().ajax.reload();
				}, error: function() {
					$('#body-result').html('<div class="alert alert-danger alert-dismissable"><b>Response:</b> Fail!<br /><b>Message:</b> There is an error!</div>');
				},
				beforeSend: function() {
					$('#body-result').html('<div class="progress progress-striped active"><div style="width: 100%" class="progress-bar progress-bar-primary"></div></div>');
				}
			});
		}
    	</script>
<style type="text/css">
.block { position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9999; }
</style>
	</head>
	<body>
	<header id="topnav">
			<div class="topbar-main">
				<div class="container-fluid">
					<div class="logo">
						<a href="<?php echo $config['web']['base_url'] ?>" class="logo">
							<span class="logo-small"><i class="fa fa-youtube"></i></span>
							<span class="logo-large"><i class="fa fa-youtube"></i> <?php echo $config['web']['title'] ?></span>
						</a>
					</div>
					<div class="menu-extras topbar-custom">
						<ul class="list-unstyled topbar-right-menu float-right mb-0">
							<li class="menu-item">
								<a class="navbar-toggle nav-link">
									<div class="lines">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</a>
							</li>
							<?php
					        if (isset($_SESSION['login'])) { ?>
							<li style="padding: 0 10px;">
								<span class="nav-link">Balance: $ <?php echo number_format($login['balance'],0,',','.'); ?></span>
							</li>
							<li class="dropdown notification-list">
								<a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
									aria-haspopup="false" aria-expanded="false">
								<i class="fa fa-user"></i> <span class="ml-1 pro-user-name"><?php echo $login['username']; ?> <i class="mdi mdi-chevron-down"></i> </span>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-dropdown">
									<a href="<?php echo $config['web']['base_url'] ?>user/settings.php" class="dropdown-item notify-item"><i class="fa fa-gear fa-fw"></i> <span>Account Settings</span></a>
									<a href="<?php echo $config['web']['base_url'] ?>logout.php" class="dropdown-item notify-item"><i class="fa fa-sign-out fa-fw"></i> <span>Logout</span></a>
								</div>
							</li>
							<?php 
        					}
        					?>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="navbar-custom">
				<div class="container-fluid">
					<div id="navigation">
						<ul class="navigation-menu">
						<li class="has-submenu">
							<a href="#"><i class="fa fa-graduation-cap"></i> Menu</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin"> Admin</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>"> Users</a></li>
							</ul>
						</li>
						<li>
							<a href="<?php echo $config['web']['base_url'] ?>admin"> <i class="fa fa-home"></i> Dashboard</a>
						</li>
						<li class="has-submenu">
							<a href="#"><i class="fa fa-tags"></i> Service</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/provider">Provider API</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/category">CATEGORY</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/service">Service</a></li>
							</ul>
						</li>
						<li>
							<a href="<?php echo $config['web']['base_url'] ?>admin/user"><i class="fa fa-users"></i>Users</a>
						</li>
						<li class="has-submenu">
							<a href="#"><i class="fa fa-money"></i> Deposit</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/deposit_method">Deposit Methods</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/deposit">Manage Deposits</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/deposit/report.php">Report</a></li>
							</ul>
						</li>
						<li class="has-submenu">
							<a href="#"><i class="fa fa-shopping-cart"></i> Message</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/order">Message</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/order/report.php">Report</a></li>
							</ul>
						</li>
						<li class="has-submenu">
							<a href="#"><i class="fa fa-paperclip"></i> Log</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/log/login.php">Login</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/log/balance-usage.php">Usage Balance</a></li>
							</ul>
						</li>
						<li class="has-submenu">
							<a href="#"><i class="fa fa-list"></i> Other</a>
							<ul class="submenu">
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/page">Page</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/ticket">Tickets</a></li>
								<li><a href="<?php echo $config['web']['base_url'] ?>admin/news">News & Information</a></li>
							</ul>
						</li>
                        </ul>
					</div>
				</div>
			</div>
		</header>

        <div class="wrapper">
			<div class="container-fluid" style="padding-top: 30px;">
			<div class="modal fade" id="modal" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title" id="modal-title"></h4>
						</div>
						<div class="modal-body" id="modal-detail-body">
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
				
                <div class="row">
                    <div class="col-lg-12" id="body-result">
<?php
if (isset($_SESSION['result'])) {
?>
<div class="alert alert-<?php echo $_SESSION['result']['alert'] ?> alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<b>Respon:</b> <?php echo $_SESSION['result']['title'] ?><br />
	<b>Message:</b> <?php echo $_SESSION['result']['msg'] ?>
</div>
<?php
unset($_SESSION['result']);
}
?>
                    </div>
                </div>
