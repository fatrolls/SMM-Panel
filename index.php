<?php
require 'mainconfig.php';
require 'lib/header.php';
if (!isset($_SESSION['login'])) {
?>
				<div class="row">
					<div class="col-lg-12">
		                <div class="card-box">
                                <center>
                                    <i class="fa fa-instagram text-green" style="font-size: 60px;"></i>
            	                    <h1 class="text-uppercase">YOUR WEBSITE</h1>
            					    <p><?php echo $config['web']['meta']['description'] ?> </p>
            						<a href="<?php echo $config['web']['base_url'] ?>auth/login.php" class="btn btn-success"><i class="fa fa-sign-in fa-fw"></i> Login</a> 
            						<a href="<?php echo $config['web']['register_url'] ?>" class="btn btn-warning"><i class="fa fa-user-plus fa-fw"></i> Register</a>
            				    </center>	
            			</div>
            		</div>
            		<div class="col-lg-12">
						<div class="card-box">
							<div class="facts-box text-center">
								<div class="row">
									<div class="col-lg-4">
										<h2><?php echo number_format($model->db_query($db, "*", "services")['count'],0,',','.') ?>+</h2>
										<p class="text-muted">Total Services</p>
									</div>
									<div class="col-lg-4">
										<h2><?php echo number_format($model->db_query($db, "*", "users")['count'],0,',','.') ?>+</h2>
										<p class="text-muted">Total Users</p>
									</div>
									<div class="col-lg-4">
										<h2><?php echo number_format($model->db_query($db, "SUM(price) as total", "orders")['rows']['total'],0,',','.') ?>+</h2>
										<p class="text-muted">Total Orders</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
                        <div class="card-box">
                            <center>
                        	<i class="fa fa-thumbs-up text-green" style="font-size: 40px;"></i>
                        	<h4 class="text-uppercase">Best Service</h4>
                        	<small>We provide a variety of the best services for your social media needs.</small>
                        	</center>
                        </div>
                    </div>
					
					<div class="col-lg-4">
                        <div class="card-box">
                            <center>
                            	<i class="fa fa-support text-green" style="font-size: 40px;"></i>
                            	<h4 class="text-uppercase">Help Desk</h4>
                            	<small>We are always ready to help if you need us in using our services.</small>
                            </center>
                        </div>
                    </div>
					
					<div class="col-lg-4">
                        <div class="card-box">
                            <center>
                            	<i class="fa fa-desktop" style="font-size: 40px;"></i>
                            	<h4 class="text-uppercase">Responsive Design</h4>
                            	<small>We use a website design that can be accessed from various devices. <i>device</i>, both smartphones and PCs.</small>
                            </center>
                        </div>
                    </div>
				</div>
				<div class="card-box">
				<div class="row">
                    <div class="col-lg-5 offset-lg-1">
                        <div>
                            <div class="question-q-box">Q.</div>
                            <h4 class="question" data-wow-delay=".1s">What's is <?php echo $config['web']['title'] ?>?</h4>
                            <p class="answer"><?php echo $config['web']['title'] ?> is a business platform that provides various social media marketing services that operate mainly in Indonesia. By joining us, you can become a social media service provider or social media reseller such as services to add Followers, Likes, etc.</p>
                        </div>
                        <div>
                            <div class="question-q-box">Q.</div>
                            <h4 class="question">How to register on <?php echo $config['web']['title'] ?></h4>
                            <p class="answer">You can register directly on the website <?php echo $config['web']['title'] ?> on the Register page (<a href="<?php echo $config['web']['base_url'] ?>auth/register.php">Click here</a>).</p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div>
                            <div class="question-q-box">Q.</div>
                            <h4 class="question">How to make an order?</h4>
                            <p class="answer">To make an order is very easy, you only need to log in to your account first and go to the order page by clicking on the menu that is already available. In addition, you can also make an order via API request.</p>
                        </div>
                        <div>
                            <div class="question-q-box">Q.</div>
                            <h4 class="question">How to make a deposit/top up balance?</h4>
                            <p class="answer">To make a deposit/fill your balance, you only need to log in to your account first and go to the deposit page by clicking on the menu that is already available. We provide deposits via bank and credit.</p>
                        </div>
                    </div>
                </div>
				</div>

<?php
} else {
?>
						<div class="row">
							<div class="col-lg-12 text-center" style="margin: 15px 0;">
								<h3 class="text-uppercase"><i class="fa fa-user-circle-o fa-fw"></i> Account Information</h3>
							</div>
							<div class="col-lg-8">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-area-chart"></i> 7 Days End Order & Deposit Chart</h4>
										<div id="last-order-chart" style="height: 200px;"></div>
								</div>
							</div>
							<div class="col-lg-4 text-center">
								<div class="card-box widget-flat border-custom bg-custom text-white">
									<h3 class="m-b-10">$ <?php echo number_format($model->db_query($db, "SUM(price) as total", "orders WHERE user_id = '".$_SESSION['login']."'")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "orders WHERE user_id = '".$_SESSION['login']."'")['count'],0,',','.') ?>)</h3>
									<p class="text-uppercase m-b-5 font-13 font-600"><i class="mdi mdi-cart-outline"></i> My Order</p>
								</div>
								<div class="card-box widget-flat border-custom bg-custom text-white">
									<i class="mdi mdi-cash-multiple"></i>
									<h3 class="m-b-10">$ <?php echo number_format($model->db_query($db, "SUM(amount) as total", "deposits WHERE user_id = '".$_SESSION['login']."'")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "deposits WHERE user_id = '".$_SESSION['login']."'")['count'],0,',','.') ?>)</h3>
									<p class="text-uppercase m-b-5 font-13 font-600">My Deposit</p>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="profile-user-box card-box bg-custom">
									<div class="row">
										<div class="col-lg-6">
											<span class="pull-left mr-3"><img src="<?php echo $config['web']['base_url'] ?>assets/images/profile.png" alt="Profile" class="thumb-lg rounded-circle"></span>
											<div class="media-body text-white">
												<h4 class="mt-1 mb-1 font-18"><?php echo $login['full_name'] ?></h4>
												<p class="font-13 text-light"><?php echo $login['full_name'] ?> registered since <?php echo format_date(substr($login['created_at'], 0, -9)).", ".substr($login['created_at'], -8) ?>.</p>
												<p class="text-light mb-0">The remaining balance: $ <?php echo number_format($login['balance'],0,',','.'); ?></p>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="text-right">
												<a class="btn btn-light" href="<?php echo $config['web']['base_url'] ?>user/settings.php"><i class="fa fa-gear fa-spin fa-fw"></i> Account Settings</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-12 text-center" style="margin: 15px 0;">
								<h3 class="text-uppercase"><i class="fa fa-bullhorn fa-fw"></i> Website Information</h3>
							</div>
							<div class="col-lg-8">
								<div class="card-box">
								<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-info-circle"></i> 5 Latest Information</h4>
									<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="width: 250px;">DATE/TIME</th>
												<th>CONTENT</th>
											</tr>
										</thead>
										<tbody>

