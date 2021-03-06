<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Dashboard</h5>
            <div class="heading-elements"></div> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" name="recent" value="recent" id="recent" class="btn btn-primary" onclick="javascript:void(0)">Create Order</button>
                        <button type="button" name="sold" value="sold" id="sold" class="btn btn-success" onclick="javascript:void(0)">RMA</button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" name="topsellers" value="topsellers" id="topsellers" onclick="displayTopSellers()">Top Sellers</button>
                        <button type="button" name="ready" value="ready" id="ready" class="btn btn-primary" onclick="javascript:void(0)">Top Margin</button>
                        <button type="button" name="recent" value="recent" id="recent" class="btn btn-primary" onclick="javascript:void(0)">Flagged</button>
                        <button type="button" name="sold" value="sold" id="sold" class="btn btn-success" onclick="javascript:void(0)">Inventory</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control" id="keywords" placeholder="Search" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control" id="search_field" >
                                    <option value="part">Part</option>
                                    <option value="serial">Serial</option>
                                    <option value="name">Name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select name="condition" id="condition" class="condition form-control" >
                                <option value="">Select Condition</option>
                                <?php
                                foreach ($condition as $key => $value) {
                                    ?>
                                    <option value="<?= $key ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="grade" id="grade" class="grade form-control" disabled="">
                                <option value="">Select Grade</option>
                                <option value="MN">MN</option>
                                <option value="TN">TN</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="F">F</option>
                                <option value="X">X</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="category1" id="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories as $key => $value) {
                                        ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 category_dropdn">
                            <div class="form-group">
                                <select name="category2" id="category2" disabled="" class="category2 form-control" onchange="get_sub_categories(this.value, 'category3')">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">

                    </div>
                </div>
            </div> 
            <hr>
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary category_btn" onclick="searchFilter()">Search By Filters</button>
                        <button type="button" name="ready" value="ready" id="ready" class="btn btn-primary sale_btn" disabled="" onclick="displayReady()">Ready For Sale</button>
                        <button type="button" name="recent" value="recent" id="recent" class="btn btn-primary recent_btn" onclick="displayRecent()">Recent</button>
                        <button type="button" name="sold" value="sold" id="sold" class="btn btn-success sold_btn" disabled="" onclick="displaySold()">Show Sold</button>
                    </div>
                </div>
            </div>
            <div class="post-list" id="postList">
                <!--                <div>
                                    Select Filters to Reveal Data
                                </div>-->
                <table class="table" id="product_tbl">
                    <thead>
                        <tr>
                            <th>Part #</th>
                            <th>Name</th>
                            <th>Condition</th>
                            <th>Grade</th>
                            <th>Notes/Specs</th>
                            <th>Location</th>
                            <!-- <th>Notes/Specs</th> -->
                        </tr>
                    </thead>
                    <tbody id="userData">
                        <?php if (!empty($posts)): foreach ($posts as $post): ?>
                                <tr>
                                    <td><?php echo $post['part']; ?></td>
                                    <td><?php echo $post['product_name']; ?></td>
                                    <td><?php echo $post['original_condition']; ?></td>
                                    <td><?php echo $post['cosmetic_grade']; ?></td>
                                    <td>
                                        <?php if ($post['fail_text'] != '' || $post['recv_notes'] != '' || $post['packaging_notes'] != '' || $post['inspection_notes'] != '' || $post['cpu'] != '') { ?>
                                            <a href="javascript:;" data-id="<?= $post['id']; ?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?= $post['id']; ?>)"><i class="icon-comment"></i></a>
                                            <a href="javascript:;" data-id="<?= $post['id']; ?>" class="btn-xs btn-default product_specs" onClick="view_specs(<?= $post['id']; ?>)"><i class="icon-info22"></i></a>
                                        <?php } ?></td>
        <!-- <td><?php //echo $post['recv_notes'];               ?></td> -->
                                    <td><?php echo $post['location_name']; ?></td>
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
        <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url() . 'assets/images/loading.gif'; ?>"/></div></div>
    </div>
</div>
<!--  View Business modal -->
<div id="notesModal" class="modal fade notesModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Serial Notes</h4>
            </div>
            <div class="modal-body">
                <div class="notes_details_container">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="specsModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Serial Specs</h4>
            </div>
            <div class="modal-body">
                <div class="specs_details_container">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Audit link modal-->
<div id="auditModal" class="modal fade auditModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Audit</h4>
            </div>
            <div class="modal-body">
                <div class="audit_details_container">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--Audit link modal-->
<!--<script src="assets/js/jquery.dataTables.js?v=1"></script>-->
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript">
                                    function onload() {
                                        $('#product_tbl').hide();
                                        $('#pagination').hide();
                                    }
                                    window.addEventListener('load', onload());

                                    jQuery(document).ready(function ($) {
                                        get_sub_categories('', 'category2');

                                        $(document).on('change', '#search_field', function () {
                                            var search_field = $(this).val();
                                            if (search_field == 'serial') {
                                                $('.sale_btn').prop('disabled', false);
                                                $('.sold_btn').prop('disabled', false);
                                                $('.grade').prop('disabled', false);
                                            } else {
                                                $('.sale_btn').prop('disabled', true);
                                                $('.sold_btn').prop('disabled', true);
                                                $('.grade').prop('disabled', true);
                                            }
                                        });

                                        $(document).on('click', '.flag-item', function (event) {
                                            var part = $(this).data('part');
                                            swal({
                                                title: "Are you sure?",
                                                text: "This will mark this product as flagged!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, make it flagged!",
                                                cancelButtonText: "No, cancel plz!",
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                                    function (isConfirm) {
                                                        if (isConfirm) {
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: '<?php echo base_url() . 'admin/sales/flag_item'; ?>',
                                                                dataType: 'json',
                                                                data: {part: part},
                                                                success: function (resp) {
                                                                    console.log(resp);
                                                                    if (resp.status == 1)
                                                                    {
                                                                        $('.flag-item[data-part=' + part + ']').hide();
                                                                        $('.is-flagged[data-part=' + part + ']').show();
                                                                        swal("Flagged", resp.message, "success");
                                                                    } else if (resp.status == 0)
                                                                    {
                                                                        swal("Error", "Invalid request", "error");
                                                                    }
                                                                }
                                                            })

                                                        } else {
                                                            swal("Cancelled", "", "error");
                                                        }
                                                    });
                                        });

                                        $(document).on('click', '.remove-flag-item', function (event) {
                                            var part = $(this).data('part');
                                            swal({
                                                title: "Are you sure?",
                                                text: "This will remove flag for this product!",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#DD6B55",
                                                confirmButtonText: "Yes, remove it flagged!",
                                                cancelButtonText: "No, cancel plz!",
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            },
                                                    function (isConfirm) {
                                                        if (isConfirm) {
                                                            $.ajax({
                                                                type: 'POST',
                                                                url: '<?php echo base_url() . 'admin/sales/remove_flag_item'; ?>',
                                                                dataType: 'json',
                                                                data: {part: part},
                                                                success: function (resp) {
                                                                    console.log(resp);
                                                                    if (resp.status == 1)
                                                                    {
                                                                        $('.flag-item[data-part=' + part + ']').show();
                                                                        $('.is-flagged[data-part=' + part + ']').hide();
                                                                        swal("Flagged", resp.message, "success");
                                                                    } else if (resp.status == 0)
                                                                    {
                                                                        swal("Error", "Invalid request", "error");
                                                                    }
                                                                }
                                                            })

                                                        } else {
                                                            swal("Cancelled", "", "error");
                                                        }
                                                    });
                                        });

                                        $(document).on('click', '.audit-link', function (event) {
                                            var serial = $(this).data('serial');
                                            if (serial != '') {
                                                $.ajax({
                                                    url: '<?php echo base_url() . 'admin/testing/find_product' ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {serial: serial},
                                                })
                                                        .done(function (response) {
                                                            if (response.status == 1) {
                                                                $(".audit_details_container").html(response.html_data);
                                                                $(".edit-audit").hide();
                                                                $("#auditModal").css('position', 'fixed');
                                                                $("#auditModal").modal('show');

                                                            } else {
                                                                swal("Error", "No data found", "error");
                                                            }
                                                        })
                                                        .fail(function () {
                                                            console.log("error");
                                                        })
                                                        .always(function () {
                                                            console.log("complete");
                                                        });
                                            }
                                        });

                                        $('form').submit(function (event) {
                                            var check_len = $('.check_row:checked').length;
                                            if (check_len == 0) {
                                                alert('please check atleast 1 Serial');
                                                return false;
                                            }
                                            return true;
                                        });
                                    });
                                    
                                    function displayTopSellers(page_num) {
//                                    return false;
                                        var keywords = $('#keywords').val();
                                        var searchfor = $('#search_field').val();
                                        var topsellers = $('#topsellers').val();
                                        page_num = page_num ? page_num : 0;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() . $url; ?>/' + page_num,
                                            data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&topsellers=' + topsellers,
                                            beforeSend: function () {
                                                $('.loading').show();
                                            },
                                            success: function (html) {
                                                $('#postList').html(html);
                                                $('.loading').fadeOut("slow");
                                            }
                                        });
                                    }

                                    function displayReady(page_num) {
                                        var keywords = $('#keywords').val();
                                        var searchfor = $('#search_field').val();
                                        var ready = $('#ready').val();
                                        page_num = page_num ? page_num : 0;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() . $url; ?>/' + page_num,
                                            data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&ready=' + ready,
                                            beforeSend: function () {
                                                $('.loading').show();
                                            },
                                            success: function (html) {
                                                $('#postList').html(html);
                                                $('.loading').fadeOut("slow");
                                            }
                                        });
                                    }
                                    function displayRecent(page_num) {
                                        var keywords = $('#keywords').val();
                                        var searchfor = $('#search_field').val();
                                        var recent = $('#recent').val();
                                        page_num = page_num ? page_num : 0;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() . $url; ?>/' + page_num,
                                            data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&recent=' + recent,
                                            beforeSend: function () {
                                                $('.loading').show();
                                            },
                                            success: function (html) {
                                                $('#postList').html(html);
                                                $('.loading').fadeOut("slow");
                                            }
                                        });
                                    }
                                    function displaySold(page_num) {
                                        var keywords = $('#keywords').val();
                                        var searchfor = $('#search_field').val();
                                        var sold = $('#sold').val();
                                        page_num = page_num ? page_num : 0;
                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() . $url; ?>/' + page_num,
                                            data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&sold=' + sold,
                                            beforeSend: function () {
                                                $('.loading').show();
                                            },
                                            success: function (html) {
                                                $('#postList').html(html);
                                                $('.loading').fadeOut("slow");
                                            }
                                        });
                                    }
                                    function searchFilter(page_num) {
                                        page_num = page_num ? page_num : 0;
                                        var keywords = $('#keywords').val();
                                        var searchfor = $('#search_field').val();
                                        var category1 = $('#category1').val();
                                        var category2 = $('#category2').val();
                                        var condition = $('#condition').val();
                                        var grade = $('#grade').val();
                                        var flag = 1;
                                        if ((keywords == '' && searchfor != 'none')) {
                                            flag = 0;
                                        }
                                        if (flag == 1) {

                                            $.ajax({
                                                type: 'POST',
                                                url: '<?php echo base_url() . $url; ?>/' + page_num,
                                                data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&category1=' + category1 + '&category2=' + category2 + '&condition=' + condition + '&grade=' + grade,
                                                beforeSend: function () {
                                                    $('.loading').show();
                                                },
                                                success: function (html) {
                                                    $('#postList').html(html);
                                                    $('.loading').fadeOut("slow");
                                                }
                                            });
                                        }
                                    }

                                    $('.category_btn').on('click', function () {
                                        var cat1 = ($('.category1')) ? $('.category1').val() : '';
                                        // var cat2 = ($('.category2').attr('disabled') == true) ? $('.category2').val() : '';
                                        var cat2 = $('.category2').val();
                                        console.log(cat1, cat2);
                                        var txt = '';
                                        if (cat1 != '') {
                                            txt += '\"' + cat1 + '\"';
                                            if (cat2 != '') {
                                                txt += ', \"' + cat2 + '\"';
                                            }
                                        }
                                        console.log('txt', txt);
                                    });

                                    function get_sub_categories(cat_id, elem, category = null) {
                                        if (cat_id != '') {
                                            var cat2_name = $('.category2 option[value="' + cat_id + '"]').text();
                                            if (cat2_name == 'Other') {
                                                $('.other_category').css('display', 'block');
                                                if (category != null && category.length > 2)
                                                    $('.other_category').val(category[2]);
                                            } else {
                                                $('.other_category').css('display', 'none');
                                                $.ajax({
                                                    url: '<?php echo $cat_url; ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {category_id: cat_id},
                                                })
                                                        .done(function (response) {
                                                            if (response.result == 1) {
                                                                $('.' + elem).html(response.html_text);

                                                                $('.' + elem).removeAttr('disabled');
                                                            } else {
                                                                $('.' + elem).html('').attr('disabled', true);
                                                            }
                                                            if (elem == 'category2') {
                                                                if (category != null && category.length > 1) {
                                                                    multiselect_selected($('.category2'), category[1]);
                                                                }
                                                                $('.category3').html('').attr('disabled', true);
                                                            }
                                                            if (elem == 'category3') {
                                                                if (category != null && category.length > 2) {
                                                                    multiselect_selected($('.category3'), category[2]);
                                                                }
                                                            }
                                                            // $('.'+elem).multiselect('destroy');
                                                            // $('.'+elem).multiselect();

                                                            // $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
                                                        })
                                                        .fail(function () {
                                                            console.log("error");
                                                        })
                                                        .always(function () {
                                                            console.log("complete");
                                                        });
                                            }
                                        } else {
                                            $('.' + elem).html('').attr('disabled', true);
                                    }
                                    }

                                    function view_notes(serial_id) {
                                        $.ajax({
                                            url: 'admin/inventory/master_sheet/view_notes/' + serial_id,
                                            method: 'post',
                                            success: function (resp) {
                                                resp = JSON.parse(resp);
                                                if (resp.status == 1)
                                                {
                                                    $('#notesModal').find('.notes_details_container').html(resp.data);
                                                } else
                                                {
                                                    $('#notesModal').find('.notes_details_container').html('Not able to load data. Please try again');
                                                }
                                                $('#notesModal').modal('show');
                                                $("#auditModal").css('position', 'absolute');
                                            }
                                        });
                                    }

                                    function view_specs(serial_id) {
                                        $.ajax({
                                            url: 'admin/inventory/master_sheet/view_specs/' + serial_id,
                                            method: 'post',
                                            success: function (resp) {
                                                resp = JSON.parse(resp);
                                                if (resp.status == 1)
                                                {
                                                    $('#specsModal').find('.specs_details_container').html(resp.data);
                                                } else
                                                {
                                                    $('#specsModal').find('.specs_details_container').html('Not able to load data. Please try again');
                                                }
                                                $('#specsModal').modal('show');
                                            }
                                        });
                                    }
</script>



