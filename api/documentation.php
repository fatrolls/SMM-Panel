<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';
?>
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-book"></i> API Documentation</h4>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<td width="50%">HTTP METHOD</td>
			<td>POST</td>
		</tr>
		<tr>
			<td>RESPONSE FORMAT</td>
			<td>JSON</td>
		</tr>
		<tr>
			<td>API URL</td>
			<td><?php echo $config['web']['base_url'] ?>api/json.php</td>
		</tr>
		<tr>
			<td>API KEY</td>
			<td><?php echo $login['api_key'] ?> <a href="<?php echo $config['web']['base_url'] ?>user/post-settings.php?action=api_key" class="btn btn-xs btn-custom" title="Buat ulang"><i class="fa fa-random"></i></a></td>
		</tr>
		<tr>
			<td>CLASS EXAMPLE</td>
			<td><a href="<?php echo $config['web']['base_url'] ?>api/example.api.txt" target="_blank">API EXAMPLE</a></td>
		</tr>
	</table>
</div>
<h3>1. Displaying Service List</h3>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Parameter</th>
			<th>Information</th>
		</tr>
		<tr>
			<td>api_key</td>
			<td>Your API Key.</td>
		</tr>
		<tr>
			<td>action</td>
			<td>services</td>
		</tr>
	</table>
</div>
<h4>Example of Response Displayed</h4>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Successful Response</th>
			<th>Response Failed</th>
		</tr>
		<tr>
			<td>
<pre>{
	"status": true,
	"data": [
		{
			"id": 1,
			"name": "Instagram Followers S1",
			"price": 10000,
			"min": 100,
			"max": 10000,
			"note": "Super Fast, Input Username",
			"category": "Instagram Followers"
		},
		{
			"id": 2,
			"name": "Instagram Likes S1",
			"price": 5000,
			"min": 100,
			"max": 10000,
			"note": "Super Fast, Input Post Url",
			"category": "Instagram Likes"
		},
	]
}
</pre>
			</td>
			<td>
<pre>{
	"status": false,
	"data": {
		"msg": "Incorrect API Key"
	}
}
</pre>
<b>Possible messages displayed:</b>
<ul>
	<li>Request does not match</li>
	<li>Incorrect API Key</li>
</ul>
			</td>
		</tr>
	</table>
</div>
<h3>2. Make an Order</h3>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Parameter</th>
			<th>Information</th>
		</tr>
		<tr>
			<td>api_key</td>
			<td>Your API Key.</td>
		</tr>
		<tr>
			<td>action</td>
			<td>order</td>
		</tr>
		<tr>
			<td>service</td>
			<td>Service ID, can be seen at <a href="<?php echo $config['web']['base_url'] ?>services.php">List of Services</a>.</td>
		</tr>
		<tr>
			<td>data</td>
			<td>Data required according to service, such as target order url/username.</td>
		</tr>
		<tr>
			<td>quantity</td>
			<td>Number of messages.</td>
		</tr>
	</table>
</div>
<h4>Example of Response Displayed</h4>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Successful Response</th>
			<th>Response Failed</th>
		</tr>
		<tr>
			<td>
<pre>{
	"status": true,
	"data": {
		"id": "123"
	}
}
</pre>
			</td>
			<td>
<pre>{
	"status": false,
	"data": {
		"msg": "Balance is not enough"
	}
}
</pre>
<b>Possible messages displayed:</b>
<ul>
	<li>Request does not match</li>
	<li>Incorrect API Key</li>
	<li>Service not found</li>
	<li>Number of messages does not match</li>
	<li>Balance is not enough</li>
	<li>Service not available</li>
</ul>
			</td>
		</tr>
	</table>
</div>
<h3>3. Check Message Status</h3>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Parameter</th>
			<th>Information</th>
		</tr>
		<tr>
			<td>api_key</td>
			<td>Your API Key.</td>
		</tr>
		<tr>
			<td>action</td>
			<td>status</td>
		</tr>
		<tr>
			<td>id</td>
			<td>Order ID.</td>
		</tr>
	</table>
</div>
<h4>Example of Response Displayed</h4>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr>
			<th width="50%">Successful Response</th>
			<th>Response Failed</th>
		</tr>
		<tr>
			<td>
<pre>{
	"status": true,
	"data": {
		"status": "Processing",
		"start_count": 199,
		"remains": 0
	}
}
</pre>
<b>Possible statuses displayed:</b>
<ul>
	<li>Pending</li>
	<li>Processing</li>
	<li>Partial</li>
	<li>Error</li>
	<li>Success</li>
</ul>
			</td>
			<td>
<pre>{
	"status": false,
	"data": {
		"msg": "Order not found"
	}
}
</pre>
<b>Possible messages displayed:</b>
<ul>
	<li>Request does not match</li>
	<li>Incorrect API Key</li>
	<li>Order not found</li>
</ul>
			</td>
		</tr>
	</table>
</div>
							</div>
						</div>
					</div>
<?php
require '../lib/footer.php';
?>