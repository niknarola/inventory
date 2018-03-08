<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Products</h5>
            <div class="heading-elements">
                <!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
            </div> 
        </div>
        <div class="panel-body">

            <hr>
            <div class="table-responsive">

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="text-search">
                            <label>&nbsp;</label>
                            <input type="text" class="form-control" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
                        </div>
                        <div class="category-search" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $key => $value)
                                        { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 category_dropdn">
                                <div class="form-group">
                                    <label>Sub Category</label><br>
                                    <select name="category2" disabled="true" class="category2 form-control" onchange="get_sub_categories(this.value, 'category3')">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select class="form-control" id="search_field" onchange="searchFilter()">
                            <option value="none">None</option>
                            <option value="part">Part</option>
                            <option value="name">Name</option>
                            <option value="category">Category</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <select class="form-control" id="sortBy" onchange="searchFilter()">
                            <option value="">Sort By</option>
                            <option value="asc">Ascending</option>
                            <option value="desc">Descending</option>
                        </select>
                    </div>
                </div>
                <div class="post-list" id="productList">
                    <table class="table" id="product_tbl">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="check_all" class="check_all" value=""></th>
                                <th>#</th>
                                <th>Part #</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Condition</th>
                            </tr>
                        </thead>
                        <tbody id="userData">
<?php if (!empty($products)): foreach ($products as $product): ?>
                                    <tr>
                                        <td><input type="checkbox" name="check[]" class="check_row" value="<?= $product['id'] ?>"></td>
                                        <td><?php echo $product['id']; ?></td>
                                        <td><?php echo $product['part']; ?></td>
                                        <td><?php echo $product['name']; ?></td>
                                        <td><?php echo $product['description']; ?></td>
                                        <td><?php echo ($product['category'] != null || $product['category'] != '') ? get_category_name($product['category']) : ''; ?></td>
                                        <td><?php echo $product['condition']; ?></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr><td colspan="3">Products(s) not found......</td></tr>
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
<script type="text/javascript" src="assets/js/uniform.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap_multiselect.js"></script>
<script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $(document).on('click', '.check_all', function (event) {
                            if ($(this).is(':checked')) {
                                $('.check_row').prop('checked', true);
                            } else {
                                $('.check_row').prop('checked', false);
                            }
                        });

                        get_sub_categories(1, 'category2');


                    });
                    function searchFilter(page_num) {

                        page_num = page_num ? page_num : 0;
                        var keywords = $('#keywords').val();
                        var searchfor = $('#search_field').val();
                        if (searchfor == 'category') {
                            $('text-search').css('display', 'none');
                            $('category-search').css('display', 'block');
                        } else {
                            $('text-search').css('display', 'block');
                            $('category-search').css('display', 'none');
                        }
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
                    }
                    }
</script>



