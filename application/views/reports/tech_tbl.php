<!--<div class="row" id="tech_rep">-->
    <div class="col-md-12">
        <div class="form-group">
            <div class="post-list table-responsive" id="postList">
                <table class="table" id="tech_tbl" >
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Tech</th>
                            <th>Completed</th>
                            <th>In Progress</th>
                            <th>Notebooks</th>
                            <th>Desktops</th>
                            <th>Thin Client</th>
                            <th>All-In-Ones</th>
                            <th>Tablets</th>
                            <th>Monitors</th>
                            <th>Printers</th>
                            <th>Pass%</th>                
                            <th>Accessories</th>                
                            <th>Other</th>                
                        </tr>
                    </thead>
                    <tbody id="userData">

                        <?php
                        if (!empty($tech_reports)):
                            
                            $count = 1;
                            foreach ($tech_reports as $reports):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo $reports['name']; ?></td>
                                    <td><?php echo $reports['complete']; ?></td>
                                    <td><?php echo $reports['inprogress']; ?></td>
                                    <td><?php echo $reports['notebook_count'];?></td>
                                    <td><?php echo $reports['desktop_count'];?></td>
                                    <td><?php echo $reports['thinclient_count'];?></td>
                                    <td><?php echo $reports['allinone_count'];?></td>
                                    <td><?php echo $reports['tablet_count'];?></td>
                                    <td><?php echo $reports['monitor_count'];?></td>
                                    <td><?php echo $reports['printer_count'];?></td>
                                    <td>
                                        <?php
                                        if ($reports['count'] != 0)
                                        {
                                            echo number_format(($reports['complete'] / $reports['count'] * 100), 2) . '%';
                                        }
                                        else
                                        {
                                            echo"N/A";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $reports['accessory_count'];?></td>
                                    <td><?php echo $reports['other_count'];?></td>
                                </tr>
                                <?php
                            endforeach;
                        else:
                            ?>
                            <tr><td colspan="3">Serial(s) not found......</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<!--</div>-->
