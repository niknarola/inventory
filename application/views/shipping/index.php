<style>
    #overlay{
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('assets/images/2.gif') 50% 50% no-repeat #f9f9f975;
    }
</style>
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
            <h5 class="panel-title">Pending Shipments</h5>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <div class="col-md-12">
                    <div class="picking-actions">
                        <a href="javascript:void(0);" class="btn bg-teal-400" id="sync">Refresh</a>
                        <a href="javascript:void(0);" class="btn bg-teal-400" id="mark-as-shipped">Mark as Shipped</a>
                    </div>
                    <table class="table datatable-basic" id="orders_tbl">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="check_all" class="check_all" id="check_all" value=""></th>
                                <th>#</th>
                                <th>Order Date</th>
                                <th>Order #</th>
                                <th>Site</th>
                                <th>Part #</th>
                                <th>Additional Info</th>
                                <th>Serial #</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>On time</th>
                                <th>Order notes</th>
                                <th>Pick notes</th>
                                <th style="display: none;">hide</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($orders) {
                                $i = 1;
                                $cls = 0;
                                $CI = & get_instance();
                                foreach ($orders as $order) {
                                    $today = date('m/d/Y');
                                    $orderDate = $order['orderDate'];
                                    $add_day = 0;
                                    do {
                                        $add_day++;
                                        $new_date = date('Y-m-d', strtotime("$today +$add_day Days"));
                                        $new_day_of_week = date('w', strtotime($new_date));
                                    } while ($new_day_of_week == 6 || $new_day_of_week == 0);

                                    $next_working_date = $new_date;
                                    if ($today == $next_working_date) {
                                        $on_time = "YES";
                                        $order_cls = "";
                                    } else {
                                        $on_time = "NO";
                                        $order_cls = "txt-danger";
                                    }
                                    $cnt_order_item_quantity = $order['qty_cnt'];
                                    $order_items = $CI->get_all_data_by_criteria($order['order_number']);
                                    ?>
                                    <?php
                                    $itemcnt = 1;
//                                    pr($order['items']);
                                    foreach ($order['items'] as $item) {

                                        $order_item_details = $CI->get_order_item_detail($item['orderItemId']);
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
                                        $scan = '';
                                        $complete = 'disabled';
                                        if (count($order_item_details) == $qty) {
                                            $scan = "disabled";
                                        }
                                        if (count($order_items) == $qty) {
                                            $complete = '';
                                        }
                                        if ($order['order_status'] != 1) {
                                            $class = "gray-bg";
                                        } elseif ($i % 2 == 0) {
                                            $class = "";
                                        } else {
                                            $class = "success";
                                        }
                                        ?>
                                        <tr class="<?php echo $class; ?>" id='order_<?php echo $item['orderItemId']; ?>'>
                                    <input class="order_item_id" type="hidden" name="order_item_id" value="<?php echo $item['orderItemId']; ?>">
                                    <input class="order_id" type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <?php if ($itemcnt == 1) { ?>
                                        <td><input type="checkbox" name="check[]" class="check_order" value="<?php echo $order['order_id']; ?>"></td>
                                        <td><?php echo $i; ?></td>
                                        <td class="order_date <?php echo $order_cls; ?>"><?php echo $order['orderDate']; ?></td>
                                        <td class="order_number"><?php echo $order['order_number']; ?></td>
                                        <td class="store"><?php echo $order['store']; ?></td>
                                    <?php } else { ?>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="noselect store" style="color: #6772e500;"><?php echo $order['orderDate']; ?></td>
                                        <td class="noselect order_number" style="color: #6772e500;"><?php echo $order['order_number']; ?></td>
                                        <td class="noselect store" style="color: #6772e500;"><?php echo $order['store']; ?></td>
                                    <?php } ?>
                                        <td><a class="part" data-part="<?php echo $part; ?>" target="_BLANK" href="<?php echo base_url() . 'admin/inventory/picking/part/' . $part; ?>"><?php echo $part; ?></a></td>
                                    <td class="additional_part_info"><?php echo $additional_part_info; ?></td>
                                    <td>
                                        <?php
                                        $order_item_qty = $qty;
                                        $qty_count = 1;
                                        if (isset($order_item_details)) {
                                            $k = 1;
                                            foreach ($order_item_details as $order_item) {
                                                if ($order_item['no_need_to_scan'] == 1) {
                                                    $status = " - Not Awailable";
                                                    $cls = "";
                                                } elseif ($order_item['order_item_status'] == 1) {
                                                    $status = "";
                                                    $cls = "item-accepted";
                                                }
                                                ?>
                                                <span><?php echo $k . '/' . $qty . ' '; ?></span><span class="<?php echo $cls; ?>"><?php echo $order_item['serial'] . $status; ?></span><br>
                                                <?php
                                                $k++;
                                                $qty_count++;
                                                $order_item_qty--;
                                            }
                                        }
                                        if ($order_item_qty > 0) {
                                            ?>
                                            <?php for ($j = $qty_count; $j <= $qty; $j++) { ?>
                                                <span><?php echo $j . '/' . $qty . ' - '; ?></span><span>Not Awailable</span><br>
                                            <?php }
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php echo ($order['order_status'] == 1 ? 'Ready to ship' : 'Picking'); ?>
                                    </td>
                                    <td><a href="javascript:void(0);" class="order-ship-link" data-order="<?php echo $order['order_number']; ?>">Ship Order</a>
                                    </td>
                                    <td class="<?php echo $order_cls; ?>">
                                        <?php echo $on_time;
                                        ?>
                                    </td>
                                    <td><a href="javascript:;" data-id="<?php echo $order['order_number']; ?>" class="btn-xs btn-default order_notes" onClick="view_order_notes(<?php echo $item['orderItemId']; ?>)"><i class="icon-comment"></i></a></td>
                                    <td><a href="javascript:;" data-id="<?php echo $order['order_number']; ?>" class="btn-xs btn-default pick_notes" onClick="view_pick_notes(<?php echo $item['orderItemId']; ?>)"><i class="icon-comment"></i></a></td>
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
    <!-- Order Notes -->
    <div id="orderModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Notes</h4>
                </div>
                <form action="<?php echo base_url() . 'admin/shipping/add_notes/order'; ?>" name="addOrderNote" id="addOrderNote" method="post">
                    <div class="modal-body">
                        <div class="order_details_container">
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Order Notes:</label>
                                            <input type="hidden" name="order_item_id" class="order_item_id" value="">
                                            <textarea class="form-control" name="order_notes" id="order_notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Order Notes -->

    <!-- Pick Notes -->
    <div id="pickModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pick Notes</h4>
                </div>
                <form action="<?php echo base_url() . 'admin/shipping/add_notes/pick'; ?>" name="addPickNote" id="addPickNote" method="post">
                    <div class="modal-body">
                        <div class="pick_details_container">
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Pick Notes:</label>
                                            <input type="hidden" name="order_item_id" class="order_item_id" value="">
                                            <textarea class="form-control" name="pick_notes" id="pick_notes"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="orderCopiedModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Ship Order</h4>
                </div>
                <div class="modal-body">
                    <div class="pick_details_container">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Order Number is copied! Paste this order number to shipstation website:</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-success go-to-ship">OK</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Pick Notes -->
    <div id="overlay">
    </div>
        <!--<script src="assets/js/jquery.dataTables.js?v=1"></script>-->
    <script type="text/javascript" src="assets/js/datatables.min.js"></script>
    <script type="text/javascript">
                            function view_order_notes(order_item_id) {
                                $.ajax({
                                    url: 'admin/shipping/view_order_notes/' + order_item_id,
                                    method: 'post',
                                    success: function (resp) {
                                        resp = JSON.parse(resp);
                                        var order_notes = resp.order_notes;
                                        $('#order_notes').val(order_notes);
                                        $('.order_item_id').val(order_item_id);
                                        $('#orderModal').modal('show');
                                    }
                                });
                            }
                            function view_pick_notes(order_item_id) {
                                $.ajax({
                                    url: 'admin/shipping/view_pick_notes/' + order_item_id,
                                    method: 'post',
                                    success: function (resp) {
                                        resp = JSON.parse(resp);
                                        var pick_notes = resp.pick_notes;
                                        $('#pick_notes').val(pick_notes);
                                        $('.order_item_id').val(order_item_id);
                                        $('#pickModal').modal('show');
                                    }
                                });
                            }
                            function filterGlobal(store) {
                                $('#orders_tbl').DataTable().search(store).draw();
                            }
                            jQuery(window).load(function () {
                                // PAGE IS FULLY LOADED  
                                // FADE OUT YOUR OVERLAYING DIV
                                $('#overlay').fadeOut();
                            });
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

                                $(".order-ship-link").on("click", function () {
                                    var order_number = $(this).data('order');

                                    var $temp = $("<input>");
                                    $("body").append($temp);
                                    $temp.val(order_number).select();
                                    document.execCommand("copy");
                                    $temp.remove();
                                    $('#orderCopiedModal').modal('show');
                                });

                                $(".go-to-ship").on("click", function () {
                                    $('#orderCopiedModal').modal('hide');
                                    window.open('https://ss7.shipstation.com/#/orders', '_blank');
                                });


                                $("#addOrderNote").submit(function (e) {
                                    var url = $(this).attr('action');
                                    $('#overlay').show();
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        dataType: 'json',
                                        data: $("#addOrderNote").serialize(), // serializes the form's elements.
                                        success: function (data)
                                        {
                                            window.location.href = '<?php echo base_url() . "admin/shipping"; ?>';
                                            $('#overlay').fadeOut();
                                        }
                                    });

                                    e.preventDefault(); // avoid to execute the actual submit of the form.
                                });
                                $("#addPickNote").submit(function (e) {
                                    var url = $(this).attr('action');
                                    $('#overlay').show();
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        dataType: 'json',
                                        data: $("#addPickNote").serialize(), // serializes the form's elements.
                                        success: function (data)
                                        {
                                            window.location.href = '<?php echo base_url() . "admin/shipping"; ?>';
                                            $('#overlay').fadeOut();
                                        }
                                    });

                                    e.preventDefault(); // avoid to execute the actual submit of the form.
                                });
                                $('.check_all').click(function () {
                                    if ($(this).is(':checked')) {
                                        $('.check_order').prop('checked', true);
                                        console.log($('.check_product:checked').length);
                                    } else {
                                        $('.check_order').prop('checked', false);
                                        console.log($('.check_order:checked').length);
                                    }
                                });
                                $('#mark-as-shipped').click(function () {

                                    if (confirm("Are you sure you want to mark this as shipped?"))
                                    {
                                        var id = [];

                                        $(':checkbox:checked').each(function (i) {
                                            id[i] = $(this).val();
                                        });

                                        if (id.length === 0) //tell you if the array is empty
                                        {
                                            alert("Please Select atleast one order");
                                        } else
                                        {
                                            $('#overlay').show();
                                            $.ajax({
                                                url: '<?php echo base_url() . 'admin/shipping/mark-as-shipped'; ?>',
                                                method: 'POST',
                                                data: {orders: id},
                                                success: function ()
                                                {
//                                                    return false;
                                                    window.location.href = '<?php echo base_url() . "admin/shipping"; ?>';
                                                    $('#overlay').fadeOut();
                                                }

                                            });
                                        }

                                    } else
                                    {
                                        return false;
                                    }
                                });
                            });
    </script>