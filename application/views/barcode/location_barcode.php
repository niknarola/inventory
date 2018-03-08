<style>
	body { line-height: 1; }
	.barcode_labels span {font-size: 11px; color: #000;}
	span.condition, span.product_line, span.category {font-size: 13px; color: #000;}
	.barcode_labels span.name {font-size: 15px;}
	@page{ 	/*size: auto;*/   /* auto is the initial value */ 
    		margin: 1mm 0mm 0mm 0mm;  /* this affects the margin in the printer settings */ 
    		/*margin: 5mm 1mm 0mm 1mm;*/  /* this affects the margin in the printer settings */ 
    		/*transform: scale(.30);*/
		}
</style>
<div class="row">
	<div class="col-md-12">
		
		<div class="printarea">
		
			<!-- <div class="panel panel-flat" style="width: 50%;float: left;padding-left: 10px;padding-right: 10px;"> -->
			<div class="print-panel hidden-print">
				<div class="">
					<div class="row text-center barcode_labels">	
						<div class="row">
							<img style="margin-bottom: 5px;" src="<?php echo ($this->uri->segment(1) == 'admin') ? 'admin/' : ''; ?><?php echo 'barcode?barcode='.rawurlencode($location).'&text='.rawurlencode($location).'&scale=2.4&thickness=25' ?>"/>
						</div>	
						<!-- <div class="row">
							<span class="product_line"><?php //echo $location ?></span>
						</div> -->	 
						
						<div class="row"><button type="button" class="btn btn-info print_btn hidden-print">Print</button></div>
					</div>
				</div>
			</div>
			<hr>
		
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
</script>
