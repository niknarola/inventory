<?php $products = ($this->session->userdata('products')) ? $this->session->userdata('products') : []; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Quick Receive</h5>
    </div>
	<form method="post">
		<div class="panel-body">
			<div class="row">
			<div class="col-md-12" style="border-right: 1px solid #eee;">
				<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<?php
						$pallet_id = '';
						 if(!empty($products)){
							$first = reset($products);
							$pallet_id = $first['pallet_id'];
						} ?>
						<label>Pallet: </label>
						<select name="pallet_id" class="form-control pallet_id">
							<?php foreach ($pallets as $key => $value): ?>
							<option <?php echo ($pallet_id!='' && $pallet_id == $key) ? 'selected' : ''  ?> value="<?= $key; ?>"><?= $value; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<hr>
				<div class="pallet_div">
					<?php for ($i=0; $i < 10; $i++) { ?>
						<div class="row receive_div" data-row="<?= $i; ?>">
							<div class="col-md-2">
								<div class="form-group">
									<label>Serial Number</label>
									<input type="text" class="form-control serial" name="serial[]" value="" placeholder="Serial #">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Part Number</label>
									<input type="text" class="form-control part" name="part[]" value="" placeholder="Part #" onchange="get_product_details(<?=$i?>);">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Category</label>
									<select name="category1[]" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2_<?= $i ?>')">
										<?php foreach ($categories as $key => $value) { ?>
											<option value="<?= $key ?>"><?= $value ?></option>
										<?php } ?>
									</select>
								</div>
								</div>
								<div class="col-md-2 category_dropdn">
								<div class="form-group">
									<label>Sub Category</label><br>
									<select name="category2[]" disabled="true" class="category2 form-control">
									</select>
								</div>
								</div>
								
							<div class="col-md-2">
								<div class="form-group">
									<label>Condition</label>
									<select name="condition[]" data-placeholder="Select Condition" class="form-control select condition">
										<?php foreach ($condition as $key => $value) { ?>
											<option value="<?= $key; ?>"><?= $value; ?></option>
										<?php }  ?>
									</select>
									<!-- <label>Inspection Notes</label>
									<input type="text" class="form-control" name="notes[]" value="" placeholder="Notes"> -->
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Description</label>
									<input type="text" class="form-control description" name="description[]" value="" placeholder="Description"> 
								</div>
							</div>
						</div>
						<hr>
					<?php } ?>
				</div>
				<div class="pallet_actions">
					<button type="submit" name="print_labels" value="print_labels" class="btn btn-sm btn-primary print_labels">Print Labels</button>   
	                <!-- <button type="submit" name="view_edit" value="view_edit" class="btn btn-sm btn-primary view_edit">View/Edit</button>  -->
	                <button type="submit" name="remove" value="remove" class="btn btn-sm btn-primary remove">Remove</button> 
	                <button type="submit" name="complete" value="complete" class="btn btn-sm btn-primary complete">Complete</button>
	                <button type="submit" name="accept" value="accept" class="btn btn-sm btn-primary accept">Accept</button>
	            </div>
			</div>
		</div>
			<hr>
			<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="table-responsive">
						<div class="pallet-list" id="palletList">
						<table class="table">
							<thead>
								<tr>
									<th><input type="checkbox" name="check_all" class="check_all" value=""></th>
									<th>Serial #</th>
									<th>Part #</th>
									<th>Category</th>
									<th>Condition</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>
								
								<?php if(!empty($products)){ foreach ($products as $product) { ?>
								<tr>
									<td><input type="checkbox" name="check[]" class="check_row" value="<?= $product['id'] ?>"></td>
									<td><?= $product['serial']; ?></td>
									<td><?= $product['part']; ?></td>
									<!-- <td><?php //echo $product['inspection_notes']; ?> </td> -->
									<td><?= get_category_name($product['category']); ?> </td>
									<td><?= $product['condition_name']; ?> </td>
									<td><?= $product['description']; ?> </td>
								</tr>
								<?php }
							}else{ ?>
								<tr><td colspan="3">Product(s) not found......</td></tr>
								<?php } ?>
							</tbody>
						</table>
						
					</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</form>
</div>
<div id="notes_modal" class="modal fade" role="dialog">
 	<div class="modal-dialog">
	    <!-- Modal content-->
	    <form method="post" action="<?= $ajax_url; ?>add_inspection_notes">
		    <div class="modal-content">
		      	<div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Add Inspection Notes</h4>
		      	</div>
		    	<div class="modal-body">
			      	<input type="hidden" class="modal_pallet_id" name="pallet_id" value="">
					<textarea name="inspection_notes" class="form-control" placeholder="Add Notes here.."></textarea>
			    </div>
			    <div class="modal-footer">
			        <button type="submit" name="save_note" class="btn bg-pink-400 save_note">Save</button>
			    </div>
		    </div>
		</form>
	</div>
