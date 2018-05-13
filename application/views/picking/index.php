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
            <h5 class="panel-title">Picking</h5>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <div class="col-md-12">
                    <div class="picking-actions">
                        <a href="javascript:void(0);" class="btn bg-teal-400" id="sync">Sync</a>
                        <a data-store="ebay" href="javascript:void(0);" class="store btn bg-teal-400">eBay</a>
                        <a data-store="amazon" href="javascript:void(0);" class="store btn bg-teal-400">Amazon</a>
                        <a data-store="excessbuy" href="javascript:void(0);" class="store btn bg-teal-400">Website</a>
                        <a data-store="b2b" href="javascript:void(0);" class="store btn bg-teal-400">B2B</a>
                        <a href="javascript:void(0);" class="btn bg-teal-400 delete-order">Delete Selected orders</a>
                    </div>
                    <table class="table datatable-basic" id="orders_tbl">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="check_all" class="check_all" id="check_all" value=""></th>
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
                                    $cnt_order_item_quantity = $order['qty_cnt'];
                                    ?>
                                    <?php
                                    $itemcnt = 1;
                                    foreach ($order['items'] as $item) {
                                        
                                        $CI = & get_instance();
                                        $order_item_details = $CI->get_order_item_detail($item['orderItemId']);
                                        $order_items = $CI->get_all_data_by_criteria($order['order_number']);
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
                                        if ($i % 2 == 0) {
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
                                    <?php } else { ?>
                                        <td>&nbsp;</td>
                                    <?php } ?>
                                    <?php if ($itemcnt == 1) { ?>
                                        <td><?php echo $i; ?></td>
                                        <td class="store"><?php echo $order['store']; ?></td>
                                        <td class="order_number"><?php echo $order['order_number']; ?></td>
                                    <?php } else { ?>
                                        <td>&nbsp;</td>
                                        <td class="noselect store" style="color: #6772e500;"><?php echo $order['store']; ?></td>
                                        <td class="noselect order_number" style="color: #6772e500;"><?php echo $order['order_number']; ?></td>
                                    <?php } ?>
                                    <td><a class="part" data-part="<?php echo $part; ?>" href="<?php echo base_url() . 'admin/shipping/picking/part/' . $part; ?>"><?php echo $part; ?></a></td>
                                    <td class="additional_part_info"><?php echo $additional_part_info; ?></td>
                                    <td class="qty <?php echo ($qty > 1 ? 'highlight' : ''); ?>"><?php echo $qty; ?></td>
                                    <td class="product_name"><?php echo $item['name']; ?></td>
                                    <td><a href="javascript:void(0);" class="order-scan-link <?php echo $scan; ?>" data-part="<?php echo $part; ?>" data-order="<?php echo $item['orderItemId']; ?>">Scan</a></td>
                                    <td>
                                        <?php
                                        $order_item_qty = $qty;
                                        $qty_count = 1;
                                        if (isset($order_item_details)) {
                                            $k = 1;
                                            foreach ($order_item_details as $order_item) {
                                                if ($order_item['no_need_to_scan'] == 1) {
                                                    $status = "No need to scan";
                                                } elseif ($order_item['order_item_status'] == 0) {
                                                    $status = "Awaiting Scan";
                                                } elseif ($order_item['order_item_status'] == 1) {
                                                    $status = "Accepted";
                                                }
                                                ?>
                                                <span><?php echo $k . '/' . $qty . ' '; ?></span><span class="item-accepted"><?php echo $order_item['serial'] . ' - ' . $status; ?></span><br>
                                                <?php
                                                $k++;
                                                $qty_count++;
                                                $order_item_qty--;
                                            }
                                        }
                                        if ($order_item_qty > 0) {
                                            ?>
                                            <?php for ($j = $qty_count; $j <= $qty; $j++) { ?>
                                                <span><?php echo $j . '/' . $qty . ' - '; ?></span><span>Awaiting Scan</span><label class=".label-danger label-striped"><a href="javascript:void(0);" class="no-need-to-scan" data-order="<?php echo $item['orderItemId']; ?>">No need to scan</a></label><br>
                                            <?php }
                                            ?>
                                        <?php } ?>
                                    </td>
                                    <?php if ($itemcnt == 1) { ?>
                                        <?php
                                        if ($cnt_order_item_quantity == count($order_items)) {
                                            $complete = '';
                                        } else {
                                            $complete = 'disabled';
                                        }
                                        ?>
                                        <td><a href="javascript:void(0);" data-action="<?php echo base_url() . 'admin/shipping/picking/complete-order/' . base64_encode($order['order_number']); ?>" data-order="<?php echo $item['orderItemId']; ?>" class="order-complete-link <?php echo $complete; ?>">Complete</a></td>
                                    <?php } else { ?>
                                        <td>&nbsp;</td>
                                    <?php } ?>
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
    <!-- scan form modal -->
    <div id="modal_form_scan" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title">Scan for serial</h5>
                </div>

                <form action="<?php base_url(); ?>admin/shipping/picking/scan_serial" class="form-inline" name="scanSerialForm" method="post" id="scanSerialForm">
                    <span class="serial-msg" style="color: red;"></span>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label>Enter Serial: </label>
                            <input type="text" name="serial" placeholder="Enter Serial Number" class="form-control">
                            <input type="hidden" name="part" value="" id="part_number" class="form-control">
                            <input type="hidden" name="order_number" value="" id="order_number" class="form-control">
                            <input type="hidden" name="orderid" value="" id="orderid" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /scan form modal -->
    <!-- Approve form modal -->
    <div id="modal_form_approve" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>

                <form action="<?php base_url(); ?>admin/shipping/picking/manage_order" class="form-inline" name="manageOrderForm" method="post" id="manageOrderForm">
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <h5 class="part_msg"></h5>
                            <input type="hidden" name="no_need_scan" id="no_need_scan" value="0" class="form-control">
                            <input type="hidden" name="scanned_store" id="scanned_store" class="form-control">
                            <input type="hidden" name="scanned_serial" id="scanned_serial" class="form-control">
                            <input type="hidden" name="scanned_part" value="" id="scanned_part" class="form-control">
                            <input type="hidden" name="scanned_product_name" value="" id="scanned_product_name" class="form-control">
                            <input type="hidden" name="scanned_order_item_id" value="" id="scanned_order_item_id" class="form-control">
                            <input type="hidden" name="scanned_order" value="" id="scanned_order" class="form-control">
                            <input type="hidden" name="scanned_additional_part_info" value="" id="scanned_additional_part_info" class="form-control">
                            <input type="hidden" name="scanned_order_total_qty" value="" id="scanned_order_total_qty" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-success" value="">Approve</button>
                        <a href="javascript:void(0);" class="btn btn-danger cancel-scan">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Approve form modal -->
    <div id="overlay">
    </div>
        <!--<script src="assets/js/jquery.dataTables.js?v=1"></script>-->
    <script type="text/javascript" src="assets/js/datatables.min.js"></script>
    <script type="text/javascript">
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
                "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}],
                "pageLength": 10,
                "order": [11, "asc"],
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

            $('#sync').on('click', function () {
                window.location.reload();
            });

            $('.store').on('click', function () {
                var store = $(this).data('store');
                filterGlobal(store);
            });

            $(".order-scan-link").click(function () {
                if ($(this).hasClass('disabled')) {
                    return false;
                } else {
                    var order_item = $(this).data('order');
                    var part = $('tr#order_' + order_item).find('a.part').data('part');
                    var order_number = $('tr#order_' + order_item).find('td.order_number').text();
                    var order_id = $('tr#order_' + order_item).find('td.order_id').text();
                    $("#part_number").val(part);
                    $("#order_number").val(order_number);
                    $("#orderid").val(order_item);
                    $("#modal_form_scan").modal();
                }
            });

            $(".no-need-to-scan").click(function () {
                var order_item = $(this).data('order');
                var scanned_order_total_qty = $('tr#order_' + order_item).find('td.qty').text();
                var scanned_part = $('tr#order_' + order_item).find('a.part').data('part');
                var scanned_product_name = $('tr#order_' + order_item).find('td.product_name').text();
                var scanned_additional_part_info = $('tr#order_' + order_item).find('td.additional_part_info').text();
                var scanned_order = $('tr#order_' + order_item).find('td.order_number').text();
                var scanned_store = $('tr#order_' + order_item).find('td.store').text();
                var scanned_order_item_id = $('tr#order_' + order_item).find('input.order_item_id').val();
                $("#scanned_part").val(scanned_part);
                $("#scanned_product_name").val(scanned_product_name);
                $("#scanned_order_item_id").val(scanned_order_item_id);
                $("#scanned_order_total_qty").val(scanned_order_total_qty);
                $("#scanned_additional_part_info").val(scanned_additional_part_info);
                $("#scanned_order").val(scanned_order);
                $("#scanned_store").val(scanned_store);
                $("#no_need_scan").val('1');
                $("#manageOrderForm").submit();
                return false;
            });


            $(".cancel-scan").click(function () {
                $("#modal_form_approve").modal('hide');
                return false;
            });

            $("#scanSerialForm").submit(function (e) {
                var url = $(this).attr('action');
                $('#overlay').show();
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: $("#scanSerialForm").serialize(), // serializes the form's elements.
                    success: function (data)
                    {
                        if (data.isserialexist == 1) {
                            if (data.serial_status == 'sold') {
                                $(".serial-msg").html('Serial # <b>' + data.serial + '</b> is SOLD!');
                            } else {
                                var partmatch = data.partmatch;
                                console.log(partmatch);
                                var scanned_part = data.part;
                                var order_item = data.orderId;
                                var scanned_order = $('tr#order_' + order_item).find('td.order_number').text();
                                var scanned_product_name = $('tr#order_' + order_item).find('td.product_name').text();
                                var scanned_order_total_qty = $('tr#order_' + order_item).find('td.qty').text();
                                var scanned_additional_part_info = $('tr#order_' + order_item).find('td.additional_part_info').text();
                                var scanned_store = $('tr#order_' + order_item).find('td.store').text();
                                var scanned_order_item_id = $('tr#order_' + order_item).find('input.order_item_id').val();
                                var scanned_serial = data.serial;
                                var msg = '';
                                if (partmatch == 0) {
                                    msg = 'Part # not a match!';
                                } else if (partmatch == 1) {
                                    msg = 'Part # matched!';
                                }
                                $(".part_msg").text(msg);
                                $("#scanned_serial").val(scanned_serial);
                                $("#scanned_part").val(scanned_part);
                                $("#scanned_order_item_id").val(scanned_order_item_id);
                                $("#scanned_order_total_qty").val(scanned_order_total_qty);
                                $("#scanned_product_name").val(scanned_product_name);
                                $("#scanned_additional_part_info").val(scanned_additional_part_info);
                                $("#scanned_order").val(scanned_order);
                                $("#scanned_store").val(scanned_store);
                                $("#modal_form_scan").modal('hide');
                                $("#modal_form_approve").modal();
                            }
                        } else {
                            $(".serial-msg").html('Serial # <b>' + data.serial + '</b> not found!');
                        }
                        $('#overlay').fadeOut();
                    }
                });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            });

            $(".order-complete-link").click(function () {
                if ($(this).hasClass('disabled')) {
                    return false;
                } else {
                    var url = $(this).data('action');
                    var order_item = $(this).data('order');
                    var scanned_order_total_qty = $('tr#order_' + order_item).find('td.qty').text();
                    var scanned_order = $('tr#order_' + order_item).find('td.order_number').text();
                    var scanned_order_id = $('tr#order_' + order_item).find('td.order_id').text();
                    var scanned_store = $('tr#order_' + order_item).find('td.store').text();
                    $('#overlay').show();
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: 'json',
                        data: {scanned_order_total_qty: scanned_order_total_qty, scanned_order_id: scanned_order_id, scanned_order: scanned_order, scanned_store: scanned_store}, // serializes the form's elements.
                        success: function (data)
                        {
                            window.location.href = '<?php echo base_url() . "admin/shipping/picking"; ?>';
                            $('#overlay').fadeOut();
                        }
                    });
                }
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

            $('.delete-order').click(function () {

                if (confirm("Are you sure you want to delete this?"))
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
                            url: '<?php echo base_url() . 'admin/shipping/picking/delete-order'; ?>',
                            method: 'POST',
                            data: {orders: id},
                            success: function ()
                            {
                                window.location.href = '<?php echo base_url() . "admin/shipping/picking"; ?>';
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