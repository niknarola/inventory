<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<form method="post">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h5 class="panel-title">Add Role</h5>
						</div>
					</div> 
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<label>Name:</label>
								<input type="text" name="name" class="form-control" placeholder="John Kay" required>
							</div>
							<div class="form-group">
								<label>Select User Role:</label>
								<select name="role_id" data-placeholder="Select user role" class="form-control select" required>
									<?php foreach ($roles as $key => $value) { ?>
										<option value="<?= $key ?>"><?= $value ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="text-right">
								<button type="submit" name="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>