<style>
	.row{ margin-left: 0px; margin-right: 0px; }
</style>
<div class="row">
	<div class="">
		<form method="post" action="<?= $admin_prefix; ?>cleaning/packout" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="">
							<h5 class="panel-title">Packout</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
				<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
								<!-- <label>Serial #:</label> -->
								<input type="text" value="" name="serial" class="form-control serial" onchange="get_product_details(this.value);" placeholder="Serial #"> 
								</div>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary category_btn" onclick="get_product_details()">Search</button>
							</div>
						</div>
				</div>					
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label> Original Serial #:</label>
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
									<input type="text" name="new_serial"  value="" class="form-control new_serial">
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
									<label>Original Condition:</label>
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
								</div>
							</div>
						</div>
							<div class="row">
								<div class="col-md-4">
								<div class="form-group">
									<label>Category</label>
									<select name="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
										<?php foreach ($categories as $key => $value) {  ?>
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
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label>Description:</label>
										<textarea name="description" class="form-control description"></textarea>
									</div>
								</div> -->
								<!-- <div class="col-md-6">
									<div class="form-group">
										<label>Recv_note:</label>
										<textarea name="recv_notes" class="form-control recv_notes"></textarea>
									</div>
								</div> -->
							</div>
						<hr>
							<div class="row">
								<div class="col-md-6">
									<div class="col-md-6">
										<div class="row">
											<div class="form-group">
												<label>Packaging:</label>
										<div class="input-group">
										<span class="input-group-addon">
										<label class="radio-inline">
											<input type="radio" value="New" name="packaging_condition" class="packaging_condition checkbx">
											New
										</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
											<input type="radio" value="Used" name="packaging_condition" class="packaging_condition checkbx">
											Used
										</label>
										</span>
									</div>
									</div>
										<div class="form-group">
										
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="candy_box" class="checkbx candy_box">
											</span>
                                            <label class="check_label">Candy Box</label>
											<!-- <input type="text" readonly="true" value="Candy Box" class="form-control">  -->
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="brown_box" class="checkbx brown_box">
											</span>
                                            <label class="check_label">Brown Box</label>
											<!-- <input type="text" readonly="true" value="Brown Box" class="form-control">  -->
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="damaged_box" class="checkbx damaged_box">
											</span>
                                            <label class="check_label">Damaged Box</label>
											<!-- <input type="text" readonly="true" value="Damaged Box" class="form-control">  -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<input type="text" name="packaging_ui" value="" class="form-control" placeholder="User Input">
									</div>
									
								</div>
									</div>
									<div class="col-md-6">
										<!-- <div class="row">
										<div class="form-group">
										<label>Accessories:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="cd_software" class="checkbx cd_software">
											</span>
                                            <label class="check_label">CD/Software</label>
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="power_cord" class="checkbx power_cord">
											</span>
                                            <label class="check_label">Power Cord</label>
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="manual" class="checkbx manual">
											</span>
                                            <label class="check_label">Manual</label>
										</div>
									</div>
								</div> -->
                                    <div class="row">
                                        <div class="form-group">
                                            <label>Additional Accessories:</label>
                                            <textarea name="additional_accessories" class="form-control additional_accessories"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label>Cleaning:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" value="1" name="cleaned" class="checkbx cleaned">
                                                </span>
                                                <!-- <input type="text" readonly="true" value="Cleaned" class="form-control">  -->
                                                <label class="check_label">Manual</label>
                                                <!-- <input type="text" readonly="true" value="Cleaned" class="form-control">  -->
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" value="1" name="taped" class="checkbx taped">
                                                </span>
                                                <label class="check_label">Taped</label>
                                                <!-- <input type="text" readonly="true" value="Taped" class="form-control">  -->
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" value="1" name="bagged" class="checkbx bagged">
                                                </span>
                                                <label class="check_label">Bagged</label>
                                                <!-- <input type="text" readonly="true" value="Bagged" class="form-control">  -->
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label>Packout Notes:</label>
										<textarea name="packout_notes" class="form-control packout_notes" placeholder="User Input"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 accessories" style="display:none;">
                                            <label>Accessories:</label>
                                        <div class="col-md-12 title-div-text">

                                        </div>
								    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" value="1" name="packout_complete" class="checkbx packout_complete">
                                                </span>
                                                <label class="check_label">Packout Complete</label>
                                                <!-- <input type="text" readonly="true" value="Packout Complete" class="form-control">  -->
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" value="1" name="send_to_finished_goods" class="checkbx send_to_finished_goods">
                                                </span>
                                                <label class="check_label">Send To Finished Goods</label>
                                                <!-- <input type="text" readonly="true" value="Send To Finished Goods" class="form-control">  -->
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
                            </div>
                            <!-- <div class="row">
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
                                </div> -->
                            <div class="col-md-12">
                                <!-- <div class="col-md-3">
                                    <input type="text" name="current_pallet" value="" class="form-control current_pallet" placeholder="Current Pallet"/>
									<input type="hidden" name="current_pallet_id" class="current_pallet_id" value="">
                                </div>     -->
                                <div class="col-md-2">
								<input type="checkbox" value="1" name="scan_loc_check" class="checkbx scan_loc_check">
                                <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
									<input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="add" value="add" class="btn bg-teal-400 add_btn">Save</button>
                                    <!-- <button type="submit" name="close" value="close" class="btn bg-danger-400 close_btn">Close/New</button> -->
                                </div>
                            </div>
						<!-- <div class="text-right">
							<button type="submit" name="save" class="btn bg-pink-400">Save</button>
						</div> -->
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- <div class=""></div> -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content -->
		<div class="modal-content">
				<div class="modal-header">
					Message
				</div>
				<div class="modal-body">
					This product cannot be scanned  as its graded as F or X.
				</div>
				<div class="modal-footer">
					<button type="button" name="close" class="btn bg-teal-400 close_grade">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModaltest" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content -->
		<div class="modal-content">
				<div class="modal-header">
					Message
				</div>
				<div class="modal-body">
					This product cannot be scanned  as its not being tested yet. You need to test it first from testing part.
				</div>
				<div class="modal-footer">
				<button type="button" name="close" class="btn bg-teal-400 close_test">Close</button>
				</div>
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

	    // $('.category3').multiselect();
	});
	
