	<div class="panel panel-flat">
	    <div class="panel-heading">
	        <h5 class="panel-title">Dock Receive</h5>
	    </div>
		<form method="post">
		<div class="panel-body">
			<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>BOL / Tracking #:</label>
								<input type="text" name="bol_or_tracking" value="<?php echo ($this->session->userdata('pallets_next')['bol_or_tracking']) ?  $this->session->userdata('pallets_next')['bol_or_tracking'] : ''; ?>" class="form-control bol_or_tracking">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>REF #:</label>
								<input type="text" name="ref" value="<?php echo ($this->session->userdata('pallets_next')['ref']) ?  $this->session->userdata('pallets_next')['ref'] : ''; ?>" class="form-control ref">
								<!-- <input type="text" name="tracking" value="<?php echo ($this->session->userdata('pallets_next')['tracking']) ?  $this->session->userdata('pallets_next')['tracking'] : ''; ?>" class="form-control tracking"> -->
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Location:</label>
								<select class="form-control main_location" name="main_location">
									<?php foreach ($locations as $key => $value) { ?>
										<option <?php echo ($this->session->userdata('pallets_next')['main_location'] == $key) ?  'selected' : ''; ?> value="<?= $key ?>"><?= $value ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button  name="search" value="search" class="btn btn-sm btn-primary search ">Search</button>
							<button type="submit" name="delete" value="delete" class="btn btn-sm btn-primary delete">Delete</button> 
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>No Of. Pallets # (Max 25):</label>
								<input type="number" name="pallet_count" value="" max="25" min="1" class="pallet_count form-control" >
							</div>
						</div>
					</div>
					<div class="pallet_div"></div>
					<div class="pallet_actions" style="display: none;">
						<button type="submit" name="print_labels" value="print_labels" class="btn btn-sm btn-primary print_labels">Receive and Print Labels</button>   
		                <button type="submit" name="next" value="next" class="btn btn-sm btn-primary next">Next</button> 
		                   
		                <button type="submit" name="complete" value="complete" class="btn btn-sm btn-primary complete">Complete</button>
		            </div>
				
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="table-responsive">
						<div class="pallet-list" id="palletList">
						<table class="table">
							<thead>
								<tr>
									<th><input type="checkbox" name="check_all" class="check_all" value=""></th>
									<th>BOL/Tracking</th>
									<th>Pallet #</th>
									<th>Pallet Id</th>
									<th>Pallet Weight</th>
									<th>Item Count</th>
									<th>Location</th>
									<th>Inspection Notes</th>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($pallets)){ foreach ($pallets as $pallet) { ?>
								<tr>
									<td><input type="checkbox" name="check[]" class="check_row" value="<?= $pallet['id'] ?>"></td>
									<td><?= $pallet['bol_or_tracking']; ?></td>
									<td><?= $pallet['pallet_part'].'/'.$pallet['total_pallet']; ?></td>
									<td><?= $pallet['pallet_id']; ?></td>
									<td><?= $pallet['weight']; ?></td>
									<td><?= $pallet['item_count']; ?></td>
									<td><?= $pallet['location_name']; ?></td>
									<td><?= $pallet['inspection_notes']; ?> <button data-pallet="<?= $pallet['id'] ?>" data-target="#notes_modal" data-toggle="modal" class="btn btn-xs bg-teal add_note_btn" type="button">Add Notes</button>
									</td>
								</tr>
								<?php }
							}else{ ?>
								<tr><td colspan="3">Pallet(s) not found......</td></tr>
								<?php } ?>
							</tbody>
						</table>
						<?php echo $this->ajax_pagination->create_links(); ?>
					</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
<div id="notes_modal" class="modal fade" role="dialog">
 	<div class="modal-dialog">
	    <!-- Modal content-->
	    <form method="post" action="<?= $ajax_url; ?>add_inspection_notes">
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Add Inspection Notes</h4>
	      	</div>
	    	<div class="modal-body">
		      	<input type="hidden" class="modal_pallet_id" name="pallet_id" value="">
				<textarea name="inspection_notes" class="form-control" placeholder="Add Notes here.."></textarea>
		    </div>
		    <div class="modal-footer">
		        <button type="submit" name="save_note" class="btn bg-pink-400 save_note">Save</button>
		    </div>
	    </div>
	</form>
	</div>
</div>
	<div class="append_div" style="display: none;">
	<div class="pallet_row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Weight:</label>
				<input type="text" name="weight[]" value="" class="weight form-control" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Item Count:</label>
				<input type="text" name="item_count[]" value="" class="item_count form-control" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Location:</label>
				<select class="form-control location" name="location[]">
					<?php foreach ($locations as $key => $value) { ?>
						<option value="<?= $key ?>"><?= $value ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(document).on('click', '.check_all', function(event) {
	        if($(this).is(':checked')){
	            $('.check_row').prop('checked', true);
	        }else{
	            $('.check_row').prop('checked', false);
	        }
	    });
		$(document).on('click', '.delete', function(event) {
			var check_len = $('.check_row:checked').length;
	        if(check_len==0){
	            alert('please check atleast 1 Serial');
	            event.preventDefault();
	        }
	       return true;
		});
		$(document).on('click', '.search', function(event) {
			// if($(".bol").val().length === 0 && $(".tracking").val().length === 0) {
			if($(".bol_or_tracking").val().length === 0) {
				alert('Please enter BOL / Tracking');
				event.preventDefault();
			}
			 return true;
		});

		$(document).on('click', '.add_note_btn', function(event) {
			var pallet_id = $(this).attr('data-pallet');
			$('#notes_modal .modal_pallet_id').val(pallet_id);
		});
		$(document).on('keyup change', '.pallet_count', function() {
			if($(this).val()>25)
				$(this).val(25);
			var cnt = $(this).val();
			var row = $('.append_div').html();
			if(cnt > 0 || cnt !=''){
				$('.pallet_div').html('');
				for (var i = 0; i < cnt; i++) {
					$('.pallet_div').append(row);
				}
				var main_location = $('.main_location').val();
				$(document).find('.pallet_div .location').val(main_location);	
				$('.pallet_actions').css('display', 'block');			
			}else{
				$('.pallet_div').html('');
				$('.pallet_actions').css('display', 'none');
			}
		});
		$(document).on('change', '.main_location', function() {
			var main_location = $(this).val();
			$(document).find('.pallet_div .location').val(main_location);
		});
	});
       
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var bol = (typeof $('.bol').val()!='undefined') ? $('.bol').val() : '' ;
    var tracking = (typeof $('.tracking').val()!='undefined') ? $('.bol').val() : '';
    var location = $('.main_location').val();
    console.log(bol,tracking);
    // var sortBy = $('#sortBy').val();
    var flag=1;
    
    if(flag==1){
	    $.ajax({
	        type: 'POST',
	        url: '<?php echo base_url().$url; ?>/'+page_num,
	        data:'page='+page_num+'&bol='+bol+'&tracking='+tracking+'&main_location='+location,
	        // data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
	        beforeSend: function () {
	            $('.loading').show();
	        },
	        success: function (html) {
	            $('#palletList').html(html);
	            $('.loading').fadeOut("slow");
	        }
	    });
	}
}
</script>
