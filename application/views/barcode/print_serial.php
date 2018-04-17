<div class="panel-body">
            <?php if(isset($file_path)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <embed src="<?php echo $file_path; ?>" type="application/pdf" width="100%" height="800px">;
                    </div>
                </div>
            <?php } ?>
        </div>
		<!-- <script type="text/javascript">
	jQuery(document).ready(function($) {
		$('button.print_btn').click(function(){
			$('div.printarea div.print-panel').removeClass('hidden-print').addClass('hidden-print');
			$(this).parents('div.print-panel').removeClass('hidden-print');
			$('hr').removeClass('hidden-print').addClass('hidden-print');
			// window.print();
		});
		$('button.search_barcode').click(function(){
            var barcode = $('.barcode').val();
            $.ajax({
                type: 'POST',
                url: 'admin/barcode/print_utility',
                async: false,
                dataType: 'JSON',
                success: function (response) {
                    console.log(response);
                }
            });
		});
	});
</script> -->