$('.close_grade').on('click', function(){
	$("input").val("");
	$("textarea").val("");
	$('.accessories').hide();
	$(".title-div-text").html('');
	$('#myModal').modal('hide');
})
$('.close_test').on('click', function(){
	$("input").val("");
	$("textarea").val("");
	$('.accessories').hide();
	$(".title-div-text").html('');
	$('#myModaltest').modal('hide');

})
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
		var new_serial = $('input.serial').val();
    	// var new_serial = $('input.new_serial').val();
		//if(part!='' && serial!=''){
		if(serial!=''){
			// var data = {part: part, serial: serial};
			var data = {serial: serial};
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
					
                    $('select.status').val('').trigger('change');
					$('.other_category').css('display','none');
				}else{
				if(response.product.cosmetic_grade == 'F' || response.product.cosmetic_grade == 'X'){
					$('#myModal').modal('show');
				}
				if(response.product.ptested == 0){
					$('#myModaltest').modal('show');
				}
				// $('input.current_pallet_id').val(response.product.plid);
				// $('input.current_pallet').val(response.product.location_pallet);
                $('input.scan_loc').val(response.product.pallet_name);
				$('input.scan_loc_id').val(response.product.plid);
				// $('input.current_pallet').val(response.product.location_name);
				$('input.product_id').val(response.product.pid);
				$('input.part').val(response.product.part);
				$('input.serial').val(response.product.serial);
				$('input.serial_id').val(response.product.id);
				$('input.new_serial').val(response.product.new_serial);
				$('input.name').val(response.product.product_name);
				$('input.packaging_ui').val(response.product.packaging_ui);
                $('input.other_status').val(response.product.other_status);
				
				//---------------
				$('textarea.description').html(response.product.product_desc);
				$('textarea.additional_accessories').html(response.product.additional_info);
				$('textarea.packout_notes').html(response.product.packaging_notes);
				$('textarea.recv_notes').html(response.product.recv_notes);
                $('select.status').val(response.product.status).trigger('change');
				//----------------
				$('.packout_complete').prop('checked', false);
				if(response.product.packout_complete==1){
					$('.packout_complete').prop('checked', true);
				}
				$('.send_to_finished_goods').prop('checked', false);
				if(response.product.send_to_finished_goods==1){
					$('.send_to_finished_goods').prop('checked', true);
				}
				
				//----------------
				$('select.original_condition').val(response.product.condition);
				
				if(response.product.packaging!=null && response.product.packaging!=''){
				var packaging_fields = JSON.parse(response.product.packaging);
				$('.candy_box').prop('checked', false);
				if(packaging_fields.candy_box==1){
					$('.candy_box').prop('checked', true);
				}
				$('.brown_box').prop('checked', false);
				if(packaging_fields.brown_box==1){
					$('.brown_box').prop('checked', true);
				}
				$('.damaged_box').prop('checked', false);
				if(packaging_fields.damaged_box==1){
					$('.damaged_box').prop('checked', true);
				}
			}
			var category = JSON.parse(response.product.category);
            console.log(category);
            if(category!=null){
       			$('select.category1').val(category[0]);
            }
            if(response.product.accessory_name!=null && response.product.accessory_name!=''){
                var accessory = JSON.parse(response.product.accessory_name);
				console.log('accessory',accessory);
				$('.checkbx').attr('checked',false);
				$('.accessories').hide();
				$(".title-div-text").html('');
                var html ='';
				if(accessory != 0 || accessory != null){
					for(i=0;i<accessory.length;i++){
						html = html + '<div class="input-group"><span class="input-group-addon"><input type="checkbox" value="'+accessory[i]+'" name="access_name[]" checked="checked" class="'+accessory[i]+' checkbx"></span><label class="check_label">'+accessory[i]+'</label></div>';
					}
					$('.accessories').show();
					$('.title-div-text').html(html);
				}
            }
				if(response.product.cleaning!=null && response.product.cleaning!=''){
				var cleaning_fields = JSON.parse(response.product.cleaning);
				$('.cleaned').prop('checked', false);
				if(cleaning_fields.cleaned==1){
					$('.cleaned').prop('checked', true);
				}
				$('.taped').prop('checked', false);
				if(cleaning_fields.taped==1){
					$('.taped').prop('checked', true);
				}
				$('.bagged').prop('checked', false);
				if(cleaning_fields.bagged==1){
					$('.bagged').prop('checked', true);
				}
			}
				$('.packaging_condition').each(function(index, el) {
					if($(this).val() == response.product.packaging_condition){
						$(this).prop('checked', true);
					}else{
						$(this).prop('checked', false);
					}
				});

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
			// }
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
