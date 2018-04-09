<form method="post"  enctype="multipart/form-data" id="utility" name="utility">
<!-- action="admin/create_pallet/printed_contents" -->
	<div class="panel panel-flat">
		<div class="panel-heading">
			<div class="row">
				<div class="">
					<h5 class="panel-title">Utility Module</h5>
				</div>
			</div>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="text-semibold">Browse INK Sheet:</label>
						<input type="file" class="form-control" name="excel" value="" placeholder="">
					</div>
					<div class="upload_button">
						<button type="submit" value="upload" name="upload_sheet" class="btn btn-default">Upload</button>
					</div>
					<!-- <div class="col-md-6 text-center">
						<div class="inline_search_button">
							<button class="btn btn-default">button</button>
						</div>
					</div> -->
				</div>
				<div class="col-md-3 form-group">
					<input type="text" value="" onchange="get_product_details()" name="internal_part" class="form-control internal_part" placeholder="Internal P/N">
					<input class="form-control internal_part1" type="hidden" value="" name="internal_part1">
					<input class="form-control hp_part" type="hidden" value="" name="hp_part">
					<input class="form-control name" type="hidden" value="" name="name">
					<input class="form-control ink" type="hidden" value="" name="ink">
					<input class="form-control type" type="hidden" value="" name="type">
					<input class="form-control type_code" type="hidden" value="" name="type_code">
					<input class="form-control color" type="hidden" value="" name="color">
					<input class="form-control color_code" type="hidden" value="" name="color_code">
					<input class="form-control condition" type="hidden" value="" name="condition">
					<input class="form-control condition_code" type="hidden" value="" name="condition_code">
				</div>
				<!-- <div class="col-md-1 form-group chekbox-validation">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" value="0" data-field="serial" name="serial_chk[]" class="serial_chk checkbx">
                        </span>
                    </div>
				</div> -->
				<div class="col-md-2 form-group">
					<input type="text" value="" name="" class="form-control" placeholder="Custom input">
				</div>
				<div class="col-md-2 form-group">
					<!-- <a href="<?php //echo base_url().'admin/barcode/utility' ?>" class="btn bg-teal print_label_internal" name="print_label_internal" type="button">Print Label</a> -->
					<button class="btn bg-teal print_label_internal"  name="print_label_internal" type="submit">Print Label</button>
				</div>
				<div class="col-md-2">
					<div class="text_amount_box text-left">
						<input type="text" class="form-control" placeholder="Amount">
					</div>
				</div>
				<div class="col-md-2 form-group">
					<button class="btn bg-teal" type="submit">Print Label</button>
					<!-- <button class="btn bg-teal" type="submit">Save</button> -->
				</div>
			</div>

			<div class="row">
				<div class="col-md-5 form-group">
					<input type="text" value="" name="" class="form-control" placeholder="Scan to Location">
				</div>
				<div class="col-md-3 form-group">
					<button class="btn bg-teal" type="submit">Scan</button>
				</div>
			</div>

			<div class="row">
				<div class="col-md-2 form-group savelabel-new">
					<button class="btn bg-teal" type="submit">Saved Labels</button> <br/>
					<button class="btn bg-teal" type="submit">New</button>
				</div>
				<div class="col-md-4 form-group">
				<select name="part" data-placeholder="Select Label" class="form-control select part">
					<?php foreach ($ink_products as $key => $value) {?>
						<option value="<?=$key;?>"><?=$value;?></option>
					<?php }?>
				</select>
					<!-- <select class="form-control">
						<option>Label 01</option>
						<option>Label 02</option>
						<option>Label 03</option>
						<option>Label 04</option>
						<option>Label 05</option>
					</select> -->
				</div>
				<div class="col-md-2 form-group">
                    <input type="text" value="" name="" class="form-control" placeholder="Print Qty..">
                </div>
                <div class="col-md-3 form-group">
					<button class="btn bg-teal" type="submit">Print Label</button>
				</div>
			</div>



		</div>
	</div>
</form>
<script type="text/javascript">
$('.print_label_internal').click(function(){
	$('#utility').attr('action','admin/barcode/utility');
});
	function get_product_details(){
		var internal_part = $('.internal_part').val();
		var hp_part = $('.hp_part').val();
		var name = $('.name').val();
		var ink = $('.ink').val();
		var type = $('.type').val();
		var type_code = $('.type_code').val();
		var color = $('.color').val();
		var color_code = $('.color_code').val();
		var condition = $('.condition').val();
		var condition_code = $('.condition_code').val();
		var data = {internal_part: internal_part, hp_part: hp_part, name: name, ink: ink, type: type, type_code: type_code, color: color, color_code: color_code,};
		$.ajax({
                type: 'POST',
                url: '<?= $ajax_url?>',
                async: false,
                dataType: 'JSON',
                data: data,
            })
			.done(function(response){
				console.log(response);
				if(response.status==0){
					$( "input" ).not( ".internal_part" ).val('');
				}else{
					$('input.internal_part1').val(response.product.internal_part);
					$('input.hp_part').val(response.product.hp_part);
					$('input.name').val(response.product.name);
					$('input.ink').val(response.product.ink);
					$('input.type').val(response.product.type);
					$('input.type_code').val(response.product.type_code);
					$('input.color').val(response.product.color);
					$('input.color_code').val(response.product.color_code);
					$('input.condition').val(response.product.conditions);
					$('input.condition_code').val(response.product.condition_code);
				}
			})
			.fail(function(){
				console.log("error");
			})
			.always(function(){
				console.log("complete");
			})
	}

</script>
<script type="text/javascript">
    $('.part').select2();
</script>
