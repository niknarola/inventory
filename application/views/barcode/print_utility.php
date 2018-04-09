<style>
	body { line-height: 1; }
	.barcode_labels span {font-size: 18px; color: #000;}
	.barcode_labels .row{ margin-bottom: 5px; }
	@page{ 	/*size: auto;*/   /* auto is the initial value */ 
    		margin: 1mm 0mm 0mm 0mm;  /* this affects the margin in the printer settings */ 
    		/*margin: 5mm 1mm 0mm 1mm;*/  /* this affects the margin in the printer settings */ 
    		/*transform: scale(.30);*/
		}
		/*.block { border: 1px solid #ddd; padding: 2px; }*/
	/*.pallet_id{ font-size: 	25px !important; }*/
		/*.bol{ padding: 2px; background-color: grey; color: #fff !important; }*/
</style>
<!-- <div class="row hidden-print">
	<a href="<?= $admin_prefix ?>receiving/print_labels" class="btn btn-success">Back</a>
</div> -->
<div class="row">
	<div class="col-md-12">
		<div class="hidden-print" style="margin-bottom: 5px;">
			<div class="text-center">
				<button type="button" class="btn btn-info print_all hidden-print">Print All</button>
			</div>
		</div>
		<div class="printarea">
		
		
		<?php
		// pr($print_labels);
		//foreach($print_labels as $key=>$value){  ?>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
						<?= $print_labels['ink'] ?>
						<?= $print_labels['conditions'] ?>
					</div>
					<div class="col-md-6">
						<?= $print_labels['type'] ?>
						<?= $print_labels['color'] ?>
					</div>
				</div>
    		</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
					<!-- barcode -->
						<?= $print_labels['hp_part'] ?>
						<!-- INK exact opposite side -->
						<?= $print_labels['conditions'] ?>
					</div>
				</div>
    		</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
					QTY: 200
					</div>
				</div>
    		</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
					<?= $print_labels['name'] ?>
					</div>
				</div>
    		</div>
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
					<?= $print_labels['internal_part'] ?>
					</div>
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
</script>
