<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat">
			<?php if(!empty($product)){ ?>
			<?php //pr($product,1); ?>
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h5 class="col-md-6 panel-title">Product Details</h5>
						<div class="pull-right col-md-6">
                        <?php if($this->uri->segment(1)=='admin' && $product['status']==0){ ?>
								<a href="admin/temporary_products/edit/<?= $product['id']; ?>" class="col-md-2 btn btn-warning approve_btn">Edit</a>
								<a href="admin/temporary_product/approve/<?= $product['id']; ?>" class="col-md-2 btn btn-primary approve_btn">Approve</a>
							<?php if($product['requested_for_clarification']==1){ ?>
								<span class="btn btn-warning">Requested for Clarification</span>
							<?php }elseif ($product['requested_for_clarification']==2){ ?>
								<span class="btn btn-success">Clarification Provided</span>
						<?php }else{ ?>
								<a href="admin/temporary_product/request_clarification/<?= $product['id']; ?>" class="col-md-4 btn btn-success">Request For Clarification</a>
						<?php } ?>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				
					<div class="col-md-12">
						<div class="row">
						<div class="col-md-9">
						<table class="table">
							<tbody>
								<?php //pr($product);die;?>
								<tr>
									<td><b>Part # :</b></td>
									<td><?= $product['part']; ?></td>
								</tr>
								<tr>
									<td><b>Name :</b></td>
									<td><?= $product['name']; ?></td>
								</tr>
								<!-- <tr>
									<td><b>Description :</b></td>
									<td><?//= $product['description']; ?></td>
								</tr> -->
								<tr>
									<td><b>Category :</b></td>
									<td><?= ($product['category']!=null || $product['category'] != '') ? get_category_name($product['category']) : ''; ?></td>
								</tr>
								<tr>
									<td><b>Product Line :</b></td>
									<td><?= $product['product_line']; ?></td>
								</tr>
								
								<!-- <tr>
									<td><b>Release Date :</b></td>
									<td><?= $product['release_date']; ?></td>
								</tr> -->
							</tbody>
						</table>
					</div>
					<div class="col-md-3">
					<?php
                        if(isset($product_images) || $product_images!= '' || $product_images != null){
                    ?>
					<img src="<?= base_url().'/assets/uploads/'.$product_images['id'].'/'.$product_images['image']; ?>" alt="No image found" style="height:200px; width:200px !important">
						<?php }else{?>
					<img src="<?= base_url().'/assets/images/not-available.jpg'?>" height="200px" width="200px" alt="No image found">
						<?php }?>
						<!-- <table class="table specifications"> 
							<tbody>
								<tr>
									<td><b>CPU :</b></td>
									<td><?= $product['cpu']; ?></td>
								</tr>
								<tr>
									<td><b>Memory :</b></td>
									<td><?= $product['memory']; ?></td>
								</tr>
								<tr>
									<td><b>Storage :</b></td>
									<td><?= $product['storage']; ?><?= ($product['ssd'] == 1) ? ' SSD' : '' ; ?></td>
								</tr>
								<tr>
									<td><b>Graphics :</b></td>
									<td><?= $product['graphics']; ?><?= ($product['dedicated'] == 1) ? ' Dedicated' : '' ; ?></td>
								</tr>
								<tr>
									<td><b>Screen :</b></td>
									<td><?= $product['screen'].' '.$product['size']; ?></td>
								</tr>
								<tr>
									<td><b>OS :</b></td>
									<td><?= $product['os']; ?></td>
								</tr>
								<tr>
									<td><b>Touch Screen :</b></td>
									<td><?= ($product['touch_screen'] == 1) ? 'Yes' : 'No' ; ?></td>
								</tr>
								<tr>
									<td><b>Webcam :</b></td>
									<td><?= ($product['webcam'] == 1) ? 'Yes' : 'No' ; ?></td>
								</tr>
								
							</tbody>
						</table> -->
					</div>
				</div>
				<div class="row">
						<?php if($product['serial_products']!=''){ ?>
						<hr>
							<h5 class="panel-title serial_title">Product Serials</h5>
								<table class="table" id="serial_table">
									<thead>
										<tr>
											<th>#</th>
											<th>Serial No.</th>
											<th>New Serial</th>
											<th>Condition</th>
											<th>Cosmetic Grade</th>
											<th>Recv Notes</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $i=1; foreach ($product['serial_products'] as $serial_products):  ?>
											<tr>
												<td><?= $i ?></td>
												<td><?= $serial_products['serial']; ?></td>
												<td><?= $serial_products['new_serial']; ?></td>
												<td><?= $serial_products['original_condition']; ?></td>
												<td><?= $serial_products['cosmetic_grade']; ?></td>
												<td><?= $serial_products['recv_notes']; ?></td>
												<td><a href="<?php echo ($this->session->userdata('admin_validated')) ? 'admin/' : ''; ?>products/product_serial/<?=$serial_products['id']?>" class="btn-xs btn-default"><i class="icon-eye"></i></a><a href="<?php echo ($this->session->userdata('admin_validated')) ? 'admin/' : ''; ?>products/serial_delete/<?=$product['id']?>/<?=$serial_products['id']?>" class="btn-xs btn-default"><i class="icon-cross2"></i></a></td>
											</tr>
										<?php $i++; endforeach ?>
									</tbody>
								</table>
						<?php } ?>
					</div>

					</div>
					
				
			</div>
			<?php if($product['requested_for_clarification']!=0){ ?>
				<?php if($this->uri->segment(1)!='admin'){ ?>
					<div class="panel-body">
						<form method="post" action="receiving/provide_clarification/<?=$product['id']?>">
							<div class="form-group">
								<label>Clarification:</label>
								<textarea name="clarification_text" class="form-control"><?= ($product['clarification_text']!='') ? $product['clarification_text'] : '' ; ?></textarea>
							</div>
							<div class="text-right">
								<button type="submit" name="save" class="btn bg-pink-400">Save</button>
							</div>
						</form>
					</div>
				<?php }else{
					if(($product['clarification_text']!='')){ ?>
						<div class="panel-body">
							<label>Clarification:</label>
							<p class="form-control"><?php echo $product['clarification_text']; ?></p>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<?php }else{ ?>
			<div class="panel-body">
				<div class="col-md-6 col-md-offset-3 text-center">
					<div class="alert alert-info"><?php echo 'No Product Found!!'; ?></div>
				</div>
			</div>
			<?php } ?>
			<div class="panel-body text-center">
				<a href="<?php echo $this->input->server('HTTP_REFERER'); ?>" class="btn btn-primary">Back</a>
			</div>
		</div>
	</div>
</div>
<script src="assets/js/jquery.dataTables.js?v=1"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#serial_table').DataTable()
	});
</script>
