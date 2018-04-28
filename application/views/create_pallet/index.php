<style>
    .pallet-btm {
    display: inline-block;
    width: 100%;
}
.p_selected{

background: #fff !important;
color: #26a69a !important;
border: 2px solid #26a69a;
box-shadow: none !important;
}
</style>
<div class="row">
	<div class="col-md-12">
	<!-- action="admin/barcode/print_labels_barcode" -->
	<!-- action="admin/barcode/print_pallet_labels_barcode" -->
        <form method="post" name="createpallet"  id="createpallet" action="" enctype="multipart/form-data">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="row">
                        <div class="">
                            <h5 class="panel-title"><?=$title?></h5>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="pallet-top">
                        <div class="col-md-2  form-group">
                            <button class="btn bg-teal pallet" name="pallet" value="pallet" id="pallet" type="button">Pallet</button>
                        </div>
                        <div class="col-md-2 form-group">
                            <button class="btn bg-teal cart" name="cart" value="cart" id="cart" type="button">Cart</button>
                        </div>
                        <!-- <div class="col-md-2 form-group">
                            <button class="btn bg-teal" type="submit">INK</button>
                        </div> -->
                        <div class="col-md-2 form-group">
                            <button class="btn bg-teal other" name="other" value="other" id="other" type="button">Other</button>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="pallet_type" class="form-control pallet_type">
                                    <option value="receiving">Receiving</option>
                                    <option value="testing">Testing</option>
                                    <option value="packout">Packout</option>
                                    <option value="inventory">Inventory</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pallet-btm-wrapper">
                    <div class="pallet-btm">

                        <div class="col-md-4 form-group inputs">
							<input type="text" value="" name="serial[]" id="serial" class="form-control serial  serial-new" placeholder="Serial Number#">
							<span id="serial_error" class="not_found_error" style="color:red"></span>
                            <input type="hidden" name="serial_id[]" class="serial_id" value="">
                        </div>
                        <div class="col-md-4 form-group">
                            <input type="text" value="" name="part[]" id="part" class="form-control part part-new" placeholder="Part Number#" >
                            <input type="hidden" name="product_id[]" class="product_id" value="">
                        </div>
                        <div class="col-md-2 form-group">
                            <i class="icon-plus-circle2 add_more_row"></i>
                        </div>
                    </div>
                </div>
				<div class="col-md-12">
							<div class="row">
								<div class="col-md-4 ">
									<input type="text" name="scan_loc" value="" placeholder="Scan To Location" id="scan_loc" class="form-control scan_loc" >
									<input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
								</div>
								<!-- <button type="submit" name="save" value="save" class="btn bg-teal-400 add_btn">Save</button> -->
							</div>
                    	</div>
                    <div class="col-md-4" style="margin-top: 20px;">
                        <button class="btn bg-teal print_labels"  name="print_labels" type="submit">Print Labels</button>
                        <button class="btn bg-teal print_btn"  name="print_btn" type="button">Print Contents</button>
                    </div>


                </div>
            </div>
        </form>
	</div>
</div>
<div class="more" style="display:none;">
<div class="pallet-btm" >
    <div class="col-md-4 form-group inputs">
		<input type="text" value="" name="serial[]" id="serial" class="form-control serial serial-new" placeholder="Serial Number#" >
		<span id="serial_error" class="not_found_error" style="color:red"></span>
        <input type="hidden" name="serial_id[]" class="serial_id" value="">
    </div>
    <div class="col-md-4 form-group">
        <input type="text" value="" name="part[]" id="part" class="form-control part part-new" placeholder="Part Number#" >
        <input type="hidden" name="product_id[]" class="product_id" value="">
    </div>
</div>
</div>

<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        Modal conten
     <div class="modal-content">
            <div class="modal-header">

            </div>
            <div class="modal-body">
			<input type="text" value="" name="custom_field" id="custom_field" class="form-control custom_field" placeholder="Custom Field">
                <center><button type="button" class="btn btn-info btn-lg add_now">Add </button></center>
            </div>
        </div>
    </div> -->
