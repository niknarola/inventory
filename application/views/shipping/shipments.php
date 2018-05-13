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
            <h5 class="panel-title">Shipments</h5>
        </div>
        <div class="table-responsive">
            <form action="" method="post">
                <div class="col-md-12">
                    <div class="picking-actions">
                        <a href="<?php echo base_url() . 'admin/shipping/shipments'; ?>" class="btn bg-teal-400" id="sync">Refresh</a>
                        <a href="<?php echo base_url() . 'admin/shipping/shipments/today'; ?>" class="btn bg-teal-400 date_filter <?php echo ($filter == 'today') ? 'active' : ''; ?>" data-val="today">Today</a>
                        <a href="<?php echo base_url() . 'admin/shipping/shipments/this-week'; ?>" class="btn bg-teal-400 date_filter <?php echo ($filter == 'this-week') ? 'active' : ''; ?>" data-val="week">This Week</a>
                    </div>
                    <table class="table datatable-basic" id="orders_tbl">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Date</th>
                                <th>Ship Date</th>
                                <th>Order #</th>
                                <th>Site</th>
                                <th>Part #</th>
                                <th>Additional Info</th>
                                <th>Serial #</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>Order notes</th>
                                <th>Tracking</th>
                                <th style="display: none;">hide</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($shipments) {
                                $i = 1;
                                $cls = 0;
                                $CI = & get_instance();
                                foreach ($shipments as $shipment) {
                                    $order = $shipment['order_details'];
                                    $today = date('m/d/Y');
//                                    $orderDate = date_format(date_create_from_format('Y-m-d', $shipment['createDate']), 'd-m-Y');
                                    $orderDate = $shipment['shipDate'];
//                                    $order_items = $CI->get_all_data_by_criteria($order['order_number']);
                                    ?>
                                    <?php
                                    $itemcnt = 1;
                                    if (!empty($shipment['shipmentItems'])) {
                                        foreach ($shipment['shipmentItems'] as $item) {

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
                                            ?>
                                            <tr class="" id='order_<?php echo $item['orderItemId']; ?>'>
                                        <input class="order_item_id" type="hidden" name="order_item_id" value="<?php echo $item['orderItemId']; ?>">
                                        <input class="order_id" type="hidden" name="order_id" value="<?php echo $shipment['orderId']; ?>">
                                        <input type="hidden" name="order_number" id="order_number" value="<?php echo $shipment['orderNumber']; ?>">
                                        <input type="hidden" name="part" id="part" value="<?php echo $part; ?>">
                                        <input type="hidden" name="additional_part_info" id="additional_part_info" value="<?php echo $additional_part_info; ?>">
                                        <input type="hidden" name="store" id="store" value="<?php echo $shipment['site']; ?>">
                                        <input type="hidden" name="product_name" id="product_name" value="<?php echo $item['name']; ?>">
                                        <?php if ($itemcnt == 1) { ?>
                                            <td><?php echo $i; ?></td>
                                            <td class="order_date"><?php echo $orderDate; ?></td>
                                            <td class="ship_date"><?php echo $shipment['shipDate']; ?></td>
                                            <td class="order_number"><?php echo $shipment['orderNumber']; ?></td>
                                            <td class="store"><?php echo $shipment['site']; ?></td>
                                        <?php } else { ?>
                                            <td>&nbsp;</td>
                                            <td class="noselect store" style="color: #6772e500;"><?php echo $orderDate; ?></td>
                                            <td class=""><?php echo $shipment['shipDate']; ?></td>
                                            <td class="noselect order_number" style="color: #6772e500;"><?php echo $shipment['orderNumber']; ?></td>
                                            <td class="noselect store" style="color: #6772e500;"><?php echo $order['site']; ?></td>
                                        <?php } ?>
                                        <td><?php echo $part; ?></td>
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
                                                    <span><?php echo $k . '/' . $qty . ' '; ?></span><span class="<?php echo $cls; ?>"><?php echo $order_item['serial'] . $status; ?></span>
                                                    <span>
                                                        <?php if (!empty($order_item['serial'])) { ?>
                                                            <a class="scan-link" data-serial="<?php echo $order_item['serial']; ?>" data-scan_type="edit" data-part="<?php echo $part; ?>" data-order="<?php echo $item['orderItemId']; ?>" href="javascript:void(0);"><i class="icon-pencil"></i></a>
                                                            <a class="scan-link" data-serial="<?php echo $order_item['serial']; ?>" data-scan_type="remove" data-part="<?php echo $part; ?>" data-order="<?php echo $item['orderItemId']; ?>" href="javascript:void(0);"><i class="icon-cross3"></i></a>
                                                        <?php } else { ?>
                                                            <a class="scan-link" data-serial="" data-scan_type="add" data-part="<?php echo $item['part']; ?>" data-order="<?php echo $item['orderItemId']; ?>" href="javascript:void(0);"><i class="icon-plus22"></i></a>
                                                        <?php } ?>
                                                    </span>
                                                    <br>
                                                    <?php
                                                    $k++;
                                                    $qty_count++;
                                                    $order_item_qty--;
                                                }
                                            }
                                            if ($order_item_qty > 0) {
                                                ?>
                                                <?php for ($j = $qty_count; $j <= $qty; $j++) { ?>
                                                    <span><?php echo $j . '/' . $qty . ' - '; ?></span><span>Not Awailable</span>
                                                    <span>
                                                        <a class="scan-link" data-serial="" data-scan_type="add" data-part="<?php echo $part; ?>" data-order="<?php echo $item['orderItemId']; ?>" href="javascript:void(0);"><i class="icon-plus22"></i></a>
                                                    </span>
                                                    <br>
                                                <?php }
                                                ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            Shipped<?php // echo ($order['order_status'] == 2 ? 'Shipped' : '');   ?>
                                        </td>
                                        <?php
                                        $carriercode = $shipment['carrierCode'];
                                        if ($carriercode == 'fedex') {
                                            $track_url = TRACK_FEDX . '?action=track&language=english&tracknumbers=' . $shipment['trackingNumber'];
                                        } elseif ($carriercode == 'stamps_com') {
                                            $track_url = TRACK_USPS . '?tLabels=' . $shipment['trackingNumber'];
                                        }
                                        ?>
                                        <td><a href="<?php echo base_url() . 'admin/shipping/view-order/' . base64_encode($shipment['orderId']); ?>" data-id="<?php echo $shipment['orderNumber']; ?>" class="">View Order</a>
                                            <br><a target="_BLANK" href="<?php echo $track_url; ?>" data-id="<?php echo $shipment['orderNumber']; ?>" class="">Track</a></td>
                                        <td><a href="javascript:;" data-id="<?php echo $shipment['orderNumber']; ?>" class="btn-xs btn-default order_notes" onClick="view_order_notes(<?php echo $item['orderItemId']; ?>)"><i class="icon-comment"></i></a></td>
                                        <td>
                                            <span><a target="_BLANK" href="<?php echo $track_url; ?>" ><?php echo $shipment['trackingNumber']; ?></a></span><br>
                                            <span><?php echo $carriercode; ?></span>
                                        </td>
                                        <td style="display: none;"></td>
                                        </tr>
                                        <?php
                                        $itemcnt++;
                                    }
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
                                            <textarea class="form-control" name="order_notes" id="order_notes" readonly=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="submit" class="btn btn-success">Save</button>-->
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
    <!-- scan form modal -->
    <div id="modal_form_scan" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title">Scan for serial</h5>
                </div>

                <form action="<?php base_url(); ?>admin/shipping/manage_serial_scan" class="form-inline" name="scanSerialForm" method="post" id="scanSerialForm">
                    <span class="serial-msg" style="color: red;"></span>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label>Enter Serial: </label>
                            <input type="text" name="serial" placeholder="Enter Serial Number" class="form-control">
                            <input type="hidden" name="old_serial" value="" id="old_serial" class="form-control">
                            <input type="hidden" name="part" value="" id="scan_part_number" class="form-control">
                            <input type="hidden" name="order_number" value="" id="scan_order_number" class="form-control">
                            <input type="hidden" name="orderid" value="" id="orderid" class="form-control">
                            <input type="hidden" name="scanType" value="" id="scanType" class="form-control">
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

                <form action="<?php base_url(); ?>admin/shipping/manage_order" class="form-inline" name="manageOrderForm" method="post" id="manageOrderForm">
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <h5 class="part_msg"></h5>
                            <input type="hidden" name="scanType" id="scanned_type" value="" class="form-control">
                            <input type="hidden" name="scanned_store" id="scanned_store" class="form-control">
                            <input type="hidden" name="scanned_serial" id="scanned_serial" class="form-control">
                            <input type="hidden" name="old_scan_serial" value="" id="old_scan_serial" class="form-control">
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
                                    "aoColumnDefs": [{"bSortable": false, "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]}],
                                    "pageLength": 10,
                                    "order": [12, "asc"],
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

                                $(".scan-link").click(function () {
                                    var scan_type = $(this).data('scan_type');
                                    var old_serial = $(this).data('serial');
                                    var order_item = $(this).data('order');
                                    var part = $('tr#order_' + order_item).find('input#part').val();
                                    var order_number = $('tr#order_' + order_item).find('input#order_number').val();
                                    var order_id = $('tr#order_' + order_item).find('td.order_id').text();
                                    if (scan_type == 'remove') {
                                        var serial = $(this).data('serial');
                                        if (confirm("Are you sure you want to remove this?"))
                                        {
                                            $('#overlay').show();
                                            $.ajax({
                                                url: '<?php echo base_url() . 'admin/shipping/remove_serial'; ?>',
                                                method: 'POST',
                                                data: {serial: serial, part: part, order_item_id: order_item},
                                                success: function (data)
                                                {
                                                    window.location.href = '<?php echo base_url() . "admin/shipping/shipments"; ?>';
                                                    $('#overlay').fadeOut();
                                                }

                                            });

                                        } else
                                        {
                                            return false;
                                        }
                                    } else {
                                        $("#scanType").val(scan_type);
                                        $("#scan_part_number").val(part);
                                        $("#scan_order_number").val(order_number);
                                        $("#old_serial").val(old_serial);
                                        $("#orderid").val(order_item);
                                        $("#modal_form_scan").modal();
                                    }
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
//                                            console.log(data);
//                                            return false;
                                            if (data.isserialexist == 1) {
                                                if (data.serial_status == 'sold') {
                                                    $(".serial-msg").html('Serial # <b>' + data.serial + '</b> is SOLD!');
                                                } else {
                                                    var scanType = data.scanType;
                                                    var partmatch = data.partmatch;
                                                    var scanned_part = data.part;
                                                    var order_item = data.orderId;
                                                    var scanned_order = $('tr#order_' + order_item).find('input#order_number').val();
                                                    var scanned_product_name = $('tr#order_' + order_item).find('input#product_name').text();
                                                    var scanned_order_total_qty = $('tr#order_' + order_item).find('td.qty').text();
                                                    var scanned_additional_part_info = $('tr#order_' + order_item).find('input#additional_part_info').val();
                                                    var scanned_store = $('tr#order_' + order_item).find('input#store').text();
                                                    var scanned_order_item_id = $('tr#order_' + order_item).find('input.order_item_id').val();
                                                    var scanned_serial = data.serial;
                                                    var old_scan_serial = data.old_serial;
                                                    var msg = '';
                                                    if (partmatch == 0) {
                                                        msg = 'Part # not a match!';
                                                    } else if (partmatch == 1) {
                                                        msg = 'Part # matched!';
                                                    }
                                                    $(".part_msg").text(msg);
                                                    $("#scanned_type").val(scanType);
                                                    $("#scanned_serial").val(scanned_serial);
                                                    $("#old_scan_serial").val(old_scan_serial);
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

                                $(".cancel-scan").click(function () {
                                    $("#modal_form_approve").modal('hide');
                                    return false;
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
                            });
    </script>