<?php
if (isset($json))
{
    echo "<script> var data=" . $json . "</script>";
}
else
{
    echo "<script> var data=''</script>";
}
?>
<?php
$get_date = $this->input->get('date');
$start_date = '';
$end_date = '';
if ($get_date != '')
{
    $dates = explode('-', $get_date);
//    $start_date = date('F j, Y', strtotime(@$dates[0]));
//    $end_date = date('F j, Y', strtotime(@$dates[1]));
    $start_date = date('j F Y', strtotime(@$dates[0]));
    $end_date = date('j F Y', strtotime(@$dates[1]));
}
?>

<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Reports</h5>
            <div class="heading-elements"></div> 
        </div>
        <div class="panel-body">
            <form class="form-horizontal form-validate" action="<?php echo base_url('admin/inventory/reports/hp_report'); ?>" id="report_info" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Search" />
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="search_field" id="search_field" >
                                    <option value="none">None</option>
                                    <option value="serial">Serial</option>
                                    <option value="part">Part</option>
                                    <option value="name">Name</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="condition" id="condition" class="condition form-control" >
                                    <option value="">Select Condition</option>
                                    <?php
                                    foreach ($condition as $key => $value)
                                    {
                                        ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="grade" id="grade" class="grade form-control" >
                                    <option value="">Select Grade</option>
                                    <option value="MN">MN</option>
                                    <option value="TN">TN</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="category1" id="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories as $key => $value)
                                    {
                                        ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 category_dropdn">
                                <select name="category2" id="category2" disabled="true" class="category2 form-control" onchange="get_sub_categories(this.value, 'category3')">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <select class="form-control" name="location" id="location">
                                    <option value="">Select Location</option>
                                    <?php
                                    foreach ($locations as $key => $value)
                                    {
                                        ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input  type="radio" name="testing" value="pass">Pass
                                    <input  type="radio" name="testing" value="fail">Fail
                                </div>
                            </div>

                            <div class="col-md-2">
                                <select class="form-control" name="status" id="status">
                                    <option value="0">Select Status</option>
                                    <option value="ready for sale">Ready For Sale</option>
                                    <option value="sold">Sold</option>
                                    <option value="in progress">In Progress</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary category_btn" onclick="searchFilter()">Search By Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="post-list" id="postList">
                                <table class="table" id="product_tbl" style="display:none;">
                                    <thead>
                                        <tr>
                                            <!-- <th><input type="checkbox" name="check_all" class="check_all" value=""></th> -->
                                            <th>#</th>
                                            <th>Serial #</th>
                                            <th>New Serial #</th>
                                            <th>Part #</th>
                                            <th>Name</th>
                                            <th>Condition</th>
                                            <th>Grade</th>
                                            <th>Location</th>
                                            <th>Status</th>                
                                            <th>Notes/Specs</th>                
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
                                                    <!-- <td><input type="checkbox" name="check[]" class="check_row" value="<?= $post['id'] ?>"></td> -->
                                                    <td><?php echo $post['id']; ?></td>
                                                    <td><?php echo $post['serial']; ?></td>
                                                    <td><?php echo $post['new_serial']; ?></td>
                                                    <td><?php echo $post['part']; ?></td>
                                                    <td><?php echo $post['product_name']; ?></td>
                                                    <td><?php echo $post['original_condition']; ?></td>
                                                    <td><?php echo $post['cosmetic_grade']; ?></td>
                                                    <td><?php echo $post['location_name']; ?></td>
                                                    <td><?php echo ($status != '') ? $status . '<br/>' . $post['modified'] : ''; ?></td>
                                                    <td>
                                                    <?php if($post['fail_text'] != '' || $post['recv_notes'] != '' || $post['packaging_notes'] != '' || $post['inspection_notes'] != '' || $post['cpu'] !=''){?>
                                                        <a href="javascript:;" data-id="<?= $post['id'];?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?= $post['id'];?>)"><i class="icon-comment"></i></a>
                                                        <a href="javascript:;" data-id="<?= $post['id'];?>" class="btn-xs btn-default product_specs" onClick="view_specs(<?= $post['id'];?>)"><i class="icon-info22"></i></a>
                                                    <?php } ?>
                                                </td>
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
                    </div>
                </div>
                <h6>Tech Productivity</h6>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            foreach ($tech_name as $key => $tech)
                            {
                                ?>                        
                                <div class="col-md-2">
                                    <a href="javascript:;" class="btn bg-primary-300 tech_btn" data-id="<?= $tech['uid'] ?>" data-name="<?= $tech['user_name']; ?>"> <?= $tech['user_name']; ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-4">
                                <!--<div class="date_div">-->
                                <button type="button" class="btn bg-slate-400 daterange-ranges" id="date_range_pick">
                                    <i class="icon-calendar22 position-left"></i><span>Select Date Range to filter data</span><b class="caret"></b>
                                </button>

                                <?php
                                if ($this->input->get('date'))
                                {
                                    $date = $this->input->get('date');
                                }
                                else
                                {
                                    $date = '';
                                }
                                ?>
                                <input type="hidden" name="date" id="date"  value="<?php echo $date; ?>">
                                <!--</div>-->
                            </div>
                            <div class="col-md-2">
                                <select name="tech_category1" id="tech_category1" class="tech_category1 form-control" onchange="get_sub_categories(this.value, 'tech_category2')">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categories as $key => $value)
                                    {
                                        ?>
                                        <option value="<?= $key ?>"><?= $value ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2 category_dropdn">
                                <select name="tech_category2" id="tech_category2" disabled="true" class="tech_category2 form-control" onchange="get_sub_categories(this.value, 'tech_category3')">
                                    <option value="">Select Sub Category</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary tech_category_btn" onclick="dateFilter()">Click to filter data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="tech_rep">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="post-list table-responsive" id="tech_postList">
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
                                                    <td><?php echo $reports['notebook_count']; ?></td>
                                                    <td><?php echo $reports['desktop_count']; ?></td>
                                                    <td><?php echo $reports['thinclient_count']; ?></td>
                                                    <td><?php echo $reports['allinone_count']; ?></td>
                                                    <td><?php echo $reports['tablet_count']; ?></td>
                                                    <td><?php echo $reports['monitor_count']; ?></td>
                                                    <td><?php echo $reports['printer_count']; ?></td>
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
                                                    <td><?php echo $reports['accessory_count']; ?></td>
                                                    <td><?php echo $reports['other_count']; ?></td>
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
                </div>
                <div class="row" >
                    <div class="col-md-12">
                        <div class="form-group" id="report_tbl" style="display:none">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control" name="select_data" id="select_data" >
                                        <option value="">Select Reports to Download</option>
                                        <option value="0">All Reports</option>
                                        <option value="1">HP Reports</option>
                                        <option value="2">Refurbished QC Reports</option>
                                        <option value="3">Aging Inventory Reports</option>
                                        <option value="4">Tech Reports</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-success"  type="submit" >Download Reports</button>
                            </div>                    
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="notesModal" class="modal fade" role="dialog">
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
<script type="text/javascript">
    function onload() {
        $('#product_tbl').hide();
        $('#pagination').hide();
    }       
    window.addEventListener('load', onload());


    $('.tech_btn').on('click', function () {
        var tech_id = $(this).data("id");
        var tech_name = $(this).data("name");
        var category1 = $('#tech_category1').val();
        var category2 = $('#tech_category2').val();
        console.log(category1);
        console.log(category2);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'admin/inventory/reports/reports_results'; ?>',
            data: {
                id: tech_id,
                name: tech_name,
                date: '<?php echo $this->input->get('date') ?>',
                category1: category1,
                category2: category2,
            },
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (resp) {
                resp = JSON.parse(resp);
                if (resp.status === 1)
                {
                    $('#report_tbl').show();
                    $('#report_tbl').html(resp.data);
                } else
                {
                    $('#report_tbl').show();
//                    $('#report_tbl').html(resp.msg);
                    $('#report_tbl').html('No data found between these dates.');
                }
                $('.loading').fadeOut("slow");
            }
        });
    })


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

    $('.tech_category_btn').on('click', function () {
        var cat1 = ($('.tech_category1')) ? $('.tech_category1').val() : '';
        // var cat2 = ($('.category2').attr('disabled') == true) ? $('.category2').val() : '';
        var cat2 = $('.tech_category2').val();
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


    function dateFilter() {
        var category1 = $('#tech_category1').val();
        var category2 = $('#tech_category2').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() . 'admin/inventory/reports/tech_reports'; ?>',
            data: {
                date: '<?php echo $this->input->get('date') ?>',
                category1: category1,
                category2: category2,
            },
            beforeSend: function () {
                $('.loading').show();
            },
            success: function (resp) {
                resp = JSON.parse(resp);
                if (resp.status === 1)
                {
                    $('#tech_postList').hide();
                    $('#tech_rep').html(resp.data);
                } else
                {
                    $('#tech_rep').html('Not able to load data. Please try again');
                }
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
        var location = $('#location').val();
        var testing = $("input[name='testing']:checked").val();
        var status = $('#status').val();
        var date = '<?php echo $this->input->get('date') ?>';
        var flag = 1;
        if ((keywords == '' && searchfor != 'none')) {
            flag = 0;
        }
        if (flag == 1) {

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $url; ?>/' + page_num,
                data: 'page=' + page_num + '&keywords=' + keywords + '&searchfor=' + searchfor + '&category1=' + category1 + '&category2=' + category2 + '&condition=' + condition + '&grade=' + grade + '&location=' + location + '&testing=' + testing + '&status=' + status + '&date=' + date,
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



    $(function () {
        var get = '<?php echo $this->input->get('date') ?>';
        if (get != "") {
            var res = get.split('-');
            start = res[0];
            end = res[1];
//alert('hi');
            $("#date_range_pick").daterangepicker({
                startDate: start,
                endDate: end,
                maxDate: moment(),
//                opens: 'left',
                ranges: {
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 12 Months': [moment().startOf('year'), moment().endOf('year')],
//                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                alwaysShowCalendars: true,
            },
                    function (start, end) {
                        $('.daterange-ranges span').html(start.format('d. MMMM YYYY') + ' &nbsp; - &nbsp; ' + end.format('d. MMMM YYYY'));
                    }
            );
            $('#date_range_pick span').html('<?php echo $start_date ?>' + ' &nbsp; - &nbsp; ' + '<?php echo $end_date ?>');

        } else {
            //var start = moment().subtract(6, 'days');
            //var end = moment();
            $("#date_range_pick").daterangepicker({
                autoUpdateInput: false,
                maxDate: moment(),
                //opens: 'left',
                ranges: {
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'Last 12 Months': [moment().startOf('year'), moment().endOf('year')],
//                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                alwaysShowCalendars: true,
            });
        }

        $('#date_range_pick').on('apply.daterangepicker', function (ev, picker) {
            var url = window.location.href;
            var newurl = updateQueryStringParameter(url, "date", picker.startDate.format('MM/DD/YYYY') + '-' + picker.endDate.format('MM/DD/YYYY'));
            $('#date_range_pick span').html(picker.startDate.format('D MMMM YYYY') + ' &nbsp; - &nbsp; ' + picker.endDate.format('D MMMM YYYY'));
            window.location.href = newurl;
        });

        $('#date_range_pick').on('cancel.daterangepicker', function (ev, picker) {
            if ($('#date_range_pick span').html() != '') {
                var url = window.location.href;
                var newurl = updateQueryStringParameter(url, "date", '');
                window.location.href = newurl;
            }
            $('#date_range_pick span').html('');
        });

        $('#date_range_pick').on('cancel.daterangepicker', function (ev, picker) {
            $('date_range_pick span').html('');
        });

    });

    function updateQueryStringParameter(uri, key, value) {
        var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        var separator = uri.indexOf('?') !== -1 ? "&" : "?";
        if (uri.match(re)) {
            return uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            return uri + separator + key + "=" + value;
        }
    }

    function view_notes(serial_id){
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
                }
            });
    }

    function view_specs(serial_id){
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



