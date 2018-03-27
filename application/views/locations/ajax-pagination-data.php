<table class="table" id="product_tbl">
    <thead>
        <tr>
            <th><input type="checkbox" name="check_all" class="check_all" value=""></th>
            <!-- <th>#</th> -->
            <th>Print</th>
            <th>Serial #</th>
            <th>Part #</th>
            <th>Name</th>
            <th>Location/Pallet</th>
            <th>Condition</th>
            <th>Notes</th>
            <th>Move</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="userData">
        <?php if (!empty($posts)): foreach ($posts as $post): ?>
                <?php
                $status = $post['status'];
                if ($status == 'Other')
                {
                    $status = $post['other_status'];
                }
                ?>
                <tr>
                    <td><input type="checkbox" name="check[]" class="check_row" value="<?= $post['id'] ?>"></td>
                    <!-- <td><?php //echo $post['id'];  ?></td> -->
                    <td><?php if ($post['location_name'] != '')
        { ?><a class="print_location" href="<?php echo $print_url . '/' . $post['location_id']; ?>">Print</a> <?php } ?></td>
                    <td><?php echo $post['serial']; ?></td>
                    <td><?php echo $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td><?php echo ($post['location_name'] != '') ? $post['location_name'] . ' / ' . $post['palletid'] : ''; ?></td>
                    <td><?php echo $post['original_condition']; ?></td>
                    <td><?php echo $post['recv_notes']; ?></td>
                    <td><button class="btn-link transfer_location" data-serial="<?php echo $post['serial']; ?>" data-location="<?php echo $post['location_name']; ?>" style="color: #1E88E5;" type="button">Transfer Location</button></td>
                    <td><?php echo ($status != '') ? $status . '<br/>' . $post['modified'] : ''; ?></td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr><td colspan="3">Serial(s) not found......</td></tr>
<?php endif; ?>
    </tbody>
</table>
<div id="pagination">
<?php echo $this->ajax_pagination->create_links(); ?>
</div>