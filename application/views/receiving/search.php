<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<!-- <form method="post" action="receiving/search_results"> -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<h5 class="panel-title">Search Product</h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="form-group">
								<label>Part #:</label>
								<input type="text" name="part" value="" class="form-control" onchange="get_product_details(this.value);">
							</div> 
							<!-- <div class="form-group">
								<label>Serial #:</label>
								<input type="text" value="" name="serial" class="form-control"> 
							</div> -->
							<div class="text-right">
								<!-- <button type="submit" name="search" class="btn bg-pink-400">Search</button> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- </form> -->
	</div>
	<!-- <div class=""></div> -->
</div>
	<div class="row search_results"></div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('input[name="part"]').focus();
	});
	function get_product_details(part){
		if(part!=''){
			$.ajax({
				url: '<?php echo $ajax_url ?>find_product',
				type: 'POST',
				dataType: 'json',
				data: {part: part},
			})
			.done(function(response) {
				if(response.status==1){
					$("div.search_results").html(response.html_data);
				}else{
					var p = $('input[name="part"]').val();
					$("div.search_results").html('<div class="text-center"><span>No products found!</span><br/><a href="receiving/temporary_product?part='+p+'" class="btn btn-primary">Create Temporary Product</a></div>');
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