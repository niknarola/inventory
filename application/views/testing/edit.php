<?php //echo"product"; pr($product);?>
<div class="row">
	<div class="col-md-12">
		<form method="post" name="edit_audit_record" action="<?php echo ($this->uri->segment(1)=='admin') ? 'admin/' : ''; ?>testing/edit_audit_record/<?php echo $product['id']; ?>" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-8">
							<h5 class="panel-title"><?= $title; ?></h5>
						</div>
					</div>
				</div>
				<div class="panel-body">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Serial Number:</label>
                            <input disabled="true" class="form-control" type="text" name="serial" value="<?= $product['serial']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>New Serial Number:</label>
                            <input class="form-control" type="text" name="new_serial" value="<?= $product['new_serial'];?>">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Part Number:</label>
                            <input disabled="true" class="form-control" type="text" name="part" value="<?= $product['part']?>">
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Received Condition:</label>
                            <select name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
                                <?php foreach ($original_condition as $key => $value) {?>
                                    <option <?php echo ($key == $product['condition']) ? 'selected' : '' ?> value="<?= $key; ?>"><?= $value; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Grade:</label>
                            <select name="grade" data-placeholder="Select Grade" class="form-control select grade">
                                <?php //foreach ($original_condition as $key => $value) { ?>
                                    <option value="MN">MN - Manufacturer New</option>
                                    <option value="TN">TN - Tested New</option>
                                    <option value="B">B - Light Scratches</option>
                                    <option value="C">C - Deep Scratches</option>
                                    <option value="F">F - Fail</option>
                                    <option value="X">X - Unsellable</option>
                                <?php //}  ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Final Condition:</label>
                            <select name="final_condition" data-placeholder="Select Final Condition" class="form-control select original_condition">
                                <?php foreach ($original_condition as $key => $value) { ?>
                                    
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Item Location:</label>
                            <input class="form-control" type="text" name="location" value="<?= $product['pallet']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Physical Location:</label>            
                            <input class="form-control" type="text" name="physical_location" value="<?= $product['locationname']?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Comment:</label>
                            <?php if ($product['comments']!='' || $product['comments']!=null){?>            
                            <textarea name="comment"class="form-control"><?= $product['comments']?></textarea>
                            <?php }else{?>
                                <textarea name="comment"class="form-control"></textarea>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="save" value="save" class="btn bg-teal-400 add_btn">Save</button>
                        <button  onclick="delete_serial(<?= $product['sid']?>, event)" name="delete" value="delete" class="btn bg-danger-400 close_btn">Remove Unit</button>
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
	    var cat_raw = '<?php echo $product['category']; ?>';
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

	});
	function get_sub_categories(cat_id, elem, category=null){
		console.log('change');
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
    function multiselect_selected($el, values) {
    	$el.val(values);
    }
    $('.approve_btn').on('click',function() {
        $("input[name='status']").val('1');
        $("[name='temp_prod_edit']").submit();
    });

    function delete_serial(serial_id, event) {
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Product!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plz!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var serial_id = '<?php echo $product['sid']?>';
                        $.ajax({
                            method: "POST",
                            url: "<?php echo base_url(); ?>admin/testing/delete/" + serial_id,
                            success: function (resp) {

                                console.log(resp);
                                resp = JSON.parse(resp);
                                if (resp.status == '1')
                                {

                                    swal("Deleted", resp.message, "success");
                                    setTimeout(function () {
                                        window.location.href = window.location.href;
                                    }, 1000);
                                } else if (resp.status == '0')
                                {
                                    swal("Error", "Invalid request", "error");
                                }
                            }
                        })

                    } else {
                        swal("Cancelled", "Your Product is safe :)", "error");
                    }
                });
    }
</script>