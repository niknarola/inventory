<style>
	.row{ margin-left: 0px; margin-right: 0px; }
</style>
<div class="row">
	<div class="">
		<form method="post" action="cleaning/packout" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="">
							<h5 class="panel-title">Packout</h5>
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
											<input type="text" readonly="true" value="Candy Box" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="brown_box" class="checkbx brown_box">
											</span>
											<input type="text" readonly="true" value="Brown Box" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="damaged_box" class="checkbx damaged_box">
											</span>
											<input type="text" readonly="true" value="Damaged Box" class="form-control"> 
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
												<input type="checkbox" value="1" name="manual" class="checkbx manual">
											</span>
											<input type="text" readonly="true" value="Manual" class="form-control"> 
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<label>Additional Accessories:</label>
										<textarea name="additional_accessories" class="form-control additional_accessories"></textarea>
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
									<div class="col-md-6">
									<div class="form-group">
										<label>Cleaning:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="cleaned" class="checkbx cleaned">
											</span>
											<input type="text" readonly="true" value="Cleaned" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="taped" class="checkbx taped">
											</span>
											<input type="text" readonly="true" value="Taped" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="bagged" class="checkbx bagged">
											</span>
											<input type="text" readonly="true" value="Bagged" class="form-control"> 
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>&nbsp;</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="packout_complete" class="checkbx packout_complete">
											</span>
											<input type="text" readonly="true" value="Packout Complete" class="form-control"> 
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="send_to_finished_goods" class="checkbx send_to_finished_goods">
											</span>
											<input type="text" readonly="true" value="Send To Finished Goods" class="form-control"> 
										</div>
									</div>
								</div>
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
	    // $('.category3').multiselect();
	});
	
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
					
					$('.other_category').css('display','none');
				}else{
				$('input.product_id').val(response.product.pid);
				$('input.serial_id').val(response.product.id);
				$('input.new_serial').val(response.product.new_serial);
				$('input.name').val(response.product.product_name);
				$('input.packaging_ui').val(response.product.packaging_ui);
				
				//---------------
				$('textarea.description').html(response.product.product_desc);
				$('textarea.additional_accessories').html(response.product.additional_accessories);
				$('textarea.packaging_notes').html(response.product.packaging_notes);
				$('textarea.recv_notes').html(response.product.recv_notes);
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