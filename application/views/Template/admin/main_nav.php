<div class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?php echo base_url().'admin/user'?>">Inventory Management</a>
		<ul class="nav navbar-nav visible-xs-block">
			<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
	</div>
	<div class="navbar-collapse collapse" id="navbar-mobile">
		<ul class="nav navbar-nav">
			<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown dropdown-user">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<img src="assets/images/placeholder.jpg" alt="">
					<span><?= $this->session->userdata('name') ?></span>
					<i class="caret"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="<?php echo base_url('admin/user/edit_profile')?>"><i class="icon-pencil5"></i> My profile</a></li>
					<li><a href="<?php echo base_url('admin/user/change_password')?>"><i class="icon-lock2"></i> Change Password</a></li>
					<li><a href="admin/logout"><i class="icon-switch2"></i> Logout</a></li>
				</ul>
			</li>
		</ul> 
	</div>
</div>

