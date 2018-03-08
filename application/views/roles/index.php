<div class="col-md-8 col-md-offset-2">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Roles</h5>
		<div class="heading-elements">
			<!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
    	</div> 
	</div>
	<div class="table-responsive">
    	<div class="col-md-12 role_form" style="border-bottom: 1px solid #ddd;">
	    	<form action="admin/roles/add" method="post">
	    		<div class="col-md-6 form-group">
					<input type="text" name="name" placeholder="Role Name" class="form-control" required>
				</div>
	    		<div class="col-md-1 form-group">
					<button type="submit" name="submit" class="btn btn-primary">Add</button>
				</div>
			</form>
		</div>
		<hr>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=1;
				foreach ($roles as $role) { ?>
					<tr>
						<td><?= $i ?></td>
						<td><?= $role['name']; ?></td>
						<td><button type="button" class="btn-xs btn btn-success edit_role" data-name="<?= $role['name']; ?>" data-href="admin/roles/edit/<?= $role['id'] ?>">Edit</button> <a class="btn btn-xs btn-info" href="admin/roles/permissions/<?=$role['id']?>">Manage Permissions</a></td>
					</tr>
				<?php
				$i++;
				 } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.add_role').click(function(event) {
			$('.role_form form').attr('action',$(this).attr('data-href'));
			$('.role_form form').find('input[name="name"]').val('');
			$('.role_form form').find('button').html('Add');
		});
		$('.edit_role').click(function(event) {
			$('.role_form form').attr('action',$(this).attr('data-href'));
			$('.role_form form').find('input[name="name"]').val($(this).attr('data-name'));
			$('.role_form form').find('button').html('Edit');
		});
	});
</script>