<form method="post" action="<?php echo ($this->uri->segment(1)=='admin') ? 'admin/' : ''; ?>barcode/generate">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<h5 class="panel-title col-md-4">Generate Barcodes</h5>
						<div class="form-group col-md-4 pull-right field_div">
							<label class="col-md-5 text-right">Lock Fields:</label>
							<div class="multi-select-full col-md-7">
								<select name="lock_labels[]" class="multiselect-select-all lock_fields" multiple="multiple">
									<option value="serial">serial</option>
									<option value="part">part</option>
									<option value="name">name</option>
									<option value="condition_select">condition</option>
									<option value="custom_input">Custom Condition</option>
									<option value="comment">comment</option>
									<option value="description">description</option>
									<option value="categories">categories</option>
									<option value="product_line">product_line</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-4 pull-right field_div">
						<label class="col-md-5 text-right">Print Fields:</label>
						<div class="multi-select-full col-md-7">
							<select name="print_labels[]" class="multiselect-select-all print_labels" multiple="multiple">
								<option value="serial">serial</option>
								<option value="part">part</option>
								<option value="name">name</option>
								<option value="condition">condition</option>
								<option value="comment">comment</option>
								<option value="description">description</option>
								<option value="categories">categories</option>
								<option value="product_line">product_line</option>
							</select>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group text-center">
				<button type="button" data-toggle="modal" data-target="#myModal" name="generate" class="btn btn-success generate">Generate</button>
				<button type="button" name="add_more" class="btn bg-pink-400 add_more_btn"><i class="icon-plus22"></i>Add more</button>
				<button type="button" name="print_internal_labels" class="btn bg-blue-400 print_internal_labels">Print Internal Label</button>
				<button type="button" name="print_finished_goods_labels" class="btn bg-orange-400 print_finished_goods_labels">Print Finished Goods Label</button>
				<button type="button" name="print_custom_labels" class="btn bg-teal-400 print_custom_labels">Print Custom Label</button>
			</div>
			<?php //for ($i=0; $i < 5; $i++) { ?>
				<div class="panel panel-flat info_block">
					<!-- <a href="#" class="close-thik"></a> -->
					<span class="close_block" style="display: none;"><i class="icon-cross2"></i></span>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Serial #:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" data-field="serial" name="serial_chk[]" class="serial_chk checkbx">
										</span>
										<input type="text" name="serial[]" value="" class="form-control serial">
									</div>
								</div> 
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Part #:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" data-field="part" name="part_chk[]" class="part_chk checkbx">
										</span>
										<input type="text" value="" name="part[]" class="form-control part" required> 
									</div>
								</div>
							</div>
							<div class="col-md-4 condition_div">
								<div class="form-group">
									<label>Condition:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="condition_chk[]" data-field="condition" class="condition_chk checkbx">
										</span>
										<select class="form-control condition_select condition" name="condition[]">
											<option value="New">New</option>
											<option value="New Open Box">New Open Box</option>
											<option value="Refurbished">Refurbished</option>
											<option value="Unknown">Unknown</option>
											<option value="Custom">Custom</option>
										</select>
									</div>
								</div>
								<div class="form-group custom_input" style="display: none;">
									<label>Custom Condition:</label>
									<div class="input-group">
										<!-- <span class="input-group-addon">
											<input type="checkbox">
										</span> -->
										<input type="text" value="" name="custom_condition[]" class="custom_input form-control"> 
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Name:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="name_chk[]" data-field="name" class="name_chk checkbx">
										</span>
										<input type="text" value="" name="name[]" class="form-control name">
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Line:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="product_line_chk[]" data-field="product_line" class="product_line_chk checkbx">
										</span>
										<select name="product_line[]" class="form-control product_line">
											<?php foreach ($product_line as $key => $value) { ?>
												<option value="<?= $key; ?>"><?= $value; ?></option>
											<?php }  ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Categories:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="categories_chk[]" data-field="categories" class="categories_chk checkbx">
										</span>
										<input type="text" value="" name="categories[]" class="form-control categories"> 
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Comment:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="comment_chk[]" data-field="comment" class="comment_chk checkbx">
										</span>
										<input type="text" value="" name="comment[]" class="form-control comment"> 
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Description:</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="0" name="description_chk[]" data-field="description" class="description_chk checkbx">
										</span>
										<input type="text" value="" name="description[]" class="form-control description"> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php //} ?>	
	</div>
		<!-- <div class=""></div> -->
</div>
<div id="myModal" class="modal fade" role="dialog">
 	<div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Action To Perform</h4>
	      	</div>
	    	<div class="modal-body">
		      	<input type="hidden" name="product_id" value="">
		        <button type="submit" name="add_item_to_inventory" class="btn btn-info add_item_to_inventory">Add Item to Inventory</button>
		        <button type="submit" name="print_label_only" class="btn bg-pink-400 print_label_only">Print Label Only</button>
		        <div class="cat_section" style="display: none;">
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
								<select name="category3"  disabled="true" class="category3 form-control">
								</select>
							</div>
						</div>
					</div>
		    	</div>
		    </div>
	    </div>
	</div>
