<style>
    .pallet-btm {
        display: inline-block;
        width: 100%;
    }
    .p_selected{

        background: #fff !important;
        color: #26a69a !important;
        border: 2px solid #26a69a;
        box-shadow: none !important;
    }
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
<div class="row">
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
        <!-- action="admin/barcode/print_labels_barcode" -->
        <!-- action="admin/barcode/print_pallet_labels_barcode" -->
        <form method="post" name="createpallet"  id="createpallet" action="" enctype="multipart/form-data">
            <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="row">
                        <div class="">
                            <h5 class="panel-title"><?= $title ?></h5>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="pallet-btm-wrapper">
                        <div class="pallet-btm">

                            <div class="col-md-4 form-group inputs">
                                <input type="text" value="" name="serial[]" id="serial" class="form-control serial  serial-new" placeholder="Serial Number#">
                                <span id="serial_error" class="not_found_error" style="color:red"></span>
                                <input type="hidden" name="serial_id[]" class="serial_id" value="">
                            </div>
                            <div class="col-md-4 form-group">
                                <select name="condition[]" data-placeholder="Select Original Condition" class="form-control select original_condition">
                                    <?php foreach ($original_condition as $key => $value) { ?>
                                        <option value="<?= $key; ?>"><?= $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="" name="ready_for_sale[]" class="styled ready_for_sale">
                                        Ready for sale
                                    </label>
                                </div>
                                <!--<input type="checkbox" value="" name="ready_for_sale[]" class="styled ready_for_sale"> Ready for sale-->
                            </div>
                            <div class="col-md-2 form-group">
                                <i class="icon-plus-circle2 add_more_row"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 ">
                                <input type="text" name="scan_loc" value="" placeholder="Scan To Location" id="scan_loc" class="form-control scan_loc" >
                                <span id="scan_location_error" class="not_found_error" style="color:red"></span>
                                <input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top: 20px;">
                        <button class="btn bg-teal save"  name="save" type="button">Save</button>
                    </div>


                </div>
            </div>
        </form>
    </div>
</div>
<div class="more" style="display:none;">
    <div class="pallet-btm" >
        <div class="col-md-4 form-group inputs">
            <input type="text" value="" name="serial[]" id="serial" class="form-control serial  serial-new" placeholder="Serial Number#">
            <span id="serial_error" class="not_found_error" style="color:red"></span>
            <input type="hidden" name="serial_id[]" class="serial_id" value="">
        </div>
        <div class="col-md-4 form-group">
            <select name="condition[]" data-placeholder="Select Original Condition" class="form-control select original_condition">
                <?php foreach ($original_condition as $key => $value) { ?>
                    <option value="<?= $key; ?>"><?= $value; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2 form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="" name="ready_for_sale[]" class="styled ready_for_sale">
                    Ready for sale
                </label>
            </div>
        </div>
    </div>
</div>

<div class="hidden_content_div" id="hidden_content_div" style="display:none"></div>
<div id="overlay">
</div>
<script type="text/javascript">
    jQuery(window).load(function () {
        // PAGE IS FULLY LOADED  
        // FADE OUT YOUR OVERLAYING DIV
        $('#overlay').fadeOut();
    });
    jQuery(document).ready(function () {
        var action = '';

        $('.add_more_row').on('click', function () {
            $('.pallet-btm-wrapper').append($('.more').html());
        });

        $('.save').on('click', function () {
            var val = $(".serial-new").val();
            if (val.trim().length !== 0) {
                $('#serial_error').text('');
                get_serial_condition($(this).val(), $(this).parents('.pallet-btm'));
            } else {
                $('#serial_error').html('Please Enter Serial');
                return false;
            }
            var val = $(".scan_loc").val();
            if (val.trim().length !== 0) {
                $('#scan_location_error').text('');
            } else {
                $('#scan_location_error').html('Please Enter scan location');
                return false;
            }
            var serials = [];
            var serial_conditions = [];
            var ready_for_sale = [];
            $('.pallet-btm-wrapper').find('.serial-new').each(function () {
                var serial_val = $(this).val();
                if (serial_val.trim().length !== 0) {
                    serials.push(serial_val);
                } else {
                    $(this).parents('.pallet-btm').find('#serial_error').html('Please Enter Serial');
                    return false;
                }
            });
            $('.pallet-btm-wrapper').find('.original_condition').each(function () {
                serial_conditions.push($(this).val());
            });
            $('.pallet-btm-wrapper').find('.ready_for_sale').each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    ready_for_sale.push(1);
                } else {
                    ready_for_sale.push(0);
                }
            });
            var scan_loc = $('#scan_loc').val();
            console.log('val', scan_loc);

            var data = {serials: serials, serial_conditions: serial_conditions, ready_for_sale: ready_for_sale, scan_loc: scan_loc};
            if (action) {
                data["action"] = action;
            }
            $('#overlay').show();
            $.ajax({
                type: 'POST',
                url: 'admin/receiving/detail_receipt',
                async: false,
                dataType: 'JSON',
                data: data,
                success: function (response) {
                    $('#overlay').fadeOut();
                    if (response.location_found == 0) {
                        swal("Error", "Location you have entered is not exist in database", "error");
                    } else if (response.location_found == 1) {
                        window.location.href = '<?php echo base_url() . "admin/receiving/detail_receipt"; ?>';
                    }
                }
            });

        });

        $(document).on('blur', '.pallet-btm .serial-new', function () {
            var val = $(".serial-new").val();
            if (val.trim().length !== 0) {
                $('#serial_error').text('');
                get_serial_condition($(this).val(), $(this).parents('.pallet-btm'));
            } else {
                $('#serial_error').html('Please Enter Serial');
                return false;
            }
        });

        function get_serial_condition(serial, parentObj) {
            // console.log(parentObj);
            //var part = $('input.part').val();
            if (serial != '') {
                var data = {serial: serial};
                $.ajax({
                    url: '<?php echo $ajax_url; ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                        .done(function (response) {
                            console.log(response);
//                            return false;
                            if (response.product_serial) {
                                parentObj.find('select.original_condition').val(response.product_serial.pocid);
                            } else {
                                swal("Error", 'Serial ' + serial + ' not found in database', "error");
//                                alert('Serial ' + serial + ' not in database');
                                parentObj.find('select.original_condition').val('');
                                parentObj.find('#serial').val('');
                            }
                        })
                        .fail(function () {
                            console.log("error");
                        })
                        .always(function () {
                            console.log("complete");
                        });
            }
        }
    });
</script>
