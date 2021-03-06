<table class="table" id="product_tbl">
    <thead>
        <tr>
            <th>Images</th>
            <th>Serial #</th>
            <th>New Serial #</th>
            <th>Part #</th>
            <th>Name</th>
            <th>Condition</th>
            <th>Grade</th>
            <th>Notes/Specs</th>
            <th>Location</th>
            <th>Status</th>
            <!-- <th>Notes/Specs</th> -->
        </tr>
    </thead>
    <tbody id="userData">
<?php //pr($posts); ?>
        <?php if (!empty($posts)): foreach ($posts as $post): ?>
                <?php
                $status = $post['status'];
                if ($status == 'Other')
                {
                    $status = $post['other_status'];
                }
                ?>
                <tr>
                    <?php
                        if($post['files'] != '' || $post['files'] != null){
                    ?>
                    <td><img src="<?= base_url().'/assets/uploads/'.$post['pid'].'/serials/'.$post['id'].'/'.$post['files']; ?>" alt="No image found"></td>
                        <?php } else {?>
                            <td><img src="<?= base_url().'/assets/images/not-available.jpg'?>" height="100px" width="100px" alt="No image found"></td>
                        <?php } ?>
                    <td><?php echo $post['serial']; ?></td>
                    <td><?php echo $post['new_serial']; ?></td>
                    <td><?php echo ($post['is_flagged'] == 1) ? $post['part'].' <i class="icon-flag3"></i>' : $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td><?php echo $post['original_condition']; ?></td>
                    <td><?php echo $post['cosmetic_grade']; ?></td>
                    <td>
                    <?php if($post['fail_text'] != '' || $post['recv_notes'] != '' || $post['packaging_notes'] != '' || $post['inspection_notes'] != '' || $post['cpu'] !=''){?>
                        <a href="javascript:;" data-id="<?= $post['id'];?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?= $post['id'];?>)"><i class="icon-comment"></i></a>
                        <a href="javascript:;" data-id="<?= $post['id'];?>" class="btn-xs btn-default product_specs" onClick="view_specs(<?= $post['id'];?>)"><i class="icon-info22"></i></a>
                        <?php } ?></td>
                    <!-- <td><?php //echo $post['recv_notes']; ?></td> -->
					<td><?php echo ($post['pallet'] != '') ? $post['pallet'] . ' / ' . $post['pallet_location_name'] : ''; ?></td>
					<!-- date('m-d-Y h:i A', strtotime($val['modified_date']) + $_COOKIE['currentOffset'] ); -->
                    <td><?php echo ($status != '') ? $status . '<br/>' . date('m-d-Y h:i A', strtotime($post['modified']) + $_COOKIE['currentOffset'] ) : ''; ?></td>
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
