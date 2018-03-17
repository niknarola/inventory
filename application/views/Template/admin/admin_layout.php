<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>
	<base href="<?php echo base_url(); ?>">
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet" type="text/css">

	<!-- /global stylesheets -->
	<!-- Core JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	
	<!-- /core JS files -->
	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/app.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/moment.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/daterangepicker.js"></script>
	<!-- /theme JS files -->
</head>
<body>
	<!-- Main navbar -->
	<?php include_once 'main_nav.php' ?>
	<!-- /main navbar -->
	<!-- Page container -->
	<div class="page-container">
		<!-- Page content -->
		<div class="page-content">
			<!-- Main sidebar -->
			<?php include_once 'sidebar.php' ?>
			<!-- /main sidebar -->
			<!-- Main content -->
			<div class="content-wrapper">
				<!-- Page header -->
				<?php include_once 'breadcrumb.php'; ?>
				<!-- /page header -->
				<!-- Content area -->
				<div class="content">
					<?php if($this->session->flashdata('msg')!=null){ ?>
					<div class="alert alert-success">
						<span><?php echo $this->session->flashdata('msg'); ?></span>
					</div>
					<?php } ?>
					<?php if($this->session->flashdata('err_msg')!=null){ ?>
					<div class="alert alert-danger">
						<span><?php echo $this->session->flashdata('err_msg'); ?></span>
					</div>
					<?php } ?>
					<?php echo $body; ?>
					<!-- Footer -->
					<div class="footer text-muted"></div>
					<!-- /footer -->
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
