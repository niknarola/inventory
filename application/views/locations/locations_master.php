
<?//= $admin_prefix;die; ?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h5 class="panel-title">Locations Master</h5>
    </div>
	<form method="post">
		<div class="panel-body">
			<div class="row">
			<div class="col-md-12" style="border-right: 1px solid #eee;">
				<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Pallet: </label>
						<select name="pallet_id" class="form-control pallet_id" onchange="get_serials_by_pallet(this.value);">
							<option value="">Select Pallet</option>
							<?php foreach ($pallets as $key => $value): ?>
							<option value="<?= $key; ?>"><?= $value; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="pallet_div col-md-6">
				</div>
			</div>
			<div class="row">
				<div class="quick" style="display: none;">
					<p>There seems no items in the selected pallet, Please move to <a href="<?= $admin_prefix; ?>receiving/quick_receive">Quick Receive</a> add the items in the pallet</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="pallet_actions">
					<div class="form-group col-md-1">
					<input type="text" class="form-control pallet_item_cnt" readonly="true" value="" placeholder="#items">
				</div>
				<div class="form-group col-md-2">
					<input type="text" name="location" class="form-control location" value="" placeholder="Location">
				</div>
                <button type="submit" name="complete" value="complete" class="btn btn-sm btn-primary complete">Complete</button>
	            </div>
	        </div>
			</div>
		</div>
			<hr>
			<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="table-responsive">
						<div class="pallet-list" id="palletList">
						<table class="table">
							<thead>
								<tr>
									<th>Location</th>
									<th>Print Labels</th>
									<th>Item Count</th>
									<th>Last Updated</th>
									<th>Created</th>
								</tr>
							</thead>
							<tbody>
								
								<?php if(!empty($locations)){ foreach ($locations as $location) { ?>
								<tr>
									<td><?= $location['name']; ?></td>
									<td><a class="print_location" href="<?php echo $print_url.'/'.$location['id']; ?>">Print</a></td>
									<td><?= get_item_count($location['id']); ?></td>
									<td><?= $location['modified']; ?> </td>
									<td><?= $location['created']; ?> </td>
								</tr>
								<?php }
							}else{ ?>
								<tr><td colspan="3">Location(s) not found......</td></tr>
								<?php } ?>
							</tbody>
						</table>
						
					</div>
					</div>
				</div>
			</div>
		</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {

		});
	function get_serials_by_pallet(pallet){
		console.log('pallet',pallet);
		if(pallet!=''){
		$.ajax({
			url: '<?php echo $admin_prefix;?>locations/get_serial_part_by_pallet',
			type: 'POST',
			dataType: 'json',
			data: {pallet: pallet},
		})
		.done(function(response) {
			console.log("response", response);
			if(response.status == 1){
				$('.pallet_item_cnt').val(response.cnt);
				$('.pallet_div').html(response.html);
				$('.quick').css('display','none');
			}else{
				$('.pallet_item_cnt').val('');
				$('.pallet_div').html('');
				$('.quick').css('display','block');
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