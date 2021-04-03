<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">

					<div class="row">
						<div class="col-md-10"></div>
						<div class="col-md-2 pull-right">
							<a href="<?php echo site_url('leads/primary_leads'); ?>" class="btn btn-primary pull-right" style="margin-top: 5px; margin-right: 10px;"><< Back to List </a>
						</div>
					</div>
					
					<!-- form -->
					<?php echo form_open('', array('id' => 'addLead', 'class' => 'kt-form kt-form--label-right'));?>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Client Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<?php if($this->session->userdata('role') == 5 || $this->session->userdata('role') == 1){ ?>
							<div class="row">
								<?php if($this->session->userdata('role') == 1){?>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="message-text" class="form-control-label">Assigned To:</label>
										<select class="form-control validate" id="assigned_to" name="assigned_to">
											<option value="" >Select</option>
											<option value="500">Blank User</option>
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
								<?php } ?>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="recipient-name" class="form-control-label">Company Name:</label>
										<input type="text" class="form-control validate" id="lead_name" value=
										"<?php if(isset($client_details)) echo $client_details[0]['IMPORTER_NAME']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="message-text" class="form-control-label">Country:</label>
										<select class="form-control validate" id="lead_country" name="lead_country" disabled="disabled">
											<option value="" >Select</option>
											<?php 
												foreach ($country as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['country'] == $value['lookup_value']){
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
										<label for="message-text" class="form-control-label">Region:</label>
										<select class="form-control validate" id="lead_region" name="lead_region" disabled="disabled">
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
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="source" class="form-control-label">Source:</label>
										<select class="form-control validate" name="source" id="source">
											<option value="" >Select</option>
											<option value="primary data" <?php if(isset($client_details) && strtolower($client_details[0]['source']) == 'primary data'){echo 'selected = "selected"';}?>>Primary Data</option>
											<option value="primary pipes" <?php if(isset($client_details) && strtolower($client_details[0]['source']) == 'primary pipes'){echo 'selected = "selected"';}?>>Primary Data</option>
										</select>
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="message-text" class="form-control-label">Website:</label>
										<input type="text" class="form-control" id="website" name="website" value="<?php if(isset($client_details)) echo $client_details[0]['website']; ?>">
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="no_of_employees" class="form-control-label">No of Employees:</label>
										<select class="form-control" id="no_of_employees" name="no_of_employees">
											<option value="" >Select</option>
											<option value="1-9" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '1-9') echo 'selected="selected"';?>>1-9</option>
											<option value="10-25" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '10-25') echo 'selected="selected"';?>>10-25</option>
											<option value="25-50" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '25-50') echo 'selected="selected"';?>>25-50</option>
											<option value="50-100" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '50-100') echo 'selected="selected"';?>>50-100</option>
											<option value="100-200" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '100-200') echo 'selected="selected"';?>>100-200</option>
											<option value="200-500" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '200-500') echo 'selected="selected"';?>>200-500</option>
											<option value="500-1000" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '500-1000') echo 'selected="selected"';?>>500-1000</option>
											<option value="1000+" <?php if(isset($client_details) && $client_details[0]['no_of_employees'] == '1000+') echo 'selected="selected"';?>>1000+</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="last_contacted_date" class="form-control-label">Last Contacted Date:</label>
										<input type="text" id="last_contacted_date" class="form-control" <?php if(isset($client_connects) && !empty($client_connects)) echo 'value="'.date('d-m-Y', strtotime($client_connects[0]['connected_on'])).'"'; ?> disabled="disabled">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="lead_type" class="form-control-label">Lead Type:</label>
										<select class="form-control validate" id="lead_type" name="lead_type">
											<option value="">Select</option>
											<?php 
												foreach ($lead_type as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['lead_type'] == $value['lead_type_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_type_id'].'" '.$selected.'>'.$value['type_name'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="lead_industry" class="form-control-label">Lead Industry:</label>
										<select class="form-control" id="lead_industry" name="lead_industry">
											<option value="">Select</option>
											<?php 
												foreach ($lead_industry as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['lead_industry'] == $value['lead_industry_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_industry_id'].'" type_id="'.$value['type_id'].'" '.$selected.'>'.$value['industry_name'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="lead_stage" class="form-control-label">Lead Stage:</label>
										<select class="form-control validate" id="lead_stage" name="lead_stage">
											<option value="">Select</option>
											<?php 
												foreach ($lead_stages as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['lead_stage'] == $value['lead_stage_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_stage_id'].'" '.$selected.'>'.$value['stage_name'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="stage_reason" class="form-control-label">Stage 0 - Reason:</label>
										<select class="form-control" id="stage_reason" name="stage_reason">
											<option value="">Select</option>
											<?php 
												foreach ($lead_stage_reasons as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['stage_reason'] == $value['lead_reason_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['lead_reason_id'].'" stage_id="'.$value['lead_stage_id'].'" '.$selected.'>'.$value['reason'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="purchase_factor_1" class="form-control-label">Purchase Factor - 1</label>
										<select class="form-control" id="purchase_factor_1" name="purchase_factor_1">
											<option value="">Select</option>
											<?php 
												foreach ($purchase_factors as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['purchase_factor_1'] == $value['factor_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['factor_id'].'" '.$selected.'>'.$value['factor_value'].'</option>';
												}
											?>
										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="purchase_factor_1" class="form-control-label">Purchase Factor - 2</label>
										<select class="form-control" id="purchase_factor_1" name="purchase_factor_2">
											<option value="">Select</option>
											<?php 
												foreach ($purchase_factors as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['purchase_factor_2'] == $value['factor_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['factor_id'].'" '.$selected.'>'.$value['factor_value'].'</option>';
												}
											?>
										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="purchase_factor_1" class="form-control-label">Purchase Factor - 3</label>
										<select class="form-control" id="purchase_factor_1" name="purchase_factor_3">
											<option value="">Select</option>
											<?php 
												foreach ($purchase_factors as $key => $value) {
													$selected = '';
													if(isset($client_details) && $client_details[0]['purchase_factor_3'] == $value['factor_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['factor_id'].'" '.$selected.'>'.$value['factor_value'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="sales-notes" class="form-control-label">Sales Notes:</label>
										<textarea class="form-control" name="sales_notes" id="sales-notes"><?php if(isset($client_details)) echo $client_details[0]['sales_notes']; ?></textarea>
									</div>
								</div>
							</div>
							<?php } if($this->session->userdata('role') == 13 || $this->session->userdata('role') == 1){?>
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="recipient-name" class="form-control-label">Company Name:</label>
										<input type="text" class="form-control validate" id="lead_name" value=
										"<?php if(isset($client_details)) echo $client_details[0]['IMPORTER_NAME']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="product_pitch" class="form-control-label">Specific Product to Pitch:</label>
										<input type="text" class="form-control" id="product_pitch" name="product_pitch" value="<?php if(isset($client_details)) echo $client_details[0]['product_pitch']; ?>" <?php echo $readonly; ?>>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="purchase_comments" class="form-control-label">Purchase Comments:</label>
										<textarea class="form-control" name="purchase_comments" id="purchase_comments" <?php echo $readonly; ?>><?php if(isset($client_details)) echo $client_details[0]['purchase_comments']; ?></textarea>
									</div>
								</div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="margins" class="form-control-label">Margins:</label>
										<input type="text" class="form-control" id="margins" name="margins" value="<?php if(isset($client_details)) echo $client_details[0]['margins']; ?>" <?php echo $readonly; ?>>
									</div>
								</div>
							</div>
							<?php } if($this->session->userdata('role') == 5 || $this->session->userdata('role') == 1){ ?>
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
													<th>Decision Maker(%)</th>
													<th width="8%">Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											if(isset($client_details) && !empty($client_details)){
												$i=1;
												foreach($client_details as $cm){
													if($cm['other_member'] == 'Y'){
														continue;
													}
													if($cm['lead_dtl_id'] == ''){
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
														<td><input type="text" name="decision_maker[]" class="form-control  validate[custom[onlyNumberSp]]" value="<?php echo $cm['decision_maker']; ?>"></td>
														<td><input type="hidden" name="lead_dtl_id[]" value="<?php echo $cm['lead_dtl_id']; ?>" class="member_id"><input type="hidden" name="other_member[]" value=""><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect" title="Contact"><i class="la la-comment"></i></button><button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_delBtn" title="Delete"><i class="la la-trash"></i></button></td>
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
													if($cm['lead_dtl_id'] == ''){
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
							<?php } ?>
						</div>

						<div class="modal-footer">
							<?php if(isset($client_details)){ ?>
								<input type="hidden" id="lead_mst_id" name="lead_mst_id" value="<?php echo $client_details[0]['lead_mst_id']; ?>">
							<?php } ?>
							<input type="hidden" id="imp_id" name="imp_id" value="<?php echo $client_details[0]['IMP_ID']; ?>">
							<input type="hidden" id="data_category" name="data_category" value="<?php echo strtoupper($lead_category); ?>">
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
                <form action="<?php echo site_url('leads/addCommentsPrimary'); ?>" method="post" id="lead_connect">
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
               				<input type="hidden" id="category" name="category" value="<?php echo $lead_category; ?>">
							<input type="hidden" id="imp_id" name="imp_id" value="<?php echo $client_details[0]['imp_id']; ?>">
               				<input type="hidden" id="lead_id" name="lead_id" value="<?php echo $client_details[0]['lead_mst_id']; ?>">
               				<button class="btn btn-success" type="submit">Submit</button>
               				<button type="button" class="btn btn-primary" data-toggle="modal" data-backdrop="static" data-target="#taskModal" id="createTask">Create Task</button>
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


<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<form id="addTask" name="addTask">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">New Task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
               			<div class="col-12 align-self-center form-group">
               				<textarea class="form-control validate[required]" placeholder="Task Details" id="taskDetail" name="task_detail"></textarea>
               			</div>
               			<div class="col-12 align-self-center form-group">
               				<input type="text" class="form-control validate[required]" id="deadline" name="deadline" placeholder="Task Deadline">
               			</div>
               		</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="task_lead_id" name="task_lead_id" value="<?php echo $client_details[0]['lead_mst_id']; ?>">
					<input type="hidden" id="task_member_id" name="task_member_id" value="">
					<input type="hidden" name="lead_source" value="primary">
					<button type="submit" class="btn btn-success" id="saveTask">Save Task</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="addTask.reset();">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--end::Client form-->