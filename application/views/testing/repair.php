<?php //echo"product"; pr($product);die;?>
<div class="col-md-12">
					<?php if ($this->session->flashdata('msg')) { ?>
						<div class="alert alert-success hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('msg') ?></strong>
						</div>
					<?php }  if ($this->session->flashdata('err_msg')) { ?>
						<div class="alert alert-danger hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('err_msg') ?></strong>
						</div>
            		<?php }?>
       		 	</div>
<div class="row">
	<div class="col-md-12">
		<form method="post" name="edit_audit_record" action="<?php echo ($this->uri->segment(1) == 'admin') ? 'admin/' : ''; ?>testing/repair" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-8">
							<h5 class="panel-title"><?=$title;?></h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
                <div class="row">
                <div class="row">
						<div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
									<!-- <label>Serial #:</label> -->
									<!-- onchange="get_product_details();" -->
									<input type="text" value="" name="serial" class="form-control serial"   placeholder="Serial #">
									<span id="serial_error" class="not_found_error" style="color:red"></span>
                                </div>
                            </div>
							<div class="col-md-2">
							<!-- onclick="get_product_details()" -->
                                    <button type="button" class="btn btn-primary category_btn" >Search</button>
                            </div>
						</div>
					</div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Previous Repair Notes:</label>
                            <textarea disabled="true" class="form-control prev_notes" type="text" name="prev_notes" ></textarea>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Repair Notes:</label>
                            <textarea class="form-control" type="text" name="rep_notes" ></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row ">
                            <div class="col-md-4 ">
							<input type="checkbox" value="1" name="scan_loc_check" class="checkbx scan_loc_check">
                                <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
                                <input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                            </div>
                            <button type="submit" name="save" value="save" class="save-btn btn bg-teal-400 add_btn">Save</button>
                        </div>
                    </div>
            </div>
		</form>
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
		    if(event.keyCode == 13 || event.keyCode == 9) {
		      event.preventDefault();
		      return false;
		    }
	  	});
   });
    // function get_product_details(){
		$('.category_btn').on('click', function(){
		// $(".serial").on('keyup', function (e) {
		// 	if(e.keyCode == 13 || e.keyCode == 9){
    	var serial = $('input.serial').val();
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
					$( "input" ).not( ".part, .serial, .new_serial" ).val('');
					$( "input" ).not( ".serial, .new_serial" ).val('');
					$('textarea').html('');
				}else{
                    $('input.scan_loc').val(response.product.pallet);
				    $('input.scan_loc_id').val(response.product.plid);
    				$('textarea.prev_notes').html(response.product.repair_notes);
			    }
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}
		});
		$(".serial").on('keyup', function (e) {
				if(e.keyCode == 13 || e.keyCode == 9){
					$('.category_btn').click()
				}
			  });

	 $(document).on('click','.category_btn, .save-btn', function() {
		if($(".serial").val().length !== 0) {
			$('#serial_error').text('');
			var base_url='<?php echo base_url(); ?>';
			$.ajax({
					url: base_url+'admin/testing/serial_exists',
					type: 'POST',
					dataType: 'json',
					data: {serial: $(".serial").val()}
				})
				.done(function(response) {
					console.log(response);
					if(response.serial.code==200){
					}else if(response.serial.code==400){
						$('#serial_error').html('Serial Does not exists.');
						return false;
					}
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
		}
		else{
			$('#serial_error').html('Please Enter Serial');
			return false;
		}
	});
		// 	}
		// });
	// }
</script>
