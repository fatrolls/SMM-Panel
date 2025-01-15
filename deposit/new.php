<?php
require '../mainconfig.php';
require '../lib/check_session.php';
if ($_POST) {
	require '../lib/is_login.php';
	$input_data = array('method', 'phone', 'amount');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input is incorrect.');
	} else {
		$validation = array(
			'method' => $_POST['method'],
			'amount' => $_POST['amount'],
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Input cannot be empty.');
		} else {
			$method = $model->db_query($db, "*", "deposit_methods", "id = '".mysqli_real_escape_string($db, $_POST['method'])."' AND status = '1'");
			$deposit_request = $model->db_query($db, "*", "deposits", "user_id = '".$login['id']."' AND status = 'Pending'");
			if ($method['count'] == 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Deposit Method not found.');
			} else {
				if ($_POST['amount'] < $method['rows']['min_amount']) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Minimal deposit $ '.number_format($method['rows']['min_amount'],0,',','.').'.');
				} elseif ($method['rows']['payment'] == 'credit' AND empty($_POST['phone'])) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Sender Number cannot be empty.');
				} elseif ($deposit_request['count'] >= 1) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'You cannot make another deposit request, because you have 1 request with <i>Pending</i> status.');
				} else {
					$post_amount = $_POST['amount'];
					if ($method['rows']['payment'] == 'bank' AND $method['rows']['type'] == 'auto') {
						$post_amount = $_POST['amount'] + rand(000,999);
					}
					$input_post = array(
						'user_id' => $login['id'],
						'payment' => $method['rows']['payment'],
						'type' => $method['rows']['type'],
						'method_name' => $method['rows']['name'],
						'post_amount' => $post_amount,
						'amount' => $post_amount * $method['rows']['rate'],
						'note' => $method['rows']['note'],
						'phone' => $_POST['phone'],
						'status' => 'Pending',
						'created_at' => date('Y-m-d H:i:s')
					);
					$deposit_type = ($input_post['type'] == 'auto') ? 'Automatic' : 'Manual';
					$insert = $model->db_insert($db, "deposits", $input_post);
					if ($insert == true) {
$tanggal = date('Y-m-d');
$kode = 'ulindzgn-L9rJn0P3EG5fSgi'; 
$bank = $method['rows']['name']; 

$url = "https://cekduit.my.id/api/input.php";

$curlHandle = curl_init();
curl_setopt($curlHandle, CURLOPT_URL, $url);
curl_setopt($curlHandle, CURLOPT_POSTFIELDS, "kode=".$kode."&jumlah=".$post_amount."&bank=".$bank."&tanggal=".$tanggal);
curl_setopt($curlHandle, CURLOPT_HEADER, 0);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
curl_setopt($curlHandle, CURLOPT_POST, 1);
$result = curl_exec($curlHandle);
curl_close($curlHandle);

$b = json_decode($result, true);
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Deposit request successfully created.', 'msg' => '<br />ID Deposit: '.$insert.'<br />Metode Deposit: '.$input_post['method_name'].' ('.$deposit_type.')<br />Transfer Amount: $ '.number_format($input_post['post_amount'],0,',','.').'<br />Balance Received: $ '.number_format($input_post['amount'],0,',','.').'<br />'.$input_post['note']);
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Fail!', 'msg' => 'Deposit request failed to be made.');
					}
				}
			}
		}
	}
}
require '../lib/header.php';
?>
						<div class="row">
							<div class="col-lg-8">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-money"></i> New Deposit</h4>
<form class="form-horizontal" method="post" id="ajax-result">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Payment Types</label>
			<select class="form-control" name="payment" id="payment">
				<option value="0">Choose...</option>
				<option value="bank">Transfer Bank</option>
				<option value="credit">Transfer Credit</option>
			</select>
	</div>
	<div class="form-group">
		<label>Request Type</label><br />
			<label><input type="radio" name="type" value="auto"> Automatic</label><br />
			<label><input type="radio" name="type" value="manual"> Manual</label>
	</div>
	<div class="form-group">
		<label>Payment Method</label>
			<select class="form-control" name="method" id="method">
				<option value="0">Choose Payment Types and Requests...</option>
			</select>
	</div>
	<div class="form-group hide" id="phone">
		<label>Sender Number</label>
		<input type="number" class="form-control" name="phone" placeholder="08123456789">
	</div>
	<div class="form-group">
		<label>Amount</label>
		<input type="number" class="form-control" name="amount" placeholder="50000" id="post-amount"><small class="text-danger" id="min-amount"></small>
	</div>
	<div class="form-group">
		<label>Balance Received</label><input type="number" class="form-control" id="amount" readonly>
	</div>
	<div class="form-group">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-info-circle"></i> Cara Melakukan Deposit Balance</h4>
<h4>Steps:</h4>
<ul>
	<li>Choose the type of payment you want, there are 2 options: <b>Bank Transfer</b> & <b>Credit Transfer</b>.</li>
	<li>Choose the type of request you want, there are 2 options:
		<ul>
			<li><b>Automatic:</b> Your payment will be automatically confirmed by the system within 5-10 minutes after making the payment.</li>
			<li><b>Manual:</b> You must confirm payment to the Admin, so that your deposit request can be accepted.</li>
		</ul>
	</li>
	<li>Choose the payment method you want.</li>
	<li>Login the deposit amount.</li>
	<li>If you choose the <b>Transfer Credit</b> payment type, you are required to input the mobile number used for the credit transfer.</li>
</ul>
<h4>Important:</h4>
<ul>
	<li>You can only have a maximum of 3 Pending deposit requests, so don't <i>spam</i> and pay off your payments immediately.</li>
	<li>If the deposit request is not paid within more than 24 hours, the deposit request will be automatically cancelled.</li>
</ul>
									</div>
								</div>
							</div>
<script type="text/javascript">
$(document).ready(function() {
	function get_methods(payment, type) {
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-get-method.php",
			data: "payment=" + payment + "&type=" + type,
			dataType: "html",
			success: function(data) {
				$('#method').html(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">An error occurred! Please refresh the page.</font>');
			}
		});
	}
	$('input[type=radio][name=type]').change(function() {
		get_methods($('#payment').val(), this.value);
	});
	$('#payment').change(function() {
		get_methods($('#payment').val(), $('input[type=radio][name=type]:checked').val());
		if ($('#payment').val() == 'credit') {
			$('#phone').removeClass('hide');
		} else {
			$('#phone').addClass('hide');
		}
	});
	$('#method').change(function() {
		var method = $('#method').val();
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-select-method.php",
			data: "method=" + method,
			dataType: "html",
			success: function(data) {
				$('#min-amount').html(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">An error occurred! Please refresh the page.</font>');
			}
		});
	});
	$('#post-amount').keyup(function() {
		var method = $('#method').val();
		var amount = $('#post-amount').val();
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-get-amount.php",
			data: "method=" + method + "&amount=" + amount,
			dataType: "html",
			success: function(data) {
				$('#amount').val(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">An error occurred! Please refresh the page.</font>');
			}
		});
	});
});
</script>
<?php
require '../lib/footer.php';
?>