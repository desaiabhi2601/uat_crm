<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">

					<!-- <div class="row">
						<div class="col-md-10"></div>
						<div class="col-md-2 pull-right">
							<a href="<?php echo site_url('pq/list'); ?>" class="btn btn-primary pull-right" style="margin-top: 5px; margin-right: 10px;"><< Back to List </a>
						</div>
					</div> -->
					
					<!-- form -->
					<?php echo form_open('', array('id' => 'addPQClient', 'class' => 'kt-form kt-form--label-right'));?>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Client Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="assigned_to" class="form-control-label">Handled By:</label>
										<select class="form-control validate[required]" id="assigned_to" name="assigned_to">
											<option value="" >Select</option>
											<?php 
												foreach ($users as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['assigned_to'] == $value['user_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['user_id'].'" '.$selected.'>'.ucwords(strtolower($value['name'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="company_name" class="form-control-label">Company Name:</label>
										<input type="text" class="form-control  validate[required]" id="company_name" name="company_name" value=
										"<?php if(isset($client_details)) echo $client_details[0]['company_name']; ?>">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="country" class="form-control-label">Country:</label>
										<select class="form-control validate" id="country" name="country">
											<option value="" >Select</option>
											<?php 
												foreach ($country as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['country'] == $value['lookup_id']){
														$selected = 'selected="selected"';
														$client_details[0]['region'] = $value['parent'];
													}
													echo '<option value="'.$value['lookup_id'].'" region="'.$value['parent'].'" '.$selected.' >'.ucwords(strtolower($value['lookup_value'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="region" class="form-control-label">Region:</label>
										<select class="form-control validate[required]" id="region" name="region">
											<option value="" >Select</option>
											<?php 
												foreach ($region as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['region'] == $value['lookup_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($value['lookup_value'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="website" class="form-control-label">Company Website:</label>
										<input type="text" class="form-control  validate[]" id="website" name="website" value=
										"<?php if(isset($client_details)) echo $client_details[0]['website']; ?>">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="priority" class="form-control-label">Priority Level:</label>
										<select class="form-control validate[required]" id="priority" name="priority">
											<option value="" >Select</option>
											<option value="H" <?php if(isset($client_details) && $client_details[0]['priority'] == 'H'){ echo 'selected="selected"'; }?>>High</option>
											<option value="M" <?php if(isset($client_details) && $client_details[0]['priority'] == 'M'){ echo 'selected="selected"'; }?>>Medium</option>
											<option value="L" <?php if(isset($client_details) && $client_details[0]['priority'] == 'L'){ echo 'selected="selected"'; }?>>Low</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="registration_id" class="form-control-label">Registration ID:</label>
										<input type="text" class="form-control" id="registration_id" name="registration_id" value=
										"<?php if(isset($client_details)) echo $client_details[0]['registration_id']; ?>">
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="registration_method" class="form-control-label">Registration Method:</label>
										<select class="form-control validate[required]" id="registration_method" name="registration_method">
											<option value="" >Select</option>
											<option value="online" <?php if(isset($client_details) && $client_details[0]['registration_method'] == 'online'){ echo 'selected="selected"'; }?>>Online</option>
											<option value="offline" <?php if(isset($client_details) && $client_details[0]['registration_method'] == 'offline'){ echo 'selected="selected"'; }?>>Offline</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="id_password" class="form-control-label">ID & Password</label>
										<textarea name="id_password" id="id_password" class="form-control"><?php if(isset($client_details)){ echo $client_details[0]['id_password']; }?></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="client_category" class="form-control-label">Client Category:</label>
										<select class="form-control" id="client_category" name="client_category">
											<option value="" >Select</option>
											<?php 
												foreach ($client_category as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['client_category'] == $value['lead_type_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_type_id'].'" '.$selected.' >'.ucwords(strtolower($value['type_name'])).'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="client_stage" class="form-control-label">Client Stage:</label>
										<select class="form-control" id="client_stage" name="client_stage">
											<option value="" >Select</option>
											<?php 
												/*foreach ($client_stage as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['client_stage'] == $value['lead_stage_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_stage_id'].'" '.$selected.' >'.ucwords(strtolower($value['stage_name'])).'</option>';
												}*/
											?>
											<option value="1" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 1){ echo 'selected="selected"'; } ?>>Stage 1 - We have not done anything about it</option>
											<option value="2" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 2){ echo 'selected="selected"'; } ?>>Stage 2 - We tried to initiate the registration but could not move ahead</option>
											<option value="3" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 3){ echo 'selected="selected"'; } ?>>Stage 3 - We initiated the registration</option>
											<option value="4" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 4){ echo 'selected="selected"'; } ?>>Stage 4 - Registration followed up</option>
											<option value="5" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 5){ echo 'selected="selected"'; } ?>>Stage 5 - Registered</option>
											<option value="6" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 6){ echo 'selected="selected"'; } ?>>Stage 6 - We received rfq</option>
											<option value="7" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 7){ echo 'selected="selected"'; } ?>>Stage 7 - We received order</option>
											<option value="8" <?php if(isset($client_details) && $client_details[0]['client_stage'] == 8){ echo 'selected="selected"'; } ?>>Stage 0 - Blacklisted Cos.</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="important_links" class="form-control-label">Important Links:</label>
										<textarea name="important_links" id="important_links" class="form-control"><?php if(isset($client_details)) echo $client_details[0]['important_links']; ?></textarea>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="client_status" class="form-control-label">Client Status:</label>
										<select class="form-control" id="client_status" name="client_status">
											<option value="" >Select</option>
											<option value="pending" <?php if(isset($client_details) && $client_details[0]['client_status'] == 'pending'){ echo 'selected="selected"'; }?>>Pending</option>
											<?php if(isset($client_details)){ ?>
											<option value="approved" <?php if(isset($client_details) && $client_details[0]['client_status'] == 'approved'){ echo 'selected="selected"'; }?>>Approved</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="row approved_fields" <?php if(!(isset($client_details) && $client_details[0]['client_status'] == 'approved')) { ?> style="display: none;" <?php } ?>>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="vendor_id" class="form-control-label">Vendor ID:</label>
										<input type="text" class="form-control" id="vendor_id" name="vendor_id" value=
										"<?php if(isset($client_details)) echo $client_details[0]['vendor_id']; ?>">
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="order_system" class="form-control-label">Order System:</label>
										<select class="form-control" id="order_system" name="order_system">
											<option value="" >Select</option>
											<option value="offline"<?php if(isset($client_details) && $client_details[0]['order_system'] == 'offline'){ echo 'selected="selected"'; }?>>Offline</option>
											<option value="po" <?php if(isset($client_details) && $client_details[0]['order_system'] == 'po'){ echo 'selected="selected"'; }?>>P. O</option>
											<option value="bid" <?php if(isset($client_details) && $client_details[0]['order_system'] == 'bid'){ echo 'selected="selected"'; }?>>BID</option>
											<option value="tender" <?php if(isset($client_details) && $client_details[0]['order_system'] == 'tender'){ echo 'selected="selected"'; }?>>Tender</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="order" class="form-control-label">Order:</label>
										<select class="form-control" id="order" name="order">
											<option value="" >Select</option>
											<option value="yes" <?php if(isset($client_details) && $client_details[0]['order'] == 'yes'){ echo 'selected="selected"'; }?>>Yes</option>
											<option value="not yet" <?php if(isset($client_details) && $client_details[0]['order'] == 'not yet'){ echo 'selected="selected"'; }?>>Not Yet</option>
											<option value="routine order" <?php if(isset($client_details) && $client_details[0]['order'] == 'routine order'){ echo 'selected="selected"'; }?>>Routine Order</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="last_order_date" class="form-control-label">Last Order Date:</label>
										<input type="text" class="form-control hasdatepicker" id="last_order_date" name="last_order_date" value=
										"<?php if(isset($client_details)) echo $client_details[0]['last_order_date']; ?>">
									</div>
								</div>
							</div>

							<div class="row approved_fields" <?php if(!(isset($client_details) && $client_details[0]['client_status'] == 'approved')) { ?> style="display: none;" <?php } ?>>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="enquiry" class="form-control-label">Enquiry:</label>
										<select class="form-control" id="enquiry" name="enquiry">
											<option value="" >Select</option>
											<option value="yes" <?php if(isset($client_details) && $client_details[0]['enquiry'] == 'yes'){ echo 'selected="selected"'; }?>>Yes</option>
											<option value="not yet" <?php if(isset($client_details) && $client_details[0]['enquiry'] == 'not yet'){ echo 'selected="selected"'; }?>>Not Yet</option>
											<option value="routine order" <?php if(isset($client_details) && $client_details[0]['enquiry'] == 'routine order'){ echo 'selected="selected"'; }?>>Routine Enquiry</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="last_enquiry_date" class="form-control-label">Last Enquiry Date:</label>
										<input type="text" class="form-control hasdatepicker" id="last_enquiry_date" name="last_enquiry_date" value=
										"<?php if(isset($client_details) && $client_details[0]['last_enquiry_date'] != '1970-01-01') echo $client_details[0]['last_enquiry_date']; ?>">
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="approval_document" class="form-control-label">Approval Document:</label>
										<select class="form-control" id="approval_document" name="approval_document">
											<option value="" >Select</option>
											<option value="available" <?php if(isset($client_details) && $client_details[0]['approval_document'] == 'available'){ echo 'selected="selected"'; }?>>Available</option>
											<option value="not available" <?php if(isset($client_details) && $client_details[0]['approval_document'] == 'not available'){ echo 'selected="selected"'; }?>>Not Available</option>
											<option value="na" <?php if(isset($client_details) && $client_details[0]['approval_document'] == 'na'){ echo 'selected="selected"'; }?>>NA</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="upload_document">Upload Dcoument</label>
										<div class="dropzone dropzone-default" id="upload_document">
											<div class="dropzone-msg dz-message needsclick">
												<h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
												<span class="dropzone-msg-desc"></span>
											</div>
										</div>
										<?php if(isset($client_details) && $client_details[0]['upload_document']){ ?>
											<a href="<?php echo site_url('assets/pq-document/'.$client_details[0]['upload_document']); ?>" target="_blank">View uploaded document</a>
										<?php } ?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<h4>Members</h4>
									<button type="button" class="btn btn-sm btn-primary pull-right" id="lead_add_member" >Add New</button>
									<div class="form-group">
										<table class="table table-bordered" id="lead_member_grid">
											<thead>
												<tr>
													<th width="12%">Name</th>
													<th width="12%">Designation</th>
													<th width="12%">Email</th>
													<th width="10%">Mobile</th>
													<th width="6%">Whatsapp</th>
													<th width="7%">Skype</th>
													<th width="7%">Telephone</th>
													<th width="6%">MainBuyer</th>
													<!-- <th>Comments</th> -->
													<th width="10%">Last Contact Date</th>
													<th width="10%">Mode</th>
													<th width="8%">Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if(isset($client_details) && !empty($client_details)){
												$i=1;
												foreach($client_details as $cm){
													if($client_details[0]['lead_dtl_id'] == '' || $client_details[0]['lead_dtl_id'] == null){
														continue;
													}
													if($cm['other_member'] == 'Y'){
														continue;
													}
											?>
													<tr>
														<td><input class="form-control" type="text" name="name[]" value="<?php echo $cm['member_name']; ?>"></td>
														<td><input class="form-control" type="text" name="designation[]" value="<?php echo $cm['designation']; ?>"></td>
														<td><input class="form-control validate[custom[email]]" type="text" name="email[]" value="<?php echo $cm['email']; ?>"></td>
														<td><input class="form-control" type="text" name="mobile[]" value="<?php echo $cm['mobile']; ?>"></td>
														<td>
															<select class="form-control" name="is_whatsapp[]">
																<option value="Yes" <?php if($cm['is_whatsapp'] == 'Yes') echo 'selected="selected"';?>>Yes</option>
																<option value="No" <?php if($cm['is_whatsapp'] != 'Yes' || $cm['is_whatsapp'] == NULL) echo 'selected="selected"';?>>No</option>
															</select>
														</td>
														<td><input class="form-control" type="text" name="skype[]" value="<?php echo $cm['skype']; ?>"></td>
														<td><input class="form-control" type="text" name="telephone[]" value="<?php echo $cm['telephone']; ?>"></td>
														<td>
															<select class="form-control" name="main_buyer[]">
																<option value="Yes" <?php if($cm['main_buyer'] == 'Yes') echo 'selected="selected"';?>>Yes</option>
																<option value="No" <?php if($cm['main_buyer'] != 'Yes' || $cm['main_buyer'] == NULL) echo 'selected="selected"';?>>No</option>
															</select>
														</td>
														<td>
															<?php 
																if(isset($client_connects) && !empty($client_connects)){
																	foreach ($client_connects as $key => $value) {
																		if($value['member_id'] == $cm['lead_dtl_id']){
																			$resp = date('d-m-Y', strtotime($value['connected_on']));
																			break;
																		}else{
																			$resp = '-';
																		}
																	}
																	echo $resp;
																}else{
																	echo '-';
																}
															?>
														</td>
														<td>
															<?php 
																if(isset($client_connects) && !empty($client_connects)){
																	foreach ($client_connects as $key => $value) {
																		if($value['member_id'] == $cm['lead_dtl_id']){
																			$resp = ucfirst($value['connect_mode']);
																			break;
																		}else{
																			$resp = '-';
																		}
																	}
																	echo $resp;
																}else{
																	echo '-';
																}
															?>
														</td>
														<td>
															<input type="hidden" name="lead_dtl_id[]" value="<?php echo $cm['lead_dtl_id']; ?>" class="member_id"><input type="hidden" name="other_member[]" value="">
															<?php if($cm['lead_dtl_id'] > 0){?>
															<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect" title="Contact"><i class="la la-comment"></i></button>
															<?php } ?>
															<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_delBtn" title="Delete"><i class="la la-trash"></i></button>
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
							<div class="row">
								<div class="col-md-12">
									<h4>Other Members</h4>
									<button type="button" class="btn btn-sm btn-primary pull-right" id="lead_add_non_member" >Add New</button>
									<div class="form-group">
										<table class="table table-bordered" id="lead_non_member_grid">
											<thead>
												<tr>
													<th width="14%">Name</th>
													<th width="14%">Designation</th>
													<th width="14%">Email</th>
													<th width="10%">Mobile</th>
													<th width="6%">Whatsapp</th>
													<th width="7%">Skype</th>
													<th width="7%">Telephone</th>
													<!-- <th>Comments</th> -->
													<th width="10%">Last Contact Date</th>
													<th width="10%">Mode</th>
													<th width="8%">Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if(isset($client_details) && !empty($client_details)){
												$i=1;
												foreach($client_details as $cm){
													if($cm['other_member'] != 'Y'){
														continue;
													}
												?>
													<tr>
														<td><input class="form-control" type="text" name="name[]" value="<?php echo $cm['member_name']; ?>"></td>
														<td><input class="form-control" type="text" name="designation[]" value="<?php echo $cm['designation']; ?>"></td>
														<td><input class="form-control" type="text" name="email[]" value="<?php echo $cm['email']; ?>"></td>
														<td><input class="form-control" type="text" name="mobile[]" value="<?php echo $cm['mobile']; ?>"></td>
														<td>
															<select class="form-control" name="is_whatsapp[]">
																<option value="Yes" <?php if($cm['is_whatsapp'] == 'Yes') echo 'selected="selected"';?>>Yes</option>
																<option value="No" <?php if($cm['is_whatsapp'] != 'Yes' || $cm['is_whatsapp'] == NULL) echo 'selected="selected"';?>>No</option>
															</select>
														</td>
														<td><input class="form-control" type="text" name="skype[]" value="<?php echo $cm['skype']; ?>"></td>
														<td><input class="form-control" type="text" name="telephone[]" value="<?php echo $cm['telephone']; ?>"></td>
														<td>
															<?php 
																if(isset($client_connects) && !empty($client_connects)){
																	foreach ($client_connects as $key => $value) {
																		if($value['member_id'] == $cm['lead_dtl_id']){
																			$resp = date('d-m-Y', strtotime($value['connected_on']));
																			break;
																		}else{
																			$resp = '-';
																		}
																	}
																	echo $resp;
																}else{
																	echo '-';
																}
															?>
														</td>
														<td>
															<?php 
																if(isset($client_connects) && !empty($client_connects)){
																	foreach ($client_connects as $key => $value) {
																		if($value['member_id'] == $cm['lead_dtl_id']){
																			$resp = ucfirst($value['connect_mode']);
																			break;
																		}else{
																			$resp = '-';
																		}
																	}
																	echo $resp;
																}else{
																	echo '-';
																}
															?>
														</td>
														<td><input type="hidden" name="lead_dtl_id[]" value="<?php echo $cm['lead_dtl_id']; ?>" class="member_id"><input type="hidden" name="other_member[]" value="Y"><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect" title="Contact"><i class="la la-comment"></i></button><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_delBtn" title="Delete"><i class="la la-trash"></i></button></td>
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

						<div class="modal-footer">
							<?php if(isset($client_details)){ ?>
								<input type="hidden" name="pq_client_id" value="<?php echo $client_details[0]['pq_client_id']; ?>">
							<?php } ?>
							<button type="submit" class="btn btn-primary"><?php if(isset($client_details)) echo 'Update Lead'; else echo 'Add Lead'; ?></button>
						</div>
					<?php echo form_close(); ?>
					<!-- form -->
				</div>
			</div>
		</div>
	</div>
</div>

<!--begin::Client form-->
<div class="modal fade" id="member-contact-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('pq/addComments'); ?>" method="post" id="lead_connect">
               		<div class="row">
               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Date</label>
               				<input type="text" id="contact_date" name="contact_date" class="form-control validate hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Mode</label>
               				<select class="form-control validate[required]" name="connect_mode" id="connect_mode">
               					<option value=""></option>
               					<option value="whatsapp">Whatsapp</option>
               					<option value="call">Call</option>
               					<option value="linkedin">LinkedIn</option>
               					<option value="email">Email</option>
               				</select>
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Email Sent</label>
               				<select class="form-control validate[required]" name="email_sent" id="email_sent">
               					<option value=""></option>
               					<option value="Yes">Yes</option>
               					<option value="No">No</option>
               				</select>
               			</div>

               			<div class="col-md-12 form-group">
               				<label for="contact_details">Comments</label>
               				<textarea id="contact_details" name="contact_details" class="form-control validate[maxSize[100],required]"></textarea>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="member_id" name="member_id">
               				<input type="hidden" id="lead_id" name="lead_id" value="<?php echo $client_details[0]['pq_client_id']; ?>">
               				<button class="btn btn-success" type="submit">Submit</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Connect History</h4>
                <div id="tab_history">
                	<table class="table table-bordered" id="connect_table">
                		<thead>
	                		<tr>
	                			<th>Contacted On</th>
	                			<th>Contact Mode</th>
	                			<th>Email Sent</th>
	                			<th>Comments</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                		<?php 
                			foreach ($client_connects as $key => $value) {
                				echo '<tr member_id = "'.$value['member_id'].'">
                					<td>'.date('d-m-Y', strtotime($value['connected_on'])).'</td>
                					<td>'.ucfirst($value['connect_mode']).'</td>
                					<td>'.$value['email_sent'].'</td>
                					<td>'.$value['comments'].'</td>
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