<script src="assets/js/jquery.dataTables.js?v=1"></script>
<div class="col-md-12">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Search Results</h5>
		<div class="heading-elements">
			<!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
    	</div> 
	</div>
	<div class="table-responsive">
    	<table class="table" id="product_tbl">
			<thead>
				<tr>
					<th>#</th>
					<th>Part</th>
					<th>Name</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>
				<?php foreach ($result as $product) { ?>
					<tr>
						<td><?= $i; ?></td>
						<td><?= $product['part'] ?></td>
						<td><?= $product['name'] ?></td>
						<td><?= $product['description'] ?></td>
						<td><a class="btn-xs btn-info" href="products/view/<?= $product['id'] ?>">View Details</a></td>
					</tr>
					<?php $i++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#product_tbl').DataTable({
		    ordering: false
		});
	});
</script>