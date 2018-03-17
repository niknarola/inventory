<div class="col-md-12">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Search Results</h5>
		<div class="heading-elements">
			<!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
    	</div>
	</div>
	<div class="panel-body">
    <?php //echo'post data';pr($_POST); die;?>
	<?php if($_POST['part']){
        $product = reset($product);
        // pr($product);die;
        // echo"in serial product";pr($product['status']);die;
        // if($product['status']==1){
        if($product){ 
            // pr($product);die;
            ?>
	<div class="table-responsive">
		<div class="row col-md-6 col-md-offset-3">
		<table class="table text-left">
			<tbody>
				<tr>
					<td>Units In House</td>
                    <td><?= $units_in_house;?></td>
				</tr>
				<tr>
                    <td>Ready For Sale</td>
                    
                    <td><?= $ready_for_sale;?></td>
				</tr>
				<tr>
                
					<td>Units In Production</td>
                    <td><?= $units_in_production;?></td>
				</tr>
				<tr>
					<td>Units Sold</td>
                    <td><?= $sold;?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>
		<hr>
	<div class="row">
    	<table class="table" id="product_tbl">
			<thead>
				<tr>
					<th>#</th>
					<th>Serial Number</th>
					<th>Part</th>
					<th>Name</th>
					<th>Description</th>
					<th>Status</th>
					<th>Sales Order</th>
					<th>Tracking Number</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>
				<?php foreach ($product['serial_products'] as $serial_product) { ?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $serial_product['serial'] ?></td>
						<td><?= $product['part'] ?></td>
						<td><?= $product['name'] ?></td>
						<td><?= $product['description'] ?></td>
						<td><?= $serial_product['status'] ?></td>
						<td></td>
						<td></td>
					</tr>
					<?php $i++; ?>
				<?php }  ?>
			</tbody>
		</table>
	</div>
	</div>
	<?php }else{ ?>
			<div class="row col-md-6 col-md-offset-3 text-center">
				<div class="alert alert-info">The product has already been added as Temporary Product and id pending for review.</div>
			</div>
			<div class="row col-md-6 col-md-offset-3 text-center">
				<a class="btn btn-info" href="products/view/<?= $product['id'] ?>">View Product</a>
				<a class="btn btn-primary" href="receiving/temporary_product_edit/<?= $product['id'] ?>">Edit Product</a>
				<a class="btn btn-success" data-toggle="modal" data-target="#addquantity_modal">Add Quantity</a>
				<div id="addquantity_modal" class="modal fade" role="dialog">
				  <div class="modal-dialog">
				    <!-- Modal content-->
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4 class="modal-title">Add Serial Number</h4>
				      </div>
				      <form method="post" action="receiving/add_serial/<?=$product['id']?>">
				      <div class="modal-body">
				       <div class="form-group">
							<label>Serial #:</label>
							<input type="text" name="serial" value="" class="form-control serial" required>
						</div> 
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				        <button type="submit" class="btn btn-primary">Save</button>
				      </div>
				  </form>
				    </div>
				  </div>
				</div>
			</div>	
	<?php } } elseif($_POST['serial']) {?>
        <div class="row">
    	<table class="table" id="product_tbl">
			<thead>
				<tr>
					<th>#</th>
					<th>Serial Number</th>
					<th>Part</th>
					<th>Name</th>
					<th>Description</th>
					<th>Status</th>
					<!-- <th>Sales Order</th> -->
					<!-- <th>Tracking Number</th> -->
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>

			<?php foreach ($product as $serial_product) { ?> 
					<tr>
						<td><?= $i; ?></td>
						<td><?= $serial_product['serial'] ?></td>
						<td><?= $serial_product['part'] ?></td>
						<td><?= $serial_product['name'] ?></td>
						<td><?= $serial_product['description'] ?></td>
						<td><?= $serial_product['serial_status'] ?></td>
						<!-- <td></td>
						<td></td> -->
					</tr>
					<?php $i++; ?>
				 <?php }  ?> 
			</tbody>
		</table>
	</div>
    <?php } elseif($_POST['part'] && $_POST['serial']) { ?>
        <div class="row">
    	<table class="table" id="product_tbl">
			<thead>
				<tr>
					<th>#</th>
					<th>Serial Number</th>
					<th>Part</th>
					<th>Name</th>
					<th>Description</th>
					<th>Status</th>
					<th>Sales Order</th>
					<th>Tracking Number</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>
				<?php foreach ($product['serial_products'] as $serial_product) { ?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $serial_product['serial'] ?></td>
						<td><?= $product['part'] ?></td>
						<td><?= $product['name'] ?></td>
						<td><?= $product['description'] ?></td>
						<td><?= $serial_product['status'] ?></td>
						<td></td>
						<td></td>
					</tr>
					<?php $i++; ?>
				<?php }  ?>
			</tbody>
		</table>
	</div>
    <?php } ?>
</div>
</div>
</div>