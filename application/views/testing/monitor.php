<div class="row">
	<div class="">
		<form method="post" action="<?= $admin_prefix; ?>testing/monitor" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="">
							<h5 class="panel-title"><?= $title; ?></h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<hr>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Part #:</label>
									<input type="text" name="part" value="" onchange="get_product_details();" class="form-control part" required>
									<input type="hidden" name="product_id" class="product_id" value="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Serial #:</label>
									<input type="text" name="serial" value="" onchange="get_product_details();" class="form-control serial">
									<input type="hidden" name="serial_id" class="serial_id" value="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>New Serial #:</label>
									<input type="text" name="new_serial" onchange="get_product_details();" value="" class="form-control new_serial">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name:</label>
									<input type="text" value="" name="name" class="form-control name" required> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Received Condition:</label>
									<select name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
										<?php foreach ($original_condition as $key => $value) { ?>
											<option value="<?= $key; ?>"><?= $value; ?></option>
										<?php }  ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Add File:</label>
									<input type="file" class="form-control" name="product_files[]" multiple="multiple" value="" placeholder="">
									<input type="hidden" name="files" class="files" value="">
								</div>
							</div>
						</div>
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
									<input class="form-control other_category" style="display: none;" type="text" name="category3" value="" placeholder="Enter Category">
								</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Description:</label>
										<textarea name="description" class="form-control description"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Recv_note:</label>
										<textarea name="recv_notes" class="form-control recv_notes"></textarea>
									</div>
								</div>
							</div>
						<hr>
							<div class="row">
								<div class="col-md-2">
									<div class="row">
										<div class="form-group">
											<label>Cosmetic Notes:</label>
											<input type="text" class="form-control cs1" name="cs1" value="" placeholder="User Input">
											<input type="text" class="form-control cs2" name="cs2" value=""  placeholder="User Input">
										</div>
									</div>
									<div class="row">
									<div class="form-group">
										<label>Cosmetic Issues:</label>
										<?php foreach ($cosmetic_issues as $key => $value) { ?>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="<?= $key ?>" name="cosmetic_issue[]" class="cosmetic_boxes checkbx">
											</span>
											<input type="text" readonly="true" value="<?= $value ?>" class="form-control"> 
										</div>
										<?php } ?>
									</div>
								</div>
								

								</div>
								<div class="col-md-6">
									<div class="col-md-8">
										<div class="form-group">
										<label>Specifications:</label>
											<div class="row">
												<div class="col-md-2">Curved</div>
												<div class="col-md-5"><input type="text" class="form-control curved" name="curved" value="" placeholder=""></div>
											</div>
											
											<div class="row">
												<div class="col-md-2">Screen</div>
												<div class="col-md-5"><input type="text" class="form-control screen" name="screen" value="" placeholder="Resolution"></div>
												<div class="col-md-5"><input type="text" class="form-control size" name="size" value="" placeholder="Size"></div>
											</div>
											
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Addition Info/Accessories:</label>
											<textarea class="form-control additional_info" rows="10" cols="3" name="additional_info"></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="col-md-6">
										<div class="row">
										<div class="form-group">
										<label>Other Features:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="touchscreen" class="checkbx touchscreen">
											</span>
											<input type="text" readonly="true" value="Touch Screen" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<input type="text" readonly="true" value="No Webcam" class="form-control"> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label>Additional Features:</label>
										<textarea name="additional_features" class="form-control additional_features"></textarea>
									</div>
								</div>
									</div>
									<div class="col-md-6">
										<div class="row">
										<div class="form-group">
										<label>Accessories:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="cd_software" class="checkbx cd_software">
											</span>
											<input type="text" readonly="true" value="CD/Software" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="power_cord" class="checkbx power_cord">
											</span>
											<input type="text" readonly="true" value="Power Cord" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="stand" class="checkbx stand">
											</span>
											<input type="text" readonly="true" value="Stand" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="hdmi_cable" class="checkbx hdmi_cable">
											</span>
											<input type="text" readonly="true" value="HDMI Cable" class="form-control"> 
										</div>
									</div>
								</div>
