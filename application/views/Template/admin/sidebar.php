<div class="sidebar sidebar-main hidden-print">
	<div class="sidebar-content">
		<!-- User menu -->
		<div class="sidebar-user">
			<div class="category-content">
				<div class="media">
					<a href="#" class="media-left"><img src="assets/images/placeholder.jpg" class="img-circle img-sm" alt=""></a>
					<div class="media-body">
						<span class="media-heading text-semibold"><?= $this->session->userdata('name') ?></span>
						<div class="text-size-mini text-muted">
							<i class="icon-user text-size-small"></i> &nbsp;<?= $this->session->userdata('role_name') ?>
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
					<?php $uri = $this->input->server('REQUEST_URI'); ?>
					<li class="<?php echo (strpos($uri, 'dashboard') != false) ? 'active' : '' ?>"><a href="javascript:void();"><i class="icon-home2"></i> <span>Dashboard</span></a></li>
					<li class="<?php echo (strpos($uri, 'products') != false) ? 'active' : '' ?>"><a href="admin/products"><i class="icon-barcode2"></i> <span>Products</span></a></li>
					<li class="<?php echo (strpos($uri, 'upload_products') != false) ? 'active' : '' ?>"><a href="admin/products/upload_products"><i class="icon-upload"></i> <span>Upload Products</span></a></li>
					<li class="<?php echo ($uri == 'barcode') ? 'active' : '' ?>"><a href="admin/barcode/generate_barcodes"><i class="icon-barcode2"></i> <span>Generate Barcodes</span></a></li>
					<li class="<?php echo ($uri == 'receiving') ? 'active' : '' ?>">
						<a href="#"><i class="icon-stack2"></i> <span>Receiving</span></a>
							<ul>
								<li class="<?php echo (strpos($uri, 'dock_receive') != false) ? 'active' : '' ?>"><a href="admin/receiving/dock_receive"><i class="icon-menu"></i> <span>Dock Receive</span></a></li>
								<li class="<?php echo (strpos($uri, 'quick_receive') != false) ? 'active' : '' ?>"><a href="admin/receiving/quick_receive"><i class="icon-menu"></i> <span>Quick Receive</span></a></li>
								<li class="<?php echo (strpos($uri, 'print_labels') != false) ? 'active' : '' ?>"><a href="admin/receiving/print_labels"><i class="icon-menu"></i> <span>Print Labels</span></a></li>
							</ul>
					</li>
					<li class="<?php echo ($uri == 'testing') ? 'active' : '' ?>">
						<a href="#"><i class="icon-stack2"></i> <span>Testing</span></a>
							<ul>
								<li class="<?php echo (strpos($uri, 'notebook') != false) ? 'active' : '' ?>"><a href="admin/testing/notebook"><i class="icon-menu"></i> <span>Notebook</span></a></li>
								<li class="<?php echo (strpos($uri, 'desktop') != false) ? 'active' : '' ?>"><a href="admin/testing/desktop"><i class="icon-menu"></i> <span>Desktop</span></a></li>
								<li class="<?php echo (strpos($uri, 'thin_client') != false) ? 'active' : '' ?>"><a href="admin/testing/thin_client"><i class="icon-menu"></i> <span>Thin Client</span></a></li>
								<li class="<?php echo (strpos($uri, 'all_in_one') != false) ? 'active' : '' ?>"><a href="admin/testing/all_in_one"><i class="icon-menu"></i> <span>All-In-One</span></a></li>
								<li class="<?php echo (strpos($uri, 'tablet') != false) ? 'active' : '' ?>"><a href="admin/testing/tablet"><i class="icon-menu"></i> <span>Tablet</span></a></li>
								<li class="<?php echo (strpos($uri, 'monitor') != false) ? 'active' : '' ?>"><a href="admin/testing/monitor"><i class="icon-menu"></i> <span>Monitor</span></a></li>
								<li class="<?php echo (strpos($uri, 'accessory') != false) ? 'active' : '' ?>"><a href="admin/testing/accessory"><i class="icon-menu"></i> <span>Accessory</span></a></li>
								<li class="<?php echo (strpos($uri, 'printer') != false) ? 'active' : '' ?>"><a href="admin/testing/printer"><i class="icon-menu"></i> <span>Printer</span></a></li>
								<li class="<?php echo (strpos($uri, 'other_item') != false) ? 'active' : '' ?>"><a href="admin/testing/other_item"><i class="icon-menu"></i> <span>Other Item</span></a></li>
								<li class="<?php echo (strpos($uri, 'audit') != false) ? 'active' : '' ?>"><a href="admin/testing/audit"><i class="icon-menu"></i> <span>Audit</span></a></li>
								<li class="<?php echo (strpos($uri, 'quality') != false) ? 'active' : '' ?>"><a href="admin/testing/quality"><i class="icon-menu"></i> <span>Quality Control</span></a></li>
								<li class="<?php echo (strpos($uri, 'repair') != false) ? 'active' : '' ?>"><a href="admin/testing/repair"><i class="icon-menu"></i> <span>Repair</span></a></li>
							</ul>
						</li>
						<li class="<?php echo (strpos($uri, 'packout') != false) ? 'active' : '' ?>"><a href="admin/cleaning/packout"><i class="icon-user"></i> <span>Packout</span></a></li>
						<li class="<?php echo (strpos($uri, 'inventory') )? 'active' : '' ?>">
							<a href="#"><i class="icon-stack2"></i> <span>Inventory</span></a>
							<ul>
								<li class="<?php echo (strpos($uri, 'picking') != false) ? 'active' : '' ?>"><a href="admin/inventory/picking"><i class="icon-menu"></i> <span>Picking</span></a></li>
								<li class="<?php echo (strpos($uri, 'locations') != false) ? 'active' : '' ?>"><a href="admin/inventory/locations"><i class="icon-menu"></i> <span>Locations</span></a></li>
								<li class="<?php echo (strpos($uri, 'master_sheet') != false) ? 'active' : '' ?>"><a href="admin/inventory/master_sheet"><i class="icon-menu"></i> <span>Master Sheet</span></a></li>
								<li class="<?php echo (strpos($uri, 'reports') != false) ? 'active' : '' ?>"><a href="admin/inventory/reports"><i class="icon-menu"></i> <span>Reports</span></a></li>
							</ul>
						</li>
					<li class="<?php echo (strpos($uri, 'search') != false) ? 'active' : '' ?>"><a href="admin/receiving/search"><i class="icon-user"></i> <span>Search</span></a></li>
					<li class="<?php echo (strpos($uri, 'sales') )? 'active' : '' ?>">
							<a href="#"><i class="icon-stack2"></i> <span>Sales</span></a>
							<ul>
								<li class="<?php echo (strpos($uri, 'woocommerce') != false) ? 'active' : '' ?>"><a href="admin/sales/woocommerce"><i class="icon-menu"></i> <span>Woo Commerce</span></a></li>
								<li class="<?php echo (strpos($uri, 'ready_for_sale') != false) ? 'active' : '' ?>"><a href="admin/sales/ready_for_sale"><i class="icon-menu"></i> <span>Ready For Sale</span></a></li>
								<li class="<?php echo (strpos($uri, 'create_order') != false) ? 'active' : '' ?>"><a href="admin/sales/create_order"><i class="icon-menu"></i> <span>Create Order</span></a></li>
								<li class="<?php echo (strpos($uri, 'rma') != false) ? 'active' : '' ?>"><a href="admin/sales/rma"><i class="icon-menu"></i> <span>RMA</span></a></li>
								<li class="<?php echo (strpos($uri, 'new_product') != false) ? 'active' : '' ?>"><a href="admin/sales/new_product"><i class="icon-menu"></i> <span>New Product</span></a></li>
								<li class="<?php echo (strpos($uri, 'reports') != false) ? 'active' : '' ?>"><a href="admin/sales/reports"><i class="icon-menu"></i> <span>Reports</span></a></li>
							</ul>
						</li>
					<li class="<?php echo (strpos($uri, 'shipping') != false) ? 'active' : '' ?>"><a href="admin/shipping"><i class="icon-user"></i> <span>Shipping</span></a></li>
					<li class="<?php echo (strpos($uri, 'administration') )? 'active' : '' ?>">
							<a href="#"><i class="icon-stack2"></i> <span>Administration</span></a>
							<ul>
								<li class="<?php echo (strpos($uri, 'tech_productivity') != false) ? 'active' : '' ?>"><a href="admin/tech_productivity"><i class="icon-menu"></i> <span>Ready For Sale</span></a></li>
								<li class="<?php echo (strpos($uri, 'integration') != false) ? 'active' : '' ?>"><a href="admin/integration"><i class="icon-menu"></i> <span>Integration</span></a></li>
								<li class="<?php echo (strpos($uri, 'user') != false) ? 'active' : '' ?>"><a href="admin/user"><i class="icon-menu"></i> <span>Create User</span></a></li>
								<li class="<?php echo (strpos($uri, 'roles') != false) ? 'active' : '' ?>"><a href="admin/roles"><i class="icon-menu"></i> <span>User Permissions</span></a></li>
								<li class="<?php echo (strpos($uri, 'reports') != false) ? 'active' : '' ?>"><a href="admin/reports"><i class="icon-menu"></i> <span>Reports</span></a></li>
								<li class="<?php echo (strpos($uri, 'temporary_product_review') != false) ? 'active' : '' ?>"><a href="admin/temporary_product_review"><i class="icon-menu"></i> <span>Review</span></a></li>
								<li class="<?php echo (strpos($uri, 'edit') != false) ? 'active' : '' ?>"><a href="admin/edit"><i class="icon-menu"></i> <span>Edit</span></a></li>
								
							</ul>
						</li>
					
				</ul>
			</div>
		</div>
		<!-- /main navigation -->
	</div>
</div>