<?php
$news = $model->db_query($db, "*", "news", null, "id DESC", "LIMIT 5");
if ($news['count'] == 1) { ?>
	<tr>
		<td><?php echo format_date(substr($news['rows']['created_at'], 0, -9)).", ".substr($news['rows']['created_at'], -8) ?></td>
		<td><?php echo nl2br($news['rows']['content']) ?></td>
	</tr>
<?php
} else {
	foreach ($news['rows'] as $key => $value) {
?>
<tr>
	<td><?php echo format_date(substr($value['created_at'], 0, -9)).", ".substr($value['created_at'], -8) ?></td>
	<td><?php echo nl2br($value['content']) ?></td>
</tr>
<?php
	}
}
if ($news['count'] >= 5) { ?>
											<tr>
												<td colspan="3" align="center">
													<a href="<?php echo $config['web']['base_url'] ?>news.php">See All...</a>
												</td>
											</tr>

<?php
}
?>
										</tbody>
									</table>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-link fa-fw"></i> Sitemap</h4>
									<ul>
										<li><a href="<?php echo $config['web']['base_url'] ?>page/contact">Contact</a></li>
										<li><a href="<?php echo $config['web']['base_url'] ?>page/tos">Terms of Service</a></li>
										<li><a href="<?php echo $config['web']['base_url'] ?>page/faq">Frequently Asked Questions</a></li>
									</ul>
								</div>
							</div>
						</div>
<script type="text/javascript">
Morris.Area({
	element: 'last-order-chart',
	data: [
<?php
$date_list = array();
for ($i = 6; $i > -1; $i--) {
	$date_list[] = date('Y-m-d', strtotime('-'.$i.' days'));
}

for ($i = 0; $i < count($date_list); $i++) {
	$get_order = $model->db_query($db, "*", "orders", "user_id = '".$login['id']."' AND DATE(created_at) = '".$date_list[$i]."'");
	$get_deposit = $model->db_query($db, "*", "deposits", "user_id = '".$login['id']."' AND DATE(created_at) = '".$date_list[$i]."' AND status = 'Success'");
	print("{ y: '".format_date($date_list[$i])."', a: ".$get_order['count'].", b: ".$get_deposit['count']." }, ");
}
?>
	],
	xkey: 'y',
	ykeys: ['a','b'],
	labels: ['Order','Deposit'],
	lineColors: ['#02c0ce','#53c68c'],
	gridLineColor: '#eef0f2',
	pointSize: 0,
	lineWidth: 0,
	resize: true,
	parseTime: false
});
</script>
<?php
}
require 'lib/footer.php';
?>