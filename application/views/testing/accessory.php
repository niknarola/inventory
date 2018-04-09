<div class="row">
	<div class="col-md-12">
		<form method="post" action="<?= $admin_prefix; ?>testing/accessory" id="accessory" enctype="multipart/form-data">
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
									<label>Serial #:</label>
									<input type="text" name="serial" value="" onchange="get_product_details();" class="form-control serial">
									<input type="hidden" name="serial_id" class="serial_id" value="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Part #:</label>
									<input type="text" name="part" value="" onchange="get_product_details();" class="form-control part" required>
									<input type="hidden" name="product_id" class="product_id" value="">
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>New Serial #:</label>
									<input type="text" name="new_serial" value="" class="form-control new_serial">
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
											<option <?php echo ($key == 1) ? 'selected' : ''; ?> value="<?= $key ?>"><?= $value ?></option>
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
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label>Description:</label>
										<textarea name="description" class="form-control description"></textarea>
									</div>
								</div> -->
								<div class="col-md-6">
									<div class="form-group">
										<label>Recv_note:</label>
										<textarea name="recv_notes" class="form-control recv_notes"></textarea>
									</div>
								</div>
							</div>
						<hr>
						<div class="row">
						<div class="col-md-8">
							<div class="row">

                                    <div class="col-md-6">
								<div class="form-group">
									<label>Pass</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="pass" class="checkbx pass">
										</span>
										<input type="text" readonly="true" value="Pass" class="form-control"> 
									</div>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group">
									<label>Fail</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="fail" class="checkbx fail">
										</span>
                                                                              <div class="multi-select-full">  
                                                                                    <select name="fail_option" class="multiselect form-control fail_option" multiple="multiple">
											<?php foreach ($fail_options as $key => $value) { ?>
												<option value="<?= $key; ?>"><?= $value; ?></option>
											<?php }  ?>
                                                                                    </select>
                                                                        </div>
									</div>
									<div class="form-group fail_reason_div" style="display: none;">
										<input type="text" class="form-control fail_reason_notes" name="fail_reason_notes" value="" placeholder="Fail Reason Notes">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                                <div class="col-md-6 form-group">
									<div class="" style="margin-bottom: 5px;">
										<label>Cosmetic Grade:</label>
										<div class="input-group">
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="MN" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
												TN
											</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="TN" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
												MN
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
                                                                                
									</div>
									</div>
									<span><b>MN</b> – Manufacturer New / <b>TN</b> - Tested New / <b>B</b> - Light Scratches / <b>C</b> - Deep Scratches </span>
								</div>
                                    <div class="col-md-6 form-group ">
									<div class="costmatic-fx" style="margin-bottom: 5px;">
										<label>&nbsp;</label>
										<div class="input-group col-md-6">
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="F" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
												F
											</label>
										</span> 
                                                                                <span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="X" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx">
												X
											</label>
										</span> 
									</div>
									</div>
                                                                <span><b>F</b> - Fail / <b>X</b> - Unsellable</span>
								</div>
							</div>
                                 </div>
                                 <div class="col-md-4">
                                 	<div class="form-group">
									<label>Failure Explanation:</label>
                                                                        <textarea name="fail_text" class="form-control" rows="5" cols="8"></textarea>
									<!--<input type="text" name="fail_1" value="" class="form-control fail_1">-->
								</div>
                                 </div>
								</div>
								<div class="row">
								<div class="col-md-2">
								<div class="row">
									<div class="form-group">
										<label>Cosmetic Notes:</label>
										<input type="text" class="form-control cs1" name="cs1" value="" placeholder="User Input">
										<input type="text" class="form-control cs2" name="cs2" value=""  placeholder="User Input">
									</div>
								</div>
									<!-- <div class="row"> -->
									<!-- <div class="form-group"> -->
										<!-- <label>Cosmetic Issues:</label> -->
										<?php //foreach ($cosmetic_issues as $key => $value) { ?>
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="<?= $key ?>" name="cosmetic_issue[]" class="cosmetic_boxes checkbx">
											</span>
											<input type="text" readonly="true" value="<?= $value ?>" class="form-control"> 
										</div> -->
										<?php //} ?>
									<!-- </div> -->
								<!-- </div> -->
							</div>
								<div class="col-md-8 based-on-radio">
									<div class="col-md-9">
										<div class="form-group">
										<label>&nbsp;</label>
                                        <div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="cable" class="cable checkbx">
														</span>
														<input type="text" class="form-control" value="Cable" readonly="true">
													</div>
												</div>
												<div class="col-md-4 col-md-offset-4"><input type="text" class="form-control sp_ui1" name="sp_ui1" value="" placeholder="User Input"></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="docking_station" class="docking_station checkbx">
														</span>
														<input type="text" class="form-control" value="Docking Station" readonly="true">
													</div>
												</div>
												<div class="col-md-4 col-md-offset-4"><input type="text" class="form-control sp_ui2" name="sp_ui2" value="" placeholder="User Input"></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="pc_part" class="pc_part checkbx">
														</span>
														<input type="text" class="form-control" value="PC Part" readonly="true">
													</div>
												</div>
												<div class="col-md-4"><input type="text" class="form-control pc_part_ui" name="pc_part_ui" value="" placeholder="User Input"></div>
												<div class="col-md-4"><input type="text" class="form-control sp_ui3" name="sp_ui3" value="" placeholder="User Input"></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="printer_part" class="printer_part checkbx">
														</span>
														<input type="text" class="form-control" value="Printer Part" readonly="true">
													</div>
												</div>
												<div class="col-md-4"><input type="text" class="form-control printer_part_ui" name="printer_part_ui" value="" placeholder="User Input"></div>
												<div class="col-md-4"><input type="text" class="form-control sp_ui4" name="sp_ui4" value="" placeholder="User Input"></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="retail" class="retail checkbx">
														</span>
														<input type="text" class="form-control" value="Retail" readonly="true">
													</div>
												</div>
												<div class="col-md-4"><input type="text" class="form-control retail_ui" name="retail_ui" value="" placeholder="User Input"></div>
												<div class="col-md-4"><input type="text" class="form-control sp_ui5" name="sp_ui5" value="" placeholder="User Input"></div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="accessory_other" class="accessory_other checkbx">
														</span>
														<input type="text" class="form-control" value="Other" readonly="true">
													</div>
												</div>
												<div class="col-md-4"><input type="text" class="form-control accessory_other_ui" name="accessory_other_ui" value="" placeholder="User Input"></div>
												<div class="col-md-4"><input type="text" class="form-control sp_ui6" name="sp_ui6" value="" placeholder="User Input"></div>
											</div>
                                        </div>
									</div>
									<div class="col-md-3">
                                        <div class="form-group">
                                                <label>Specifications:</label>
                                                <textarea placeholder="Additional Info User Input" class="form-control additional_info" rows="10" cols="3" name="additional_info"></textarea>
                                            </div>
                                        </div>
								</div>
                            <div class="col-md-2">
								<div class="col-md-12">
										<!-- <div class="row"> -->
										<!-- <div class="form-group"> -->
										<!-- <label>Accessories:</label> -->
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="cd_software" class="checkbx cd_software">
											</span>
											<input type="text" readonly="true" value="CD/Software" class="form-control"> 
										</div> -->
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="power_cord" class="checkbx power_cord">
											</span>
											<input type="text" readonly="true" value="Power Cord" class="form-control"> 
										</div> -->
										<!-- <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="manual" class="checkbx manual">
											</span>
											<input type="text" readonly="true" value="Manual" class="form-control"> 
										</div> -->
									<!-- </div> -->
								<!-- </div> -->
							</div>
							</div>
                            </div>
                            <div class="row accessories-div" style="display:none;">
                                <div class="col-md-4 title-div-text">
                                <!-- <div class="col-md-6 "> -->
                                    <label>Accessories</label>
                                    
                                    <!-- </div> -->
                                </div>   
                            </div>
							<div class="row">
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
											<option value="Unknown">Unknown</option>
											<option value="Active">Active</option>
											<option value="Expired">Expired</option>
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
							<!-- <div class="col-md-6">
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
							</div> -->
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tech Notes:</label>
									<textarea name="tech_notes" class="form-control tech_notes"></textarea>
								</div>
							</div>
						</div>
                        <div class="col-md-12">
                            <div class="col-md-2 col-md-offset-9">
                                <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
									<input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" name="save" class="btn bg-pink-400">Save</button>
                            </div>
                        </div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- <div class=""></div> -->
