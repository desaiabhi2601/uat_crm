<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<?php echo form_open('', array("class" => "kt-form kt-form--label-right", "id" => "addrfq_form", "onsubmit" => "loader()")); ?>
						<div class="kt-portlet__body">
							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">Sent By</label>
									<select class="form-control validate[]" name="rfq_sentby" id="rfq_sentby" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
										<option value="">Choose Sales Person</option>
										<?php foreach ($sales_person as $value) {
											$selected = '';
											if(isset($rfq_details) && $rfq_details[0]['rfq_sentby'] == $value['user_id']){
												$selected = 'selected="selected"';
											}
										?>
											<option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-lg-3">
									<label class="">Assign To</label>
									<select class="form-control validate[]" name="assigned_to" id="assigned_to" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
										<option value="">Choose Purchase Manager</option>
										<?php foreach ($purchase_person as $value) {
											$selected = '';
											if(isset($rfq_details) && $rfq_details[0]['assigned_to'] == $value['user_id']){
												$selected = 'selected="selected"';
											}
										?>
											<option value="<?php echo $value['user_id']; ?>" <?php echo $selected; ?>><?php echo $value['name']; ?></option>
										<?php } ?>
									</select>
								</div>

								<div class="col-lg-3">
									<label class="">Company</label>
									<div class="input-group">
										<?php /*<select class="form-control validate[]" id="rfq_company" name="rfq_company" <?php if($this->session->userdata('role') != 6){ echo 'readonly'; }?>>
											<option value="">Choose Company</option>
											<?php foreach ($clients as $key => $value) {
												$selected = '';
												if(isset($rfq_details) && $rfq_details[0]['rfq_company'] == $value['client_id'] && $rfq_details[0]['client_source'] == $value['client_source']){
													$selected = 'selected="selected"';
												}
											?>
												<option value="<?php echo $value['client_id']; ?>" rank="<?php echo $value['client_rank']; ?>"source="<?php echo $value['client_source']; ?>" last_pur="<?php echo $value['last_purchased']; ?>" <?php echo $selected; ?>><?php echo $value['client_name']; ?></option>
											<?php } ?>
										</select>*/ ?>
										<input type="text" class="form-control" id="rfq_company" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['rfq_company_name']; ?>">
										<input type="hidden" name="rfq_company" id="rfq_company_hidden" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['rfq_company']; ?>">
										<div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_company">+</button>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<div id="company_result" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 80%; max-height: 100px; height: 100px; overflow-y: scroll; display: none;">
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-3">
									<label class="">Name of Buyer</label>
									<div class="input-group">
										<select class="form-control validate[]" id="rfq_buyer" name="rfq_buyer" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
											<option value="">Choose Buyer</option>
										</select>
										<div class="input-group-append">
											<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#add_member">+</button>
										</div>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">Rank</label>
									<input type="text" class="form-control validate[]" name="rfq_rank" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['rfq_rank']; ?>" id="rfq_rank" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
									<input type="hidden" name="client_source" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['client_source']; ?>" id="client_source">
								</div>

								<div class="col-lg-3">
									<label class="">Last Buy</label>
									<input type="text" class="form-control validate[]" name="rfq_lastbuy" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['rfq_lastbuy']; ?>" id="rfq_lastbuy" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
								</div>

								<?php /*<div class="col-lg-3">
									<label class="">Reference</label>
									<input type="text" class="form-control validate[]" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['reference']; ?>" name="reference">
								</div> */?>

								<div class="col-lg-6">
									<label>RFQ Subject</label>
									<input type="text"  class="form-control validate[]" name="rfq_subject" id="rfq_subject" value="<?php if(isset($rfq_details)) echo $rfq_details[0]['rfq_subject']; ?>" <?php if($this->session->userdata('role') != 6 && $this->session->userdata('user_id') != 22 && $this->session->userdata('user_id') != 38 && $this->session->userdata('role') != 1 && $this->session->userdata('user_id') != 33){ echo 'readonly'; }?>>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-lg-3">
									<label class="">Importance</label>
									<select class="form-control validate[]" name="rfq_importance">
										<option value="">Select</option>
										<option value="L" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_importance'] == 'L'){ echo 'selected="selected"'; } ?>>Low</option>
										<option value="M" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_importance'] == 'M'){ echo 'selected="selected"'; } ?>>Medium</option>
										<option value="H" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_importance'] == 'H'){ echo 'selected="selected"'; } ?>>High</option>
										<option value="V" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_importance'] == 'V'){ echo 'selected="selected"'; } ?>>Very High</option>
									</select>
								</div>

								<!-- <div class="col-lg-3">
									<label class="">Notes</label>
									<textarea class="form-control" name="rfq_notes" id="rfq_notes"></textarea>
								</div> -->

								<div class="col-lg-3">
									<label class="">Status</label>
									<select class="form-control validate[]" name="rfq_status">
										<option value="waiting" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_status'] == 'waiting'){ echo 'selected="selected"'; } ?>>Waiting</option>
										<option value="pending" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_status'] == 'pending'){ echo 'selected="selected"'; } ?>>Pending</option>
										<option value="query" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_status'] == 'query'){ echo 'selected="selected"'; } ?>>Query</option>
										<option value="regret" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_status'] == 'regret'){ echo 'selected="selected"'; } ?>>Regret</option>
										<option value="done" <?php if(isset($rfq_details) && $rfq_details[0]['rfq_status'] == 'done'){ echo 'selected="selected"'; } ?>>Done</option>
									</select>
								</div>

								<?php if(isset($rfq_id)){ ?>
								<div class="col-lg-3">
									<button type="button" data-toggle="modal" data-target="#notes-modal" class="btn btn-xl btn-primary notes" title="Add Notes" style="margin-top: 25px;">Notes</button>
									<button type="button" data-toggle="modal" data-target="#query-modal" class="btn btn-xl btn-primary queries" title="Query" style="margin-top: 25px;">Query</button>
								</div>
								<?php } ?>

								<div class="col-lg-3">
									<label class="">Closing Date</label>
									<input type="text" class="form-control hasdatepicker validate[]" value="<?php if(isset($rfq_details) && $rfq_details[0]['rfq_closedate'] != ''){ echo date('d-m-Y', strtotime($rfq_details[0]['rfq_closedate'])); } ?>" name="rfq_closedate">
								</div>
							</div>

							<div class="row">
								<div class="col-12">
									<button type="button" class="btn btn-primary btn-sm" id="add_row" style="float: right;">Add Row</button>
								</div>
							</div>

							<?php
							$display = "none"; 
							if(isset($rfq_details) && $rfq_details[0]['rfq_dtl_id'] >0){
								$display = "block";
							}  
							?>
							<div class="row" id="preview_div" style="display: <?php echo $display; ?>">
								<div class="col-12">
									<table class="table table-bordered">
										<thead>
												<tr>
												<th colspan="7">
													RFQ Preview
												</th>
											</tr>
											<tr>
												<th width="5%">Sr. #</th>
												<th width="20%">Product</th>
												<th width="20%">Material</th>
												<th width="30%">Description</th>
												<th width="5%">Quantity</th>
												<th width="10%">Unit</th>
												<th width="10%">Action</th>
											</tr>
										</thead>
										<tbody id="tbody">
										<?php 
											if(!empty($rfq_details) && $rfq_details[0]['product_id'] != ''){ 
												foreach ($rfq_details as $key => $value) {
										?>
											<tr>
												<td><?php echo $key+1; ?></td>
												<td>
													<select class="form-control products" name="product_id[]">
														<option value="">Select Product</option>
														<?php foreach($product as $pd){
															$selected = '';
															if($value['product_id'] == $pd['lookup_id']){
																$selected = 'selected="selected"';
															}
															echo '<option value="'.$pd['lookup_id'].'" '.$selected.'>'.$pd['lookup_value'].'</option>';
														} ?>
													</select>
												</td>
												<td>
													<select class="form-control products" name="material_id[]">
														<option value="">Select Material</option>
														<?php foreach($material as $mt){
															$selected = '';
															if($value['material_id'] == $mt['lookup_id']){
																$selected = 'selected="selected"';
															}
															echo '<option value="'.$mt['lookup_id'].'" '.$selected.'>'.$mt['lookup_value'].'</option>';
														} ?>
													</select>
												</td>
												<td>
													<textarea class="form-control validate[required]" name="description[]"><?php echo $value['description']; ?></textarea>
												</td>
												<td>
													<input type="text" class="form-control validate[required,custom[onlyNumberSp]] quantity" name="quantity[]" value="<?php echo $value['quantity']; ?>">
												</td>
												<td>
													<select class="form-control products" name="unit[]">
														<option value="">Select Unit</option>
														<?php foreach($units as $un){
															$selected = '';
															if($value['unit'] == $un['unit_id']){
																$selected = 'selected="selected"';
															}
															echo '<option value="'.$un['unit_id'].'" '.$selected.'>'.$un['unit_value'].'</option>';
														} ?>
													</select>
												</td>
												<td>
													<button type="button" class="btn btn-sm btn-danger delRow">Delete</button>
												</td>
											</tr>	
										<?php  	}
											}
										?>
										</tbody>
									</table>
								</div>
							</div>							
						</div>
						
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<div class="row">
									<div class="col-lg-4"></div>
									<div class="col-lg-8">
										<?php if(isset($rfq_details)) echo '<input type="hidden" name="rfq_mst_id" value="'.$rfq_id.'">'; ?>
										<button type="submit" class="btn btn-primary" name="save_rfq">Save RFQ</button>
									</div>
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>

					<br/><br/>
					<?php if(isset($rfq_id)){ ?>
					<div class="row">
						<div class="col-12">
							<div class="tab-content" style="padding: 50px;">
								<div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
									<button type="button" class="btn btn-primary btn-sm" id="add_rfq_vendor" style="float: right;">Add Row</button>
									<table class="table table-bordered" id="vendor_table">
										<thead>
											<tr>
												<th>Sr. #</th>
												<th>Vendor</th>
												<th>Status</th>
												<th>Evaluate Offer</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												if(!empty($rfq_to_vendor)){
													$i=0;
													foreach ($rfq_to_vendor as $key => $value) { 
											?>
												<tr>
													<td><?php echo ++$i; ?></td>
													<td>
														<select class="form-control vendor" disabled="disabled">
														<?php foreach($vendors as $ven){
															$selected = '';
															if($ven['vendor_id'] == $value['vendor_id']){
																$selected = 'selected="selected"';
															}
															echo '<option value="'.$ven['vendor_id'].'" '.$selected.'>'.$ven['vendor_name'].'</option>';
														} ?>
														</select>
													</td>
													<td>
														<select class="form-control vendor_status">
															<option value="pending" <?php if($value['vendor_status'] == 'pending'){echo 'selected="selected"';}?>>Pending</option>
															<option value="query" <?php if($value['vendor_status'] == 'query'){echo 'selected="selected"';}?>>Query</option>
															<option value="regret" <?php if($value['vendor_status'] == 'regret'){echo 'selected="selected"';}?>>Regret</option>
															<option value="done" <?php if($value['vendor_status'] == 'done'){echo 'selected="selected"';}?>>Done</option>
														</select>
													</td>
													<td>
														<select class="form-control evaluate_price" style="width:30%; display: inline-block;">
															<option value="" <?php if($value['evaluate_price'] == ''){echo 'selected="selected"';}?>>Select Price</option>
															<option value="high" <?php if($value['evaluate_price'] == 'high'){echo 'selected="selected"';}?>>H</option>
															<option value="low" <?php if($value['evaluate_price'] == 'low'){echo 'selected="selected"';}?>>L</option>
														</select>
														<select class="form-control evaluate_delivery" style="width:45%; display: inline-block; margin-left: 5%">
															<option value="" <?php if($value['evaluate_delivery'] == ''){echo 'selected="selected"';}?>>Select Delivery</option>
															<option value="high" <?php if($value['evaluate_delivery'] == 'high'){echo 'selected="selected"';}?>>High</option>
															<option value="low" <?php if($value['evaluate_delivery'] == 'low'){echo 'selected="selected"';}?>>Low</option>
														</select>
													</td>
													<td>
														<a href="<?php echo site_url('procurement/viewPdf/'.$value['connect_id']); ?>" class="btn btn-xl btn-icon btn-icon-md viewRFQ" title="View PDF"><i class="la la-eye"></i></a> 
														<button type="button" class="btn btn-xl btn-icon btn-icon-md saveVendor" title="Save"><i class="la la-save"></i></button>
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
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!--begin::Client form-->
<div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Notes</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('procurement/addNotes'); ?>" method="post" id="rfq_note_frm">
               		<div class="row">
               			<div class="col-md-6 form-group">
               				<label for="notes">Add Note</label>
               				<textarea id="notes" name="notes" class="form-control validate[maxSize[100],required]"></textarea>
               			</div>
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" name="rfq_id" value="<?php echo $rfq_id; ?>">
               				<button class="btn btn-success" type="submit">Submit</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Notes History</h4>
                <div id="tab_history">
                	<table class="table table-bordered" id="notes_table">
                		<thead>
	                		<tr>
	                			<th width="70%">Notes</th>
	                			<th width="30%">Added On</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                		<?php 
                			foreach ($rfq_notes as $key => $value) {
                				echo '<tr connect_id = "'.$value['connect_id'].'" type="'.$value['type'].'">
                					<td>'.$value['note'].'</td>
                					<td>'.date('d M h:i:a', strtotime($value['entered_on'])).'</td>
                				</tr>';
                			}
                		?>
                		</tbody>
                	</table>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="query-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">RFQ Queries</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('procurement/addQuery'); ?>" method="post" id="rfq_query_frm">
               		<div class="row">
               			<div class="col-md-6 form-group">
               				<label for="notes"><?php if($this->session->userdata('role') == 5) { ?>Reply Query <?php } if($this->session->userdata('role') != 5) { ?>Add Query<?php } ?></label>
               				<textarea id="notes" name="notes" class="form-control validate[maxSize[100],required]"></textarea>
               			</div>
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" name="rfq_id" value="<?php echo $rfq_id; ?>">
               				<button class="btn btn-success" type="submit">Submit</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Queries History</h4>
                <div id="tab_history">
                	<table class="table" id="query_table">
                		<tbody>
                		<?php 
                			foreach ($rfq_query as $key => $value) {
                				$align="left";
                				if($value['entered_by'] == $this->session->userdata('user_id')){
                					$align="right";
                				}
                				echo '<tr connect_id = "'.$value['connect_id'].'" type="'.$value['type'].'">
                					<td>
                						<div style="text-align:'.$align.'">
                							'.$value['note'].'<br/>
                							<span style="font-size: 10px;">'.date('d M h:i a', strtotime($value['entered_on'])).'</span>
                						</div>
                					</td>
                				</tr>';
                			}
                		?>
                		</tbody>
                	</table>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<?php echo form_open('', array('id' => 'rfq_addCompany', 'class' => 'kt-form kt-form--label-right'));?>
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