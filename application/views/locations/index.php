<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Products</h5>
            <div class="heading-elements">
                <a href="<?= $admin_prefix; ?>inventory/location_master" class="btn bg-teal">Locations Master</a>
            </div> 
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 serieal-location">
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-md-4"><input type="text" name="serial_num" class="form-control serial_num" value="" placeholder="Serial Number"></div>
                        <!-- <div class="col-md-4"><input type="text" name="part_num" class="form-control part_num" value="" placeholder="Part Number"></div> -->
                        <div class="col-md-4"><input type="text" name="location" class="form-control location" value="" placeholder="Location"></div>
                    </div>
                    <div class="row text-center">
                        <button type="button" class="btn btn-sm btn-primary create_location">Create</button>    
                        <button type="button" class="btn btn-sm btn-primary move_location">Move/Modify</button> 
                        <button type="button" class="btn btn-sm btn-primary assign_location">Assign</button>    
                        <button type="button" class="btn btn-sm btn-primary print_location">Print</button>  
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="keyword-none">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input type="text" class="form-control" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
                        </div>
                    </div>
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select class="form-control" id="sortBy" onchange="searchFilter()">
                            <option value="">Sort By</option>
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div> -->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <select class="form-control" id="search_field" onchange="searchFilter()">
                                <option value="none">None</option>
                                <option value="part">Part</option>
                                <option value="name">Name</option>
                                <option value="location">Location</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="post-list" id="postList">
                    <table class="table" id="product_tbl" style="width:99%;">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="check_all" class="check_all" value=""></th>
                                <!-- <th>#</th> -->
                                <th>Print</th>
                                <th>Serial #</th>
                                <th>Part #</th>
                                <th>Name</th>
                                <th>Location/Pallet</th>
                                <th>Condition</th>
                                <th>Notes</th>
                                <th>Move</th>
                                <th>Status</th>                
                            </tr>
                        </thead>
                        <tbody id="userData">
                            <?php if (!empty($posts)): foreach ($posts as $post): ?>
                                    <?php
                                    $status = $post['status'];
                                    if ($status == 'Other')
                                    {
                                        $status = $post['other_status'];
                                    }
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="check[]" class="check_row" value="<?= $post['id'] ?>"></td>
                                        <!-- <td><?php //echo $post['id'];  ?></td> -->
                                        <td><?php if ($post['location_name'] != '')
                                    { ?><a class="print_location" href="<?php echo $print_url . '/' . $post['location_id']; ?>">Print</a><?php } ?></td>
                                        <td><?php echo $post['serial']; ?></td>
                                        <td><?php echo $post['part']; ?></td>
                                        <td><?php echo $post['product_name']; ?></td>
                                        <td><?php echo ($post['location_name'] != '') ? $post['location_name'] . ' / ' . $post['palletid'] : ''; ?></td>
                                        <td><?php echo $post['original_condition']; ?></td>
                                        <td><?php echo $post['recv_notes']; ?></td>
                                        <td><button class="btn-link transfer_location" data-serial="<?php echo $post['serial']; ?>" data-location="<?php echo $post['location_name']; ?>" style="color:#26A69A;" type="button">Transfer Location</button></td>
                                        <td><?php echo ($status != '') ? $status . '<br/>' . $post['modified'] : ''; ?></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr><td colspan="3">Serial(s) not found......</td></tr>
                    <?php endif; ?>
                        </tbody>
                    </table>
<?php echo $this->ajax_pagination->create_links(); ?>
                </div>
            </div>
            <div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url() . 'assets/images/loading.gif'; ?>"/></div></div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).on('click', '.check_all', function (event) {
            if ($(this).is(':checked')) {
                $('.check_row').prop('checked', true);
            } else {
                $('.check_row').prop('checked', false);
            }
        });
        $(document).on('click', '.transfer_location', function (event) {
            var serial = $(this).attr('data-serial');
            var location = $(this).attr('data-location');
            $('.serial_num').val(serial)
            $('.location').val(location)
        });
        $('form').submit(function (event) {
            var check_len = $('.check_row:checked').length;
            if (check_len == 0) {
                alert('please check atleast 1 Serial');
                return false;
            }
            return true;
        });
        $(document).on('click', '.create_location', function (event) {
            var location = $('.location').val();
            if (location != '') {
                $.ajax({
                    url: '<?php echo $ajax_url; ?>/create_location',
                    type: 'POST',
                    dataType: 'json',
                    data: {location: location},
                })
                        .done(function (response) {
                            console.log("response", response);
                            alert(response.msg);
                            //          if(response.status==1){
                            //              alert(response.msg);
                            //          }else{
                            //              alert(response.msg);
                            // }
                        })
                        .fail(function () {
                            console.log("error");
                        })
                        .always(function () {
                            console.log("complete");
                        });
            }
        });
        $(document).on('click', '.assign_location', function (event) {
            var location = $('.location').val();
            var serial = $('.serial_num').val();
            if (location != '' && serial != '') {
                $.ajax({
                    url: '<?php echo $ajax_url; ?>/assign_location',
                    type: 'POST',
                    dataType: 'json',
                    data: {location: location, serial: serial},
                })
                        .done(function (response) {
                            console.log("success");
                            console.log("response", response);
                            alert(response.msg);
                        })
                        .fail(function () {
                            console.log("error");
                        })
                        .always(function () {
                            console.log("complete");
                        });
            }
        });
        $(document).on('click', '.move_location', function (event) {
            var location = $('.location').val();
            var serial = $('.serial_num').val();
            if (location != '' && serial != '') {
                $.ajax({
                    url: '<?php echo $ajax_url; ?>/move_location',
                    type: 'POST',
                    dataType: 'json',
                    data: {location: location, serial: serial},
                })
                        .done(function (response) {
                            console.log("success");
                            console.log("response", response);
                            alert(response.msg);
                        })
                        .fail(function () {
                            console.log("error");
                        })
                        .always(function () {
                            console.log("complete");
                        });
            }
        });
    });
    function searchFilter(page_num) {

        page_num = page_num ? page_num : 0;
        var keywords = $('#keywords').val();
        var searchfor = $('#search_field').val();
        // var sortBy = $('#sortBy').val();
        var flag = 1;
        if ((keywords == '' && searchfor != 'none')) {
            flag = 0;
        }
        if (flag == 1) {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $url; ?>/' + page_num,
                data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor,
                // data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
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
</script>