</div>
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.check_all', function(event) {
	        if($(this).is(':checked')){
	            $('.check_row').prop('checked', true);
	        }else{
	            $('.check_row').prop('checked', false);
	        }
	    });	
	    get_sub_categories(1, 'category2');
	});
	function get_sub_categories(cat_id, elem_row, category=null){
		if(cat_id!=''){
			var elem = elem_row;
			var row = '';
			if (elem_row.indexOf('_') > -1){
				var split_elem = elem_row.split("_");
				 elem = split_elem[0];
				 row = split_elem[1];
			}
			if(row!=''){
				var cat2_name = $('div[data-row="'+row+'"]').find('.category2 option[value="'+cat_id+'"]').text();
			}else{
				var cat2_name = $('.category2 option[value="'+cat_id+'"]').text();
			}
			if(cat2_name=='Other'){
				if(row!=''){
					$('div[data-row="'+row+'"]').find('.other_category').css('display','block');
					if(category!=null && category.length > 2)
						$('div[data-row="'+row+'"]').find('.other_category').val(category[2]);
			}else{
				$('.other_category').css('display','block');
					if(category!=null && category.length > 2)
						$('.other_category').val(category[2]);
			}
			}else{
				if(row!=''){
					$('div[data-row="'+row+'"]').find('.other_category').css('display','none');
				}else{
					$('.other_category').css('display','none');
				}
				$.ajax({
	    			url: '<?php echo $cat_url; ?>',
	    			type: 'POST',
	    			dataType: 'json',
	    			data: {category_id: cat_id},
	    		})
	    		.done(function(response) {
	    			if(response.result==1){
	    				if(row!=''){
			    			$('div[data-row="'+row+'"]').find('.'+elem).html(response.html_text);
							$('div[data-row="'+row+'"]').find('.'+elem).removeAttr('disabled');
						}else{
							$('.'+elem).html(response.html_text);
							$('.'+elem).removeAttr('disabled');
						}
	    			}else{
		    			if(row!=''){ $('div[data-row="'+row+'"]').find('.'+elem).html('').attr('disabled', true); }
		    			else{ $('.'+elem).html('').attr('disabled', true); }
		    		}
		    		if(elem=='category2'){
		    			if(category!=null && category.length > 1){
		    				if(row!='')
								multiselect_selected($('div[data-row="'+row+'"]').find('.category2'), category[1]);
							else
								multiselect_selected($('.category2'), category[1]);
						}
						if(row!='')
							$('div[data-row="'+row+'"]').find('.category3').html('').attr('disabled', true);
						else
							$('.category3').html('').attr('disabled', true);
					}
					if(elem=='category3'){
		    			if(category!=null && category.length > 2){
		    				if(row!='')
								multiselect_selected($('div[data-row="'+row+'"]').find('.category3'), category[2]);
							else
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
     function get_product_details(row){
     	console.log('row',row);
  		var part = $('.receive_div[data-row="'+row+'"]').find('input.part').val();
    	var serial = $('.receive_div[data-row="'+row+'"]').find('input.serial').val();
    	//var new_serial = $('input.new_serial').val();
		if(part!='' && serial!=''){
			var data = {part: part};
			$.ajax({
				url: '<?php echo $ajax_url; ?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(response) {
				if(response.status==0){
					$('div[data-row="'+row+'"]').find( "input" ).not( ".part, .serial" ).val('');
					get_sub_categories(1, 'category2_'+row);
					$('div[data-row="'+row+'"]').find('.other_category').css('display','none');
				}else{
				$('div[data-row="'+row+'"]').find('input.product_id').val(response.product.pid);
				$('div[data-row="'+row+'"]').find('input.serial_id').val(response.product.id);
				$('div[data-row="'+row+'"]').find('input.description').val(response.product.product_desc);
			
				//----------------
				if(response.product.condition==null || response.product.condition=='')
					$('div[data-row="'+row+'"]').find('select.condition').val(response.product.original_condition_id);
				else
					$('div[data-row="'+row+'"]').find('select.condition').val(response.product.condition);

				var cat_raw = response.product.category;
			    var category = (cat_raw!='') ? JSON.parse(cat_raw) : '';
			    cat = (category!='') ? category[0] : 1;
				get_sub_categories(cat,'category2_'+row, category);
				if(category.length == 1){
					// $('.category2').multiselect();
					// $('.category3').multiselect();
				}
				if(category.length > 2){
					get_sub_categories(category[1],'category3_'+row, category);
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
	function multiselect_selected($el, values) {
    	$el.val(values);
    }
</script>
