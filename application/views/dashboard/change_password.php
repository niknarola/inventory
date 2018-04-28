<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<h5 class="panel-title">Change Password</h5>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
				<form class="form-horizontal form-validate" action="" id="user_info" method="POST">
					<div class="panel panel-flat">
						<div class="panel-body">
					<?php if ($this->session->flashdata('msg')) { ?>
						<div class="alert alert-success hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('msg') ?></strong>
						</div>
					<?php }  if ($this->session->flashdata('err_msg')) { ?>
						<div class="alert alert-danger hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('err_msg') ?></strong>
						</div>
            		<?php }?>
							<div class="form-group">
								<label class="col-md-3 control-label">Current Password:</label>
								<div class="col-md-3">
									<input type="password" name="curr_pass" id="curr_pass" placeholder="Current Password" class="form-control" />
									<span id="curr_pass_error" class="not_found_error" style="color:red"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">New Password:</label>
								<div class="col-md-3">
									<input type="password" class="form-control" id="pass" placeholder="New Password" name="pass" >
									<span id="pass_error" class="not_found_error" style="color:red"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Repeat Password:</label>
								<div class="col-md-3">
									<input type="password" class="form-control" id="re_pass" placeholder="Repeat Password" name="re_pass" >
									<span id="re_pass_error" class="not_found_error" style="color:red"></span>
								</div>
							</div>
							<div class="text-right">
								<button class="btn btn-success" type="submit">Reset Password <i class="icon-arrow-right14 position-right"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
