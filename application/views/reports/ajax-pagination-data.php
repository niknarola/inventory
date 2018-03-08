<table class="table" id="product_tbl">
    <thead>
        <tr>
            <th><input type="checkbox" name="check_all" class="check_all" value=""></th>
            <th>#</th>
            <th>Serial #</th>
            <th>Part #</th>
            <th>Name</th>
            <th>Condition</th>
            <th>Grade</th>
            <!--<th>Notes</th>-->
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
                    <td><input type="checkbox" name="check[]" class="check_row" value="<?= $post['id'] ?>"></td>
                    <td><?php echo '#' . $post['id']; ?></td>
                    <td><?php echo $post['serial']; ?></td>
                    <td><?php echo $post['part']; ?></td>
                    <td><?php echo $post['product_name']; ?></td>
                    <td><?php echo $post['original_condition']; ?></td>
                    <td><?php echo $post['cosmetic_grade']; ?></td>
                    <!--<td><?php // echo $post['recv_notes'];     ?></td>-->
                    <td><?php echo $post['location_name']; ?></td>
                    <td><?php echo ($status != '') ? $status . '<br/>' . $post['modified'] : ''; ?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr><td colspan="3">Serial(s) not found......</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php echo $this->ajax_pagination->create_links(); ?>







<!--<table class="table" id="report_tbl">
    <thead>
        <tr>
            <th>Part #</th>
            <th>Serial #</th>
            <th>Date Tested</th>
            <th>Condition</th>
            <th>Grade</th>
            <th>Testing Result</th>
            <th>Reason(if fail)</th>
            <th>Hard Drive Wiped</th>
            <th>Factory Reset</th>
            <th>Status</th>                
            <th>RMA</th>                
        </tr>
    </thead>
    <tbody id="userData">
<?php if (!empty($report_results)): foreach ($report_results as $results): ?>
                                        <tr>
                                            <td><?php echo $results['part']; ?></td>
                                            <td><?php echo $results['serial']; ?></td>
                                            <td><?php echo $results['testing_date']; ?></td>
                                            <td><?php echo $results['original_condition']; ?></td>
                                            <td><?php echo $results['cosmetic_grade']; ?></td>
                                            <td><?php echo ($results['pass'] == '1' && $results['fail'] == '1') ? 'Pass' : '' ?></td>
                                            <td><?php echo $results['fail_reason_notes']; ?></td>
                                            <td><?php echo $results['hard_drive_wiped_date']; ?></td>
                                            <td><?php echo $results['factory_reset_date']; ?></td>
                                            <td><?php echo $results['status']; ?></td>
                                            <td><?php echo $results['rma']; ?></td>
                                        </tr>
        <?php
    endforeach;
else:
    ?>
                        <tr><td colspan="3">Serial(s) not found......</td></tr>
<?php endif; ?>
    </tbody>
</table>-->
<?php
// echo $this->ajax_pagination->create_links(); ?>