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
		.pallet_id{ font-size: 	25px !important; }
		/*.bol{ padding: 2px; background-color: grey; color: #fff !important; }*/
</style>
<div class="row hidden-print">
	<a href="<?= $admin_prefix ?>receiving/dock_receive" class="btn btn-success">Back To Pallets</a>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="hidden-print" style="margin-bottom: 5px;">
			<div class="text-center">
				<button type="button" class="btn btn-info print_all hidden-print">Print All</button>
			</div>
		</div>
		<div class="printarea">
		
		<?php $i = 1; ?>
		<?php foreach ($print_labels as $key => $value): ?>
			<div class="print-panel hidden-print">
				<div class="row text-center barcode_labels">
					<div class="col-md-6 col-md-offset-3 block">
					<div class="row">
						<span class="bol"><b>BOL # <?php echo $value['bol_or_tracking'] ?></b></span>
					</div>
					<div class="row">
						<span><b>Pallet <?php echo $i.'/'.$value['pallet_part'] ?> - Item Count: <?php echo $value['item_count'] ?></b></span>
					</div>
					<div class="row">
						<span class="pallet_id"><b><?php echo $value['pallet_id'] ?></b></span>
					</div>
						<div class="row">
							<img style="margin-bottom: 5px;" src="<?php echo ($this->uri->segment(1) == 'admin') ? 'admin/' : ''; ?><?php echo 'barcode?barcode='.rawurlencode($value['pallet_id']).'&text='.rawurlencode($value['pallet_id']).'&scale=4.5&thickness=30' ?>"/>
						</div>
						<div class="row">
							<span><b>Ref Number: <?php echo $value['ref'] ?></b></span>
						</div>
						<div class="row"><button type="button" class="btn btn-info print_btn hidden-print">Print</button></div>
					</div>
					</div>
				
			</div>
			<hr>
		<?php $i++; endforeach ?>
		
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
