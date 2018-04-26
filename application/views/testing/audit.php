<div class="row">
	<div class="col-md-12">
		<form method="post" >
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10 ">
							<h5 class="panel-title">Audit</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
								<!-- onchange="get_product_details(this.value);" -->
								<!-- onclick="get_product_details()" -->
                                    <input type="text" value="" name="serial" class="form-control serial"  placeholder="Serial #"> 
                                </div>
                            </div>
							<div class="col-md-2">
                                    <button type="button" class="btn btn-primary category_btn" >Search</button>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
	<div class="row search_results"></div>
    <div id="notesModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product Serial Notes</h4>
                </div>
                <div class="modal-body">
                    <div class="notes_details_container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	// 	// $('input[name="part"]').focus();
	$(window).keydown(function(event){
		    if(event.keyCode == 13 || event.keyCode == 9) {
		      event.preventDefault();
		      return false;
		    }
	  	});
	});
	// function get_product_details(){
        // var part = $('input.part').val();
		// $(".serial").on('keyup', function (e) {
		// 	if(e.keyCode == 13 || e.keyCode == 9){
			$('.category_btn').on('click', function(){
    	var serial = $('input.serial').val();
		// if(part!='' || serial!=''){
		if(serial!=''){
			$.ajax({
				url: '<?php echo $ajax_url ?>',
				type: 'POST',
				dataType: 'json',
				// data: {part: part, serial: serial},
				data: {serial: serial},
			})
			.done(function(response) {
				if(response.status==1){
					$("div.search_results").html(response.html_data);
				}else{
					var p = $('input[name="part"]').val();
					$("div.search_results").html('<div class="text-center"><span>No products found!</span>');
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
    // }
	// 	});

		$(".serial").on('keyup', function (e) {
				if(e.keyCode == 13 || e.keyCode == 9){
					$('.category_btn').click()
				}
			  });
    function view_notes(serial_id){
        $.ajax({
            url: 'admin/testing/view_notes/' + serial_id,
            method: 'post',
            success: function (resp) {
                resp = JSON.parse(resp);
                if (resp.status == 1)
                {
                    $('#notesModal').find('.notes_details_container').html(resp.data);
                } else
                {
                    $('#notesModal').find('.notes_details_container').html('Not able to load data. Please try again');
                }
                $('#notesModal').modal('show');
            }
        });
    }

    
</script>
