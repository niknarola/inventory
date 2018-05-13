<div class="row">
	<div class="col-md-12">
		<form method="post" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="">
						<div class="">
							<h5 class="panel-title">Upload Product Data</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="">
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
							<input type="file" class="file-input-extensions" name="excel">
                                <span class="help-block">Allow only <code>xlsx</code> extensions.</span>
						</div>
					</div>
					<div class="text-left">
                        <button type="submit" name="save" class="btn bg-pink-400">Upload</button>
                    </div>
				</div>
			</div>
		</form>
</div>
<script type="text/javascript">
// Custom file extensions
    $(".file-input-extensions").fileinput({
        browseLabel: 'Browse',
        browseClass: 'btn btn-primary',
        uploadClass: 'btn btn-default',
        browseIcon: '<i class="icon-file-plus"></i>',
        uploadIcon: '<i class="icon-file-upload2"></i>',
        removeIcon: '<i class="icon-cross3"></i>',
        layoutTemplates: {
            icon: '<i class="icon-file-check"></i>'
        },
        maxFilesNum: 10,
        allowedFileExtensions: ["xlsx"]
    });
    $('.fileinput-upload-button').hide();

</script>
	</div>
</div>