<!-- </div> -->
<div class="hidden_content_div" id="hidden_content_div" style="display:none"></div>
<?php //echo"in index page down";die;?>
<script type="text/javascript">
jQuery(document).ready(function() {
    var action = '';
    var counter = 1;
    var pallet_type = $('.pallet_type').val();

    $('.add_more_row').on('click',function(){
        $('.pallet-btm-wrapper').append($('.more').html());
    });

    $('.pallet').click(function(){
        action = 'pallet';
        $(this).addClass('p_selected');
        $('.cart').removeClass('p_selected');
        $('.other').removeClass('p_selected');
    });
    $('.cart').click(function(){
        action = 'cart';
        $(this).addClass('p_selected');
        $('.pallet').removeClass('p_selected');
        $('.other').removeClass('p_selected');
    });
    $('.other').click(function(){
        action = 'other';
        $(this).addClass('p_selected');
        $('.cart').removeClass('p_selected');
        $('.pallet').removeClass('p_selected');
    });
    $('.print_btn').on('click', function(){
        var serials = [];
        $('.pallet-btm-wrapper').find('.serial-new').each(function(){
            serials.push($(this).val());
        });
		var scan_loc = $('#scan_loc').val();
        console.log('val',scan_loc);

		var data = {serials: serials, pallet_type: pallet_type, scan_loc: scan_loc};
        if(action){
            data["action"] = action;
        }
		console.log('data',data)
        $.ajax({
                type: 'POST',
                url: 'admin/inventory/create_pallet/print_contents',
                async: false,
                dataType: 'JSON',
                data: data,
                success: function (data) {
                    $('.hidden_content_div').html(data);
                    var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                    mywindow.document.write(document.getElementById('hidden_content_div').innerHTML);
                    mywindow.document.close();
                    mywindow.focus();
                    mywindow.print();
                    mywindow.close();
                }
            });

    });
	$('.print_labels').click(function(){
	
		// var scan_loc = $('#scan_loc').val();
		// var pallet_type = $('.pallet_type').val();
        // // console.log('val',scan_loc);
        // if(action){
        //     var data = {action: action, pallet_type: pallet_type, scan_loc:scan_loc};
        // }else {
        //     var data = {pallet_type: pallet_type, scan_loc:scan_loc};
        // }
        var serials = [];
        $('.pallet-btm-wrapper').find('.serial-new').each(function(){
            serials.push($(this).val());
        });
		var scan_loc = $('#scan_loc').val();
        console.log('val',scan_loc);

        var pallet_type = $('.pallet_type').val();

		var data = {serials: serials, pallet_type: pallet_type, scan_loc: scan_loc};
        if(action){
            data["action"] = action;
        }
		console.log('data',data)
		$.ajax({
                type: 'POST',
                url: 'admin/inventory/create_pallet/print_labels',
                // url: 'admin/barcode/print_pallet_labels_barcode',
                async: false,
                dataType: 'JSON',
                data: data,
                success: function (data) {
		        $('#createpallet').attr('action',"admin/barcode/print_pallet_labels_barcode");
					console.log(data);
                    // return false;
                    // $('.hidden_content_div').html(data);
                    // var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                    // mywindow.document.write(document.getElementById('hidden_content_div').innerHTML);
                    // mywindow.document.close();
                    // mywindow.focus();
                    // mywindow.print();
                    // mywindow.close();
                }
            });
	})
    $(document).on('blur','.pallet-btm .serial-new',function(){
		var val = $(".serial-new").val();
		if(val.trim().length !== 0) {
			$('#serial_error').text('');
	        get_product_details($(this).val(),$(this).parents('.pallet-btm'));
		}
		else{
			$('#serial_error').html('Please Enter Serial');
			return false;
		}
    });

    function get_product_details(serial, parentObj){
        // console.log(parentObj);
        //var part = $('input.part').val();
        if(serial!=''){
            var data = {serial: serial};
            $.ajax({
                url: '<?php echo $ajax_url; ?>',
                type: 'POST',
                dataType: 'json',
                data: data,
            })
            .done(function(response) {
                if(response.status==0){
                    $( "input" ).not( ".serial" ).val('');
                }else{
                    // $('input.scan_loc').val(response.product.location_name);
                    // $('input.scan_loc_id').val(response.product.location_id);
                    parentObj.find('input.part-new').val(response.product.part);
                    parentObj.find('input.product_id').val(response.product.pid);
                    parentObj.find('input.serial_id').val(response.product.id);
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
});
</script>
