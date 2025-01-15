<?php
require '../../mainconfig.php';
require '../../lib/check_session_admin.php';
require '../../lib/header_admin.php';
?>
						<div class="row">
							<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-file"></i> Page Data</h4>
										<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover">
											<thead>
												<tr>
													<th width="50%">PAGE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Contact</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=1" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
												<tr>
													<td>Terms of Service</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=2" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
												<tr>
													<td>Frequently Asked Questions</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=3" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
<?php
require '../../lib/footer.php';
?>