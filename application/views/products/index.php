<div class="">
    <div class="panel panel-flat box-wrap">
        <div class="panel-heading">
            <h5 class="panel-title">Products</h5>
            <div class="heading-elements">
                <!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
            </div> 
        </div>
        <div class="panel-body">
            <form class="form-horizontal form-validate" action="" id="" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Search" />
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="search_field" id="search_field" >
                                    <!--<option value="none">None</option>-->
                                    <option value="part">Part</option>
                                    <option value="name">Name</option>
                                    <option value="description">Description</option>
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
                            <div class="col-md-2">
                                <button type="button" class="btn btn-primary category_btn" onclick="searchFilter()">Search By Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="post-list" id="productList">
                            <div id='loader' style="display:none;"><img src='assets/images/2.gif'></div>        
                                <table class="table" id="product_tbl">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Part</th>
                                            <th>Name</th>
                                            <!-- <th>Description</th> -->
                                            <th>Category</th>
                                            <th>Is CTO</th>
                                            <th>Action</th>                
                                        </tr>
                                    </thead>
                                    <tbody id="userData">
                                        <?php if (!empty($products)): foreach ($products as $product): ?>
                                                <tr>
                                                    <td>#<?php echo $product['pid']; ?></td>
                                                    <td><?php echo $product['part']; ?></td>
                                                    <td><?php echo $product['name']; ?></td>
                                                    <!-- <td><?php //echo $product['description']; ?></td> -->
                                                    <td><?php echo ($product['category'] != null || $product['category'] != '') ? get_category_name($product['category']) : ''; ?></td>
                                                    <td><?php echo ($product['is_cto'] == 0) ? 'No' : 'Yes'; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url().'admin/products/view/'.$product['pid']?>" class="btn-xs btn-default product_action_btn"><i class="icon-eye"></i></a>
                                                        <a href="<?php echo base_url().'admin/products/edit/'.$product['pid']?>" class="btn-xs btn-default product_action_btn"><i class="icon-pencil"></i></a>
                                                        <a href="<?php echo base_url().'admin/products/delete/'.$product['pid']?>" class="btn-xs btn-default product_action_btn"><i class="icon-cross2"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <tr><td colspan="3">Products(s) not found......</td></tr>
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
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        get_sub_categories('', 'category2');
    });

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
    
    function searchFilter(page_num) {

        page_num = page_num ? page_num : 0;
        var keywords = $('#keywords').val();
        var searchfor = $('#search_field').val();
        var category1 = $('#category1').val();
        var category2 = $('#category2').val();
        var flag = 1;
        if ((keywords == '' && searchfor != 'part')) {
            // console.log('in if flag0');
            flag = 0;
        }
        if (flag == 1) {
            console.log('in if flag1');
            $('#loader').show();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() . $url; ?>/' + page_num,
                data: 'page=' + page_num + '&keywords=' + encodeURIComponent(keywords) + '&searchfor=' + searchfor + '&category1=' + category1 + '&category2=' + category2,
                beforeSend: function () {
                    $('.loading').show();
                },
                success: function (html) {
                    $('#loader').hide();
                    $('#productList').html(html);
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
    function multiselect_selected($el, values) {
        $el.val(values);
    }
</script>
