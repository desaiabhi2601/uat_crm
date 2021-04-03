<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<div class="row">
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet">
					<!-- form -->
				<?php echo form_open('', array('id' => 'addClient', 'class' => 'kt-form kt-form--label-right', 'autocomplete' => 'off'));?>
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
									<input type="text" class="form-control validate[required] company_name" id="company_name" name="company_name" value=
									"<?php if(isset($client_details)) echo $client_details['client_name']; ?>" autocomplete="off">
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
												$selected = '';
												if(isset($client_details) && $client_details['country'] == $value['lookup_id']){
													$selected = 'selected="selected"';
												}
												echo '<option value="'.$value['lookup_id'].'" region="'.$value['parent'].'" '.$selected.' readonly>'.ucwords(strtolower($value['lookup_value'])).'</option>';
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
												$selected = '';
												if(isset($client_details) && $client_details['region'] == $value['lookup_id']){
													$selected = 'selected="selected"';
												}
												echo '<option value="'.$value['lookup_id'].'" '.$selected.'>'.ucwords(strtolower($value['lookup_value'])).'</option>';
											}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-12">
								<div class="form-group">
									<label for="message-text" class="form-control-label">Website:</label>
									<input type="text" class="form-control validate[custom[url]]" id="website" name="website" value="<?php if(isset($client_details)) echo $client_details['website']; ?>">
								</div>
							</div>

							<div class="col-md-12">
								<h4>Members</h4>
								<button type="button" class="btn btn-sm btn-primary pull-right" id="add_member" >Add New</button>
								<div class="form-group">
									<table class="table table-bordered" id="member_grid">
										<thead>
											<tr>
												<th>Name</th>
												<th>Email</th>
												<th>Mobile</th>
												<th>Is Whatsapp</th>
												<th>Skype</th>
												<th>Telephone</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if(isset($client_members) && !empty($client_members)){
											$i=1;
											foreach($client_members as $cm){ ?>
												<tr>
													<td><input class="form-control" type="text" name="name[]" value="<?php echo $cm['name']; ?>"></td>
													<td><input class="form-control" type="text" name="email[]" value="<?php echo $cm['email']; ?>"></td>
													<td><input class="form-control" type="text" name="mobile[]" value="<?php echo $cm['mobile']; ?>"></td>
													<td>
														<select class="form-control" name="is_whatsapp">
															<option value="Y" <?php if($cm['is_whatsapp'] == 'Y') echo 'selected="selected"';?>>Yes</option>
															<option value="N" <?php if($cm['is_whatsapp'] != 'Y' || $cm['is_whatsapp'] == NULL) echo 'selected="selected"';?>>No</option>
														</select>
													</td>
													<td><input class="form-control" type="text" name="skype[]" value="<?php echo $cm['skype']; ?>"></td>
													<td><input class="form-control" type="text" name="telephone[]" value="<?php echo $cm['telephone']; ?>"></td>
													<td><input type="hidden" name="member_id[]" value="<?php echo $cm['member_id']; ?>" class="member_id"><button type="button" class="btn btn-danger btn-sm removeBtn">Remove</button></td>
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
							<input type="hidden" value="<?php echo $client_details['client_id']; ?>" name="client_id">
						<?php } ?>
						<button type="submit" class="btn btn-primary"><?php if(isset($client_details)) echo 'Update Client'; else echo 'Add Client'; ?></button>
					</div>
				<?php echo form_close(); ?>
					<!-- form -->

				</div>
			</div>
		</div>
	</div>
</div>

<!--begin::Client form-->
<div class="modal fade" id="add_company" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		
		</div>
	</div>
</div>


<!--end::Client form-->