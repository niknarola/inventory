<div class="sidebar sidebar-main hidden-print">
	<div class="sidebar-content">
		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<a href="#" class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
					<div class="media-body">
						<span class="media-heading text-semibold"><?php echo $this->session->userdata('name'); ?></span>
						<div class="text-size-mini text-muted">
							<i class="icon-user text-size-small"></i> &nbsp; <?php echo $this->session->userdata('role_name'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /user menu -->
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<?php $url = explode("/", $this->input->server('REQUEST_URI'));  $uri = end($url); ?>
					<li class="<?php echo ($uri=='/' || $uri == 'dashboard') ? 'active' : '' ?>"><a href="dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
					<?php if($this->session->userdata('role_id')!=5){ ?>
						<li class="<?php echo ($uri == 'products') ? 'active' : '' ?>"><a href="products"><i class="icon-barcode2"></i> <span>Products</span></a></li>
					<?php } ?>
					<li class="<?php echo (strpos($uri, 'upload_products') != false) ? 'active' : '' ?>"><a href="products/upload_products"><i class="icon-barcode2"></i> <span>Upload Products</span></a></li>
					<li class="<?php echo ($uri == 'generate_barcodes') ? 'active' : '' ?>"><a href="barcode/generate_barcodes"><i class="icon-home4"></i> <span>Generate Barcodes</span></a></li>
					<?php $permissions_array = get_permissions(); 
					$permissions = array_column($permissions_array,'ptype','permission_name');
					$ptypes = array_column($permissions_array,'ptype');
					$testing = 0;
					if(in_array('testing', $ptypes))
						$testing = 1;
					if($testing==1){ ?>
							<li class="">
								<a href="#"><i class="icon-stack2"></i> <span>Testing</span></a>
								<ul>
									<?php foreach ($permissions as $permission=>$ptype) { 
										$permission_url = str_replace('-', '_', $permission);
									 if($ptype=='testing'){ ?>
								<li class="<?php echo ($uri == str_replace(' ', '_', $permission_url)) ? 'active' : '' ?>"><a href="<?= strtolower($this->session->userdata('role_name')).'/'. str_replace(' ', '_', $permission_url) ?>"><i class="icon-menu"></i> <span><?= ucwords($permission); ?></span></a></li>
									<?php } ?>
							<?php } ?>
								</ul>
							</li>
							<?php }
					foreach ($permissions as $permission=>$ptype) { 
						if($permission == 'search' || $permission == 'temporary product flagged' || $permission == 'add notes' || $permission == 'packout' ){
						?>
						<li class="<?php echo ($uri == str_replace(' ', '_', $permission)) ? 'active' : '' ?>"><a href="<?= strtolower($this->session->userdata('role_name')).'/'. str_replace(' ', '_', $permission) ?>"><i class="icon-menu"></i> <span><?= ucwords($permission); ?></span></a></li>
					<?php 
					}else if($permission == 'locations'){ ?>
						<li class="<?php echo ($uri == str_replace(' ', '_', $permission)) ? 'active' : '' ?>"><a href="<?=  str_replace(' ', '_', $permission) ?>"><i class="icon-menu"></i> <span><?= ucwords($permission); ?></span></a></li>
					<?php }else if($ptype!='testing'){ ?>
						<li class="<?php echo ($uri == str_replace(' ', '_', $permission)) ? 'active' : '' ?>"><a href="javascript:void();"><i class="icon-menu"></i> <span><?= ucwords($permission); ?></span></a></li> 
					<?php }
				} ?>
				</ul>
			</div>
		</div>
		<!-- /main navigation -->
	</div>
</div>