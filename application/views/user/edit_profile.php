<div class="panel panel-flat">
	<div class="panel-heading">
		<div class="row">
			<h5 class="panel-title">Edit Profile</h5>
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
								<label class="col-md-3 control-label">Name:</label>
								<div class="col-md-3">
									<input type="text" name="name" value="<?php echo $user_data['name']; ?>" id="name" placeholder="Name" class="form-control" />
									<span id="name_error" class="not_found_error" style="color:red"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Email</label>
								<div class="col-md-3">
									<input type="email" class="form-control" value="<?php echo $user_data['email']; ?>" id="email" placeholder="Email" name="email" >
									<span id="email_error" class="not_found_error" style="color:red"></span>
								</div>
							</div>
							
							<div class="text-right">
								<button class="btn btn-success" type="submit">Save <i class="icon-arrow-right14 position-right"></i></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$(document).on('keyup','#name', function() {
		if($("#name").val().length !== 0) {
			$('#name_error').text('');
		}
		else{
			$('#name_error').html('Please Enter name');
		}
	});
	$(document).on('keyup','#email', function() {
		if($("#email").val().length !== 0) {
			$('#email_error').text('');
		}
		else{
			$('#email_error').html('Please Enter email');
		}
	});
});
</script>