</div>	
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">Accessories Not in database</h4></center>
            </div>
            <div class="modal-body">
                <center><button type="button" class="btn btn-info btn-lg add_now" data-toggle="modal" data-target="#myModal2">Add Now</button></center>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="row accessories">
				<div class="new_add_wrapper">
				    <div class="col-md-5">
                        <div class="form-group">
                            Accessories Type
                            <select name="access_type0[]" class="form-control cd_soft access-type-select">
                            	<option value="AC Adapter">AC Adapter</option>
                            	<option value="Mouse">Mouse</option>
                            	<option value="Keyboard">Keyboard</option>
                            	<option value="Stylus Pen">Stylus Pen</option>
                            	<option value="Docking Station">Docking Station</option>
                            	<option value="Power Jacket">Power Jacket</option>
                            	<option value="Rugged Jacket">Rugged Jacket</option>
                            	<option value="Detachable Keyboard">Detachable Keyboard</option>
                            	<option value="Detachable Power Keyboard">Detachable Power Keyboard</option>
                            	<option value="Other">Other</option>
                            </select>
                            <input style="display: none; margin-top:10px;" type="text" name="other_access_type0[]" value="" class="form-control other_access_type" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group" >
                            Accessories Name
                            <input  type="text" class="form-control cd_soft access-name-input" style="display:none;" name="access_name0[]" value="" placeholder="" />

                            <select name="access_name0[]" style="display:block;" class="form-control cd_soft access-name-select">
                            	<option value="45W Blue Tip">45W Blue Tip</option>
                            	<option value="65W Blue Tip">65W Blue Tip</option>
                            	<option value="150W+ Blue Tip">150W+ Blue Tip</option>
                            	<option value="45W Black Tip">45W Black Tip</option>
                            	<option value="65W Black Tip">65W Black Tip</option>
                            	<option value="150W+ Black Tip">150W+ Black Tip</option>
                            	<option value="No AC Adapter">No AC Adapter</option>
                            	<option value="Other">Other</option>
                            </select>

                            <input style="display: none; margin-top:10px;" type="text" name="other_access_name0[]" value="" class="form-control other_access_name" placeholder="">
                        </div>
                    </div>
				</div>
                    <div class="col-md-2" ><i class="icon-plus-circle2 add_more_access"></i></div>
                </div>
            </div>
            <div class="modal-footer">
            <center><button type="button" class="btn btn-info btn-lg add_ok" data-toggle="modal" data-target="">Add Now</button></center>
            </div>
        </div>
    </div>
