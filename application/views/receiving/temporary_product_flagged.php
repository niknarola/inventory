<div class="col-md-12">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Products</h5>
		<div class="heading-elements">
			<a href="<?php echo $admin_prefix; ?>receiving/temporary_product" class="btn bg-teal">Add Temporary Product</a>
    	</div> 
	</div>
	<div class="table-responsive">
		<form action="<?php echo $admin_prefix; ?>receiving/product_actions" method="post">
		<div class="col-md-12">
		<table class="table" id="product_tbl">
			<thead>
				<tr>
					<th>#</th>
					<th><input type="checkbox" name="check_all" class="check_all" value=""></th>
					<th>Part</th>
					<th>Name</th>
					<th>Description</th>
					<th>category</th>
					<th>Created At</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
		<div class="form-group"><button type="submit" class="btn btn-danger" name="delete_all" value="approve">Delete Selected</button>
		<button type="submit" class="btn btn-info" name="approve_all" value="approve">Approve Selected</button></div>
	</form>
	</div>
</div>
</div>
<script src="assets/js/jquery.dataTables.js?v=1"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
    // DataTable
    	table = $('#product_tbl').DataTable({
			"processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [], //Initial no order.
             //"bFilter": false,
             oLanguage: {sProcessing: "<div id='loader'><img src='assets/images/2.gif'></div>"},
	 		// Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo $ajax_url; ?>",
	            "type": "POST"
	        },
	 		//Set column definition initialisation properties.
	        "columnDefs": [
	        { 
	            "targets": [ 0,1,7,8 ], //first column / numbering column
	            "orderable": false, //set not orderable,
	        },
	        ],
		});
    $('.check_all').click(function(){
	    if($(this).is(':checked')){
	    	$('.check_product').prop('checked', true);
	    	console.log($('.check_product:checked').length);
	    }else{
	    	$('.check_product').prop('checked', false);
	    	console.log($('.check_product:checked').length);
	    }
    });
    $('form').submit(function(event) {
    	var check_len = $('.check_product:checked').length;
    	if(check_len==0){
    		alert('please check atleast 1 product');
			return false;
    	}
    	return true;
    });

});
</script>