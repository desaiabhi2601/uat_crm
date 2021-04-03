<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<?php echo form_open('', array("class" => "kt-form kt-form--label-right", "id" => "add_marking")); ?>
						<div class="kt-portlet__body">
							<div class="form-group row">
								<div class="col-lg-4">
									<label>Made By</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
										<select class="form-control validate[required]" name="made_by" id="made_by">
											<option value="">Select User</option>
											<?php
												foreach ($quality_users as $key => $value) {
													$selected = '';
													if($this->session->userdata('user_id') == $value['user_id'] && !isset($marking_details)){
														$selected = 'selected="selected"';
													}

													if(isset($marking_details) && $marking_details[0]['made_by'] == $value['user_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<label>Marking For</label>
									<div class="input-group">
										<select class="form-control validate[required]" id="marking_type" name="marking_type">
											<option value="">Select</option>
											<option value="sample" <?php if(isset($marking_details) && $marking_details[0]['marking_type'] == 'sample'){ echo 'selected="selected"'; } ?>>Sample MTC</option>
											<option value="proforma" <?php if($marking_details[0]['marking_type'] == 'proforma'){ echo 'selected="selected"'; } ?>>Proforma MTC</option>
										</select>
									</div>
								</div>

								<div class="col-lg-4 marking_for" id="quotation">
									<div class="form-group">
										<label for="quotation_no" class="form-control-label">Quotation #</label>
										<input type="text" name="marking_for" class="form-control marking_for_field" id="quotation_no" <?php if(isset($marking_details)){ echo 'value="'.$marking_details[0]['quote_no'].'"'; } ?> />
										<input type="hidden" name="marking_for_hidden" class="form-control marking_for_field" id="quotation_no_hidden" <?php if(isset($marking_details)){ echo 'value="'.$marking_details[0]['quotation_mst_id'].'"'; } ?>/>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="marking_for_result" id="quotation_no_res" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 95%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; top: -25px;">
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 marking_for" id="proforma" style="display: none;">
									<div class="form-group">
										<label for="proforma_no" class="form-control-label">Proforma #</label>
										<input type="text" name="marking_for" class="form-control marking_for_field" id="proforma_no" <?php if(isset($marking_details)){ echo 'value="'.$marking_details[0]['proforma_no'].'"'; } ?>>
										<input type="hidden" name="marking_for_hidden" class="form-control marking_for_field" id="proforma_no_hidden" <?php if(isset($marking_details)){ echo 'value="'.$marking_details[0]['quotation_mst_id'].'"'; } ?>/>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="marking_for_result" id="proforma_no_res" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 95%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; top: -25px;">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-3">
									<label>Assign To</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
										<select class="form-control validate[required]" name="assigned_to" id="assigned_to">
											<option value="">Select User</option>
											<?php 
												foreach ($sales_users as $key => $value) {
													$selected = '';
													if(isset($marking_details) && $marking_details[0]['assigned_to'] == $value['user_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="marking_company" class="form-control-label">Company Name:</label>
										<input type="text" class="form-control validate[required]" id="marking_company" name="marking_company" <?php if(isset($marking_details)){ echo "value='".$marking_details[0]['client_name']."'"; } ?>> 
										<input type="hidden" name="marking_company_id" id="marking_company_id" <?php if(isset($marking_details)){ echo "value='".$marking_details[0]['client_id']."'"; } ?>>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="marking_member" class="form-control-label">Member Name:</label>
										<input type="text" class="form-control validate[required]" id="marking_member" name="marking_member" <?php if(isset($marking_details)){ echo "value='".$marking_details[0]['name']."'"; } ?>>
										<input type="hidden" name="marking_member_id" id="marking_member_id" <?php if(isset($marking_details)){ echo "value='".$marking_details[0]['member_id']."'"; } ?>>
									</div>
								</div>
								<div class="col-lg-3" id="ref_div">
									<label class="">Reference</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Reference" name="reference" value="<?php if(isset($marking_details)) echo $marking_details[0]['reference']; ?>">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th colspan="11">Marking Preview <input type="button" class="btn btn-primary btn-sm" id="add_row" style="float:right;" value="Add Row"/></th>
											</tr>
											<tr>
												<th width="5%">Sr #</th>
												<th width="20%">Description</th>
												<th width="3%">Qty</th>
												<th width="3%">Unit</th>
												<th width="10%">Product</th>
												<th width="10%">Material</th>
												<th width="10%">Heat # <button class="btn btn-sm btn-clean btn-icon btn-icon-md" id="generateHeatAll" title="Generate Heat Number"><i class="la la-download"></i></button></th>
												<th width="10%">Specifications</th>
												<th width="16%">Marking</th>
												<th width="3%">Action</th>
											</tr>
										</thead>
										<tbody id="marking_tbody">
											<?php 
												$k=0;
												if(isset($marking_details)){
													foreach ($marking_details as $key => $value) {
											?>
												<tr>
													<td><?php echo ++$k;?></td>
													<td><?php echo $value['description']; ?></td>
													<td><?php echo $value['quantity']; ?></td>
													<td><?php echo $value['unit_value']; ?></td>
													<td><select class="form-control product" name="product[]">
															<option value="">Select Product</option>
															<?php
																foreach ($product as $prod) {
																	$selected = '';
																	if($prod['lookup_id'] == $value['product_id']){
																		$selected = 'selected = "selected"';
																	}
																	echo '<option '.$selected.' value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
																}
															?>
														</select>
													</td>
													<td>
														<select class="form-control material" name="material[]">
															<option value="">Select Material</option>
															<?php
																foreach ($material as $mat) {
																	$selected = '';
																	if($mat['lookup_id'] == $value['material_id']){
																		$selected = 'selected = "selected"';
																	}
																	echo '<option '.$selected.' value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
																}
															?>
														</select>
													</td>
													<td>
														<input class="form-control heat_number" name="heat_number[]" type="text" placeholder="Heat Number" value="<?php echo $value['heat_no']; ?>" readonly>
														<?php if($value['heat_no'] == ''){?>
														<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md generateHeat" title="Generate Heat Number" quote_dtl_id="<?php echo $value['quotation_dtl_id']; ?>">
															<i class="la la-download"></i>
														</button>
														<?php } ?>
														<input type="hidden" name="quote_dtl_id[]" value="<?php echo $value['quotation_dtl_id']; ?>">
													</td>
													<td>
														<input class="form-control" type="text" placeholder="Specifications" name="specification[]" value="<?php if(isset($marking_details)){ echo $value['specification']; } ?>">
													</td>
													<td><textarea class="form-control" name="marking[]"><?php if(isset($marking_details)){ echo $value['marking']; } ?></textarea></td>
													<td>
														<button class="btn btn-sm btn-danger delRow">Delete</button>
													</td>
												</tr>
											<?php
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-8">
									<label for="comments" class="form-control-label">Comments</label>
									<textarea class="form-control" id="comments" name="comments"></textarea>
								</div>
							</div>
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-4"></div>
									<div class="col-lg-8">
										<?php if(isset($marking_details)) echo '<input type="hidden" name="marking_mst_id" value="'.$marking_id.'">'; ?>
										<button type="submit" class="btn btn-primary" name="save_quotation">Save Markings</button>
									</div>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>