<!--								<div class="row">
									<div class="form-group">
										<label>Additional Accessories:</label>
										<textarea name="additional_accessories" class="form-control additional_accessories"></textarea>
									</div>
								</div>-->
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group" style="margin-bottom: 5px;">
										<label>Cosmetic Grade:</label>
										<div class="input-group">
										<span class="input-group-addon">
										<label class="radio-inline">
											<input type="radio" value="A" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
											A
										</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
											<input type="radio" value="B" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
											B
										</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
											<input type="radio" value="C" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
											C
										</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
											<input type="radio" value="D" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
											D
										</label>
										</span>
									</div>
									</div>
									<span><b>A</b> – Like New / <b>B</b> - Light Scratches / <b>C</b> - Deep Scratches / <b>D</b> - Significant Physical Damage</span>
								</div>
								<div class="col-md-3">
								<div class="form-group">
									<label>Final Condition: </label>
									<select name="final_condition" class="form-control final_condition">
										<?php foreach ($original_condition as $key => $value) { ?>
											<option value="<?= $key; ?>"><?= $value; ?></option>
										<?php }  ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-6">
									<div class="form-group">
										<label>Warranty: </label>
										<select name="warranty" class="form-control warranty" onchange="warranty_change(this.value)">
											<option value="Active">Active</option>
											<option value="Expired">Expired</option>
											<option value="Unknown">Unknown</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Active Until: </label>
										<div class="input-group">
										<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										<input type="text" name="warranty_date" class="form-control daterange-single warranty_date" value="">
									</div>
									</div>
								</div>
							</div>
								</div>
							<hr>
							<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Fail</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="fail" class="checkbx fail">
										</span>
										<select name="fail_option" class="form-control fail_option">
											<?php foreach ($fail_options as $key => $value) { ?>
												<option value="<?= $key; ?>"><?= $value; ?></option>
											<?php }  ?>
										</select>
									</div>
									<div class="form-group fail_reason_div" style="display: none;">
										<input type="text" class="form-control fail_reason_notes" name="fail_reason_notes" value="" placeholder="Fail Reason Notes">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Fail 1:</label>
									<input type="text" name="fail_1" value="" class="form-control fail_1">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Fail 2:</label>
									<input type="text" name="fail_2" value="" class="form-control fail_2">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Fail 3:</label>
									<input type="text" name="fail_3" value="" class="form-control fail_3">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="pass" class="checkbx pass">
										</span>
										<input type="text" readonly="true" value="Pass" class="form-control"> 
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="factory_reset" class="checkbx factory_reset">
										</span>
										<input type="text" readonly="true" value="Factory Reset" class="form-control"> 
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="hard_drive_wiped" class="checkbx hard_drive_wiped">
										</span>
										<input type="text" readonly="true" value="Hard Drive Wiped" class="form-control"> 
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Status:</label>
									<select name="status" class="form-control status">
										<option value="">Select Option</option>
										<option value="Sold">Sold</option>
										<option value="RMA">RMA</option>
										<option value="Ready For Sale">Ready For Sale</option>
										<option value="Testing">Testing</option>
										<option value="Failed">Failed</option>
										<option value="Awaiting Repair">Awaiting Repair</option>
										<option value="Packout">Packout</option>
										<option value="Received">Received</option>
										<option value="Shipped">Shipped</option>
										<option value="FGI HOLD">FGI HOLD</option>
										<option value="Other">Other</option>
									</select>
									<input style="display: none;" type="text" name="other_status" value="" class="form-control other_status" placeholder="">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tech Notes:</label>
									<textarea name="tech_notes" class="form-control tech_notes"></textarea>
								</div>
							</div>
							</div>
							<div class="text-right">
								<button type="submit" name="save" class="btn bg-pink-400">Save</button>
							</div>
						</div>
				</div>
		</form>
			</div>
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
	    get_sub_categories(1, 'category2');
	    $(document).on('change', '.status', function(event) {
	     	if($(this).val() == 'Other'){
	     		$('.other_status').css('display', 'block');
	    	}else{
	    		$('.other_status').css('display', 'none');
	    	}

	     });
	     $(document).on('change', '.fail_option', function(event) {
	    	if($(this).val()==6){
	    		$('.fail_reason_div').css('display', 'block');
	    	}else{
	    		$('.fail_reason_div').css('display', 'none');
	    	}
	    	
	    });
	    // $('.category3').multiselect();
	});
	function warranty_change(val){
		if(val!='Active'){
	    		$('input.warranty_date').attr('disabled',true);
	    	}else{
	    		$('input.warranty_date').attr('disabled',false);
	    	}
	}
	function get_sub_categories(cat_id, elem, category=null){
		if(cat_id!=''){
			
			var cat2_name = $('.category2 option[value="'+cat_id+'"]').text();
			if(cat2_name=='Other'){
				$('.other_category').css('display','block');
				if(category!=null && category.length > 2)
				$('.other_category').val(category[2]);
			}else{
				$('.other_category').css('display','none');
				$.ajax({
	    			url: '<?php echo $cat_url; ?>',
	    			type: 'POST',
	    			dataType: 'json',
	    			data: {category_id: cat_id},
	    		})
	    		.done(function(response) {
	    			if(response.result==1){
		    			$('.'+elem).html(response.html_text);

	    				$('.'+elem).removeAttr('disabled');
	    			}else{
		    			$('.'+elem).html('').attr('disabled', true);
		    		}
		    		if(elem=='category2'){
		    			if(category!=null && category.length > 1){
							multiselect_selected($('.category2'), category[1]);
						}
						$('.category3').html('').attr('disabled', true);
					}
					if(elem=='category3'){
		    			if(category!=null && category.length > 2){
							multiselect_selected($('.category3'), category[2]);
						}
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
    }
    function multiselect_selected($el, values) {
    	$el.val(values);
    }
    function get_product_details(){
  		var part = $('input.part').val();
    	var serial = $('input.serial').val();
    	var new_serial = $('input.new_serial').val();
		if(part!='' && serial!=''){
			var data = {part: part, serial: serial};
			if(new_serial!=''){
				data.new_serial = new_serial;
			}
			$.ajax({
				url: '<?php echo $ajax_url; ?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(response) {
				if(response.status==0){
					$( "input" ).not( ".part, .serial, .new_serial" ).val('');
					$('textarea').html('');
					$('input[type="checkbox"]').prop('checked', false);
					$('input[type="radio"]').prop('checked', false);
					get_sub_categories(1, 'category2');
					$('select.warranty').val('Active').trigger('change');
					$('select.status').val('').trigger('change');
					$('.other_category').css('display','none');
				}else{
				$('input.product_id').val(response.product.pid);
				$('input.serial_id').val(response.product.id);
				$('input.new_serial').val(response.product.new_serial);
				$('input.name').val(response.product.product_name);
				$('input.cpu').val(response.product.cpu);
				$('input.memory').val(response.product.memory);
				$('input.storage').val(response.product.storage);
				$('input.graphics').val(response.product.graphics);
				$('input.screen').val(response.product.screen);
				$('input.os').val(response.product.os);
				$('input.size').val(response.product.size);
				$('input.other_status').val(response.product.other_status);
				$('input.files').val(response.product.files);
				$('input.fail_reason_notes').val(response.product.fail_reason_notes);
				//---------------
				$('textarea.description').html(response.product.product_desc);
				$('textarea.additional_info').html(response.product.additional_info);
				$('textarea.additional_features').html(response.product.additional_features);
				$('textarea.additional_accessories').html(response.product.additional_accessories);
				$('textarea.tech_notes').html(response.product.tech_notes);
				$('textarea.recv_notes').html(response.product.recv_notes);
				//----------------
				$('.touchscreen').prop('checked', false);
				if(response.product.touch_screen==1){
					$('.touchscreen').prop('checked', true);
				}
				$('.cosmetic_grade_boxes').each(function(index, el) {
					$(this).prop('checked', false);
					if($(this).val() == response.product.cosmetic_grade){
						$(this).prop('checked', true);
					}
				});
				$('.optical_drive').prop('checked', false);
				if(response.product.optical_drive==1){
					$('.optical_drive').prop('checked', true);
				}
				$('.webcam').prop('checked', false);
				if(response.product.webcam==1){
					$('.webcam').prop('checked', true);
				}
				$('.cd_software').prop('checked', false);
				if(response.product.cd_software==1){
					$('.cd_software').prop('checked', true);
				}
				$('.power_cord').prop('checked', false);
				if(response.product.power_cord==1){
					$('.power_cord').prop('checked', true);
				}
				$('.manual').prop('checked', false);
				if(response.product.manual==1){
					$('.manual').prop('checked', true);
				}
				$('.pass').prop('checked', false);
				if(response.product.pass==1){
					$('.pass').prop('checked', true);
				}
				$('.factory_reset').prop('checked', false);
				if(response.product.factory_reset==1){
					$('.factory_reset').prop('checked', true);
				}
				$('.ssd').prop('checked', false);
				if(response.product.ssd==1){
					$('.ssd').prop('checked', true);
				}
				$('.dedicated').prop('checked', false);
				if(response.product.dedicated==1){
					$('.dedicated').prop('checked', true);
				}
				$('.mouse_keyboard').prop('checked', false);
				if(response.product.mouse_keyboard==1){
					$('.mouse_keyboard').prop('checked', true);
				}
				//----------------
				$('select.original_condition').val(response.product.original_condition_id);
				$('select.status').val(response.product.status).trigger('change');
				$('select.fail_option').val(response.product.fail_option).trigger('change');
				$('select.warranty').val(response.product.warranty).trigger('change');
				var cs_issue = JSON.parse(response.product.cosmetic_issue);
				$('.cosmetic_boxes').each(function(index, el) {
					if($.inArray($(this).val(), cs_issue)!=-1){
						$(this).prop('checked', true);
					}else{
						$(this).prop('checked', false);
					}
				});
				var cs_issue_text = JSON.parse(response.product.cosmetic_issues_text);
				$('.cs1').val(cs_issue_text.cs1);
				$('.cs2').val(cs_issue_text.cs2);
				var fail_text = JSON.parse(response.product.fail_text);
				$('.fail_1').val(fail_text.fail_1);
				$('.fail_2').val(fail_text.fail_2);
				$('.fail_3').val(fail_text.fail_3);

				var cat_raw = response.product.category;
			    var category = (cat_raw!='') ? JSON.parse(cat_raw) : '';
			    cat = (category!='') ? category[0] : 1;
				get_sub_categories(cat,'category2', category);
				if(category.length == 1){
					// $('.category2').multiselect();
					// $('.category3').multiselect();
				}
				if(category.length > 2){
					get_sub_categories(category[1],'category3', category);
				}else{
					// $('.category3').multiselect();
				}
			}
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