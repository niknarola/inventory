<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Print labels for Pallets and Locations</h5>
    </div>
    <div class="panel-body">
        <form method="post" action="<?php echo $admin_prefix ?>barcode/print_labels_barcode">
        	<div class="pallet_div">
        		<div class="row receive_div" data-row="1">
        	<div class="col-md-2">
                                    <div class="form-group">
                                        <label>Pallet ID</label>
                                        <input required="true" type="text" class="form-control pallet_id" name="pallet_id[]" value="" placeholder="Pallet ID #">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control part" name="location[]" value="" placeholder="Location">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Custom Field</label>
                                        <input type="text" class="form-control custom" name="custom[]" value="" placeholder="Custom Field">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <a name="add_more" value="add_more" class="btn btn-sm btn-success add_more">Add More</a>   
                                <button name="print" value="print" class="btn btn-sm btn-info print">Print Labels</a>   
                            </div>
                        </div>
        </form>
    </div>
</div>
 <div class="new-pallet-div" id="new-pallet-div" style="display:none;">
 	<div class="row receive_div" data-row="1">
        	<div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control pallet_id" required="true" name="pallet_id[]" value="" placeholder="Pallet ID #">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control part" name="location[]" value="" placeholder="Location">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control custom" name="custom[]" value="" placeholder="Custom Field">
                </div>
            </div>
        </div>
 </div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.add_more').on('click',function(){
	        $('.pallet_div').append($('.new-pallet-div').html());
	        $(".pallet_div").find('.receive_div').last().attr("data-row",$(".pallet_div").find('.receive_div').length);
	    });
	});
</script>
