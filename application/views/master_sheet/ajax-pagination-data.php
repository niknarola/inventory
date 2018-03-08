<table class="table" id="product_tbl">
    <thead>
        <tr>
            <th>Serial #</th>
            <th>Part #</th>
            <th>Name</th>
            <th>Condition</th>
            <th>Grade</th>
            <th>Notes</th>
            <th>Location</th>
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
                    <td><?php echo $post['serial']; ?></td>
                    <td><?php echo $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td><?php echo $post['original_condition']; ?></td>
                    <td><?php echo $post['cosmetic_grade']; ?></td>
                    <td><?php echo $post['recv_notes']; ?></td>
                    <td><?php echo $post['location_name']; ?></td>
                    <td><?php echo ($status != '') ? $status . '<br/>' . $post['modified'] : ''; ?></td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr><td colspan="3">Serial(s) not found......</td></tr>
<?php endif; ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>