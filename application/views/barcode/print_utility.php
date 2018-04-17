<!-- <div class="row">
	<div class="col-md-12">
		<div class="hidden-print" style="margin-bottom: 5px;">
			<div class="text-center">
				<button type="button" class="btn btn-info print_all hidden-print">Print</button>
			</div>
		</div>
		<div class="printarea">
		
		
		<?php
		$orig = base_url().'assets/images/barcode/'.$print_labels['hp_part'].'.png';
		$orig1 = base_url().'assets/images/barcode/'.$print_labels['internal_part'].'.png';
		// pr($print_labels);
		//foreach($print_labels as $key=>$value){  ?>
		<div class="print-sticker">
			<div class="sticker-head d-flex">
				<h2>
					<big><?= $print_labels['ink'] ?></big> 
					<small><?= $print_labels['conditions'] ?></small>
				</h2>
				<h6 class="mar-l">
					<big><?= $print_labels['type_code'] ?></big>
					<small><?= $print_labels['color'] ?></small>
					<span>03/27/2018</span>
				</h6>
			</div>
			<div class="barcode-img d-flex">
				<span><img src="<?php echo $orig; ?>"/></span>
				<h6 class="d-flex">INK</h6>
			</div>
			<div class="sticker-qty">
				<h2>QTY:200</h2>
				<h6><?= $print_labels['name'] ?></h6>
			</div>
			<div class="barcode-img">
				<span><img src="<?php echo $orig1; ?>"/></span>
			</div>
		</div>
			
		<?php //} ?> 
		
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('button.print_btn').click(function(){
			$('div.printarea div.print-panel').removeClass('hidden-print').addClass('hidden-print');
			$(this).parents('div.print-panel').removeClass('hidden-print');
			$('hr').removeClass('hidden-print').addClass('hidden-print');
			window.print();
		});
		$('button.print_all').click(function(){
			$('div.printarea div.print-panel').removeClass('hidden-print'); 
			$('hr').removeClass('hidden-print');
			window.print();
		});
	});
</script> -->
<div class="panel-body">
            <?php if(isset($file_path)){ ?>
                <div class="row">
                    <div class="col-md-12">
                        <embed src="<?php echo $file_path; ?>" type="application/pdf" width="100%" height="800px">;
                    </div>
                </div>
            <?php } ?>
        </div>
		<script type="text/javascript">
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
                    // $('.hidden_barcode_div').html(data);
                    // setTimeout(function(){
                    //     //window.print();
                    //     var mywindow = window.open('', 'PRINT', 'height=400,width=600');
                    //     // //mywindow.document.write('<h1>' + document.title  + '</h1>');
                    //     mywindow.document.write(document.getElementById('test_div').innerHTML);
                    //     mywindow.document.close();
                    //     mywindow.focus();
                    //     mywindow.print();
                    //     mywindow.close();
                    // },1000);
                }
            });
		// 	$('div.printarea div.print-panel').removeClass('hidden-print'); 
		// 	$('hr').removeClass('hidden-print');
		// 	window.print();
		});
	});
</script>