</div>
</form>
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_select.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.bootstrap-select').selectpicker();
		$('.print_labels').multiselect();
		$('.category_select').multiselect();
		$('.lock_fields').multiselect({
			onChange:function(element, checked){
				var selected = $(element).val();
				console.log('selected',selected);
				if(selected == 'condition_select'){
					if($( ".info_block" ).first().find('.condition_select').val()=='Custom'){
						var custom_input = $( ".info_block" ).first().find('input.custom_input').val();
						$( ".info_block .condition_select").val($( ".info_block" ).first().find('.condition_select').val());
						$( ".info_block" ).first().find("input.custom_input").val(custom_input);			
					}else{
						$( ".info_block .condition_select").val($( ".info_block" ).first().find('.condition_select').val());
					}
				}else{
					var txtval = $( ".info_block" ).first().find('input.'+selected).val();
					console.log('txtval',txtval);
					$(".info_block input."+selected).val(txtval);		
				}
			}
		});
    	$('.print_internal_labels').click(function(e){
    		e.preventDefault();
    		$('.checkbx').prop('checked', true);
    		multiselect_selectAll($('.print_labels'));
    	});
    	$('.print_internal_labels').click();
		$('.print_finished_goods_labels').click(function(e){
    		e.preventDefault();
    		$('.checkbx').prop('checked', false);
    		deselect_all($('.print_labels'));
    		select_finished_goods_labels($('.print_labels'));
    	});
    	$('.print_custom_labels').click(function(e){
    		e.preventDefault();
    		$('.checkbx').prop('checked', false);
    		var sel = $('.print_labels').val();
    		$.each(sel, function(index, val) {
    			$('.'+val+'_chk').prop('checked', true);
    		});
    	});
    	$(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
		$('.add_more_btn').click(function(){
			$( ".info_block" ).first().clone().appendTo( "form" );
			var len = $(".info_block").length;
			$(".info_block").last().find('input[type="text"]').val('');
			$(".info_block").last().find('input.checkbx').val(len-1);
			// $( ".info_block" ).last().find('.condition_select').val($( ".info_block" ).first().find('.condition_select').val());
			$(".info_block").last().find('.close_block').css('display', 'inline-block');
		})
		$( "form" ).on('click', '.close_block', function(event) {
			$(this).parent().remove();
		});
		get_sub_categories(1,'category2');
		// $('.category2').multiselect();
		// $('.category3').multiselect();
		$( ".info_block" ).first().find('.checkbx').click(function(){
			var field = $(this).attr('data-field')
			if($(this).is(':checked')){
				$('.'+field+'_chk').prop('checked', true);
			}else{
				$('.'+field+'_chk').prop('checked', false);
			}
		});
		$( "form" ).on('change', '.condition_select', function(event) {
			if($(this).val() == 'Custom'){
				$(this).parents('.condition_div').find('.custom_input').css('display','inline-block');
				$(this).parents('.condition_div').find('.form-group').addClass('col-md-6');
			}else{
				$(this).parents('.condition_div').find('.form-group').removeClass('col-md-6');
				$(this).parents('.condition_div').find('.custom_input').removeClass('col-md-6').css('display','none');
			}
		});
	});
	function multiselect_selectAll($el) {
        $('option', $el).each(function(element) {
        	$el.multiselect('select', $(this).val());
        });
    }
    function deselect_all($el){
    	$('option', $el).each(function(element) {
    		$el.multiselect('deselect', $(this).val());
    	});
    }
    function select_finished_goods_labels($el) {
        $('option', $el).each(function(element) {
			var arr = [ "serial", "part", "name", "condition" ];
			if($.inArray( $(this).val(), arr )> -1){
				$('.'+$(this).val()+'_chk').prop('checked', true);
        		$el.multiselect('select', $(this).val());
			}
        });
    }
    $( ".info_block" ).first().find('input.part').change(function(){
    	get_product_details($(this).val());
    });
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
    function get_product_details(part){
        var uri = '<?= $this->uri->segment(2);?>';
		if(part!=''){
			$.ajax({
				url: '<?php echo $ajax_url; ?>',
				type: 'POST',
				dataType: 'json',
				data: {part: part, uri: uri},
			})
			.done(function(response) {
				if(response.status==1){
					$( ".info_block" ).first().find('input.name').val(response.product.name);
					$( ".info_block" ).first().find('input.description').val(response.product.description);
					$( ".info_block" ).first().find('select.product_line').val(response.product.product_line_id);
					$( ".info_block" ).first().find('input.categories').val(response.product.category_names);
					$( 'input[name="product_id"]' ).val(response.product.id);
					$( '.cat_section' ).css('display','none');
				}else{
					$( ".info_block" ).first().find('input.name').val('');
					$( ".info_block" ).first().find('input.description').val('');
					// $( ".info_block" ).first().find('select.product_line').val('');
					$( ".info_block" ).first().find('input.categories').val('');
					$( 'input[name="product_id"]' ).val('');
					$( '.cat_section' ).css('display','block');
				}
				/*if(response.status==1){
					$("div.search_results").html(response.html_data);
				}else{
					$("div.search_results").html('<div class="text-center"><span>No products found!</span><br/><a href="receiving/temporary_product" class="btn btn-primary">Create Temporary Product</a></div>');
				}*/
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