<table class="table" id="product_tbl">
<div id='loader' style="display:none;"><img src='assets/images/2.gif'></div>  
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
                    <td><?php echo $product['pid']; ?></td>
                    <td><?php echo ($product['is_flagged'] == 1) ? $product['part'].' <i class="icon-flag3"></i>' : $product['part']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <!-- <td><?php //echo $product['description']; ?></td> -->
                    <td><?php echo ($product['category'] != null || $product['category'] != '') ? get_category_name($product['category']) : ''; ?></td>
                    <td><?php echo ($product['is_cto'] == 0) ? 'No' : 'Yes'; ?></td>
                    <td>
                        <a href="<?php echo base_url() . 'admin/products/view/' . $product['pid'] ?>" class="btn-xs btn-default product_action_btn"><i class="icon-eye"></i></a>
                        <a href="<?php echo base_url() . 'admin/products/edit/' . $product['pid'] ?>" class="btn-xs btn-default product_action_btn"><i class="icon-pencil"></i></a>
                        <a href="<?php echo base_url() . 'admin/products/delete/' . $product['pid'] ?>" class="btn-xs btn-default product_action_btn"><i class="icon-cross2"></i></a>
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
