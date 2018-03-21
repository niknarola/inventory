<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<form method="post" action="receiving/add_notes">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h5 class="panel-title">Add Notes</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<label>Part #:</label>
								<input type="text" name="part" value="" class="form-control" onchange="get_product_details(this.value);" required />
								<input type="hidden" class="product_id" name="product_id" value="" />
							</div> 
							<div class="form-group">
								<label>Serial #:</label>
								<input type="text" value="" name="serial" class="form-control serial" onchange="get_serial_details(this.value);" required /> 
								<input type="hidden" class="serial_id" name="serial_id" value="" />
							</div>
							<div class="form-group submit_div" style="display: none;">
								<label>Notes:</label>
								<textarea required="true" class="form-control notes" name="recv_notes"></textarea>
							</div>
							<div class="text-right submit_div" style="display: none;">
								<button type="submit" name="save" class="btn bg-pink-400">Save Notes</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<!-- <div class=""></div> -->
</div>
	<div class="row search_results"></div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('input[name="part"]').focus();
	});
	function get_product_details(part){
        var uri = '<?= $this->uri->segment(2);?>';
		if(part!=''){
			$.ajax({
				url: 'receiving/find_product',
				type: 'POST',
				dataType: 'json',
				data: {part: part, uri:uri},
			})
			.done(function(response) {
				console.log('response',response);
				if(response.status==1){
                    // response.product.forEach(function(prod){
					//     $("input.product_id").val(prod.id);
                    // })
                    $("input.product_id").val(response.product.id);
				}else{
					$("input.product_id").val('');
					$("div.search_results").html('<div class="text-center"><span>No such product found!</span></div>');
				}
					$("input.serial_id").val('');
					$("input.serial").val('');
					$("textarea.notes").html('');
					$('.submit_div').css('display', 'none');
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}
	}
	function get_serial_details(serial){
		if(serial!=''){
			var product_id = $('input.product_id').val();
			$.ajax({
				url: 'receiving/find_serial',
				type: 'POST',
				dataType: 'json',
				data: {serial: serial, product_id: product_id},
			})
			.done(function(response) {
				console.log('response',response);
				if(response.status==1){
					$("input.serial_id").val(response.serial.id);
					$("textarea.notes").html(response.serial.recv_notes);
					$('.submit_div').css('display', 'block');
				}else{
					$("input.serial_id").val('');
					$("textarea.notes").html('');
					$("div.search_results").html('<div class="text-center"><span>No such serial product found!</span></div>');
					$('.submit_div').css('display', 'none');
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