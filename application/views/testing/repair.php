<?php //echo"product"; pr($product);die;?>
<div class="row">
	<div class="col-md-12">
		<form method="post" name="edit_audit_record" action="<?php echo ($this->uri->segment(1)=='admin') ? 'admin/' : ''; ?>testing/repair" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-8">
							<h5 class="panel-title"><?= $title; ?></h5>
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
                                    <input type="text" value="" name="serial" class="form-control serial" onchange="get_product_details(this.value);" placeholder="Serial #"> 
                                </div>
                            </div>
							<div class="col-md-2">
                                    <button type="button" class="btn btn-primary category_btn" onclick="get_product_details()">Search</button>
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
                        <!-- <div class="col-md-4">
                        <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
					    <input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                        </div> -->
                        <button type="submit" name="save" value="save" class="btn bg-teal-400 add_btn">Save</button>
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
	
    function get_product_details(){
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
                    $('input.scan_loc').val(response.product.location_name);
				    $('input.scan_loc_id').val(response.product.location_id);
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
	}
</script>