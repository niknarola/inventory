<?php if ($this->session->flashdata('msg')) { ?>
	<div class="alert alert-success hide-msg">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
		<strong><?php echo $this->session->flashdata('msg') ?></strong>
	</div>
<?php } if ($this->session->flashdata('err_msg')) {?>
	<div class="alert alert-danger hide-msg">
		<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
		<strong><?php echo $this->session->flashdata('err_msg') ?></strong>
	</div>
<?php }	?>
<div class="panel panel-flat">
	<div class="panel-heading">
	
					
						
		<h5 class="panel-title">Users</h5>
		<div class="heading-elements">
			<a href="admin/user/add" class="btn bg-teal"> Add User</a>
    	</div>
	</div>

	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=1;
				foreach ($users as $user) { ?>
					<tr>
					<td><?= $i ?></td>
					<td><?= $user['name']; ?></td>
					<td><?= $user['email']; ?></td>
					<td><?= $user['role_name']; ?></td>
					<td><a class="btn-xs btn btn-success edit_role" href="admin/user/edit/<?= $user['id'] ?>">Edit</a></td>
				</tr>
				<?php
				$i++;
				 } ?>
			</tbody>
		</table>
	</div>
</div>
