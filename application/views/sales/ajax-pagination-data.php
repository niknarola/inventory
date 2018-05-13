<table class="table" id="product_tbl">
    <thead>
        <?php if (!empty($posts) && ($searchBy == "part" || $searchBy == "name")) { ?>
            <tr>
                <th>Part #</th>
                <th>Name</th>
                <th>Cost</th>
                <th>Avg Price</th>
                <th>Profit</th>
                <th>Qty in Stock</th>
                <th>Ready for Sale</th>
                <th>Flag Item</th>
            </tr>
        <?php } else { ?>
            <tr>
                <th>Serial #</th>
                <th>New Serial #</th>
                <th>Part #</th>
                <th>Name</th>
                <th>Audit Link</th>
                <th>Sales SKU</th>
                <th>Cost</th>
            </tr>
        <?php } ?>
    </thead>
    <tbody id="userData">
        <?php //pr($posts); ?>
        <?php if (!empty($posts) && ($searchBy == "part" || $searchBy == "name")): foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td><?php echo $post['qty_in_stock']; ?></td>
                    <td><?php echo $post['ready_for_sale']; ?></td>
                    <?php if ($post['is_flagged'] == 0) { ?>
                        <td>
                            <a href="javascript:void(0);" class="flag-item" data-part="<?php echo $post['part']; ?>">Flag</a>
                            <span class="is-flagged" data-part="<?php echo $post['part']; ?>" style="display: none;">
                                <i class="icon-flag3"></i> 
                                <a href="javascript:void(0);" class="remove-flag-item" data-part="<?php echo $post['part']; ?>">Remove Flag</a>
                            </span>
                        </td>
                    <?php } else { ?>
                        <td>
                            <a href="javascript:void(0);" class="flag-item" style="display: none;" data-part="<?php echo $post['part']; ?>">Flag</a>
                            <span class="is-flagged" data-part="<?php echo $post['part']; ?>">
                                <i class="icon-flag3"></i> 
                                <a href="javascript:void(0);" class="remove-flag-item" data-part="<?php echo $post['part']; ?>">Remove Flag</a>
                            </span>
                        </td>
                    <?php } ?>
                </tr>
                <?php
            endforeach;
        elseif (!empty($posts) && $searchBy == "serial"): foreach ($posts as $post):
                ?>
                <?php
                $status = $post['status'];
                if ($status == 'Other') {
                    $status = $post['other_status'];
                }
                ?>
                <tr>
                    <td><?php echo $post['serial']; ?></td>
                    <td><?php echo $post['new_serial']; ?></td>
                    <td><?php echo ($post['is_flagged'] == 1) ? $post['part'].' <i class="icon-flag3"></i>' : $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td>
                        <a href="javascript:void(0);" class="audit-link" data-serial="<?php echo $post['serial']; ?>">Audit Link</a>
                    </td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr><td colspan="3">No data found......</td></tr>
<?php endif; ?>
    </tbody>
</table>
<div id="pagination">
<?php echo $this->ajax_pagination->create_links(); ?>
</div>