</div>
<div class="row access1" style="display:none;">
	<div class="new_add_wrapper">
		<div class="col-md-5">
			<div class="form-group">
				Accessories Type
				<select name="access_type[]" class="form-control cd_soft access-type-select">
					<option value="AC Adapter">AC Adapter</option>
					<option value="Mouse">Mouse</option>
					<option value="Keyboard">Keyboard</option>
					<option value="Stylus Pen">Stylus Pen</option>
					<option value="Docking Station">Docking Station</option>
					<option value="Power Jacket">Power Jacket</option>
					<option value="Rugged Jacket">Rugged Jacket</option>
					<option value="Detachable Keyboard">Detachable Keyboard</option>
					<option value="Detachable Power Keyboard">Detachable Power Keyboard</option>
					<option value="Other">Other</option>
				</select>
				<input style="display: none; margin-top:10px;" type="text" name="other_access_type[]" value="" class="form-control other_access_type" placeholder="">
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group" >
				Accessories Name
				<input  type="text" class="form-control cd_soft access-name-input" style="display:none;" name="access_name[]" value="" placeholder="" />
				<select name="access_name[]" style="display:block;" class="form-control cd_soft access-name-select">
					<option value="45W Blue Tip">45W Blue Tip</option>
					<option value="65W Blue Tip">65W Blue Tip</option>
					<option value="150W+ Blue Tip">150W+ Blue Tip</option>
					<option value="45W Black Tip">45W Black Tip</option>
					<option value="65W Black Tip">65W Black Tip</option>
					<option value="150W+ Black Tip">150W+ Black Tip</option>
					<option value="No AC Adapter">No AC Adapter</option>
					<option value="Other">Other</option>
				</select>
				<input style="display: none; margin-top:10px;" type="text" name="other_access_name[]" value="" class="form-control other_access_name" placeholder="">
			</div>
		</div>
	</div>
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
		$(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
	  	});
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
	$('input.warranty_date').attr('disabled',true);
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
  		//var part = $('input.part').val();
    	var serial = $('input.serial').val();
    	// var new_serial = $('input.new_serial').val();
		if(serial!=''){
		//if(part!='' && serial!=''){
			var data = {serial: serial};
			// if(new_serial!=''){
			// 	data.new_serial = new_serial;
			// }
			$.ajax({
				url: '<?php echo $ajax_url; ?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(response) {
				if(response.status==0){
					$( "input" ).not( ".serial, .new_serial" ).val('');
					$('textarea').html('');
					$('input[type="checkbox"]').prop('checked', false);
					$('input[type="radio"]').prop('checked', false);
					$('.category1').val(1).trigger('change');
					get_sub_categories(1, 'category2');
					$('select.warranty').val('Active').trigger('change');
					$('select.status').val('').trigger('change');
					$('.other_category').css('display','none');
				}else{
					if(response.product.ptested == '' || response.product.ptested == 0 || response.product.ptested == null){
						$('#myModal').modal('show');
                        $('.add_now').on('click', function() {
                            $('#myModal').modal('hide');
                            $('#newModal').modal('show');
                        });
					}else {
						// need to add html
						var html="";
						var array_type = '';
						if(response.product.accessory_name){
							var temp_name = JSON.parse(response.product.accessory_name);
							var temp_type = JSON.parse(response.product.accessory_type);
							html= html + '';
							if(temp_name!=null){
								var str = '';
								for(var i=0;i<temp_name.length;i++){
									$('.accessories-div').show();
									str = str + '<div class="input-group"><span class="input-group-addon"><input type="hidden" value="" name="access_type[]"><input type="checkbox" value="'+temp_name[i]+'" name="access_name[]" checked="true" class=" '+temp_name[i]+' checkbx"></span><label class="check_label">'+temp_name[i]+'</label></div>';
									$(".title-div-text").html(str);
								}
							}
						}


					}
					// if(response.product.tested_by == '' || response.product.tested_by == 0 || response.product.tested_by == null){
                    //     $('#myModal').modal('show');
                    //     $('.add_now').on('click', function() {
                    //         $('#myModal').modal('hide');
                    //         $('#newModal').modal('show');
                    //     });
                    // }
					$('input.scan_loc').val(response.product.location_name);
				$('input.scan_loc_id').val(response.product.location_id);
				$('input.product_id').val(response.product.pid);
				$('input.part').val(response.product.part);
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
				
				$('.cosmetic_grade_boxes').each(function(index, el) {
					$(this).prop('checked', false);
					if($(this).val() == response.product.cosmetic_grade){
						$(this).prop('checked', true);
					}
				});
				
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
				$('.hard_drive_wiped').prop('checked', false);
				if(response.product.hard_drive_wiped==1){
					$('.hard_drive_wiped').prop('checked', true);
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
				if(cs_issue_text!=null){
				$('.cs1').val(cs_issue_text.cs1);
				$('.cs2').val(cs_issue_text.cs2);
				}
				/*var fail_text = JSON.parse(response.product.fail_text);
				$('.fail_1').val(fail_text.fail_1);
				$('.fail_2').val(fail_text.fail_2);
				$('.fail_3').val(fail_text.fail_3);*/
				var accessory_fields = JSON.parse(response.product.accessory_fields);
				$('.cable').prop('checked', false);
				if(accessory_fields.cable==1){
					$('.cable').prop('checked', true);
				}
				$('.docking_station').prop('checked', false);
				if(accessory_fields.docking_station==1){
					$('.docking_station').prop('checked', true);
				}
				$('.pc_part').prop('checked', false);
				if(accessory_fields.pc_part==1){
					$('.pc_part').prop('checked', true);
				}
				$('.pc_part_ui').val(accessory_fields.pc_part_ui);

				$('.printer_part').prop('checked', false);
				if(accessory_fields.printer_part==1){
					$('.printer_part').prop('checked', true);
				}
				$('.printer_part_ui').val(accessory_fields.printer_part_ui);

				$('.retail').prop('checked', false);
				if(accessory_fields.retail==1){
					$('.retail').prop('checked', true);
				}
				$('.retail_ui').val(accessory_fields.retail_ui);

				$('.accessory_other').prop('checked', false);
				if(accessory_fields.accessory_other==1){
					$('.accessory_other').prop('checked', true);
				}
				$('.accessory_other_ui').val(accessory_fields.accessory_other_ui);

				var specifications_ui = JSON.parse(response.product.specifications_ui);
				$('.sp_ui1').val(specifications_ui.sp_ui1);
				$('.sp_ui2').val(specifications_ui.sp_ui2);
				$('.sp_ui3').val(specifications_ui.sp_ui3);
				$('.sp_ui4').val(specifications_ui.sp_ui4);
				$('.sp_ui5').val(specifications_ui.sp_ui5);
				$('.sp_ui6').val(specifications_ui.sp_ui6);

				var cat_raw = response.product.category;
			    var category = (cat_raw!='') ? JSON.parse(cat_raw) : '';
			    cat = (category!='') ? category[0] : 1;
			    $('.category1').val(cat).trigger('change');
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
    
    
        $('.multiselect').multiselect({
            onChange: function() {
                $.uniform.update();
        }
        // Styled checkboxes and radios
    });
    $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
    $('.pass').change(function(){
            if(this.checked){
                $("input[name='fail']").prop('disabled',true);
                $('.f').prop('disabled', true);
                $('.x').prop('disabled', true);
            }else{
                $("input[name='fail']").prop('disabled',false);
                $('.f').prop('disabled', false);
                $('.x').prop('disabled', false);
            }
        })

        $('.fail').change(function(){
            if(this.checked){
                $("input[name='pass']").prop('disabled',true);
                $('.mn').prop('disabled', true);
                $('.tn').prop('disabled', true);
                $('.b').prop('disabled', true);
                $('.c').prop('disabled', true);
            }
            else{
                $("input[name='pass']").prop('disabled',false);
                $('.mn').prop('disabled', false);
                $('.tn').prop('disabled', false);
                $('.b').prop('disabled', false);
                $('.c').prop('disabled', false);
            }
        })
    $( ".cosmetic_grade_boxes" ).change(function() {
        var grade = $("input[name='cosmetic_grade']:checked").val();
        if(grade == 'F' || grade == 'X')
        {
            $('.based-on-radio').find("input,textarea").prop('disabled',true);
            //pass
            $("input[name='pass']").prop('disabled',true);
            $("input[name='pass']").prop('checked',false);
            $('.mn').prop('disabled', true);
            $('.tn').prop('disabled', true);
            $('.b').prop('disabled', true);
            $('.c').prop('disabled', true);
            //fail
            $("input[name='fail']").prop('checked',true);
        }
        else
        {
            $('.based-on-radio').find("input,textarea").prop('disabled',false);
           //pass
            $("input[name='pass']").prop('disabled',false);
            $("input[name='pass']").prop('checked',true);
            //fail
            $("input[name='fail']").prop('checked',false);
            $("input[name='fail']").prop('disabled',true);
            $('.f').prop('disabled', true);
            $('.x').prop('disabled', true);
        }
    });
	$(document).on('change', '.status', function(event) {
	     	if($(this).val() == 'Other'){
	     		$('.other_status').css('display', 'block');
	    	}else{
	    		$('.other_status').css('display', 'none');
	    	}

	    });
	    $(document).on('change', '.access-type-select', function(event) {
			$(this).parents('.new_add_wrapper').find('.access-name-select').css('display', 'none');
	    		$(this).parents('.new_add_wrapper').find('.access-name-input').css('display', 'none');
				$(this).parents('.new_add_wrapper').find('.other_access_type').css('display', 'none');
	     	if($(this).val() == 'AC Adapter'){
				$(this).parents('.new_add_wrapper').find('.access-name-select').css('display', 'block');
	    		$(this).parents('.new_add_wrapper').find('.access-name-input').css('display', 'none');
	    	}else if($(this).val() == 'Other'){
				$(this).parents('.new_add_wrapper').find('.access-name-select').css('display', 'none');
	    		$(this).parents('.new_add_wrapper').find('.access-name-input').css('display', 'block');
				$(this).parents('.new_add_wrapper').find('.other_access_type').css('display', 'block');
			}else if($(this).val() != 'AC Adapter'){
	    		$(this).parents('.new_add_wrapper').find('.access-name-select').css('display', 'none');
	    		$(this).parents('.new_add_wrapper').find('.access-name-input').css('display', 'block');
	    	}

	    });
	    $(document).on('change', '.access-name-select', function(event) {
	     	if($(this).val() == 'Other'){
				$(this).parents('.new_add_wrapper').find('.other_access_name').css('display', 'block');
	    	}else{
	    		$(this).parents('.new_add_wrapper').find('.other_access_name').css('display', 'none');
	    	}

	    });
		
		$('.add_more_access').on('click', function() {
		len = $('.access-type-select:visible').length;
        $('.access1').find('.access-type-select').attr('name','access_type'+len+'[]');

		len = $('.access-name-select:visible').length;
        $('.access1').find('.access-name-select').attr('name','access_name'+len+'[]');

        $('.accessories').append($('.access1').html());
    })
    $('.add_ok').on('click', function(){
		var new_array = [];
		$('.accessories .new_add_wrapper').each(function(obj){
			var new_json = {};
			new_json.name=$(this).find('.access-type-select').val();
			new_json.value1=$(this).find('.access-name-select').val();
			//Ac adapter
			if(new_json.name == 'AC Adapter'){
				new_json.value1 = $(this).find('.access-name-select').val();
				if(new_json.value1 == 'Other'){
					new_json.value2 = $(this).find('.other_access_name').val();	
				}
	    	}
			//Other
			else if(new_json.name == 'Other'){
	    		new_json.value1 = $(this).find('.access-name-input').val();
				new_json.value2 = $(this).find('.other_access_type').val();
			}
			//Other type
			else if(new_json.name != 'AC Adapter'){
	    		new_json.value1 = $(this).find('.access-name-input').val();
	    	}
			new_array.push(new_json);
		});
		var data="";
		$.ajax({
			url: 'admin/testing/get_accessories',
			type: 'POST',
			data: {"data": JSON.stringify(new_array)},
			success: function (data) {
				$('.title-div-text').append(data);
			}
		});
				$('#myModal2').modal('hide');
				$('.accessories-div').show();
		

    });

</script>
