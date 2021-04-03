<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<?php echo form_open('', array("class" => "kt-form kt-form--label-right", "id" => "invoice_form")); ?>
						<div class="kt-portlet__body">
							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">Invoice #</label>
									<input type="text" class="form-control validate[required]" placeholder="Please enter invoice #" name="invoice_no" value="<?php if(isset($invoice_details)) echo $invoice_details[0]['invoice_no']; ?>">
								</div>
								<div class="col-lg-3">
									<label class="">Invoice Date</label>
									<input type="text" class="form-control hasdatepicker validate[required]" value="<?php if(isset($invoice_details)) echo date('d-m-Y', strtotime($invoice_details[0]['invoice_date'])); else echo date('d-m-Y'); ?>" name="invoice_date">
								</div>
								<div class="col-lg-3">
									<label class="">Company</label>
									<div class="input-group">
										<select class="form-control select2 validate[required]" id="company" name="company">
											<option value="" disabled selected>Choose company</option>
											<?php 
												if(!empty($clients)){
													foreach ($clients as $key => $value) {
														$selected = '';
														if(isset($invoice_details) && $invoice_details[0]['company_id'] == $value['client_id']){
															$selected = 'selected = "selected"';
														}
														echo '<option value="'.$value['client_id'].'" '.$selected.'>'.ucwords(strtolower($value['client_name'])).' ('.$value['country'].')</option>';
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
									<label class="">Attention</label>
									<div class="input-group">
										<select class="form-control select2 validate[required]" id="attention" disabled="disabled" name="attention">
											<option value="" disabled selected>Choose Attention</option>
										</select>
										<div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_member" id="addNewMember" disabled="disabled">+</button>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th colspan="9">Invoice Preview <input type="button" class="btn btn-primary btn-sm" id="add_row" style="float:right;" value="Add Row"/></th>
											</tr>
											<tr>
												<th rowspan="2" width="5%">Sr #</th>
												<th rowspan="2" width="35%">Description</th>
												<th rowspan="2" width="10%">Quantity</th>
												<th rowspan="2" width="10%">Rate</th>
												<th rowspan="2" width="10%">Total</th>
												<th rowspan="2" width="12%">Product</th>
												<th rowspan="2" width="12%">Material</th>
												<th rowspan="2" width="6%">Action</th>
											</tr>
										</thead>
										<tbody id="tbody">
											<?php 
												if(isset($invoice_details)){
													$i=0;
													foreach ($invoice_details as $key => $value) { 
											?>
												<tr>
													<td><?php echo ++$i; ?></td>
													<td><textarea class="form-control validate[required]" name="description[]" ><?php echo $value['description']; ?></textarea></td>
													<td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] qty" name="quantity[]" value="<?php echo $value['quantity']; ?>"></td>
													<td><input type="text" class="form-control validate[required,custom[onlyNumberSp]] rate" name="rate[]" value="<?php echo $value['rate']; ?>"></td>
													<td><label class="price"><?php echo $value['price']; ?></label></td>
													<td><?php
															echo '<select class="form-control" id="product_select" name="product[]"><option value="">Select Product</option>';
															foreach($product as $prod){
																$selected= '';
																if($prod['lookup_id'] == $value['product_id']){
																	$selected = 'selected = "selected"';
																}
																echo '<option value="'.$prod['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($prod['lookup_value'])).'</option>';
															}
															echo '</select>';
													?></td>
													<td><?php
															echo '<select class="form-control id="material_select" name="material[]"><option value="">Select Material</option>';
															foreach($material as $mat){ 
																$selected= '';
																if($mat['lookup_id'] == $value['material_id']){
																	$selected = 'selected = "selected"';
																}
																echo '<option value="'.$mat['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($mat['lookup_value'])).'</option>';
															}
															echo '</select>';
													?></td>
													<td><button type="button" class="btn btn-danger btn-sm removeBtn">Delete</button></td>
												</tr>
											<?php
													}	
												}
											?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="8"></td>
											</tr>
											<tr>
												<td colspan="3" rowspan="4">
													<div class="form-group row">
														<div class="col-md-10">
															<label>Remarks</label>
															<textarea class="form-control" name="remarks" id="remarks"><?php if(isset($invoice_details)) echo $invoice_details[0]['remarks']; ?></textarea>
														</div>
													</div>
												</td>
												<td colspan="2" rowspan="5"></td>
												<td colspan="2">Net Total</td>
												<td id="net_total"><?php if(isset($invoice_details)) echo $invoice_details[0]['net_total']; ?></td>
											</tr>
											<tr>
												<td colspan="2">Discount</td>
												<td id="freight"><input type="text" class="form-control validate[custom[onlyNumberSp]]" name="discount" id="discount" value="<?php if(isset($invoice_details)) echo $invoice_details[0]['discount']; ?>"></td>
											</tr>
											<tr>
												<td colspan="2">Freight</td>
												<td id="freight"><input type="text" class="form-control validate[custom[onlyNumberSp]]" name="freight_charges" id="freight_charges" value="<?php if(isset($invoice_details)) echo $invoice_details[0]['freight_charge']; ?>"></td>
											</tr>
											<tr>
												<td colspan="2">Other Charges</td>
												<td id="other"><input type="text" class="form-control validate[custom[onlyNumberSp]]" name="other_charges" id="other_charges" value="<?php if(isset($invoice_details)) echo $invoice_details[0]['other_charge']; ?>"></td>
											</tr>
											<tr>
												<td colspan="3">
													<label>Mode</label>
													<select class="form-control" name="mode">
														<option value="air" <?php if(isset($invoice_details) && $invoice_details[0]['mode'] == 'air') echo 'selected="selected"'; ?>>Airways</option>
														<option value="sea" <?php if(isset($invoice_details) && $invoice_details[0]['mode'] == 'sea') echo 'selected="selected"'; ?>>Seaways</option>
													</select>
												</td>
												<td colspan="2" style="font-weight: bold">Grand Total</td>
												<td id="grand_total"><?php if(isset($invoice_details)) echo $invoice_details[0]['grand_total']; ?></td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-12 text-center">
										<?php if(isset($invoice_details)){ echo '<input type="hidden" name="invoice_id" value="'.$invoice_id.'">'; }?>
										<button type="Submit" class="btn btn-primary" name="save_invoice">Save Invoice</button>
										<!-- <button type="Submit" class="btn btn-primary" name="send_quotation">Send Quotation</button> -->
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
			<?php echo form_open('', array('id' => 'addCompany', 'class' => 'kt-form kt-form--label-right', 'autocomplete' => 'off'));?>
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
								<input type="text" class="form-control validate[required] company_name" id="company_name" name="company_name">
							</div>
							<div class="row">
								<div class="col-12">
									<div id="company_result_client" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 80%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; margin-top: -25px;">
									</div>
								</div>
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

<style>
	thead th{
		text-align: center;
	}
</style>