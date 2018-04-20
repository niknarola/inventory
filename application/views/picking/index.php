<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Picking</h5>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <div class="col-md-12">
                    <div class="picking-actions">
                        <a href="javascript:void(0);" class="btn bg-teal-400">Sync</a>
                        <a data-store="ebay" href="javascript:void(0);" class="store btn bg-teal-400">eBay</a>
                        <a data-store="amazon" href="javascript:void(0);" class="store btn bg-teal-400">Amazon</a>
                        <a data-store="excessbuy" href="javascript:void(0);" class="store btn bg-teal-400">Website</a>
                        <a data-store="b2b" href="javascript:void(0);" class="store btn bg-teal-400">B2B</a>
                    </div>
                    <table class="table datatable-basic" id="orders_tbl">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Site</th>
                                <th>Order #</th>
                                <th>Part #</th>
                                <th>Additional Info</th>
                                <th>Quantity Ordered</th>
                                <th>Name</th>
                                <th>Serial Number</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th style="display: none;">hide</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($orders) {
                                $i = 1;
                                $cls = 0;
                                foreach ($orders as $order) {
                                    ?>
                                    <?php
                                    $itemcnt = 1;
                                    foreach ($order['items'] as $item) {
                                        $n = 1;
                                        $sku = $item['sku'];
                                        $pieces = explode('-', $sku);
                                        if (count($pieces) > 1) {
                                            $part1 = implode('-', array_slice($pieces, 0, $n));
                                            $part2 = $pieces[$n];
                                        } else {
                                            $part1 = $sku;
                                            $part2 = '';
                                        }
                                        $part = $part1;
                                        $additional_part_info = $part2;
                                        $qty = $item['quantity'];
                                        if ($i % 2 == 0) {
                                            $class = "";
                                        } else {
                                            $class = "success";
                                        }
                                        ?>
                                        <tr class="<?php echo $class; ?>">
                                            <?php if ($itemcnt == 1) { ?>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $order['store']; ?></td>
                                                <td><?php echo $order['order_number']; ?></td>
                                            <?php } else { ?>
                                                <td>&nbsp;</td>
                                                <td class="noselect" style="color: #6772e500;"><?php echo $order['store']; ?></td>
                                                <td class="noselect" style="color: #6772e500;"><?php echo $order['order_number']; ?></td>
                                            <?php } ?>
                                            <td><a href="<?php echo base_url() . 'admin/inventory/picking/part/' . $part; ?>"><?php echo $part; ?></a></td>
                                            <td><?php echo $additional_part_info; ?></td>
                                            <td class="<?php echo ($qty > 1 ? 'highlight' : ''); ?>"><?php echo $qty; ?></td>
                                            <td><?php echo $item['name']; ?></td>
                                            <td><a href="javascript:void(0);" class="order-scan-link">Scan</a></td>
                                            <td>
                                                <?php for ($k = 1; $k <= $qty; $k++) { ?>
                                                    <span><?php echo $k . '/' . $qty . ' - '; ?></span><span>Awaiting Scan</span>
                                                <?php }
                                                ?>
                                            </td>
                                            <td><a href="javascript:void(0);" class="order-complete-link">Complete</a></td>
                                            <td style="display: none;"></td>
                                        </tr>
                                        <?php
                                        $itemcnt++;
                                    }
                                    $i++;
                                    ?>

                                    <?php
                                }
                            } else {
                                echo "<td colspan='9'><center>No orders found</center></td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <!--<script src="assets/js/jquery.dataTables.js?v=1"></script>-->
    <script type="text/javascript" src="assets/js/datatables.min.js"></script>
    <script type="text/javascript">
        function filterGlobal(store) {
            $('#orders_tbl').DataTable().search(store).draw();
        }
        jQuery(document).ready(function ($) {
            // DataTable
            table = $('.datatable-basic').dataTable({
                "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]}],
                "pageLength": 10,
                "order": [10, "asc"],
                "scrollX": true,
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: {'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;'}
                },
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            });
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity,
                width: 'auto'
            });
//            $('.store').on('click', function () {
//                var store = $(this).data('store');
//                filterGlobal(store);
//            });
//            $('.check_all').click(function () {
//                if ($(this).is(':checked')) {
//                    $('.check_product').prop('checked', true);
//                    console.log($('.check_product:checked').length);
//                } else {
//                    $('.check_product').prop('checked', false);
//                    console.log($('.check_product:checked').length);
//                }
//            });
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