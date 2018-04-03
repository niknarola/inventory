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
		<div class="hidden-print" style="margin-bottom: 5px;">
			<div class="text-center">
				<button type="button" class="btn btn-info print_all hidden-print">Print All</button>
			</div>
		</div>
		<div class="printarea">
		<?php 
			$name_chk = (!empty($name_chk)) ? $name_chk : []; 
			$serial_chk = (!empty($serial_chk)) ? $serial_chk : []; 
			$part_chk = (!empty($part_chk)) ? $part_chk : []; 
			$condition_chk = (!empty($condition_chk)) ? $condition_chk : []; 
			$product_line_chk = (!empty($product_line_chk)) ? $product_line_chk : []; 
			$categories_chk = (!empty($categories_chk)) ? $categories_chk : []; 
			$description_chk = (!empty($description_chk)) ? $description_chk : []; 
			$comment_chk = (!empty($comment_chk)) ? $comment_chk : []; 
		?>
		<?php $cnt = sizeof($serial); ?>
		<?php for ($i=0; $i < $cnt; $i++) { ?>
			<!-- <div class="panel panel-flat" style="width: 50%;float: left;padding-left: 10px;padding-right: 10px;"> -->
			<div class="print-panel hidden-print">
				<div class="">
					<div class="row text-center barcode_labels">			 
						<?php //if(in_array('serial', $print_labels)){ ?>
							<?php if(in_array($i, $serial_chk) && $serial[$i]!=''){ ?>
								<div class="row">
									<img style="margin-bottom: 5px;" src="<?php echo ($this->uri->segment(1) == 'admin') ? 'admin/' : ''; ?><?php echo 'barcode?barcode='.rawurlencode($serial[$i]).'&text='.rawurlencode("Serial Number: ".$serial[$i]).'&scale=2.4&thickness=25' ?>"/>
								</div>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('part', $print_labels)){ ?>
							<?php if(in_array($i, $part_chk) && $part[$i]!=''){ ?>
								<div class="row">
									<img style="margin-bottom: 2px;" src="<?php echo ($this->uri->segment(1) == 'admin') ? 'admin/' : ''; ?><?php echo 'barcode?barcode='.rawurlencode($part[$i]).'&text='.rawurlencode("Part Number: ".$part[$i]).'&scale=2.4&thickness=25' ?>"/>
								</div>
							<?php } ?>
						<?php //} ?>
						<?php // if(in_array('name', $print_labels)){ ?>
							<?php if(in_array($i, $name_chk)){ ?>
							<div class="row">
								<span class="name"><b><?php echo $name[$i] ?></b></span>
							</div>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('condition', $print_labels)){ ?>
							<?php if(in_array($i, $condition_chk) && $condition[$i]!=''){ ?>
								<?php if($condition[$i] == 'Custom'){  ?>
							<div class="row"><span class="condition"><?php echo $custom_condition[$i] ?></span></div>
								<?php }else{ ?>
									<div class="row"><span class="condition"><?php echo $condition[$i] ?></span></div>
								<?php } ?>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('product_line', $print_labels)){ ?>
							<?php if(in_array($i, $product_line_chk) && $product_line[$i]!= ''){ ?>
								<div class="row"><span class="product_line">Product Line - <?php echo $product_line_names[$product_line[$i]] ?></span></div>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('categories', $print_labels)){ ?>
							<?php if(in_array($i, $categories_chk) && $categories[$i]!=''){ ?>
								<div class="row"><span class="category">Category - <?php echo $categories[$i] ?></span></div>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('comment', $print_labels)){ ?>
							<?php if(in_array($i, $comment_chk) && $comment[$i]!=''){ ?>
								<div class="row"><span>Comment - <?php echo $comment[$i] ?></span></div>
							<?php } ?>
						<?php //} ?>
						<?php //if(in_array('description', $print_labels)){ ?>
							<?php if(in_array($i, $description_chk) && $description[$i]!=''){ ?>
								<div class="row"><span>Description - <?php echo $description[$i] ?></span></div>
							<?php } ?> 
						<?php //} ?> 
					</div>
				</div>
				<div class="row"><button type="button" class="btn btn-info print_btn hidden-print">Print</button></div>
			</div>
			<hr>
		<?php } ?>
		</div>
	</div>
</div>
<style>
	.row.text-center.barcode_labels {
		height: 2.4in;
		width: 2.4in;
		text-align: center;
		margin: 0 auto;
	}
	.row.text-center.barcode_labels img{width:90%;}
	button.btn.btn-info.print_btn.hidden-print {
    margin: 0 auto;
    display: block;
}
</style>
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
