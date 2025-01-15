<?php
require '../mainconfig.php';
require '../lib/check_session.php';
// query list for paging
if (isset($_GET['search']) AND isset($_GET['status'])) {
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND method_name LIKE '%".protect_input($_GET['search'])."%' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND method_name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['status'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
// 
require '../lib/header.php';
?>
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-history"></i> Deposit History</h4>
									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row">
                                        	<div class="form-group col-lg-5">
                                        		<label>Filter Status</label>
                                        		<select class="form-control" name="status">
                                        			<option value="">All</option>
                                                   	<option value="Pending" >Pending</option>
                                                    <option value="Processing" >Processing</option>
                                                    <option value="Success" >Success</option>
                                                    <option value="Error" >Error</option>
                                                    <option value="Partial" >Partial</option>
                                        		</select>
                                        	</div>
                                        	<div class="form-group col-lg-5">
                                        		<label>Search Keywords</label>
                                        		<input type="text" class="form-control" name="search" placeholder="Keywords..." value="">
                                        	</div>
                                        	<div class="form-group col-lg-2">
                                        		<label>Submit</label>
                                        		<button type="submit" class="btn btn-block btn-dark">Filter</button>
                                        	</div>
                                        </div>
								    </form>
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="datatable">
										<thead>
												<tr>
													<th>ID</th>
													<th>DATE/TIME</th>
													<th>PAYMENT</th>
													<th>TYPE</th>
													<th>METHOD</th>
													<th>AMOUNT PAID</th>
													<th>BALANCE RECEIVED</th>
													<th style="max-width: 200px;">INFORMATION</th>
													<th>STATUS</th>
												</tr>
										</thead>
										<tbody>
										<?php	
										while ($data_query = mysqli_fetch_assoc($new_query)) {
										if($data_query['status'] == "Pending") {
											$label = "warning";
										} else if($data_query['status'] == "Canceled") {
											$label = "danger";
										} else if($data_query['status'] == "Success") {
											$label = "success";
										}
										?>
                                        	<tr>
												<td><?php echo $data_query['id'] ?></td>
												<td><?php echo format_date(substr($data_query['created_at'], 0, -9)).", ".substr($data_query['created_at'], -8) ?></td>
												<td><?php echo $data_query['payment'] == "bank" ? 'Transfer Bank' : 'Transfer Credit' ?></td>
												<td><?php echo $data_query['type'] == "auto" ? 'Automatic' : 'Manual' ?></td>
												<td><?php echo $data_query['method_name'] ?></td>
												<td>$ <?php echo number_format($data_query['post_amount'],0,',','.') ?></td>
												<td>$ <?php echo number_format($data_query['amount'],0,',','.') ?></td>
												<td><?php echo $data_query['note'] ?></td>
												<td><span class="badge badge-<?php echo $label; ?>"><?php echo $data_query['status'] ?></span></td>
											</tr>
                                        </tbody>
										<?php
										}
										?>
										</table>
										<?php
                                        require '../lib/pagination.php';
                                        ?>
								</div>
							</div>
						</div>
<?php
require '../lib/footer.php';
?>