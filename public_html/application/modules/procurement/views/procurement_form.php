<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<?php echo form_open('', array("class" => "kt-form kt-form--label-right", "id" => "procurement_form")); ?>
						<div class="kt-portlet__body">
							<div class="form-group row">
								<div class="col-lg-6">
									<label>Made By</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
										<select class="form-control validate[required]" name="made_by">
											<option value="">Select User</option>
											<?php
												if(!isset($proc_details) && $this->session->userdata('role') == 5){
													echo '<option value="'.$this->session->userdata('user_id').'" selected="selected">'.ucwords(strtolower($this->session->userdata('name'))).'</option>';	
												}
												else if(!empty($users)){
													foreach ($users as $key => $value) {
														$selected = '';
														if($this->session->userdata('user_id') == $value['user_id'] && !isset($proc_details)){
															$selected = 'selected="selected"';
														}

														if(isset($proc_details) && $proc_details[0]['made_by'] == $value['user_id']){
															$selected = 'selected="selected"';
														}
														echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<label>Assign To</label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
										<select class="form-control validate[required]" name="assigned_to">
											<option value="">Select User</option>
											<?php 
												if(!isset($proc_details) && $this->session->userdata('role') == 5){
													echo '<option value="'.$this->session->userdata('user_id').'" selected="selected">'.ucwords(strtolower($this->session->userdata('name'))).'</option>';	
												}
												else if(!empty($assignee)){
													foreach ($assignee as $key => $value) {
														$selected = '';
														if(isset($proc_details) && $proc_details[0]['assigned_to'] == $value['user_id']){
															$selected = 'selected="selected"';
														}
														echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
													}
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">RFQ No</label>
									<input type="hidden" name="rfq_no" value="<?php if(isset($proc_details)) echo $proc_details[0]['rfq_no']; ?>">
									<input type="text" class="form-control" placeholder="RFQ No" value="<?php if(isset($proc_details)) echo $proc_details[0]['rfq_no']; ?>" disabled>
								</div>
								<div class="col-lg-3">
									<label class="">Date</label>
									<input type="text" name="proc_date" id="proc_date" class="form-control hasdatepicker" <?php if(isset($proc_details)) { echo 'value="'.date('d-m-Y', strtotime($proc_details[0]['proc_date'])).'"'; } else { echo 'disabled'; } ?>>
								</div>
								<div class="col-lg-6">
									<label>Sent By</label>
									<select class="form-control validate[required]" name="sent_by">
											<option value="">Select User</option>
											<?php 
												if(!isset($proc_details) && $this->session->userdata('role') == 5){
													echo '<option value="'.$this->session->userdata('user_id').'" selected="selected">'.ucwords(strtolower($this->session->userdata('name'))).'</option>';	
												}
												else if(!empty($assignee)){
													foreach ($assignee as $key => $value) {
														$selected = '';
														if(isset($proc_details) && $proc_details[0]['sent_by'] == $value['user_id']){
															$selected = 'selected="selected"';
														}
														echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
													}
												}
											?>
										</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">Company</label>
									<div class="input-group">
										<select class="form-control select2 validate[required]" id="company" name="client_id">
											<option value="" disabled selected>Choose company</option>
											<?php 
												if(!empty($clients)){
													foreach ($clients as $key => $value) {
														$selected = '';
														if(isset($proc_details) && $proc_details[0]['client_id'] == $value['client_id']) {
															$selected='selected="selected"';
														}
														echo '<option '.$selected.' value="'.$value['client_id'].'">'.ucwords(strtolower($value['client_name'])).'</option>';
													}
												}
											?>
										</select>
										<div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_company">+</button>
										</div>
									</div>
								</div>

								<div class="col-lg-3">
									<label class="">Name</label>
									<div class="input-group">
										<select class="form-control select2 validate[required]" id="proc_name" name="proc_name">
											<option value="" disabled selected>Choose company</option>
											<?php 
												if(!empty($clients)){
													foreach ($clients as $key => $value) {
														$selected = '';
														if(isset($proc_details) && $proc_details[0]['proc_name'] == $value['proc_name']) {
															$selected='selected="selected"';
														}
														echo '<option '.$selected.' value="'.$value['proc_name'].'">'.ucwords(strtolower($value['proc_name'])).'</option>';
													}
												}
											?>
										</select>
										<!-- <div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_company">+</button>
										</div> -->
									</div>
								</div>
								<div class="col-lg-3">
									<label class="">Attention</label>
									<div class="input-group">
										<select class="form-control select2 validate[required]" id="attention" disabled="disabled" name="member_id">
											<option value="" disabled selected>Choose Attention</option>
										</select>
										<div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_member" id="addNewMember" disabled="disabled">+</button>
										</div>
									</div>
								</div>
								<div class="col-lg-3" id="ref_div" <?php if((isset($proc_details) && $proc_details['0']['stage'] != 'proforma') || !isset($proc_details)){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?>>
									<label class="">Reference</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Reference" name="reference" value="<?php if(isset($proc_details)) echo $proc_details[0]['reference']; ?>">
									</div>

									
									<div class="col-lg-3" id="ref_div" <?php if((isset($proc_details) && $proc_details['0']['stage'] != 'proforma') || !isset($proc_details)){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; } ?>>
									<label class="">Reference2</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Reference" name="reference" value="<?php if(isset($proc_details)) echo $proc_details[0]['reference']; ?>">
									</div>


								</div>
								<div class="col-lg-3" id="order_div" <?php if(isset($proc_details) && $proc_details['0']['stage'] == 'proforma'){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; }?>>
									<label class="">Order #</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Order #" name="order_no" value="<?php if(isset($proc_details)) echo $proc_details[0]['order_no']; ?>">
									</div>
								</div>
								<div class="col-lg-3" id="proforma_div" <?php if(isset($proc_details) && $proc_details['0']['stage'] == 'proforma'){ echo 'style="display: block;"'; }else{ echo 'style="display: none;"'; }?>>
									<label class="">Proforma #</label>
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Proforma #" name="proforma_no" value="<?php if(isset($proc_details)) echo $proc_details[0]['proforma_no']; ?>" readonly="readonly">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th colspan="11">Quotation Preview <input type="button" class="btn btn-primary btn-sm" id="add_row" style="float:right;" value="Add Row"/></th>
											</tr>
											<tr>
												<th rowspan="2" width="4%">Sr #</th>
												<th width="7%">Product<br/><button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_product">+</button></th>
												<th rowspan="2" width="20%">Description</th>
												<th rowspan="2" width="8%">Quantity</th>
												<th width="10%">Unit<br/><button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_unit">+</button></th>
												<th rowspan="2" width="8%">Cost</th>
												<th width="8%">Margin(%)</th>
												<th width="8%">Packaging Charges(%)</th>
												<th rowspan="2" width="9%">Unit Price</th>
												<th rowspan="2" width="9%">Total Price</th>
												<th rowspan="2" width="5%">Action</th>
											</tr>
											<tr>
												<td>
													<select class="form-control" id="parent_product"><option value="">Select Product</option><?php echo $prd_str; ?></select>
													<select class="form-control" id="parent_material"><option value="">Select Material</option><?php echo $mat_str; ?></select>
												</td>
												<td>
													<select class="form-control" id="parent_unit"><?php echo $unit_str; ?></select>
												</td>
												<td>
													<input type="text" class="form-control" id="parent_margin" placeholder="Margin (in percent)">
												</td>
												<td>
													<input type="text" class="form-control" id="parent_packaging" placeholder="Packaging (in percent)">
												</td>
											</tr>
										</thead>
										<tbody id="tbody">
											<?php 
												$k=0;
												if(isset($proc_details)){
													foreach ($proc_details as $key => $value) {
											?>
												<tr>
													<td><?php echo ++$k;?></td>
													<td><select class="form-control products" name="product_id[]">
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
														<select class="form-control materials" name="material_id[]">
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
														<textarea class="form-control validate[required]" name="description[]"><?php echo $value['description'];?></textarea>
													</td>
													<td>
														<input type="text" class="form-control validate[required,custom[onlyNumberSp]] quantity" name="quantity[]" value="<?php echo $value['quantity']; ?>">
													</td>
													<td>
														<select class="form-control units" name="unit[]">
															<?php foreach($units as $uts){
																$selected = '';
																if($uts['unit_id'] == $value['unit']){
																	$selected = 'selected = "selected"';
																}
																echo '<option '.$selected.' value="'.$uts['unit_id'].'">'.ucwords(strtolower($uts['unit_value'])).'</option>';
															}?>
														</select>
													</td>
													<td>
														<input type="text" class="form-control <?php if($value['unit_rate'] != '') echo 'validate[required,custom[onlyNumberSp]]'; ?> rate" name="unit_rate[]" <?php if($value['unit_rate'] != '') echo 'value="'.$value['unit_rate'].'"'; else echo 'readonly="readonly"'; ?>>
													</td>
													<td>
														<input type="text" class="form-control <?php if($value['unit_rate'] != '') echo 'validate[required,custom[onlyNumberSp]]'; ?> margin" name="margin[]" <?php if($value['margin'] != '') echo 'value="'.$value['margin'].'"'; else echo 'readonly="readonly"'; ?>>
													</td>
													<td>
														<input type="text" class="form-control <?php if($value['unit_rate'] != '') echo 'validate[required,custom[onlyNumberSp]]'; ?> packingCharge" name="packing_charge[]" <?php if($value['unit_rate'] != '') echo 'value="'.$value['packing_charge'].'"'; else echo 'readonly="readonly"'; ?>>
													</td>
													<td>
														<label class="unit_price"><?php if($value['unit_rate'] != '') echo $value['unit_price']; ?></label>
														<input type="text" class="form-control validate[custom[onlyNumberSp]] unit_price_txt" name="unit_price[]" <?php if($value['unit_rate'] == '') echo 'value="'.$value['unit_price'].'"'; ?>>
													</td>
													<td>
														<label class="total_price"><?php echo $value['row_price']; ?></label>
													</td>
													<td>
														<button class="btn btn-sm btn-danger delRow">Delete</button>
													</td>
												</tr>
											<?php
													}
												}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="11"></td>
											</tr>
											<tr>
												<td colspan="7" rowspan="8"></td>
												<td colspan="2">Net Total</td>
												<td colspan="2" id="net_total"><?php if(isset($proc_details)) echo $proc_details[0]['net_total']; ?></td>
											</tr>
											<tr>
												<td colspan="2">Discount Type</td>
												<td colspan="2">
													<select id="discount_type" class="form-control" name="discount_type">
														<option value="percent" <?php if(isset($proc_details) && $proc_details[0]['discount_type'] == 'percent') echo 'selected="selected";';?>>Percent</option>
														<option value="value" <?php if(isset($proc_details) && $proc_details[0]['discount_type'] == 'value') echo 'selected="selected";';?>>Value</option>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2">Discount</td>
												<td colspan="2"><input type="text" name="discount" id="discount" class="form-control validate[custom[onlyNumberSp]]" value="<?php if(isset($proc_details)) echo $proc_details[0]['discount']; ?>"></td>
											</tr>
											<tr>
												<td colspan="2">Freight <button class="btn btn-sm btn-warning" type="button" data-toggle="modal" data-target="#freight_calc_modal"><i class="fa fa-calculator" aria-hidden="true"></i></button></td>
												<td colspan="2"><input type="text" name="freight" id="freight" class="form-control" name="freight" value="<?php if(isset($proc_details)) echo $proc_details[0]['freight']; ?>"></td>
											</tr>
											<tr>
												<td colspan="2">Bank Charges</td>
												<td colspan="2"><input type="text" name="bank_charges" id="bank_charges" class="form-control" value="<?php if(isset($proc_details)) echo $proc_details[0]['bank_charges']; ?>"></td>
											</tr>
											<tr id="gst_tr" <?php if(isset($proc_details) && $proc_details[0]['gst'] > 0) echo 'style="display: contents;"'; else echo 'style="display: none;"';?>>
												<td colspan="2">GST (18%)</td>
												<td colspan="2"><span id="gst_span"><?php if(isset($proc_details) && $proc_details[0]['gst'] > 0) echo $proc_details[0]['gst']; ?></span><input type="hidden" name="gst" id="gst" value="<?php if(isset($proc_details) && $proc_details[0]['gst'] > 0) echo $proc_details[0]['gst']; ?>"></td>
											</tr>
											<tr>
												<td colspan="4">
													<div class="accordion" id="accordionExample">
														<div class="card">
															<div class="card-header" id="headingOne">
																<button class="btn btn-primary btn-xs pull-right" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																	( + )
																</button>
															</div>

															<div id="collapseOne" class="collapse <?php if(isset($proc_details) && $proc_details[0]['other_charges'] > 0) echo 'show';?>" aria-labelledby="headingOne" data-parent="#accordionExample">
																<div class="card-body">
																	<table class="table table-bordered">
																		<tr>
																			<td width="50%">Other Charges</td>
																			<td width="50%"><input type="text" name="other_charges" id="other_charges" class="form-control validate[custom[onlyNumberSp]]" value="<?php if(isset($proc_details)) echo $proc_details[0]['other_charges']; ?>"></td>
																		</tr>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<td colspan="2" style="font-weight: bold">Grand Total</td>
												<td colspan="2" id="grand_total"><?php if(isset($proc_details)) echo $proc_details[0]['grand_total']; ?></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<h5>Terms & Conditions</h5>
								</div>

								<div class="col-lg-12">
									<table class="table">
										<tr>
											<td width="50%">
												<table class="table table-bordered">
													<tr>
														<td>Delivered To</td>
														<td id="delivered_to_td">
															<select id="delivered_through" class="form-control" name="delivered_through">
																<?php foreach($delivery as $option){
																	$selected = '';
																	if(isset($proc_details) && $option['delivery_id'] == $proc_details[0]['delivered_through']){
																		$selected = 'selected = "selected"';
																	}
																?>
																	<option <?php echo $selected; ?> value="<?php echo $option['delivery_id']; ?>" trans_id = "<?php echo $option['transport_id']; ?>"><?php echo $option['delivery_name']; ?></option>
																<?php } ?>
															</select>
														</td>
													</tr>
													<tr>
														<td>Delivery Time</td>
														<td>
															<div class="input-group">
																<select class="form-control" id="delivery_time" name="delivery_time">
																	<?php foreach($delivery_time as $option){
																		$selected = '';
																		if(isset($proc_details) && $option['dt_id'] == $proc_details[0]['delivery_time']){
																			$selected = 'selected = "selected"';
																		}
																	?>
																		<option <?php echo $selected; ?> value="<?php echo $option['dt_id']; ?>"><?php echo $option['dt_value']; ?></option>
																	<?php } ?>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_delivery_time">+</button>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td>Payment</td>
														<td>
															<div class="input-group">
																<select class="form-control" id="payment_term" name="payment_term">
																	<?php foreach($payment_terms as $option){ 
																		$selected = '';
																		if(isset($proc_details) && $option['term_id'] == $proc_details[0]['payment_term']){
																			$selected = 'selected = "selected"';
																		}
																	?>
																		<option <?php echo $selected; ?> value="<?php echo $option['term_id']; ?>"><?php echo $option['term_value']; ?></option>
																	<?php } ?>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_payment_terms">+</button>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td>Validity</td>
														<td>
															<div class="input-group">
																<select class="form-control" id="validity" name="validity">
																	<?php foreach($validity as $option){ 
																		$selected = '';
																		if(isset($proc_details) && $option['validity_id'] == $proc_details[0]['validity']){
																			$selected = 'selected = "selected"';
																		}
																	?>
																		<option <?php echo $selected; ?> value="<?php echo $option['validity_id']; ?>"><?php echo $option['validity_value']; ?></option>
																	<?php } ?>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_validity">+</button>
																</div>
															</div>
														</td>
													</tr>
													<!-- <tr>
														<td>Make</td>
														<td>
															<div class="input-group">
																<select id="make" class="form-control">
																	<option>OM Tubes</option>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_delivery_time">+</button>
																</div>
															</div>
														</td>
													</tr> -->
												</table>
											</td>
											<td width="50%">
												<table class="table table-bordered">
													<tr>
														<td>Currency</td>
														<td>
															<select id="currency" class="form-control" name="currency">
																<?php foreach($currency as $option){ 
																	$selected = '';
																	if(isset($proc_details) && $option['currency'] == $proc_details[0]['currency']){
																		$selected = 'selected = "selected"';
																		if($proc_details[0]['currency_rate'] > 0){
																			$option['currency_rate'] = $proc_details[0]['currency_rate'];
																		}
																	}
																?>
																	<option <?php echo $selected; ?> rate="<?php echo $option['currency_rate']; ?>" value="<?php echo $option['currency_id']; ?>"><?php echo $option['currency']; ?></option>
																<?php } ?>
															</select>
															<input type="hidden" name="currency_rate" id="currency_rate" <?php if(isset($proc_details)) { echo 'value="'.$proc_details[0]['currency_rate'].'"'; } ?>>
														</td>
													</tr>
													<tr>
														<td>Country of Origin</td>
														<td>
															<div class="input-group">
																<select id="origin_country" class="form-control" name="origin_country">
																	<?php foreach($origin_country as $option){ 
																		$selected = '';
																		if(isset($proc_details) && $option['country_id'] == $proc_details[0]['origin_country']){
																			$selected = 'selected = "selected"';
																		}
																	?>
																		<option <?php echo $selected; ?> value="<?php echo $option['country_id']; ?>"><?php echo $option['country']; ?></option>
																	<?php } ?>
																</select>
																<div class="input-group-append">
																	<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_origin">+</button>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td>MTC Type</td>
														<td>
															<select class="form-control" id="mtc_type" name="mtc_type">
																<?php foreach($mtc_type as $option){ 
																	$selected = '';
																	if(isset($proc_details) && $option['mtc_id'] == $proc_details[0]['mtc_type']){
																		$selected = 'selected = "selected"';
																	}
																?>
																	<option <?php echo $selected; ?> value="<?php echo $option['mtc_id']; ?>"><?php echo $option['mtc_value']; ?></option>
																<?php } ?>
															</select>
														</td>
													</tr>
													<tr>
														<td>Packing Type</td>
														<td>
															<select class="form-control" id="transport_mode" name="transport_mode">
																<?php foreach($transport_mode as $option){ 
																	$selected = '';
																	if(isset($proc_details) && $option['mode_id'] == $proc_details[0]['transport_mode']){
																		$selected = 'selected = "selected"';
																	}
																?>
																	<option <?php echo $selected; ?> value="<?php echo $option['mode_id']; ?>"><?php echo $option['mode']; ?></option>
																<?php } ?>
															</select>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-4"></div>
									<div class="col-lg-8">
										<?php if(isset($proc_details)) echo '<input type="hidden" name="quote_id" value="'.$quote_id.'">'; ?>
										<button type="submit" class="btn btn-primary" name="save_quotation">Save Quotation</button>
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

<!--begin::Modal-->
<div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'addCompany', 'class' => 'kt-form kt-form--label-right'));?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Client</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="recipient-name" class="form-control-label">Company Name:</label>
								<input type="text" class="form-control validate[required]" id="company_name" name="company_name">
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Country:</label>
								<select class="form-control validate[required]" id="country" name="country">
									<option value="" disbaled>Select</option>
									<?php 
										foreach ($country as $key => $value) {
											echo '<option value="'.$value['lookup_id'].'" region="'.$value['parent'].'" readonly>'.ucwords(strtolower($value['lookup_value'])).'</option>';
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Region:</label>
								<select class="form-control validate[required]" id="region" name="region">
									<option value="" disbaled>Select</option>
									<?php 
										foreach ($region as $key => $value) {
											echo '<option value="'.$value['lookup_id'].'" >'.ucwords(strtolower($value['lookup_value'])).'</option>';
										}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-sm-12">
							<div class="form-group">
								<label for="message-text" class="form-control-label">Website:</label>
								<input type="text" class="form-control validate[custom[url]]" id="website" name="website">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Client</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="add_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'addMember', 'class' => 'kt-form kt-form--label-right'));?>
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Company Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Name:</label>
							<input type="text" class="form-control validate[required]" id="name" name="name">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Email:</label>
							<input type="email" class="form-control validate[required,custom[email]]" id="email" name="email">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Mobile #:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="mobile" name="mobile">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Whatsapp #:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="whatsapp" name="whatsapp">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Skype ID:</label>
							<input type="text" class="form-control" id="skype" name="skype">
						</div>

						<div class="col-md-4 col-sm-12">
							<label for="message-text" class="form-control-label">Telephone:</label>
							<input type="number" class="form-control validate[custom[onlyNumberSp]]" id="telephone" name="telephone">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addMemberBtn" class="btn btn-primary">Add Member</button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--end::Modal-->


<div class="modal fade" id="add_delivery_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'delivery_time_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Delivery Time</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_delivery_time" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addDeliveryBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>


<div class="modal fade" id="add_payment_terms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'payment_term_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Payment Term</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_payment_term" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addPaymentBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="add_validity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'validity_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Validity</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_validity" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addValidtyBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="add_origin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'origin_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Origin Country</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_origin" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addOriginBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="add_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'unit_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Unit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_unit" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addUnitBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<?php echo form_open('', array('id' => 'product_frm')); ?>
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="text" id="new_product" class="form-control validate[required]" placeholder="Add new value">
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" id="addProductBtn" class="btn btn-primary">Submit</button>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>

<div class="modal fade" id="freight_calc_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Freight Calculator</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<?php echo form_open('', array('id' => 'freight_calc')); ?>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="fc_trans_mode">Transport Mode</label>
							<select class="form-control validate[required]" id="fc_trans_mode">
								<option value="sea">Sea Worthy</option>
								<option value="air">Air Worthy</option>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="fc_terms">Terms</label>
							<select class="form-control validate[required]" id="fc_terms">
								<option value="">Select</option>
								<option value="CIF" type="sea">CIF</option>
								<option value="FOB" type="sea">FOB</option>
								<option value="DDU" type="air" style="display: none;">DDU</option>
								<option value="FOB" type="air" style="display: none;">FOB</option>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="fc_weight">Weight</label>
							<input type="text" id="fc_weight" class="form-control validate[required,custom[onlyNumberSp]]" placeholder="in kilograms">
						</div>
						<div class="col-md-6 form-group">
							<label for="fc_overlength">Overlength Pipes</label>
							<select id="fc_overlength" class="form-control validate[required]">
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</div>
						<div class="col-md-6 form-group" id="sea_country">
							<label for="fc_country">Country</label>
							<select id="fc_country" class="form-control validate[required]">
								<option value="">Select Country</option>
								<?php foreach($ports as $port){?>
									<option value="<?php echo $port['country']; ?>" port="<?php echo $port['port_name']; ?>" per_ton="<?php echo $port['per_ton']; ?>"><?php echo $port['country']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 form-group" id="air_country" style="display: none;" >
							<label for="fc_country_air">Country</label>
							<select id="fc_country_air" class="form-control validate[required]">
								<option value="">Select Country</option>
								<?php foreach($zones as $zone){?>
									<option value="<?php echo $zone['country']; ?>" zone="<?php echo $zone['zone_id']; ?>"><?php echo $zone['country']; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="fc_port">Port</label>
							<input type="text" disabled="disabled" id="fc_port" class="form-control">
						</div>
						<div class="col-md-12 form-group pull-right">
							<button type="submit" id="fc_submit" class="btn btn-success pull-right">Caclculate</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="fc_value">Freight Value (in USD)</label>
							<input type="text" disabled="disabled" id="fc_value" class="form-control">
						</div>
					</div>
				<?php echo form_close(); ?>
				<style>
					#freight_calc_modal .select2-container{
						display: block;
					}
				</style>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<style>
	thead th{
		text-align: center;
	}
</style>