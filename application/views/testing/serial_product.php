<div class="col-md-12">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">Search Results</h5>
		</div>
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
					
					<?php $cat = json_decode($product['category']); foreach($cat as $k => $v){ ?>
					<?php if($v == 4 || $v ==  3 || $v == 2 || $v == 8 || $v == 9){?>
						<div class="memory">
							<div class="col-md-4">
								<div class="form-group">
								<label>Memory:</label>
									<input type="text" class="form-control" type="text" name="memory" value="<?= $product['memory']?>">
								</div>
							</div>
						</div>
						<div class="cpu-storage-graphics" >
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
								// pr($product['storage']);die;
								$new_sto_ssd = ''; 
								if(isset($product['storage']) && isset($product['ssd']))
								{
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
								}
									?>
									<textarea class="form-control" type="text" name="storage"><?= $new_sto_ssd; ?></textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								<label>Graphics:</label>

								<?php
								
								$new_gra_ded = '';
								if(isset($product['storage']) && isset($product['ssd']))
								{ 
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
								}
									?>
									<textarea class="form-control" type="text" name="graphics"><?= $new_gra_ded; ?></textarea>
								</div>
							</div>
						</div>
						<div class="os" >
							<div class="col-md-4">
								<div class="form-group">
								<label>OS:</label>
									<input type="text" class="form-control" type="text" name="os" value="<?= $product['os']?>">
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if($v == 4 || $v == 2 || $v == 5 || $v == 8){?>
						<div class="screen" >
							<div class="col-md-4">
								<div class="form-group">
									<label>Screen:</label>
									<input type="text" class="form-control" type="text" name="screen" value="<?= $product['screen'].'  '.$product['resolution'].'  '. $product['size'] ?>">
								</div>
							</div>
						</div>
					<?php } ?>
					<?php if($v == 3 || $v == 9){?>
						<div class="form-factor" >
							<di	v class="col-md-4">
								<div class="form-group">
									<label>Form Factor:</label>
									<input type="text" class="form-control" type="text" name="form_factor" value="<?= $product['form_factor']?>">
									</div>
							</di>
						</div>
					<?php } ?>
		<!-- ===================================Locations============================== -->
					<div class="col-md-4">
                        <div class="form-group">
                            <label>Item Location:</label>
                            <input class="form-control" type="text" name="serial_location_name" value="<?= $product['pallet']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Physical Location:</label>            
                            <input class="form-control" type="text" name="pallet_location_name" value="<?= $product['pallet_location_name']?>">
                        </div>
                    </div>
					<div class="col-md-4">
						<div class="form-group">
                        	<label>Additional Info/Accessories:</label>
                            <textarea  class="form-control" type="text" name="cpu"><?= $product['additional_info'];?></textarea>
                        </div>
                    </div>
		<!-- ===================================Locations============================== -->
				<?php if($v == 6) {?>
					<div class="cat-6" data-category="6" data-name="Printers">
						<div class="col-md-12 edit">
							<div class="col-md-4">
								<div class="form-group">
									<label>Physical Inspection</label>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
											<?php
												$checked='';
												$print = '';
												if(isset($product['physical_inspection_fields']) && !empty($product['physical_inspection_fields'])){
													$print = json_decode($product['physical_inspection_fields']);
													if($print->missing_tray == 1 || $print->missing_ink_toner == 1 || $print->broken_glass == 1 || $print->physical_damage == 1){
														$checked = 'checked="checked"';
													}else{
														$checked = '';
													}
												
											?>
												<span class="input-group-addon">
													<input type="checkbox" value="1" <?= $checked;?> name="missing_tray" class="missing_tray checkbx">
												</span>
												<input type="text" class="form-control" value="Missing Tray" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control missing_tray_ui" name="missing_tray_ui" value="<?= $print->missing_tray_ui?>" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" <?= $checked;?> name="missing_ink_toner" class="missing_ink_toner checkbx">
												</span>
												<input type="text" class="form-control" value="Missing Ink/Toner" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control missing_ink_toner_ui" name="missing_ink_toner_ui" value="<?= $print->missing_ink_toner_ui?>" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" <?= $checked;?> name="broken_glass" class="broken_glass checkbx">
												</span>
												<input type="text" class="form-control" value="Broken Glass" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control broken_glass_ui" name="broken_glass_ui" value="<?= $print->broken_glass_ui?>" placeholder="User Input"></div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" <?= $checked;?> name="physical_damage" class="physical_damage checkbx">
												</span>
												<input type="text" class="form-control" value="Physical Damage" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control physical_damage_ui" name="physical_damage_ui" value="<?= $print->physical_damage_ui?>" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-12">
											<textarea placeholder="User Input" class="form-control pi_ui" rows="3" cols="3" name="pi_ui"><?= $print->physical_inspection_ui?></textarea>
										</div>
									</div>
												<?php }?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-12">
									<div class="form-group">
									<label>Testing:</label>
									<?php
										$checked='';
										$test = '';
										if(isset($product['printer_testing_fields']) && !empty($product['printer_testing_fields'])){
											$test = json_decode($product['printer_testing_fields']);
											if($test->no_power == 1 || $test->not_loading == 1 || $test->loud_noise == 1 || $test->paper_jam == 1 || $test->ink_system == 1){
												$checked = 'checked="checked"';
											}else{
												$checked = '';
											}
										
									?>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" <?= $checked;?> name="no_power" class="no_power checkbx">
													</span>
													<input type="text" class="form-control" value="No Power" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control no_power_ui" name="no_power_ui" value="<?=$test->no_power_ui?>" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" <?= $checked;?> name="not_loading" class="not_loading checkbx">
													</span>
													<input type="text" class="form-control" value="Not Loading" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control not_loading_ui" name="not_loading_ui" value="<?=$test->not_loading_ui?>" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" <?= $checked;?> name="loud_noise" class="loud_noise checkbx">
													</span>
													<input type="text" class="form-control" value="Loud Noise" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control loud_noise_ui" name="loud_noise_ui" value="<?=$test->loud_noise_ui?>" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" <?= $checked;?> name="paper_jam" class="paper_jam checkbx">
													</span>
													<input type="text" class="form-control" value="Paper Jam" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control paper_jam_ui" name="paper_jam_ui" value="<?=$test->paper_jam_ui?>" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1"  <?= $checked;?> name="ink_system" class="ink_system checkbx">
													</span>
													<input type="text" class="form-control" value="Ink System" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control ink_system_ui" name="ink_system_ui" value="<?=$test->ink_system_ui?>" placeholder="User Input"></div>
										</div>
										<?php } ?>

								</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if($v == 7 || $v == 10){ ?>
						<div class="col-md-6">
					<?php
					 $other = '';
					if(isset($product['other_item_inputs']) && !empty($product['other_item_inputs'])){
						$other = json_decode($product['other_item_inputs']);
						// pr($other->ot_ui1);die;
					?>
								<div class="col-md-5 edit">
									<div class="form-group">
										<label>&nbsp;</label>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui1" name="ot_ui1" value="<?= $other->ot_ui1;?>" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui2" name="ot_ui2" value="<?= $other->ot_ui2;?>" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui3" name="ot_ui3" value="<?= $other->ot_ui3;?>" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui4" name="ot_ui4" value="<?= $other->ot_ui4;?>" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui5" name="ot_ui5" value="<?= $other->ot_ui5;?>" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui6" name="ot_ui6" value="<?= $other->ot_ui6;?>" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui7" name="ot_ui7" value="<?= $other->ot_ui7;?>" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui8" name="ot_ui8" value="<?= $other->ot_ui8;?>" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-12">
											<textarea placeholder="User Input" class="form-control ot_ui9" rows="3" name="ot_ui9"><?= $other->ot_ui9;?></textarea>
											</div>
										</div>
										
									</div>
								</div>
					<?php } ?>
					<?php
					 $other_test = '';
					if(isset($product['specifications_ui']) && !empty($product['specifications_ui'])){
						$other_test = json_decode($product['specifications_ui']);
					?>
								<div class="col-md-4 edit-spec">
									<div class="form-group">
										<label>Specifications:</label>
										<div class="row">
											<input type="text" class="form-control sp_ui1" name="sp_ui1" value="<?= $other_test->sp_ui1?>" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui2" name="sp_ui2" value="<?= $other_test->sp_ui2?>" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui3" name="sp_ui3" value="<?= $other_test->sp_ui3?>" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui4" name="sp_ui4" value="<?= $other_test->sp_ui4?>" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui5" name="sp_ui5" value="<?= $other_test->sp_ui5?>" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui6" name="sp_ui6" value="<?= $other_test->sp_ui6?>" placeholder="User Input">
										</div>
									</div>
								</div>
							</div>
					<?php } ?>
							
						
				<?php } ?>

					<?php 
						if($product['cosmetic_grade'] == 'F' || $product['cosmetic_grade'] == 'X'){?>
						<div class="col-md-4">
							<div class="form-group">
								<label>Failure Explanation:</label>
									<textarea  class="form-control" type="text" name="cpu"><?= $product['fail_text'];?></textarea>
								</div>
                    	</div>
					<?php }?>

					<div class="col-md-4 other-features">
						<div class="form-group">
							<label>Other Features:</label>
							<?php if($v == 4){?>
							<div class="row cat-4" data-category="4" data-name="Laptops & Netbooks" >
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
												<?php
													$checked = '';
													if ($product['touch_screen'] == 0) {
														$checked = '';
													} else {
														$checked = 'checked = "checked"';
													}?>
												<input  type="checkbox" <?=$checked;?> value="1" name="touchscreen" class="checkbx touchscreen">
											</span>
											<label class="check_label">Touch Screen</label>
										</div>
									</div>
									<div class="col-md-6">
											<div class="input-group" style="margin-bottom:5px;">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['optical_drive'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input   type="checkbox" <?=$checked;?> value="1" name="optical_drive" class="checkbx optical_drive">
											</span>
											<label class="check_label">Optical Drive</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['webcam'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['tgfg_capable'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input   <?=$checked;?> type="checkbox" value="1" name="tgfg_capable" class="checkbx tgfg_capable">
											</span>
											<label class="check_label">Sim Capable</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 3){?>
							<div class="row cat-3" data-category="3" data-name="Desktops">
									<div class="col-md-6">
											<div class="input-group" style="margin-bottom:5px;">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['optical_drive'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input   type="checkbox" <?=$checked;?> value="1" name="optical_drive" class="checkbx optical_drive">
											</span>
											<label class="check_label">Optical Drive</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['desktop_other'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="desktop_other" class="checkbx desktop_other">
											</span>
											<label class="check_label">Other</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 9){?>
							<div class="row cat-9" data-category="9" data-name="Thin Clients" >
									<div class="col-md-6">
											<div class="input-group" style="margin-bottom:5px;">
											<span class="input-group-addon">
											<?php
											$checked = '';
											if ($product['optical_drive'] == 0) {
												$checked = '';
											} else {
												$checked = 'checked = "checked"';
											}?>
											<input   type="checkbox" <?=$checked;?> value="1" name="optical_drive" class="checkbx optical_drive">
											</span>
											<label class="check_label">Optical Drive</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['desktop_other'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="desktop_other" class="checkbx desktop_other">
											</span>
											<label class="check_label">Other</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 2){?>
							<div class="row cat-2" data-category="2" data-name="All-in-Ones" >
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
												<?php
													$checked = '';
													if ($product['touch_screen'] == 0) {
														$checked = '';
													} else {
														$checked = 'checked = "checked"';
													}?>
												<input  type="checkbox" <?=$checked;?> value="1" name="touchscreen" class="checkbx touchscreen">
											</span>
											<label class="check_label">Touch Screen</label>
										</div>
									</div>
									<div class="col-md-6">
											<div class="input-group" style="margin-bottom:5px;">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['optical_drive'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input   type="checkbox" <?=$checked;?> value="1" name="optical_drive" class="checkbx optical_drive">
											</span>
											<label class="check_label">Optical Drive</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['webcam'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 8){?>
							<div class="row cat-8" data-category="8" data-name="Tablets" >
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['webcam'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['tgfg_capable'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="tgfg_capable" class="checkbx tgfg_capable">
											</span>
											<label class="check_label">Sim Capable</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 5){?>
							<div class="row cat-5" data-category="5" data-name="Monitors" >
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['touch_screen'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="touch_screen" class="checkbx touch_screen">
											</span>
											<label class="check_label">Touch Screen</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['webcam'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
									<div class="col-md-6" style="margin-top: 5px;">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
											$checked = '';
											if ($product['curved'] == 0) {
												$checked = '';
											} else {
												$checked = 'checked = "checked"';
											}?>
											<input <?=$checked;?> type="checkbox" value="1" name="curved" class="checkbx curved">
											</span>
											<label class="check_label">Curved</label>
										</div>
									</div>
							</div>
							<?php } ?>
							<?php if($v == 7 || $v == 10){?>
								<div class="row cat-7-10" data-category="7-10" data-name="Others" >
									<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
												<?php
													$checked = '';
													if ($product['tgfg_capable'] == 0) {
														$checked = '';
													} else {
														$checked = 'checked = "checked"';
													}?>
												<input <?=$checked;?> type="checkbox" value="1" name="tgfg_capable" class="checkbx tgfg_capable">
												</span>
												<label class="check_label">Sim Capable</label>
											</div>
									</div>
								</div>
							<?php } } ?>
						</div>
                  	</div>
					
                    <div class="col-md-12">
                        <a href="javascript:;" class="btn bg-teal-400 add_btn" data-id="<?=$product['id'];?>" class="btn-xs btn-default product_notes" onClick="view_notes(<?=$product['id'];?>)">View Notes</a>
                        <a href="<?php echo base_url() . 'admin/testing/edit_audit_record/' . $product['id'] ?>" class="btn bg-teal-400 add_btn" data-id="<?=$product['id'];?>" class="btn-xs btn-default product_specs"> Edit/Remove</a>
                    </div>
        </div>
    </div>
</div>
