<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form method="post" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="">
							<h5 class="panel-title">Upload Product Data</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="form-group">
							<label class="display-block text-semibold">Select Upload Options</label>
							<label class="radio-inline">
								<input type="radio" value="inventory" name="upload" checked="checked">
								Upload Inventory Products
							</label>
							<label class="radio-inline">
								<input type="radio" value="new" name="upload">
								Upload New Product
							</label>
						</div>
						<div class="form-group">
							<label class="text-semibold">Browse Products Sheet:</label>
							<input type="file" class="form-control" name="excel" value="" placeholder="" required>
						</div>
					</div>
					<div class="row">
						<div class="text-right">
							<button type="submit" name="save" class="btn bg-pink-400">Upload</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>