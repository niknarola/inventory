<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $title; ?></title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<!-- /core JS files -->


	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/app.js"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container">
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=base_url()?>login">Inventory</a>

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<!-- <a href="mailto:admin@admin.com">
						<i class="icon-user-tie"></i> <span class="visible-xs-inline-block position-right"> Contact admin</span>
					</a> -->
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
        <!-- Page container -->
        <div class="page-container">

            <!-- Page content -->
            <div class="page-content">

                <!-- Main content -->
                <div class="content-wrapper">

                    <!-- Content area -->
                    <div class="content pb-20">    
					
                        <!-- Form with validation -->
                        <form class="form-validate" role="form" method="post" action="<?php echo base_url().'login/forgot_process'?>">
                            <div class="panel panel-body login-form">
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
                                <div class="text-center">
                                    <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                                    <h5 class="content-group">Forgot Password<small class="display-block">Your credentials</small></h5>
                                </div>

                                <div class="form-group has-feedback has-feedback-left">
                                    <input type="email" required="true" onblur="validateEmail(this);" name="email" class="form-control" placeholder="Email Id">
									<span id="email-error" style="color:red;"></span>
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>
                                <?php echo form_error('email','<div class="alert alert-mini alert-danger">','</div>'); ?>

                                <div class="form-group">
                                    <button type="submit" class="btn bg-blue btn-block">Submit <i class="icon-arrow-right14 position-right"></i></button>
                                </div>

                                 <div class="form-group">
                                    Already have an account?  <a href="<?=base_url('admin/login')?>"><strong> Back to login! </strong></a>
                                 </div>   
                            </div>
                        </form>
                        <!-- /form with validation -->

                    </div>
                    <!-- /content area -->

                </div>
                <!-- /main content -->

            </div>
            <!-- /page content -->

        </div>
        <!-- /page container -->

    </body>
</html>
<script type="text/javascript">
	function validateEmail(emailField){
		$('#email-error').text('');
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false) 
        {
            $('#email-error').html('Invalid Email Address');
            return false;
        }
		// $('#email-error').text('');
        return true;

}
</script>
