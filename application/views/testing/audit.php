<div class="row">
	<div class="">
		<form method="post" action="<?= $admin_prefix; ?>testing/audit" id="audit" enctype="multipart/form-data">
			<div class="panel panel-flat">
				<div class="panel-heading">
					<div class="row">
						<div class="">
							<h5 class="panel-title">Audit </h5>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<hr>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Serial #:</label>
									<input type="text" name="serial" value="" onchange="get_product_details();" class="form-control serial">
									<input type="hidden" name="serial_id" class="serial_id" value="">
								</div>
							</div>
                            <div class="col-md-4">
								<div class="form-group">
									<label>Part #:</label>
									<input type="text" name="part" value="" onchange="get_product_details();" class="form-control part" required>
									<input type="hidden" name="product_id" class="product_id" value="">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>New Serial #:</label>
									<input type="text" name="new_serial" value="" class="form-control new_serial">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name:</label>
									<input type="text" value="" name="name" class="form-control name" required> 
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Received Condition:</label>
									<select name="condition" data-placeholder="Select Original Condition" class="form-control select original_condition">
										<?php foreach ($original_condition as $key => $value) { ?>
											<option value="<?= $key; ?>"><?= $value; ?></option>
										<?php }  ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Add File:</label>
									<input type="file" class="form-control" name="product_files[]" multiple="multiple" value="" placeholder="">
									<input type="hidden" name="files" class="files" value="">
								</div>
							</div>
						</div>
							<div class="row">
								<div class="col-md-4">
								<div class="form-group">
									<label>Category</label>
									<select name="category1" class="category1 form-control" onchange="get_sub_categories(this.value, 'category2')">
										<?php foreach ($categories as $key => $value) { ?>
											<option <?php echo ($key == 4) ? 'selected' : ''; ?> value="<?= $key ?>"><?= $value ?></option>
										<?php } ?>
									</select>
								</div>
								</div>
								<div class="col-md-4 category_dropdn">
								<div class="form-group">
									<label>Sub Category</label><br>
									<select name="category2" disabled="true" class="category2 form-control" onchange="get_sub_categories(this.value, 'category3')">
									</select>
								</div>
								</div>
								<div class="col-md-4 category_dropdn">
								<div class="form-group">
									<label>Sub Category</label><br/>
									<select name="category3" disabled="true" class="category3 form-control">
									</select>
									<input class="form-control other_category" style="display: none;" type="text" name="category3" value="" placeholder="Enter Category">
								</div>
								</div>
							</div>
							<div class="row">
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Recv_note:</label>
										<textarea name="recv_notes" class="form-control recv_notes"></textarea>
									</div>
								</div>
							</div>
						<hr>
						<div class="row">
						<div class="col-md-8">
							<div class="row">

                                    <div class="col-md-6">
								<div class="form-group">
									<label>Pass</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="pass" class="checkbx pass">
										</span>
										<label class="check_label">Pass</label>
										<!-- <input type="text" readonly="true" value="Pass" class="form-control">  -->
									</div>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group">
									<label>Fail</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="fail" class="checkbx fail">
										</span>
                                            <div class="multi-select-full">  
                                                <select name="fail_option" class="multiselect form-control fail_option" multiple="multiple">
											<?php foreach ($fail_options as $key => $value) { ?>
												<option value="<?= $key; ?>"><?= $value; ?></option>
											<?php }  ?>
                                                </select>
                                            </div>
									</div>
									<div class="form-group fail_reason_div" style="display: none;">
										<input type="text" class="form-control fail_reason_notes" name="fail_reason_notes" value="" placeholder="Fail Reason Notes">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
                                <div class="col-md-6 form-group">
									<div class="" style="margin-bottom: 5px;">
										<label>Cosmetic Grade:</label>
										<div class="input-group">
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="A" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx mn">
                                                MN
											</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="B" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx tn">
												TN
											</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="C" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx b">
												B
											</label>
										</span>
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="D" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx c">
												C
											</label>
										</span>
                                                                                
									</div>
									</div>
									<span><b>MN</b> – Manufacturer New / <b>TN</b> - Tested New / <b>B</b> - Light Scratches / <b>C</b> - Deep Scratches </span>
								</div>
                                    <div class="col-md-6 form-group ">
									<div class="costmatic-fx" style="margin-bottom: 5px;">
										<label>&nbsp;</label>
										<div class="input-group col-md-6">
										<span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="F" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx f">
												F
											</label>
										</span> 
                                                                                <span class="input-group-addon">
											<label class="radio-inline">
												<input type="radio" value="X" name="cosmetic_grade" class="cosmetic_grade_boxes checkbx x">
												X
											</label>
										</span> 
									</div>
									</div>
                                         <span><b>F</b> - Fail / <b>X</b> - Unsellable</span>
								</div>
							</div>
                                 </div>
                                 <div class="col-md-4">
                                 	<div class="form-group">
									<label>Failure Explaination:</label>
                                                                        <textarea name="fail_text" class="form-control" rows="5" cols="8"></textarea>
									<!--<input type="text" name="fail_1" value="" class="form-control fail_1">-->
								</div>
                                 </div>
								</div>
								<div class="row">
								<div class="col-md-2">
								<div class="row">
									<div class="form-group">
										<label>Cosmetic Notes:</label>
										<input type="text" class="form-control cs1" name="cs1" value="" placeholder="User Input">
										<input type="text" class="form-control cs2" name="cs2" value=""  placeholder="User Input">
									</div>
								</div>
									<div class="row">
									<div class="form-group">
										<label>Cosmetic Issues:</label>
										<?php foreach ($cosmetic_issues as $key => $value) { ?>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="<?= $key ?>" name="cosmetic_issue[]" class="cosmetic_boxes checkbx">
											</span>
											<label class="check_label"><?= $value ?></label>
											<!-- <input type="text" readonly="true" value="<?= $value ?>" class="form-control">  -->
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
								<div class="col-md-6 based-on-radio">
									<div class="col-md-8">
										<div class="form-group">
										<label>Specifications:</label>
											<div class="row cpu_row">
                                            <i class="icon-plus-circle2 add_more_cpu"></i>
												<div class="col-md-2">CPU</div>
												<div class="col-md-5"><input type="text" class="form-control cpu" name="cpu[]" value="" placeholder="" /></div>
											</div>
											<div class="row">
												<div class="col-md-2">Memory</div>
												<div class="col-md-5"><input type="text" class="form-control memory" name="memory" value="" placeholder=""></div>
											</div>
											<div class="row storage_row">
                                            
												<div class="col-md-2">Storage</div>
												<div class="col-md-4"><input type="text" class="form-control storage" name="storage[]" value="" placeholder="" /></div>
												<div class="col-md-5">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="ssd0" class="ssd checkbx">
														</span>
														<label class="check_label">SSD</label>
														<!-- <input type="text" class="form-control" value="SSD" readonly="true"> -->
													</div>
												</div>
                                                <div class="col-md-1"><i class="icon-plus-circle2 add_more_storage"></i></div>
											</div>
											<div class="row graphics_row">
												<div class="col-md-2">Graphics</div>
												<div class="col-md-4"><input type="text" class="form-control graphics" name="graphics[]" value="" placeholder=""></div>
												<div class="col-md-5">
													<div class="input-group">
														<span class="input-group-addon">
															<input type="checkbox" value="1" name="dedicated0" class="dedicated checkbx">
														</span>
														<label class="check_label">Dedicated</label>
														<!-- <input type="text" class="form-control" value="Dedicated" readonly="true"> -->
													</div>
												</div>
                                                <div class="col-md-1"><i class="icon-plus-circle2 add_more_graphics"></i></div>
											</div>
											<div class="row scr-wrap">
												<div class="col-md-2">Screen</div>
												<div class="col-md-3"><input type="text" class="form-control screen" name="screen" value="" placeholder="Screen"></div>
												<div class="col-md-3"><input type="text" class="form-control resolution" name="resolution" value="" placeholder="Resolution"></div>
												<div class="col-md-3"><input type="text" class="form-control size" name="size" value="" placeholder="Size"></div>
											</div>
											<div class="row">
												<div class="col-md-2">OS</div>
												<div class="col-md-5"><input type="text" class="form-control os" name="os" value="" placeholder=""></div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Additional Info/Accessories:</label>
											<textarea class="form-control additional_info" rows="10" cols="3" name="additional_info"></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-4 based-on-radio">
									<div class="col-md-6">
										<div class="row">
										<div class="form-group">
										<label>Other Features:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="touchscreen" class="checkbx touchscreen">
											</span>
											<label class="check_label">Touch Screen</label>
											<!-- <input type="text" readonly="true" value="Touch Screen" class="form-control">  -->
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="optical_drive" class="checkbx optical_drive">
											</span>
											<label class="check_label">Optical Drive</label>
											<!-- <input type="text" readonly="true" value="Optical Drive" class="form-control">  -->
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="webcam" class="checkbx webcam">
											</span>
											<label class="check_label">No Webcam</label>
											<!-- <input type="text" readonly="true" value="No Webcam" class="form-control">  -->
										</div>
                                        <div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="tgfg_capable" class="checkbx tgfg_capable">
											</span>
											<label class="check_label">Sim Capable</label>
											<!-- <input type="text" readonly="true" value="Sim Capable" class="form-control">  -->
										</div>
									</div>
								</div>
								<!-- <div class="row">
									<div class="form-group">
										<label>Additional Features:</label>
										<textarea name="additional_features" class="form-control additional_features"></textarea>
									</div>
								</div> -->
									</div>
									<div class="col-md-6">
										<div class="row">
										<!-- <div class="form-group">
										<label>Accessories:</label>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="cd_software" class="checkbx cd_software">
											</span>
											<label class="check_label">CD/Software</label>
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="power_cord" class="checkbx power_cord">
											</span>
											<label class="check_label">Power Cord</label>
										</div>
										<div class="input-group">
											<span class="input-group-addon">
												<input type="checkbox" value="1" name="manual" class="checkbx manual">
											</span>
											<label class="check_label">Manual</label>
										</div>
									</div> -->
								</div>
<!--								<div class="row">
									<div class="form-group">
										<label>Additional Accessories:</label>
										<textarea name="additional_accessories" class="form-control additional_accessories"></textarea>
									</div>
								</div>-->
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
								<div class="form-group">
									<label>Final Condition: </label>
									<select name="final_condition" class="form-control final_condition">
										<?php foreach ($original_condition as $key => $value) { ?>
											<option value="<?= $key; ?>"><?= $value; ?></option>
										<?php }  ?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-6">
									<div class="form-group">
										<label>Warranty: </label>
										<select name="warranty" class="form-control warranty" onchange="warranty_change(this.value)">
											<option value="Active">Active</option>
											<option value="Expired">Expired</option>
											<option value="Unknown">Unknown</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Active Until: </label>
										<div class="input-group">
										<span class="input-group-addon"><i class="icon-calendar22"></i></span>
										<input type="text" name="warranty_date" class="form-control daterange-single warranty_date" value="">
									</div>
									</div>
								</div>
							</div>
						</div>
							<hr>
							
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="factory_reset" class="checkbx factory_reset">
										</span>
										<label class="check_label">Factory Reset</label>
										<!-- <input type="text" readonly="true" value="Factory Reset" class="form-control">  -->
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label>
									<div class="input-group">
										<span class="input-group-addon">
											<input type="checkbox" value="1" name="hard_drive_wiped" class="checkbx hard_drive_wiped">
										</span>
										<label class="check_label">Hard Drive Wiped</label>
										<!-- <input type="text" readonly="true" value="Hard Drive Wiped" class="form-control">  -->
									</div>
								</div>
							</div>
							<!-- <div class="col-md-6">
								<div class="form-group">
									<label>Status:</label>
									<select name="status" class="form-control status">
										<option value="">Select Option</option>
										<option value="Sold">Sold</option>
										<option value="RMA">RMA</option>
										<option value="Ready For Sale">Ready For Sale</option>
										<option value="Testing">Testing</option>
										<option value="Failed">Failed</option>
										<option value="Awaiting Repair">Awaiting Repair</option>
										<option value="Packout">Packout</option>
										<option value="Received">Received</option>
										<option value="Shipped">Shipped</option>
										<option value="FGI HOLD">FGI HOLD</option>
										<option value="Other">Other</option>
									</select>
									<input style="display: none;" type="text" name="other_status" value="" class="form-control other_status" placeholder="">
								</div>
							</div> -->
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Tech Notes:</label>
									<textarea name="tech_notes" class="form-control tech_notes"></textarea>
								</div>
							</div>
						</div>
                        <div class="col-md-12">
                            <div class="col-md-2 col-md-offset-9">
                            <input type="text" name="scan_loc" value="" placeholder="Scan To Location" class="form-control scan_loc">
									<input type="hidden" name="scan_loc_id" class="scan_loc_id" value="">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" name="save" class="btn bg-pink-400">Save</button>
                            </div>
                        </div>
					</div>
				</div>
			</form>
            <!--Add More-->
            <div class="row cpu1" style="display:none;">
                <div class="col-md-offset-2 col-md-5"><input type="text" class="form-control cpu" name="cpu[]" value="" placeholder=""></div>
            </div>
            <div class="row storage1" style="display:none;">
                <div class="col-md-offset-2 col-md-4">
                <input type="text" class="form-control storage" name="storage[]" value="" placeholder="" /></div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" value="1" name="ssd" class="ssd checkbx">
                        </span>
                        <label class="check_label">SSD</label>
                        <!-- <input type="text" class="form-control" value="SSD" readonly="true" /> -->
                    </div>
                </div>
            </div>
            <div class="row graphics1" style="display:none;">
                <div class="col-md-offset-2 col-md-4"><input type="text" class="form-control graphics" name="graphics[]" value="" placeholder="" /></div>
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <input type="checkbox" value="1" name="dedicated" class="dedicated checkbx">
                        </span>
                        <label class="check_label">Dedicated</label>
                        <!-- <input type="text" class="form-control" value="Dedicated" readonly="true"> -->
                    </div>
                </div>
            </div>

		</div>
	</div>
	<!-- <div class=""></div> -->
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">Accessories Not in database</h4></center>
            </div>
            <div class="modal-body">
                <center><button type="button" class="btn btn-info btn-lg add_now" data-toggle="modal" data-target="#myModal2">Add Now</button></center>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="row accessories">
                    <div class="col-md-5">
                        <div class="form-group">
                            Accessories Type
                            <input type="text" class="form-control cd_soft" name="access_type[]" value="" placeholder="" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            Accessories Name
                            <input type="text" class="form-control cd_soft" name="access_name[]" value="" placeholder="" />
                        </div>
                    </div>
                    <i class="icon-plus-circle2 add_more_access"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row access1">
<div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control cd_soft" name="access_type[]" value="" placeholder="" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="text" class="form-control cd_soft" name="access_name[]" value="" placeholder="" />
                        </div>
                    </div>
                                        </div>
