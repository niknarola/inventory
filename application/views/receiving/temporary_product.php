<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form method="post" action="<?php echo ($this->uri->segment(1)=='admin') ? 'admin/' : ''; ?>receiving/temporary_product" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h5 class="panel-title"><?= $title; ?></h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="row">
							<div class="col-md-6">
							<div class="form-group">
								<label>Part #:</label>
								<input type="text" name="part" value="<?= ($this->input->get('part') ? $this->input->get('part') : '' ) ?>" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Serial #:</label>
								<input type="text" name="serial" value="" class="form-control">
							</div>
							<div class="form-group">
								<label>Name:</label>
								<input type="text" value="" name="name" class="form-control" required> 
							</div>
							
						</div>
						<!-- <div class="col-md-6">
							<div class="row">
								<div class="form-group">
								<label>Specifications:</label>
									<div class="row">
										<div class="col-md-2">CPU</div>
										<div class="col-md-5"><input type="text" class="form-control cpu" name="cpu" value="" placeholder=""></div>
									</div>
									<div class="row">
										<div class="col-md-2">Memory</div>
										<div class="col-md-5"><input type="text" class="form-control memory" name="memory" value="" placeholder=""></div>
									</div>
									<div class="row">
										<div class="col-md-2">Storage</div>
										<div class="col-md-5"><input type="text" class="form-control storage" name="storage" value="" placeholder=""></div>
										<div class="col-md-5">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" name="ssd" class="ssd checkbx">
												</span>
												<input type="text" class="form-control" value="SSD" disabled="true">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">Graphics</div>
										<div class="col-md-5"><input type="text" class="form-control graphics" name="graphics" value="" placeholder=""></div>
										<div class="col-md-5">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" name="dedicated" class="dedicated checkbx">
												</span>
												<input type="text" class="form-control" value="Dedicated" disabled="true">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">Screen</div>
										<div class="col-md-5"><input type="text" class="form-control screen" name="screen" value="" placeholder="Resolution"></div>
										<div class="col-md-5"><input type="text" class="form-control size" name="size" value="" placeholder="Size"></div>
									</div>
									<div class="row">
										<div class="col-md-2">OS</div>
										<div class="col-md-5"><input type="text" class="form-control os" name="os" value="" placeholder=""></div>
									</div>
										
									</div>
								</div>
								
								</div>
							</div>
							<div class="row">
								
								<div class="col-md-3">
							<div class="form-group">
								<label>Product Line:</label>
								<select name="product_line_id" data-placeholder="Select Product Line" class="form-control select">
									<option value="">-- Select --</option>
									<?php foreach ($product_line as $key => $value) { ?>
										<option value="<?= $key; ?>"><?= $value; ?></option>
									<?php }  ?>
								</select>
							</div>
						</div> -->
						<div class="col-md-3">
							<div class="form-group">
								<label>Original Condition:</label>
								<select name="original_condition_id" data-placeholder="Select Original Condition" class="form-control select">
									<option value="">-- Select --</option>
									<?php foreach ($original_condition as $key => $value) { ?>
										<option value="<?= $key; ?>"><?= $value; ?></option>
									<?php }  ?>
								</select>
							</div>
						</div>
								<!-- <div class="col-md-3"> -->
						
										<!-- <div class="form-group"> -->
										<!-- <label>Other Features:</label> -->
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="touchscreen" class="checkbx touchscreen">
											</span>
											<input type="text" disabled="true" value="Touch Screen" class="form-control"> 
										</div> -->
										<!-- </div> -->
									<!-- </div> -->
										<!-- <div class="col-md-3"> -->
											<!-- <div class="form-group"> -->
										<!-- <label>&nbsp;</label> -->
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<input type="text" disabled="true" value="Webcam" class="form-control"> 
										</div> -->
									<!-- </div> -->
									<!-- </div> -->
							</div>
							<div class="form-group">
								<label>Description:</label>
								<textarea name="description" class="form-control"></textarea>
							</div>
							<!-- <div class="form-group">
								<label>Release Date:</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-calendar22"></i></span>
									<input type="text" name="release_date" class="form-control daterange-single" value="">
								</div>
							</div> -->
							<div class="row">
								<div class="col-md-4">
								<div class="form-group">
									<label>Category</label>
									<select name="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
										<?php foreach ($categories as $key => $value) { ?>
											<option value="<?= $key ?>"><?= $value ?></option>
										<?php } ?>
									</select>
								</div>
								</div>
								<div class="col-md-4 category_dropdn">
								<div class="form-group">
									<label>Sub Category</label><br>
									<select name="category2" disabled="true" class="category2 form-control" onchange="get_sub_categories(this.value, 'category3')">
									</select>
								</div>
								</div>
								<div class="col-md-4 category_dropdn">
								<div class="form-group">
									<label>Sub Category</label><br/>
									<select name="category3" disabled="true" class="category3 form-control">
										
									</select>
								</div>
								</div>
							</div>
							
							<div class="form-group">
								<label>Product Images:</label>
								<input type="file" name="product_images[]" class="file-input" multiple="multiple" data-show-upload="false">
							</div>
							<div class="text-right">
								<button type="submit" name="save" class="btn bg-pink-400">Save</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- <div class=""></div> -->
</div>
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript" src="assets/js/fileinput.min.js"></script>
<script type="text/javascript" src="assets/js/moment.min.js"></script>
<script type="text/javascript" src="assets/js/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/picker.js"></script>
<script type="text/javascript" src="assets/js/picker.date.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.daterange-single').daterangepicker({ 
	        singleDatePicker: true,
	        locale: {
	            format: 'YYYY-MM-DD'
	        }
	    });
	    $('.file-input').fileinput({
	        browseLabel: 'Browse',
	        browseIcon: '<i class="icon-file-plus"></i>',
	        removeIcon: '<i class="icon-cross3"></i>',
	        layoutTemplates: {
	            icon: '<i class="icon-file-check"></i>'
	        },
	        initialCaption: "No file selected"
	    });
	});
	get_sub_categories(1,'category2');
	/*$('.category1').multiselect();
	$('.category2').multiselect();
	$('.category3').multiselect();*/
	function get_sub_categories(cat_id, elem){
    	if(cat_id!=''){
    		$.ajax({
    			url: '<?php echo $cat_url; ?>',
    			type: 'POST',
    			dataType: 'json',
    			data: {category_id: cat_id},
    		})
    		.done(function(response) {
    			console.log("response",response);
    			if(response.result==1){
	    			$('.'+elem).html(response.html_text);
    				$('.'+elem).removeAttr('disabled');
    			}else{
	    			$('.'+elem).html('').attr('disabled', true);
	    		}
	    		if(elem=='category2'){
					$('.category3').html('').attr('disabled', true);
				}
    			// $('.'+elem).multiselect('destroy');
    			// $('.'+elem).multiselect();
    			// $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
    		})
    		.fail(function() {
    			console.log("error");
    		})
    		.always(function() {
    			console.log("complete");
    		});
    		
    	}
    }
</script>