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
			<!-- <td><?//= substr($pallet['pallet_id'], strpos($pallet['pallet_id'], "-") + 1).'/'.$pallet['pallet_part']; ?></td> -->
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