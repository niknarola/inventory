<div class="col-md-3">
    <div>
        <?php echo $tech_name; ?>  Productivity
    </div>
</div>
<div class="row" id="tech_rep">
    <div class="col-md-12">
        <div class="form-group">
            <div class="post-list table-responsive" id="postList">
                <table class="table" id="report_tbl1">
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
                                <?php
                                $status = $post['status'];
                                if ($status == 'Other')
                                {
                                    $status = $post['other_status'];
                                }
                                ?>
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
                                    <td><?php echo ($status != '') ? $status . '<br/>' . $results['modified'] : ''; ?></td>
                                    <td><?php // echo $results['rma'];       ?></td>
                                </tr>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <tr><td colspan="3">Serial(s) not found......</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div id="pagination">
                    <?php echo $this->ajax_pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
