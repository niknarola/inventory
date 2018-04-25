<div class="col-md-12">
					<?php if ($this->session->flashdata('msg')) { ?>
						<div class="alert alert-success hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('msg') ?></strong>
						</div>
					<?php }  if ($this->session->flashdata('err_msg')) { ?>
						<div class="alert alert-danger hide-msg">
							<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
							<strong><?php echo $this->session->flashdata('err_msg') ?></strong>
						</div>
            		<?php }?>
       		 	</div>
<div class="row">
<div class="col-md-12">
   <form method="post" action="<?=$admin_prefix;?>testing/quality" id="quality" enctype="multipart/form-data">
      <div class="panel panel-flat">
         <div class="panel-heading">
            <div class="row">
               <div class="col-md-12">
                  <h5 class="panel-title">Quality Control</h5>
               </div>
            </div>
         </div>
         <div class="panel-body">
            <div class="row">
               <div class="row">
                  <div class="col-md-12">
                     <div class="col-md-6">
                        <div class="form-group">
						   <!-- <label>Serial #:</label> -->
						   <!-- onchange="get_product_details(this.value);" -->
                           <input type="text" value="" name="serial" class="form-control serial" onchange="get_product_details(this.value);"  placeholder="Serial #">
                        </div>
                     </div>
                     <div class="col-md-2">
                        <button type="button" class="btn btn-primary category_btn" >Search</button>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Part #:</label>
                     <input type="text" disabled="true" name="part" value=""  class="form-control part" required>
                     <input type="hidden" name="product_id" class="product_id" value="">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>New Serial #:</label>
                     <input type="text"  disabled="true"   name="new_serial" value="" class="form-control new_serial">
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Model:</label>
                     <input type="text" disabled="true"  name="model" value="" class="form-control model">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Original Condition:</label>
                     <select disabled="true"  name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
                        <?php foreach ($original_condition as $key => $value) {?>
                        <option value="<?=$key;?>"><?=$value;?></option>
                        <?php }?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Grade:</label>
                     <select disabled="true"  name="grade" data-placeholder="Select Grade" class="form-control select grade">

                        <option value="MN">MN - Manufacturer New</option>
                        <option value="TN">TN - Tested New</option>
                        <option value="B">B - Light Scratches</option>
                        <option value="C">C - Deep Scratches</option>
                        <option value="F">F - Fail</option>
                        <option value="X">X - Unsellable</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Category</label>
                     <select  disabled="true"  name="category1" class="category1 form-control">
                        <?php foreach ($categories as $key => $value) {?>
                        <option value="<?=$key?>"><?=$value?></option>
                        <?php }?>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Final Condition:</label>
                     <select disabled="true"  name="final_condition" data-placeholder="Select Original Condition" class="form-control select final_condition">
                        <?php foreach ($original_condition as $key => $value) {?>
                        <option value="<?=$key;?>"><?=$value;?></option>
                        <?php }?>
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Grading notes:</label>
                     <textarea disabled="true" name="grading_notes" class="form-control grading_notes"></textarea>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>Repair Notes:</label>
                     <textarea disabled="true" name="repair_notes" class="form-control repair_notes"></textarea>
                  </div>
               </div>
               <hr>
               <div class="col-md-12 specs" style="display:none;">
                  <div class="form-group">
                     <label>Specs:</label>
                  </div>
               </div>
			   <div class="screen" style="display:none;">
					<div class="col-md-4">
						<div class="form-group">
							<label>Display Type:</label>
							<input disabled="true"  type="text" class="form-control screen" name="screen" value="" placeholder="Display Type">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Resolution:</label>
							<input disabled="true"  type="text" class="form-control resolution" name="resolution" value="" placeholder="resolution">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Size:</label>
							<input disabled="true"  type="text" class="form-control size" name="size" value="" placeholder="size">
						</div>
					</div>
				</div>

				<div class="os" style="display:none;">
					<div class="col-md-4">
						<div class="form-group">
							<label>OS:</label>
							<input disabled="true"  type="text" class="form-control os" name="os" value="" placeholder="OS">
						</div>
					</div>
				</div>

				<div class="memory" style="display:none;">
					<div class="col-md-4">
						<div class="form-group">
							<label>Memory:</label>
							<input disabled="true" type="text" class="form-control memory" name="memory" value="" placeholder="Memory">
						</div>
					</div>
			    </div>

				<div class="form-factor" style="display:none;">
					<div class="col-md-4">
					<div class="form-group">
						<label>Form Factor:</label>
						<input disabled="true" type="text" class="form-control form_factor" name="form_factor" value="" placeholder="Form Factor">
					</div>
					</div>
				</div>

               <div class="row">
                  <div class="col-md-12">
				  	<div class="cpu-storage-graphics" style="display:none;">
						<div class="col-md-4">
							<div class="form-group">
							<label>CPU:</label>
							<textarea disabled="true" name="cpu" class="form-control cpu"></textarea>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							<?php //pr($product);die;?>
								<label>Storage:</label>
							<?php
								$new_sto_ssd = '';
								if (isset($product['storage']) && !empty($product['storage'])) {
									foreach (json_decode($product['storage']) as $key => $value) {
										$ssd = json_decode($product['ssd']);
										if ($ssd[$key] == 0) {
											$new_sto_ssd = $new_sto_ssd . $value . ', ';
										} else {
											$new_sto_ssd = $new_sto_ssd . $value . '(ssd), ';
										}
									}
									$length = strlen($new_sto_ssd) - 1;
									$new_sto_ssd = substr($new_sto_ssd, 0, $length);
									// pr($new_sto_ssd);die;
								}
								?>
							<textarea disabled="true" name="storage" class="form-control storage"><?=$new_sto_ssd?></textarea>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							<label>Graphics:</label>
							<?php
								$new_gra_ded = '';
								if (isset($product['graphics']) && !empty($product['graphics'])) {
									foreach (json_decode($product['graphics']) as $key => $value) {
										$dedicated = json_decode($product['dedicated']);
										if ($dedicated[$key] == 0) {
											$new_gra_ded = $new_gra_ded . $value . ', ';
										} else {
											$new_gra_ded = $new_gra_ded . $value . '(dedicated), ';
										}
									}
									$length = strlen($new_gra_ded) - 1;
									$new_gra_ded = substr($new_gra_ded, 0, $length);
									// pr($new_gra_ded);die;
								}

								?>
							<textarea disabled="true" name="graphics" class="form-control graphics"> <?=$new_gra_ded?></textarea>
							</div>
						</div>
					</div>
                     <div class="col-md-4">
                        <div class="form-group">
                            <label>Additional Info/Accessories:</label>
                            <textarea disabled="true" name="additional_info" class="form-control additional_info" name="cpu"></textarea>
                        </div>
                    </div>
					<div class="row cat-6" data-category="6" data-name="Printers" style="display:none;">
						<div class="col-md-12 edit">
							<div class="col-md-4">
								<div class="form-group">
									<label>Physical Inspection</label>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" disabled="true" name="missing_tray" class="missing_tray checkbx">
												</span>
												<input type="text" class="form-control" value="Missing Tray" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control missing_tray_ui" name="missing_tray_ui" disabled="true" value="" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" disabled="true"  name="missing_ink_toner" class="missing_ink_toner checkbx">
												</span>
												<input type="text" class="form-control" value="Missing Ink/Toner" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control missing_ink_toner_ui" name="missing_ink_toner_ui" disabled="true" value="" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" disabled="true" name="broken_glass" class="broken_glass checkbx">
												</span>
												<input type="text" class="form-control" value="Broken Glass" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control broken_glass_ui" name="broken_glass_ui" value="" disabled="true" placeholder="User Input"></div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
													<input type="checkbox" value="1" disabled="true" name="physical_damage" class="physical_damage checkbx">
												</span>
												<input type="text" class="form-control" value="Physical Damage" readonly="true">
											</div>
										</div>
										<div class="col-md-6"><input type="text" class="form-control physical_damage_ui" name="physical_damage_ui" value="" disabled="true" placeholder="User Input"></div>
										
									</div>
									<div class="row">
										<div class="col-md-12">
											<textarea placeholder="User Input" disabled="true" disabled="true" class="form-control pi_ui" rows="3" cols="3" name="pi_ui"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="col-md-12">
									<div class="form-group">
									<label>Testing:</label>
									<?php
										// $checked='';
										// $test = '';
										// if(isset($product['printer_testing_fields'])){
										// 	$test = json_decode($product['printer_testing_fields']);
										// 	if($test->no_power == 1 || $test->not_loading == 1 || $test->loud_noise == 1 || $test->paper_jam == 1 || $test->ink_system == 1){
										// 		$checked = 'checked="checked"';
										// 	}else{
										// 		$checked = '';
										// 	}
										// }
									?>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" disabled="true" name="no_power" class="no_power checkbx">
													</span>
													<input type="text" class="form-control" value="No Power" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control no_power_ui" name="no_power_ui" value="" disabled="true" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" disabled="true" name="not_loading" class="not_loading checkbx">
													</span>
													<input type="text" class="form-control" value="Not Loading" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control not_loading_ui" name="not_loading_ui" value="" disabled="true" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" disabled="true"  name="loud_noise" class="loud_noise checkbx">
													</span>
													<input type="text" class="form-control" value="Loud Noise" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control loud_noise_ui" name="loud_noise_ui" value="" disabled="true" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" disabled="true" name="paper_jam" class="paper_jam checkbx">
													</span>
													<input type="text" class="form-control" value="Paper Jam" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control paper_jam_ui" name="paper_jam_ui" value="" disabled="true" placeholder="User Input"></div>
										</div>
									<div class="row">
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<input type="checkbox" value="1" disabled="true"  name="ink_system" class="ink_system checkbx">
													</span>
													<input type="text" class="form-control" value="Ink System" readonly="true">
												</div>
											</div>
											<div class="col-md-6"><input type="text" class="form-control ink_system_ui" name="ink_system_ui" value="" disabled="true" placeholder="User Input"></div>
										</div>
									

								</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row cat710" data-category="7-10" data-name="Others" style="display:none;">
						<div class="col-md-6">
								<div class="col-md-5 edit">
									<div class="form-group">
										<label>&nbsp;</label>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui1" name="ot_ui1" value="" disabled="true" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui2" name="ot_ui2" value="" disabled="true" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui3" name="ot_ui3" value="" disabled="true" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui4" name="ot_ui4" value="" disabled="true" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui5" name="ot_ui5" value="" disabled="true" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui6" name="ot_ui6" value="" disabled="true" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-6"><input type="text" class="form-control ot_ui7" name="ot_ui7" value="" disabled="true" placeholder="User Input"></div>
											<div class="col-md-6"><input type="text" class="form-control ot_ui8" name="ot_ui8" value="" disabled="true" placeholder="User Input"></div>
										</div>
										<div class="row">
											<div class="col-md-12">
											<textarea placeholder="User Input" class="form-control ot_ui9" disabled="true" rows="3" name="ot_ui9"></textarea>
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-4 edit-spec">
									<div class="form-group">
										<label>Specifications:</label>
										<div class="row">
											<input type="text" class="form-control sp_ui1" name="sp_ui1" value="" disabled="true" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui2" name="sp_ui2" value="" disabled="true" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui3" name="sp_ui3" value="" disabled="true" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui4" name="sp_ui4" value="" disabled="true" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui5" name="sp_ui5" value="" disabled="true" placeholder="User Input">
										</div>
										<div class="row">
											<input type="text" class="form-control sp_ui6" name="sp_ui6" value="" disabled="true" placeholder="User Input">
										</div>
									</div>
								</div>
							</div>
					</div>
                    <div class="col-md-4 other-features" style="display:none;">
						<div class="form-group">
							<label>Other Features:</label>
							<div class="row cat-4" data-category="4" data-name="Laptops & Netbooks" style="display:none;">
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
												<input  type="checkbox" <?=$checked;?> value="1" disabled="true" name="touchscreen" class="checkbx touchscreen">
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
											<input   type="checkbox" <?=$checked;?> value="1" disabled="true" name="optical_drive" class="checkbx optical_drive">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="webcam" class="checkbx webcam">
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
											<input   <?=$checked;?> type="checkbox" value="1" disabled="true" name="tgfg_capable" class="checkbx tgfg_capable">
											</span>
											<label class="check_label">Sim Capable</label>
										</div>
									</div>
							</div>
							<div class="row cat-3" data-category="3" data-name="Desktops" style="display:none;">
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
											<input   type="checkbox" <?=$checked;?> value="1" disabled="true" name="optical_drive" class="checkbx optical_drive">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="desktop_other" class="checkbx desktop_other">
											</span>
											<label class="check_label">Other</label>
										</div>
									</div>
							</div>
							<div class="row cat-9" data-category="9" data-name="Thin Clients" style="display:none;">
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
											<input   type="checkbox" <?=$checked;?> value="1"  disabled="true" name="optical_drive" class="checkbx optical_drive">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="desktop_other" class="checkbx desktop_other">
											</span>
											<label class="check_label">Other</label>
										</div>
									</div>
							</div>
							<div class="row cat-2" data-category="2" data-name="All-in-Ones" style="display:none;">
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
												<input  type="checkbox" <?=$checked;?> value="1" disabled="true" name="touchscreen" class="checkbx touchscreen">
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
											<input   type="checkbox" <?=$checked;?> value="1" disabled="true" name="optical_drive" class="checkbx optical_drive">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
							</div>
							<div class="row cat-8" data-category="8" data-name="Tablets" style="display:none;">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="webcam" class="checkbx webcam">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="tgfg_capable" class="checkbx tgfg_capable">
											</span>
											<label class="check_label">Sim Capable</label>
										</div>
									</div>
							</div>
							<div class="row cat-5" data-category="5" data-name="Monitors" style="display:none;">
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
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="touch_screen" class="checkbx touch_screen">
											</span>
											<label class="check_label">Touch Screen</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
												$checked = '';
												if ($product['curved'] == 0) {
													$checked = '';
												} else {
													$checked = 'checked = "checked"';
												}?>
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="curved" class="checkbx curved">
											</span>
											<label class="check_label">Curved</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
											<?php
											$checked = '';
											if ($product['curved'] == 0) {
												$checked = '';
											} else {
												$checked = 'checked = "checked"';
											}?>
											<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="curved" class="checkbx curved">
											</span>
											<label class="check_label">No Webcam</label>
										</div>
									</div>
							</div>
							<div class="row cat-7-10" data-category="7-10" data-name="Others" style="display:none;">
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
												<input <?=$checked;?> type="checkbox" value="1" disabled="true" name="tgfg_capable" class="checkbx tgfg_capable">
												</span>
												<label class="check_label">Sim Capable</label>
											</div>
									</div>
								</div>
							</div>
                  	</div>
               </div>
               <div class="">

                  <div class="col-md-4">
                     <label>Packaging and Accessories included:</label>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <input type="radio" value="1" name="pack" class="checkbx yes">
                              </span>
                              <label class="check_label">Yes</label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <input type="radio" value="1" name="pack" class="checkbx no">
                              </span>
                              <label class="check_label">No</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <label>Did Unit Pass Quality Control?:</label>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <input type="radio" value="1" name="qc" class="checkbx yes">
                              </span>
                              <label class="check_label">Yes</label>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="input-group">
                              <span class="input-group-addon">
                              <input type="radio" value="1" name="qc" class="checkbx no">
                              </span>
                              <label class="check_label">No</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12" style="margin-bottom:10px;">
                     <label>QC Notes:</label>
                     <textarea name="qc_notes" class="form-control qc_notes"></textarea>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-3">
							<input type="checkbox" value="1" name="scan_loc_check" class="checkbx scan_loc_check">
                                <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
                                <input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" name="save" class="btn bg-pink-400">Save</button>
                            </div>
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
<script type="text/javascript" src="assets/js/fileinput.min.js"></script>
<script type="text/javascript" src="assets/js/moment.min.js"></script>
<script type="text/javascript" src="assets/js/daterangepicker.js"></script>
<script type="text/javascript" src="assets/js/picker.js"></script>
<script type="text/javascript" src="assets/js/picker.date.js"></script>
<script type="text/javascript">
   jQuery(document).ready(function($) {
	$(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
	  	});

   	$('.daterange-single').daterangepicker({
           singleDatePicker: true,
           locale: {
               format: 'YYYY-MM-DD'
           }
       });
       $(document).on('change', '.status', function(event) {
        	if($(this).val() == 'Other'){
        		$('.other_status').css('display', 'block');
       	}else{
       		$('.other_status').css('display', 'none');
       	}

        });
       get_sub_categories(1, 'category2');
       $(document).on('change', '.fail_option', function(event) {
       	if($(this).val()==6){
       		$('.fail_reason_div').css('display', 'block');
       	}else{
       		$('.fail_reason_div').css('display', 'none');
       	}

       });
       // $('.category3').multiselect();
		//            var grade = $("input[name='cosmetic_grade']:checked").val();
		//        console.log('abcdeffhbkj',grade);
   });
   function warranty_change(val){
   	if(val!='Active'){
       		$('input.warranty_date').attr('disabled',true);
       	}else{
       		$('input.warranty_date').attr('disabled',false);
       	}
   }

   function get_sub_categories(cat_id, elem, category=null){
		if(cat_id!=''){
			var cat2_name = $('.category2 option[value="'+cat_id+'"]').text();
			if(cat2_name=='Other'){
				$('.other_category').css('display','block');
				if(category!=null && category.length > 2)
				$('.other_category').val(category[2]);
			}else{
				$('.other_category').css('display','none');
				$.ajax({
					url: '<?php echo $cat_url; ?>',
					type: 'POST',
					dataType: 'json',
					data: {category_id: cat_id},
				})
				.done(function(response) {
					if(response.result==1){
						$('.'+elem).html(response.html_text);

						$('.'+elem).removeAttr('disabled');
					}else{
						$('.'+elem).html('').attr('disabled', true);
					}
					if(elem=='category2'){
						if(category!=null && category.length > 1){
							multiselect_selected($('.category2'), category[1]);
						}
						$('.category3').html('').attr('disabled', true);
					}
					if(elem=='category3'){
						if(category!=null && category.length > 2){
							multiselect_selected($('.category3'), category[2]);
						}
					}
					// $('.'+elem).multiselect('destroy');
					// $('.'+elem).multiselect();

					// $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});
				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});
			}
		}
	}

		function multiselect_selected($el, values) {
			$el.val(values);
		}

      	// function get_product_details(){
			$(".serial").on('keyup', function (e) {
			if(e.keyCode == 13){
      		var serial = $('input.serial').val();
   			if(serial!=''){
			var data = {serial: serial};
			$.ajax({
				url: '<?php echo $ajax_url; ?>',
				type: 'POST',
				dataType: 'json',
				data: data,
			})
			.done(function(response) {
				if(response.status==0){
					$( "input" ).not( ".part, .serial, .new_serial" ).val('');
					$( "input" ).not( ".serial, .new_serial" ).val('');
					$('textarea').html('');
					$('input[type="checkbox"]').prop('checked', false);
					$('input[type="radio"]').prop('checked', false);
					get_sub_categories(1, 'category2');
					$('select.status').val('').trigger('change');
					$('select.warranty').val('Active').trigger('change');
					$('.other_category').css('display','none');
				}else{
					var category_test = JSON.parse(response.product.category);
					category_test.forEach(function(element) {
						$('.specs').css('display','none');
						$('.screen').css('display','none');
						$('.os').css('display','none');
						$('.form-factor').css('display','none');
						$('.memory').css('display','none');
						$('.cpu-storage-graphics').css('display','none');
						$('.other-features').css('display','none');
						$('.cat-2').css('display','none');
						$('.cat-3').css('display','none');
						$('.cat-4').css('display','none');
						$('.cat-5').css('display','none');
						$('.cat-6').css('display','none');
						$('.cat-8').css('display','none');
						$('.cat-9').css('display','none');
						$('.cat-7-10').css('display','none');
						$('.cat-710').css('display','none');
						if(element == 4){
							$('.specs').css('display','block');
							$('.screen').css('display','block');
							$('.os').css('display','block');
							$('.memory').css('display','block');
							$('.cpu-storage-graphics').css('display','block');
							$('.other-features').css('display','block');
							$('.cat-4').css('display','block');
						}
						if(element == 3){
							$('.specs').css('display','block');	
							$('.other-features').css('display','block');
							$('.os').css('display','block');
							$('.memory').css('display','block');
							$('.cpu-storage-graphics').css('display','block');	
							$('.form-factor').css('display','block');	
							$('.cat-3').css('display','block');
						}
						if(element == 2){
							$('.specs').css('display','block');	
							$('.other-features').css('display','block');
							$('.screen').css('display','block');
							$('.os').css('display','block');
							$('.memory').css('display','block');
							$('.cpu-storage-graphics').css('display','block');
							$('.cat-2').css('display','block');
						}
						if(element == 5){
							$('.specs').css('display','block');	
							$('.screen').css('display','block');
							$('.other-features').css('display','block');
							$('.cat-5').css('display','block');
						}
						if(element == 6){
							$('.cat-6').css('display','block');
						}
						if(element == 8){
							$('.specs').css('display','block');	
							$('.other-features').css('display','block');
							$('.screen').css('display','block');
							$('.os').css('display','block');
							$('.memory').css('display','block');
							$('.cpu-storage-graphics').css('display','block');
							$('.cat-8').css('display','block');
						}
						if(element == 9){
							$('.specs').css('display','block');	
							$('.other-features').css('display','block');
							$('.os').css('display','block');
							$('.memory').css('display','block');
							$('.cpu-storage-graphics').css('display','block');	
							$('.form-factor').css('display','block');	
							$('.cat-9').css('display','block');
						}
						if(element == 7 || element == 10){
							$('.other-features').show();
							$('.cat-7-10').show();
							$('.cat710').show();

							var specifications_ui = JSON.parse(response.product.specifications_ui);
							$('.sp_ui1').val(specifications_ui.sp_ui1);
							$('.sp_ui2').val(specifications_ui.sp_ui2);
							$('.sp_ui3').val(specifications_ui.sp_ui3);
							$('.sp_ui4').val(specifications_ui.sp_ui4);
							$('.sp_ui5').val(specifications_ui.sp_ui5);
							$('.sp_ui6').val(specifications_ui.sp_ui6);
							var other_item_inputs = JSON.parse(response.product.other_item_inputs);
							$('.ot_ui1').val(other_item_inputs.ot_ui1);
							$('.ot_ui2').val(other_item_inputs.ot_ui2);
							$('.ot_ui3').val(other_item_inputs.ot_ui3);
							$('.ot_ui4').val(other_item_inputs.ot_ui4);
							$('.ot_ui5').val(other_item_inputs.ot_ui5);
							$('.ot_ui6').val(other_item_inputs.ot_ui6);
							$('.ot_ui7').val(other_item_inputs.ot_ui7);
							$('.ot_ui8').val(other_item_inputs.ot_ui8);
							$('.ot_ui9').html(other_item_inputs.ot_ui9);

						}
						if(element == 4 || element == 3 || element == 9 || element == 2 || element == 8){

							var storage_array = JSON.parse(response.product.storage);
							if(storage_array != null){
								$('textarea.storage').html(storage_array.join(','));
							}
							var ssd_array = JSON.parse(response.product.ssd);
							if(ssd_array!=null){
								for(var i=0;i<ssd_array.length;i++){
									$('[name="ssd'+i+'"]').prop('checked', false);
									// console.log(typeof ssd_array[i],ssd_array[i]);
									if(ssd_array[i]==1){
										$('[name="ssd'+i+'"]').prop('checked', true);
									}
								}

							}
							var graphics_array = JSON.parse(response.product.graphics);
							if(graphics_array!=null){
								$('textarea.graphics').html(graphics_array.join(','));
							}

							var dedicated_array = JSON.parse(response.product.dedicated);
							if(dedicated_array!=null){
								for(var i=0;i<dedicated_array.length;i++){
									$('[name="dedicated'+i+'"]').prop('checked', false);
									if(dedicated_array[i]==1){
										$('[name="dedicated'+i+'"]').prop('checked', true);
									}
								}

							}

							var storage = $('.storage').val();
							var graphics = $('.graphics').val();
							var storage_array1 = storage.split(', ');
							var graphics_array1 = graphics.split(', ');

							if(ssd_array!=null){
								if(ssd_array[0] == 1 || ssd_array[1] == 1){
									storage_array1[0] = storage_array1[0] + '(ssd) '
								}
								$('textarea.storage').html(storage_array1.join(', '));
							}
							if(dedicated_array!=null){
								if(dedicated_array[0] == 1 || dedicated_array[1] == 1){
									graphics_array1[0] = graphics_array1[0] + '(decicated) '
								}
								$('textarea.graphics').html(graphics_array1.join(', '));
							}
						}
				});

				$('input.scan_loc').val(response.product.pallet);
				$('input.scan_loc_id').val(response.product.plid);
				$('input.product_id').val(response.product.pid);
				$('input.part').val(response.product.part);
				$('input.serial_id').val(response.product.id);
				$('input.new_serial').val(response.product.new_serial);
				$('input.model').val(response.product.name);
				//$('input.cpu').val(response.product.cpu);
				$('input.memory').val(response.product.memory);
				//$('input.storage').val(response.product.storage);
				//$('input.graphics').val(response.product.graphics);
				$('input.screen').val(response.product.screen);
				$('input.resolution').val(response.product.resolution);
				$('input.os').val(response.product.os);
				$('input.size').val(response.product.size);
				$('input.other_status').val(response.product.other_status);
				$('input.files').val(response.product.files);
				$('input.fail_reason_notes').val(response.product.fail_reason_notes);
				//---------------
				$('textarea.description').html(response.product.product_desc);
				$('textarea.additional_info').html(response.product.additional_info);
				$('textarea.additional_features').html(response.product.additional_features);
				$('textarea.additional_accessories').html(response.product.additional_accessories);
				$('textarea.tech_notes').html(response.product.tech_notes);
				$('textarea.recv_notes').html(response.product.recv_notes);
				//----------------
				$('.touchscreen').prop('checked', false);
				if(response.product.touch_screen==1){
					$('.touchscreen').prop('checked', true);
				}
				$('.tgfg_capable').prop('checked', false);
				if(response.product.tgfg_capable==1){
					$('.tgfg_capable').prop('checked', true);
				}
				$('.cosmetic_grade_boxes').each(function(index, el) {
					$(this).prop('checked', false);
					if($(this).val() == response.product.cosmetic_grade){
						$(this).prop('checked', true);
					}
				});
				$('.optical_drive').prop('checked', false);
				if(response.product.optical_drive==1){
					$('.optical_drive').prop('checked', true);
				}
				$('.webcam').prop('checked', false);
				if(response.product.webcam==1){
					$('.webcam').prop('checked', true);
				}
				$('.cd_software').prop('checked', false);
				if(response.product.cd_software==1){
					$('.cd_software').prop('checked', true);
				}
				$('.power_cord').prop('checked', false);
				if(response.product.power_cord==1){
					$('.power_cord').prop('checked', true);
				}
				$('.manual').prop('checked', false);
				if(response.product.manual==1){
					$('.manual').prop('checked', true);
				}
				$('.pass').prop('checked', false);
				if(response.product.pass==1){
					$('.pass').prop('checked', true);
				}
				$('.factory_reset').prop('checked', false);
				if(response.product.factory_reset==1){
					$('.factory_reset').prop('checked', true);
				}
				$('.hard_drive_wiped').prop('checked', false);
				if(response.product.hard_drive_wiped==1){
					$('.hard_drive_wiped').prop('checked', true);
				}
				var cpu_array = JSON.parse(response.product.cpu);
				if(cpu_array!=null){
					$('textarea.cpu').html(cpu_array.join(','));
				}
				//----------------
				$('select.original_condition').val(response.product.original_condition_id);
				$('select.grade').val(response.product.cosmetic_grade);
				$('select.status').val(response.product.status).trigger('change');
				$('select.fail_option').val(response.product.fail_option).trigger('change');
				$('select.warranty').val(response.product.warranty).trigger('change');
				var cs_issue = JSON.parse(response.product.cosmetic_issue);
				$('.cosmetic_boxes').each(function(index, el) {
					if($.inArray($(this).val(), cs_issue)!=-1){
						$(this).prop('checked', true);
					}else{
						$(this).prop('checked', false);
					}
				});
				var category = JSON.parse(response.product.category);
				console.log(category);
				if(category!=null){
					$('select.category1').val(category[0]);
				}
				var cs_issue_text = JSON.parse(response.product.cosmetic_issues_text);
					if(cs_issue_text!=null){
						$('textarea.grading_notes').html(cs_issue_text.cs1+', '+cs_issue_text.cs2);
						//   $('.cs1').val(cs_issue_text.cs1);
						//   $('.cs2').val(cs_issue_text.cs2);
					}
					$('textarea.repair_notes').html(response.product.repair_notes);
					// var fail_text = JSON.parse(response.product.fail_text);
					// $('.fail_1').val(fail_text.fail_1);
					// $('.fail_2').val(fail_text.fail_2);
					// $('.fail_3').val(fail_text.fail_3);

				var cat_raw = response.product.category;
				var category = (cat_raw!='') ? JSON.parse(cat_raw) : '';
				cat = (category!='') ? category[0] : 1;
				get_sub_categories(cat,'category2', category);
				if(category.length == 1){
					// $('.category2').multiselect();
					// $('.category3').multiselect();
				}
				if(category.length > 2){
					get_sub_categories(category[1],'category3', category);
				}else{
					// $('.category3').multiselect();
				}
			}
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
		}
		}
});

          $('.multiselect').multiselect({
              onChange: function() {
                  $.uniform.update();
          }
          // Styled checkboxes and radios
      	 });
      $(".styled, .multiselect-container input").uniform({ radioClass: 'choice'});


</script>
