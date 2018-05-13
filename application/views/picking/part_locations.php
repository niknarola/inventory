<div class="col-md-12">
    <?php
    if ($this->session->flashdata('success')) {
        ?>
        <div class="alert alert-success hide-msg">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
            <strong><?php echo $this->session->flashdata('success') ?></strong>
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) {
        ?>
        <div class="alert alert-danger hide-msg">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>                    
            <strong><?php echo $this->session->flashdata('error') ?></strong>
        </div>
    <?php } ?>
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h3 class="panel-title">Part Information</h3>
            <h6 class="panel-title"><b>Part #</b> : <?php echo $part; ?></h6>
            <h6 class="panel-title"><b>Part Name</b> : <?php echo $part_details['name']; ?></h6>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <div class="col-md-12">
                    <table class="table datatable-basic" id="orders_tbl">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Serial #</th>
                                <!-- <th>Name</th> -->
                                <th>Location/Pallet</th>
                                <th>Condition</th>
                                <!-- <th>Notes</th> -->
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($details) {
                                $i = 1;
                                foreach ($details as $detail) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $detail['serial'] ?></td>
                                        <!-- <td><?php //echo $detail['product_name'];  ?></td> -->
                                        <td><?php echo $detail['location'] . '/' . $detail['pallet']; ?></td>
                                        <td><?php echo $detail['original_condition']; ?></td>
                                        <!-- <td><?php //echo $detail['notes'];  ?></td> -->
                                        <td><?php echo $detail['psstatus']; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                echo "<td colspan='9'><center>No details found</center></td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/datatables.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // DataTable
            table = $('.datatable-basic').dataTable({
                "aoColumnDefs": [{"bSortable": false, "aTargets": [0]}],
                "pageLength": 10,
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                order: [[0, "asc"]]
            });
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
            $('.check_all').click(function () {
                if ($(this).is(':checked')) {
                    $('.check_product').prop('checked', true);
                    console.log($('.check_product:checked').length);
                } else {
                    $('.check_product').prop('checked', false);
                    console.log($('.check_product:checked').length);
                }
            });
            $('form').submit(function (event) {
                var check_len = $('.check_product:checked').length;
                if (check_len == 0) {
                    alert('please check atleast 1 product');
                    return false;
                }
                return true;
            });

        });
    </script>
