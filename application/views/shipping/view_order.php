<!-- Invoice template -->
<div class="panel panel-white">
    <div class="panel-heading">
        <h5 class=""><a href="<?php echo base_url() . 'admin/shipping/shipments'; ?>">Back to Shipments</a></h5>
        <div class="heading-elements">
<!--            <button type="button" class="btn btn-default btn-xs heading-btn"><i class="icon-file-check position-left"></i> Save</button>
            <button type="button" class="btn btn-default btn-xs heading-btn"><i class="icon-printer position-left"></i> Print</button>-->
        </div>
    </div>

    <div class="panel-body no-padding-bottom">
        <div class="row">
            <div class="col-sm-6 content-group">
                <h3><?php echo $store; ?></h3>
                <ul class="list-condensed list-unstyled">
                    <li><?php echo $order['orderStatus']; ?></li>
                </ul>
            </div>

            <div class="col-sm-6 content-group">
                <div class="invoice-details">
                    <h5 class="text-uppercase text-semibold">Order # <?php echo $order['orderNumber'] ?></h5>
                    <ul class="list-condensed list-unstyled">
                        <li>Order Date: <span class="text-semibold"><?php echo $orderDate; ?></span></li>
                        <li>Payment date: <span class="text-semibold"><?php echo $paymentDate; ?></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-4 content-group">
                <span class="text-muted">Bill To:</span>
                <ul class="list-condensed list-unstyled">
                    <li><h5><?php echo $order['billTo']['name']; ?></h5></li>
                    <li><span class="text-semibold"><?php echo ($order['billTo']['company'] != '') ? $order['billTo']['company'] : ''; ?></span></li>
                    <li><?php echo ($order['billTo']['street1'] != '') ? $order['billTo']['street1'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['street2'] != '') ? $order['billTo']['street2'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['street3'] != '') ? $order['billTo']['street3'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['city'] != '') ? $order['billTo']['city'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['state'] != '') ? $order['billTo']['state'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['country'] != '') ? $order['billTo']['country'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['postalCode'] != '') ? $order['billTo']['postalCode'] : ''; ?></li>
                    <li><?php echo ($order['billTo']['phone'] != '') ? $order['billTo']['phone'] : ''; ?></li>
                    <li><a href="mailto:<?php echo ($order['customerEmail'] != '') ? $order['customerEmail'] : ''; ?>"><?php echo ($order['customerEmail'] != '') ? $order['customerEmail'] : ''; ?></a></li>
                </ul>
            </div>

            <div class="col-md-4 col-lg-4 content-group">
                <span class="text-muted">Ship To:</span>
                <ul class="list-condensed list-unstyled">
                    <li><h5><?php echo $order['shipTo']['name']; ?></h5></li>
                    <li><span class="text-semibold"><?php echo ($order['shipTo']['company'] != '') ? $order['shipTo']['company'] : ''; ?></span></li>
                    <li><?php echo ($order['shipTo']['street1'] != '') ? $order['shipTo']['street1'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['street2'] != '') ? $order['shipTo']['street2'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['street3'] != '') ? $order['shipTo']['street3'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['city'] != '') ? $order['shipTo']['city'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['state'] != '') ? $order['shipTo']['state'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['country'] != '') ? $order['shipTo']['country'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['postalCode'] != '') ? $order['shipTo']['postalCode'] : ''; ?></li>
                    <li><?php echo ($order['shipTo']['phone'] != '') ? $order['shipTo']['phone'] : ''; ?></li>
                </ul>
            </div>

            <div class="col-md-4 col-lg-4 content-group">
                <span class="text-muted">Payment Details:</span>
                <ul class="list-condensed list-unstyled invoice-payment-details">
                    <li><h5>Total Amount: <span class="text-right text-semibold"><?php echo ($order['orderTotal'] != '') ? $order['orderTotal'] : 'N/A'; ?></span></h5></li>
                    <li><h5>Paid Amount: <span class="text-right text-semibold"><?php echo ($order['amountPaid'] != '') ? $order['amountPaid'] : 'N/A'; ?></span></h5></li>
                    <li>Tax: <span class="text-semibold"><?php echo ($order['taxAmount'] != '') ? $order['taxAmount'] : 'N/A'; ?></span></li>
                    <li>Payment Method: <span class="text-semibold"><?php echo ($order['paymentMethod'] != '') ? $order['paymentMethod'] : 'N/A'; ?></span></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-lg">
            <thead>
                <tr>
                    <th>Order Items</th>
                    <th class="col-sm-1">Unit $</th>
                    <th class="col-sm-1">Qty</th>
                    <th class="col-sm-1">Total $</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item) { ?>
                    <tr>
                        <td>
                            <div class="media-left">
                                <div class="thumb">
                                    <img src="<?php echo ($item['imageUrl'] != '') ? $item['imageUrl'] : ''; ?>" class="img-responsive img-rounded media-preview" alt="">
                                </div>
                            </div>

                            <div class="media-body item-info">
                                <h6 class="media-heading"><?php echo ($item['name'] != '') ? $item['name'] : ''; ?></h6>
                                <ul class="list-inline list-inline-separate text-muted mb-5">
                                    <li><?php echo ($item['sku'] != '') ? $item['sku'] : ''; ?></li>
                                </ul>
                            </div>
                        </td>
                        <td><?php echo ($item['unitPrice'] != '') ? $item['unitPrice'] : ''; ?></td>
                        <td><?php echo ($item['quantity'] != '') ? $item['quantity'] : ''; ?></td>
                        <td><span class="text-semibold"><?php echo $item['unitPrice'] * $item['quantity']; ?></span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="panel-body">
<!--        <div class="row invoice-payment">
            <div class="col-sm-7">
                <div class="content-group">
                    <h6>Authorized person</h6>
                    <div class="mb-15 mt-15">
                        <img src="assets/images/signature.png" class="display-block" style="width: 150px;" alt="">
                    </div>

                    <ul class="list-condensed list-unstyled text-muted">
                        <li>Eugene Kopyov</li>
                        <li>2269 Elba Lane</li>
                        <li>Paris, France</li>
                        <li>888-555-2311</li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="content-group">
                    <h6>Total due</h6>
                    <div class="table-responsive no-border">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Subtotal:</th>
                                    <td class="text-right">$7,000</td>
                                </tr>
                                <tr>
                                    <th>Tax: <span class="text-regular">(25%)</span></th>
                                    <td class="text-right">$1,750</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td class="text-right text-primary"><h5 class="text-semibold">$8,750</h5></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>-->

        <h6>Order Notes</h6>
        <p><span class="text-semibold">Customer : </span><span class="text-muted"><?php echo ($order['customerNotes'] != '') ? $order['customerNotes'] : 'N/A'; ?></span></p>
        <p><span class="text-semibold">Internal : </span><span class="text-muted"><?php echo ($order['internalNotes'] != '') ? $order['internalNotes'] : 'N/A'; ?></span></p>
    </div>
</div>
<!-- /invoice template -->
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
