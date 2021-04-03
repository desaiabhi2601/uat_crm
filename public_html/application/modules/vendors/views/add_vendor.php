<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<?php echo form_open('', array("class" => "kt-form kt-form--label-right", "id" => "addrfq_form")); ?>
						<div class="kt-portlet__body">
							<div class="form-group row">
								<div class="col-lg-4">
									<label class="">Vendor Name</label>
									<input type="text" class="form-control validate[]" name="vendor_name" value="<?php if(isset($vendor_details)) echo $vendor_details[0]['vendor_name']; ?>" id="vendor_name">
								</div>

								<div class="col-lg-4">
									<label class="">Country</label>
									<select class="form-control validate[]" name="country" id="country">
										<option value="">Choose Country</option>
										<?php foreach ($country as $value) {
											$selected = '';
											if(isset($vendor_details) && $vendor_details[0]['country'] == $value['lookup_id']){
												$selected = 'selected="selected"';
											}
										?>
											<option value="<?php echo $value['lookup_id']; ?>" <?php echo $selected; ?>><?php echo $value['lookup_value']; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-lg-4">
									<label class="">Website</label>
									<input type="text" class="form-control validate[]" name="website" value="<?php if(isset($vendor_details)) echo $vendor_details[0]['website']; ?>" id="website">
								</div>

								<div class="col-lg-4">
									<label class="">Source</label>
									<select class="form-control validate[]" name="source" id="source">
										<option value="">Select</option>
										<option value="primary leads" <?php if(isset($vendor_details) && $vendor_details[0]['source'] == 'primary leads'){ echo 'selected="selected"';} ?>>Primary Leads</option>
										<option value="hetregenous leads" <?php if(isset($vendor_details) && $vendor_details[0]['source'] == 'hetregenous leads'){ echo 'selected="selected"';} ?>>Hetregenous Leads</option>
									</select>
								</div>

								<div class="col-lg-4">
									<label class="">Stage</label>
									<select class="form-control validate[]" name="stage" id="stage">
										<option value="">Select</option>
										<option value="1" <?php if(isset($vendor_details) && $vendor_details[0]['stage'] == '1'){ echo 'selected="selected"';} ?>>Stage 1 – No contact</option>
										<option value="2" <?php if(isset($vendor_details) && $vendor_details[0]['stage'] == '2'){ echo 'selected="selected"';} ?>>Stage 2- We have sent them rfq</option>
										<option value="3" <?php if(isset($vendor_details) && $vendor_details[0]['stage'] == '3'){ echo 'selected="selected"';} ?>>Stage 3 – They have sent us offer</option>
										<option value="4" <?php if(isset($vendor_details) && $vendor_details[0]['stage'] == '4'){ echo 'selected="selected"';} ?>>Stage 4 – We have sent them order</option>
										<option value="5" <?php if(isset($vendor_details) && $vendor_details[0]['stage'] == '5'){ echo 'selected="selected"';} ?>>Stage 0 - Blacklisted Vendors</option>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<table class="table table-bordered">
										<thead>
												<tr>
												<th colspan="6">
													Product Details
													<button type="button" class="btn btn-primary btn-sm" id="add_row" style="float: right;">Add Row</button>
												</th>
											</tr>
											<tr>
												<th width="5%">Sr. #</th>
												<th width="30%">Product</th>
												<th width="30%">Material</th>
												<th width="30%">Type</th>
												<th width="5%">Action</th>
											</tr>
										</thead>
										<tbody id="tbody">
											<?php 
											if(isset($vendor_products) && !empty($vendor_products)){
												$i=1;
												foreach($vendor_products as $vd){
													if($vendor_products[0]['vp_id'] == '' || $vendor_products[0]['vp_id'] == null){
														continue;
													}
										?>
											<tr>
												<td><?php echo $i; ?></td>
												<td>
													<select name="product_id[]" class="form-control products">
														<option value="">Select Product</option>
														<?php 
															foreach ($product as $key => $value) {
																$selected = '';
																if($vd['product_id'] == $value['lookup_id']){
																	$selected = 'selected="selected"';
																}
																echo '<option value="'.$value['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($value['lookup_value'])).'</option>';
															}
														?>
													</select>
												</td>
												<td>
													<select name="material_id[]" class="form-control materials">
														<option value="">Select Material</option>
														<?php 
															foreach ($material as $key => $value) {
																$selected = '';
																if($vd['material_id'] == $value['lookup_id']){
																	$selected = 'selected="selected"';
																}
																echo '<option value="'.$value['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($value['lookup_value'])).'</option>';
															}
														?>
													</select>
												</td>
												<td>
													<select class="form-control type" name="vendor_type[]">
														<option value="">Select Type</option>
														<option value="manufacturer" <?php if($vd['vendor_type'] == 'manufacturer'){ echo 'selected="selected"'; }?>>Manufacturer</option>
														<option value="trader" <?php if($vd['vendor_type'] == 'trader'){ echo 'selected="selected"'; }?>>Trader</option>
													</select>
												</td>
												<td>
													<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md delRow" title="Delete"><i class="la la-trash"></i></button>
												</td>
											</tr>
										<?php $i++; 
											} 
										} ?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4>Members</h4>
									<button type="button" class="btn btn-sm btn-primary pull-right" id="vendor_add_member" >Add New</button>
									<div class="form-group">
										<table class="table table-bordered" id="tbody_member">
											<thead>
												<tr>
													<th width="12%">Name</th>
													<th width="12%">Designation</th>
													<th width="12%">Email</th>
													<th width="15%">Mobile</th>
													<th width="8%">Whatsapp</th>
													<th width="5%">Skype</th>
													<th width="5%">Telephone</th>
													<th width="10%">Main Seller</th>
													<!-- <th>Comments</th> -->
													<th width="12%">PMOC</th>
													<th width="10%">Last RFQ</th>
													<th width="4%">Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if(isset($vendor_details) && !empty($vendor_details)){
												$i=1;
												foreach($vendor_details as $vd){
													if($vendor_details[0]['vendor_dtl_id'] == '' || $vendor_details[0]['vendor_dtl_id'] == null){
														continue;
													}
											?>
													<tr>
														<td><input class="form-control" type="text" name="name[]" value="<?php echo $vd['name']; ?>"></td>
														<td><input class="form-control" type="text" name="designation[]" value="<?php echo $vd['designation']; ?>"></td>
														<td><input class="form-control validate[custom[email]]" type="text" name="email[]" value="<?php echo $vd['email']; ?>"></td>
														<td><input class="form-control" type="text" name="mobile[]" value="<?php echo $vd['mobile']; ?>"></td>
														<td>
															<select class="form-control" name="is_whatsapp[]">
																<option value="Yes" <?php if($vd['is_whatsapp'] == 'Yes') echo 'selected="selected"';?>>Yes</option>
																<option value="No" <?php if($vd['is_whatsapp'] != 'Yes' || $vd['is_whatsapp'] == NULL) echo 'selected="selected"';?>>No</option>
															</select>
														</td>
														<td><input class="form-control" type="text" name="skype[]" value="<?php echo $vd['skype']; ?>"></td>
														<td><input class="form-control" type="text" name="telephone[]" value="<?php echo $vd['telephone']; ?>"></td>
														<td>
															<select class="form-control" name="main_seller[]">
																<option value="Yes" <?php if($vd['main_seller'] == 'Yes') echo 'selected="selected"';?>>Yes</option>
																<option value="No" <?php if($vd['main_seller'] != 'Yes' || $vd['main_seller'] == NULL) echo 'selected="selected"';?>>No</option>
															</select>
														</td>
														<td>
															<select class="form-control" name="pmoc[]">
																<option value=""></option>
																<option value="email" <?php if($vd['pmoc'] == 'email') echo 'selected="selected"';?>>Email</option>
																<option value="call" <?php if($vd['pmoc'] == 'call') echo 'selected="selected"';?>>Call</option>
																<option value="whatsapp" <?php if($vd['pmoc'] == 'whatsapp') echo 'selected="selected"';?>>Whatsapp</option>
															</select>
														</td>
														<td>-</td>
														<td>
															<?php /*if($vd['vendor_dtl_id'] > 0){?>
																<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect" title="Contact" member_id="<?php echo $vd['vendor_dtl_id']; ?>"><i class="la la-comment"></i></button>
															<?php }*/ ?>
															<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md delRow" title="Delete"><i class="la la-trash"></i></button>
														</td>
													</tr>
											<?php $i++; 
												} 
											} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>			
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-4"></div>
									<div class="col-lg-8">
										<?php if(isset($vendor_details)) echo '<input type="hidden" name="vendor_id" value="'.$vendor_id.'">'; ?>
										<button type="submit" class="btn btn-primary" name="save_rfq">Save Vendor</button>
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
<style type="text/css">
	th {
		text-align: center;
	}
</style>