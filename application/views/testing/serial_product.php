<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Search Results</h5>
            <div class="heading-elements">
                <!-- <button type="button" data-href="admin/role/add" class="btn bg-teal add_role">Add Role</button> -->
            </div>
		</div>
		<?php //pr($product);die;?>
        <div class="panel-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Serial Number:</label>
                            <input  class="form-control" type="text" name="serial" value="<?= $product['serial']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>New Serial Number:</label>
                            <input class="form-control" type="text" name="new_serial" value="<?= $product['new_serial'];?>">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Part Number:</label>
                            <input class="form-control" type="text" name="part" value="<?= $product['part']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Tech ID:</label>
                            <input  class="form-control" type="text" name="part" value="<?= $product['username']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>PO ID:</label>
                            <input class="form-control" type="text" name="part" value="<?= $product['username']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Received Condition:</label>
                            <select name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
                                <?php 
                                foreach ($original_condition as $key => $value) {?>
                                   <option <?php echo ($key == $product['original_condition_id']) ? 'selected' : '' ?> value="<?= $key; ?>"><?= $value; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Grade:</label>
                            <input type="text" class="form-control" type="text" name="part" value="<?= $product['cosmetic_grade'] ?>">
                            <!-- <select name="grade" data-placeholder="Select Grade" class="form-control select grade">
                                <?php //foreach ($original_condition as $key => $value) { ?>
                                    <option value="MN">MN - Manufacturer New</option>
                                    <option value="TN">TN - Tested New</option>
                                    <option value="B">B - Light Scratches</option>
                                    <option value="C">C - Deep Scratches</option>
                                    <option value="F">F - Fail</option>
                                    <option value="X">X - Unsellable</option>
                                <?php //}  ?>
                            </select> -->
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Final Condition:</label>
                            <select name="final_condition" data-placeholder="Select Final Condition" class="form-control select original_condition">
                                <?php foreach ($original_condition as $key => $value) { ?>
                                    <option value="<?= $key; ?>"><?= $value; ?></option>
                                <?php }  ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Memory:</label>
                            <input type="text" class="form-control" type="text" name="part" value="<?= $product['memory'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>CPU:</label>
                            <textarea  class="form-control" type="text" name="part"><?= ($product['cpu']!=null) ? implode(',',json_decode($product['cpu'], true)) : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
						<label>Storage:</label>
                            <textarea class="form-control" type="text" name="part">
							<?php foreach(json_decode($product['storage']) as $key => $value){ 
							$ssd = json_decode($product['ssd']);
							if($ssd[$key] == 0){
								echo $value.'<br>';
							}
							else{
								echo $value.'(ssd)<br>';
							}
						}?>
							</textarea>
							<?//= ($product['storage']!=null) ? implode(',',json_decode($product['storage'], true)) : ''; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Graphics:</label>
                            <textarea class="form-control" type="text" name="part"><?= ($product['graphics']!=null) ? implode(',',json_decode($product['graphics'], true)) : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Screen:</label>
                            <input type="text" class="form-control" type="text" name="part" value"<?= $product['screen'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>OS:</label>
                            <input type="text" class="form-control" type="text" name="part" value="<?= $product['os'] ?>">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="javascript:;" class="btn bg-teal-400 add_btn" data-id="<?= $product['id'];?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?= $product['id'];?>)">View Notes</a>
                        <a href="<?php echo base_url().'admin/testing/edit_audit_record/'.$product['id']?>" class="btn bg-teal-400 add_btn" data-id="<?= $product['id'];?>" class="btn-xs btn-default product_specs"> Edit/Remove</a>
                    </div>
        </div>
    </div>
</div>
