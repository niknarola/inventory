<div class="col-md-12">
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Products</h5>
		<div class="heading-elements">
			<!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
    	</div> 
	</div>
<div class="panel-body">
	
</div>
<ul class="pagination pull-right">
    <?php echo $this->pagination->create_links(); ?>
</ul>
</div>
</div>
<script src="assets/js/jquery.dataTables.js?v=1"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {	
    // DataTable
    /*table = $('#product_tbl').DataTable({
			"processing": true, //Feature control the processing indicator.
	        "serverSide": true, //Feature control DataTables' server-side processing mode.
	        "order": [], //Initial no order.
	         //"bFilter": false,
	 		// Load data for the table's content from an Ajax source
	        "ajax": {
	            "url": "<?php echo $ajax_url; ?>/ajax_list",
	            "type": "POST"
	        },
	 		//Set column definition initialisation properties.
	        "columnDefs": [
	        { 
	            "targets": [ 0,5,6 ], //first column / numbering column
	            "orderable": false, //set not orderable,
	        },
	        // { 
	        //     "targets": [ 0,1,2,3,4,5 ], //first column / numbering column
	        //     "searchable": false, //set not orderable,
	        // },
	        ],
		});
    $('input[type="search"]').on( 'keyup', function () {
    	table
    	.column( $('#search_field').val() )
        .search( this.value )
        .draw();
} );
    $('#search_field').on( 'change', function () {
    	if($('input[type="search"]').val() != ''){
    		console.log(this.value);
    table
        .column( this.value )
        .search( $('input[type="search"]').val() )
        .draw();
    }
} );*/

    $(document).on('click', '.create_location', function(event) {
    	var location = $('.location').val();
    	if(location!=''){
    		$.ajax({
    			url: '<?php echo $ajax_url; ?>/create_location',
    			type: 'POST',
    			dataType: 'json',
    			data: {location: location},
    		})
    		.done(function(response) {
    			console.log("response", response);
    				alert(response.msg);
    // 			if(response.status==1){
    // 				alert(response.msg);
    // 			}else{
    // 				alert(response.msg);
				// }
    		})
    		.fail(function() {
    			console.log("error");
    		})
    		.always(function() {
    			console.log("complete");
    		});
    	}	
    });
    $(document).on('click', '.assign_location', function(event) {
    	var location = $('.location').val();
    	var serial = $('.serial_num').val();
    	if(location!='' && serial!=''){
    		$.ajax({
    			url: '<?php echo $ajax_url; ?>/assign_location',
    			type: 'POST',
    			dataType: 'json',
    			data: {location: location, serial: serial},
    		})
    		.done(function(response) {
    			console.log("success");
    			console.log("response", response);
    				alert(response.msg);
    		})
    		.fail(function() {
    			console.log("error");
    		})
    		.always(function() {
    			console.log("complete");
    		});
    	}	
    });
     $(document).on('click', '.move_location', function(event) {
    	var location = $('.location').val();
    	var serial = $('.serial_num').val();
    	if(location!='' && serial!=''){
    		$.ajax({
    			url: '<?php echo $ajax_url; ?>/move_location',
    			type: 'POST',
    			dataType: 'json',
    			data: {location: location, serial: serial},
    		})
    		.done(function(response) {
    			console.log("success");
    			console.log("response", response);
    				alert(response.msg);
    		})
    		.fail(function() {
    			console.log("error");
    		})
    		.always(function() {
    			console.log("complete");
    		});
    	}	
    });
	});
</script>