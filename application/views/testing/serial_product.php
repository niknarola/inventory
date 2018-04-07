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
                            <input  class="form-control" type="text" name="serial" value="<?= $product['serial'];?>">
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
                            <input  class="form-control" type="text" name="tech" value="<?= $product['username']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>PO ID:</label>
                            <input class="form-control" type="text" name="po" value="<?= $product['username']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Received Condition:</label>
                            <select name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
                                <?php
foreach ($original_condition as $key => $value) {?>
                                   <option <?php echo ($key == $product['original_condition_id']) ? 'selected' : '' ?> value="<?=$key;?>"><?=$value;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Grade:</label>
                            <input type="text" class="form-control" type="text" name="cosmetic_grade" value="<?= $product['cosmetic_grade']?>">
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
                                <?php foreach ($original_condition as $key => $value) {?>
                                    <option value="<?=$key;?>"><?=$value;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Memory:</label>
                            <input type="text" class="form-control" type="text" name="memory" value="<?= $product['memory']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>CPU:</label>
                            <textarea  class="form-control" type="text" name="cpu"><?= (isset($product['cpu']) && $product['cpu'] != "null") ? implode(',', json_decode($product['cpu'], true)) : '';?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
						<label>Storage:</label>
						<?php
						
                        $new_sto_ssd = ''; 
                        // if()
							foreach (json_decode($product['storage']) as $key => $value) {
								$ssd = json_decode($product['ssd']);
								if ($ssd[$key] == 0) {
									$new_sto_ssd = $new_sto_ssd.$value . ',';
								} else {
									$new_sto_ssd = $new_sto_ssd.$value . '(ssd),';
								}
							}
							$length = strlen($new_sto_ssd) - 1;
							$new_sto_ssd = substr($new_sto_ssd, 0, $length);
							?>
                            <textarea class="form-control" type="text" name="storage"><?= $new_sto_ssd; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Graphics:</label>

						<?php
						
						$new_gra_ded = ''; 
							foreach (json_decode($product['graphics']) as $key => $value) {
								$dedicated = json_decode($product['dedicated']);
								if ($dedicated[$key] == 0) {
									$new_gra_ded = $new_gra_ded.$value . ',';
								} else {
									$new_gra_ded = $new_gra_ded.$value . '(dedicated),';
								}
							}
							$length = strlen($new_gra_ded) - 1;
							$new_gra_ded = substr($new_gra_ded, 0, $length);
							?>
                            <textarea class="form-control" type="text" name="graphics"><?= $new_gra_ded; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>Screen:</label>
                            <input type="text" class="form-control" type="text" name="screen" value="<?= $product['size'].' '.$product['screen'].' '.$product['resolution']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                        <label>OS:</label>
                            <input type="text" class="form-control" type="text" name="os" value="<?= $product['os']?>">
                        </div>
                    </div>
					<div class="col-md-4">
					<div class="form-group">
                        <label>Additional Info/Accessories:</label>
                            <textarea  class="form-control" type="text" name="cpu"><?= $product['additional_info'];?></textarea>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="form-group">
                            <label>Item Location:</label>
                            <input class="form-control" type="text" name="location" value="<?= $product['pallet']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Physical Location:</label>            
                            <input class="form-control" type="text" name="physical_location" value="<?= $product['locationname']?>">
                        </div>
                    </div>
					<div class="col-md-4">
					<div class="form-group">
                        <label>Other Features:</label>
						<div class="row">
                           <div class="col-md-6">
                              <div class="input-group" style="margin-bottom:5px;">
                                 <span class="input-group-addon">
								 <?php
								 $checked = '';
								 if($product['touch_screen'] == 0){
									$checked = '';
								 }else{
									$checked = 'checked = "checked"';
								 }?>
                                 <input  type="checkbox" <?= $checked;?> value="1" name="touchscreen" class="checkbx touchscreen">
                                 </span>
                                 <label class="check_label">Touch Screen</label>
                              </div>
                           </div>
                           <div class="col-md-6">
                                <div class="input-group" style="margin-bottom:5px;">
                                 <span class="input-group-addon">
								 <?php
								 $checked = '';
								 if($product['optical_drive'] == 0){
									$checked = '';
								 }else{
									$checked = 'checked = "checked"';
								 }?>
                                 <input   type="checkbox" <?= $checked;?> value="1" name="optical_drive" class="checkbx optical_drive">
                                 </span>
                                 <label class="check_label">Optical Drive</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="input-group">
                                 <span class="input-group-addon">
								 <?php
								 $checked = '';
								 if($product['webcam'] == 0){
									$checked = '';
								 }else{
									$checked = 'checked = "checked"';
								 }?>
                                 <input <?= $checked;?> type="checkbox" value="1" name="webcam" class="checkbx webcam">
                                 </span>
                                 <label class="check_label">No Webcam</label>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="input-group">
                                 <span class="input-group-addon">
								 <?php
								 $checked = '';
								 if($product['tgfg_capable'] == 0){
									$checked = '';
								 }else{
									$checked = 'checked = "checked"';
								 }?>
                                 <input   <?= $checked;?> type="checkbox" value="1" name="tgfg_capable" class="checkbx tgfg_capable">
                                 </span>
                                 <label class="check_label">Sim Capable</label>
                              </div>
                           </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <a href="javascript:;" class="btn bg-teal-400 add_btn" data-id="<?=$product['id'];?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?=$product['id'];?>)">View Notes</a>
                        <a href="<?php echo base_url() . 'admin/testing/edit_audit_record/' . $product['id'] ?>" class="btn bg-teal-400 add_btn" data-id="<?=$product['id'];?>" class="btn-xs btn-default product_specs"> Edit/Remove</a>
                    </div>
        </div>
    </div>
</div>
