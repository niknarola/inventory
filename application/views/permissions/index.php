<div class="col-md-8 col-md-offset-2">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Permissions for <?= $role_name; ?></h5>
		<div class="heading-elements">
			<button type="button" class="btn bg-teal btn-sm add_role" data-toggle="modal" data-target="#modal_form_horizontal">Add New Permission</button>
		</div>
	</div>
	<div class="table-responsive">
    	<div class="col-md-12 permission_form" style="border-bottom: 1px solid #ddd;">
	    	<form action="admin/roles/assign_permissions" method="post">
	    		<div class="col-md-6 form-group">
	    			<select class="form-control" name="permission_id">
	    				<option value="">Select Permission</option>
	    				<?php foreach ($get_other_permissions as $perm) { ?>
	    					<option value="<?= $perm['id'] ?>"><?= ucwords($perm['name']) ?></option>
	    				<?php } ?>
	    			</select>
					<input type="hidden" name="role_id" value="<?= $role_id ?>">
				</div> 
	    		<div class="col-md-1 form-group">
					<button type="submit" name="submit" class="btn btn-primary">Assign</button>
				</div>
			</form>
		</div >
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
				foreach ($permissions as $permission) { ?>
					<tr>
						<td><?= $i ?></td>
						<td><?= ucwords($permission['permission_name']); ?></td>
						<td><a class="btn btn-xs btn-danger" href="admin/roles/remove_permission/<?=$permission['permission_id']?>/<?=$role_id?>">Remove</a></td>
					</tr>
				<?php
				$i++;
				 } ?>
			</tbody>
		</table>
	</div>
</div>
</div>
<div id="modal_form_horizontal" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">Add New Permission</h5>
			</div>
			<form action="admin/roles/add_new_permission" class="form-horizontal" method="post">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-sm-3">Permission Name</label>
						<div class="col-sm-9">
							<input type="text" placeholder="Permission Name" name="name" class="form-control" required>
							<input type="hidden" name="role_id" value="<?= $role_id ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3">
							Assign to <?= $role_name; ?>
						</label>
						<div class="col-sm-9" style="padding: 8px;">
							<input type="checkbox" name="assign_to_role" class="styled" checked="checked">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit form</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		
	});
</script>