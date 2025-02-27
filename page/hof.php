<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';

$orders = mysqli_query($db, "SELECT SUM(orders.price) AS tamount, count(orders.id) AS tcount, orders.user_id, users.full_name FROM orders JOIN users ON orders.user_id = users.id WHERE MONTH(orders.created_at) = '".date('m')."' AND YEAR(orders.created_at) = '".date('Y')."' GROUP BY orders.user_id ORDER BY tamount DESC LIMIT 10");
$deposits = mysqli_query($db, "SELECT SUM(deposits.amount) AS tamount, count(deposits.id) AS tcount, deposits.user_id, users.full_name FROM deposits JOIN users ON deposits.user_id = users.id WHERE MONTH(deposits.created_at) = '".date('m')."' AND YEAR(deposits.created_at) = '".date('Y')."' AND deposits.status = 'Success' GROUP BY deposits.user_id ORDER BY tamount DESC LIMIT 10");
$top_service = mysqli_query($db, "SELECT SUM(orders.price) AS tamount, count('orders.*') as num_orders, orders.service_name FROM orders WHERE MONTH(orders.created_at) = '".date('m')."' AND YEAR(orders.created_at) = '".date('Y')."' GROUP BY orders.service_name ORDER BY tamount DESC LIMIT 10"); // edit
?>
						<div class="row">
							<div class="col-lg-12 text-center" style="margin: 15px 0;">
								<h3 class="text-uppercase"><i class="fa fa-trophy fa-fw"></i> Top Users</h3>
								<p>Below are the top 10 users with the highest total orders and deposits this month.<br />Thank you for being our loyal customer!</p>
							</div>
							<div class="col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-trophy fa-fw"></i> Top 10 Orders</h4>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th>RANKING</th>
												<th>NAME</th>
												<th>TOTAL</th>
											</tr>
<?php
$no = 1;
while($data = mysqli_fetch_array($orders)) {
if ($no == 1) {
?> 
											<tr class="table-warning">
												<td><?php echo $no ?></td>
												<td><span class="badge badge-warning" style="margin-right: 5px;"><i class="mdi mdi-crown"></i></span><?php echo $data['full_name'] ?></td>
												<td>$ <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>
<?php
} else { 
?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $data['full_name'] ?></td>
												<td>$ <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>

<?php 
}
?>
<?php
	$no++;
}
?>
										</table>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-trophy fa-fw"></i> 10 Most Deposits</h4>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th>Ranking</th>
												<th>NAME</th>
												<th>TOTAL</th>
											</tr>
											<?php
$no = 1;
while($data = mysqli_fetch_array($deposits)) {
if ($no == 1) {
?> 
											<tr class="table-warning">
												<td><?php echo $no ?></td>
												<td><span class="badge badge-warning" style="margin-right: 5px;"><i class="mdi mdi-crown"></i></span><?php echo $data['full_name'] ?></td>
												<td>$ <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>
<?php
} else { 
?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $data['full_name'] ?></td>
												<td>$ <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>

<?php 
}
?>
<?php
	$no++;
}
?>

											</table>
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-trophy fa-fw"></i> Top 10 Services of the Month</h4>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th width="1%">Ranking</th>
												<th>Service Name</th>
												<th>Total Orders</th>
										 </tr>
											<?php 
                           $no = 1;
                                while ($data = mysqli_fetch_assoc($top_service)) {
                                                if ($no == 1) {
                                                    $label = "warning";
                                                } else {
                                                    $label = "";
                                                }
                                                ?>
                                    <tr>
											<tr class="table-warning">
										   	    <td><?php echo $no++; ?></td>
                                                <td><?php if ($no == 1) { ?><span class="badge badge-<?php echo $label; ?>" style="margin-right: 5px;"><i class="mdi mdi-crown"></i></span><?php } ?><?php echo $data['service_name']; ?></td>
												<td>$ <?php echo number_format($data['tamount'],0,',','.'); ?> (<?php echo number_format($data['num_orders'],0,',','.'); ?> Order)</td>
											</tr>
											<?php } ?>
										</table>
									</div>
								</div>
							</div>
<?php
require '../lib/footer.php';
?>