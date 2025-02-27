<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	exit("No direct script access allowed!");
}
$data_target = $model->db_query_join($db, "orders.*, users.username, provider.name AS provider_name", "orders", "LEFT JOIN users ON users.id = orders.user_id LEFT JOIN provider ON provider.id = orders.provider_id", "orders.id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
if ($data_target['count'] == 0) {
	$result_msg = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Data not found.');
	require '../../../lib/result.php';
	exit();
}
if ($data_target['rows']['is_refund'] == 1) {
	$count_refund = $data_target['rows']['price'] / $data_target['rows']['quantity'];
	$total_refund = $count_refund * $data_target['rows']['remains'];
} 
if($data_target['rows']['status'] == "Pending") {
	$label = "warning";
} else if($data_target['rows']['status'] == "Processing") {
	$label = "info";
} else if($data_target['rows']['status'] == "Error") {
	$label = "danger";
} else if($data_target['rows']['status'] == "Partial") {
	$label = "danger";
} else if($data_target['rows']['status'] == "Success") {
	$label = "success";
}
?>
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<tr>
		<th width="50%">ID</th>
		<td><?php echo $data_target['rows']['id'] ?></td>
	</tr>
	<tr>
		<td><b>DATE/TIME</b></td>
		<td><?php echo format_date(substr($data_target['rows']['created_at'], 0, -9)).", ".substr($data_target['rows']['created_at'], -8) ?></td>
	</tr>
	<tr>
		<th width="50%">USER</th>
		<td><?php echo $data_target['rows']['username'] ?></td>
	</tr>
	<tr>
		<th width="50%">NAME SERVICE</th>
		<td><?php echo $data_target['rows']['service_name'] ?></td>
	</tr>
	<tr>
		<th width="50%">DATA</th>
		<td><?php echo $data_target['rows']['data'] ?></td>
	</tr>
	<tr>
		<th width="50%">AMOUNT ORDER</th>
		<td><?php echo number_format($data_target['rows']['quantity'],0,',','.') ?></td>
	</tr>
	<tr>
		<th width="50%">PRICE</th>
		<td>$ <?php echo number_format($data_target['rows']['price'],0,',','.') ?></td>
	</tr>
	<tr>
		<th width="50%">PROFIT</th>
		<td>$ <?php echo number_format($data_target['rows']['profit'],0,',','.') ?></td>
	</tr>
	<tr>
		<th width="50%">AMOUNT BEGINNING</th>
		<td><?php echo number_format($data_target['rows']['start_count'],0,',','.') ?></td>
	</tr>
	<tr>
		<th width="50%">AMOUNT NOT ENOUGH</th>
		<td><?php echo number_format($data_target['rows']['remains'],0,',','.') ?></td>
	</tr>
	<tr>
		<th width="50%">STATUS</th>
		<td><span class="badge badge-<?php echo $label ?>"><?php echo $data_target['rows']['status'] ?></span></td>
	</tr>
	<tr>
		<th width="50%">PROVIDER API</th>
		<td><?php echo $data_target['rows']['provider_name'] ?></td>
	</tr>
	<tr>
		<th width="50%">PROVIDER ORDER ID</th>
		<td><?php echo $data_target['rows']['provider_order_id'] ?></td>
	</tr>
	<tr>
		<th width="50%">SOURCE</th>
		<td><?php echo ($data_target['rows']['is_api'] == 1) ? 'API' : 'WEB' ?></td>
	</tr>
	<tr>
		<th width="50%">REFUND</th>
		<td><?php echo ($data_target['rows']['is_refund'] == 1) ? 'YA ($ '.number_format($total_refund,0,',','.').')' : 'NO' ?></td>
	</tr>
	<tr>
		<th width="50%">TREND UPDATE</th>
		<td><?php echo $data_target['rows']['updated_at'] ?></td>
	</tr>
	<tr>
		<th width="50%">LOG POST ORDER</th>
		<td><?php echo $data_target['rows']['api_order_log'] ?></td>
	</tr>
	<tr>
		<th width="50%">LOG GET STATUS</th>
		<td><?php echo $data_target['rows']['api_status_log'] ?></td>
	</tr>
</table>
</div>