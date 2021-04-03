<link href="https://v7push-5900.kxcdn.com/css/styles.css" rel="stylesheet" type="text/css" media="all">
<link href='https://v7push-5900.kxcdn.com/css/styles_v2.css?version=1' rel='stylesheet' type='text/css'  media='all'>
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
					<?php echo form_open('', array('id' => 'addMTC', 'class' => 'kt-form kt-form--label-right', 'enctype' => 'multipart/form-data'));?>
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Client Details</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="mtc_type" class="form-control-label">MTC Type:</label>
										<select class="form-control validate[required]" id="mtc_type" name="mtc_type">
											<option value="" >Select</option>
											<option value="sample" <?php if(isset($mtc_details) && $mtc_details['mtc_type'] == 'sample'){ echo 'selected="selected"'; } ?>>Sample MTC</option>
											<option value="pending" <?php if(isset($mtc_details) && $mtc_details['mtc_type'] == 'pending'){ echo 'selected="selected"'; } ?>>Pending Order MTC</option>
											<option value="dispatch" <?php if(isset($mtc_details) && $mtc_details['mtc_type'] == 'dispatch'){ echo 'selected="selected"'; } ?>>Dispatch Order MTC</option>
										</select>
									</div>
								</div>
								<div class="col-md-3 col-sm-12 mtc_for" id="quotation">
									<div class="form-group">
										<label for="quotation_no" class="form-control-label">Quotation #</label>
										<input type="text" name="mtc_for" class="form-control mtc_for_field" id="quotation_no" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for']; } ?>">
										<input type="hidden" name="mtc_for_hidden" class="form-control mtc_for_field" id="quotation_no_hidden" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for_id']; } ?>">
									</div>
									<div class="row">
										<div class="col-12">
											<div class="mtc_for_result" id="quotation_no_res" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 95%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; top: -25px;">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-12 mtc_for" id="proforma" style="display: none;">
									<div class="form-group">
										<label for="proforma_no" class="form-control-label">Proforma #</label>
										<input type="text" name="mtc_for" class="form-control mtc_for_field" id="proforma_no" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for']; } ?>">
										<input type="hidden" name="mtc_for_hidden" class="form-control mtc_for_field" id="proforma_no_hidden" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for_id']; } ?>">
									</div>
									<div class="row">
										<div class="col-12">
											<div class="mtc_for_result" id="proforma_no_res" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 95%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; top: -25px;">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-12 mtc_for" id="invoice" style="display: none;">
									<div class="form-group">
										<label for="invoice_no" class="form-control-label">Invoice #</label>
										<input type="text" name="mtc_for" class="form-control mtc_for_field" id="invoice_no" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for']; } ?>">
										<input type="hidden" name="mtc_for_hidden" class="form-control mtc_for_field" id="invoice_no_hidden" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_for_id']; } ?>">
									</div>
									<div class="row">
										<div class="col-12">
											<div class="mtc_for_result" id="invoice_no_res" style="background-color: #fff; z-index: 100; position: absolute; border: 1px solid; width: 95%; max-height: 100px; height: 100px; overflow-y: scroll; display: none; top: -25px;">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="mtc_company" class="form-control-label">Company Name:</label>
										<input type="text" class="form-control validate[required]" id="mtc_company" name="mtc_company" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_company']; } ?>">
										<input type="hidden" name="mtc_company_id" id="mtc_company_id" value="<?php if(isset($mtc_details)){ echo $mtc_details['mtc_company_id']; } ?>">
									</div>
								</div>

								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="assigned_to" class="form-control-label">Assigned To:</label>
										<select class="form-control" id="assigned_to" name="assigned_to">
											<option value="">Select</option>
											<?php 
												foreach ($quality_users as $key => $value) {
													$selected = '';
													if(isset($mtc_details) && $mtc_details['assigned_to'] == $value['user_id']){
														$selected = 'selected="selected"';
													}
													echo '<option value="'.$value['user_id'].'" '.$selected.'>'.$value['name'].'</option>';
												}
											?>
										</select>
									</div>
								</div>
								<?php if(isset($mtc_details)){ ?>
								<div class="col-md-3 col-sm-12">
									<label for="made_flag" class="form-control-label">MTC Made</label>
									<select class="form-control" name="made_flag" id="made_flag">
										<option value="">Select</option>
										<option value="Y" <?php if($mtc_details['made_flag'] == 'Y'){ echo 'selected="selected"'; } ?>>Yes</option>
										<option value="N" <?php if($mtc_details['made_flag'] == 'N'){ echo 'selected="selected"'; } ?>>No</option>
									</select>
								</div>

								<div class="col-md-3 col-sm-12">
									<label for="mtc_file" class="form-control-label">Upload MTC</label>
									<!-- <input type="file" name="mtc_file_upload[]" accept="application/pdf" multiple="multiple" /> -->
									<div class="dropzone dropzone-default" id="mtc_file">
										<div class="dropzone-msg dz-message needsclick">
											<h3 class="dropzone-msg-title">Drop files here or click to upload.</h3>
											<span class="dropzone-msg-desc"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12">
									<table class="pending_active_issues_table_data" >
						                <tbody id="pending_issues_data">
						                  	<tr class="subject">
						                        <th>Pdf Document Name</th>
						                        <th>Action</th>
						                  	</tr>
						                  	<?php foreach($mtc_files as $mtc_files_details) {?>
						                  	<tr class="subject">
						                        <td><?php echo $mtc_files_details['file_name']; ?></td>
						            			<td class="activity_action">
									              	<ul>
									              		<!-- https://crm.omtubes.com/assets/mtc-document/1602495739-MTC-DOCUMENT-6.pdf -->
									                    <li>
									                      	<a href="<?php echo base_url('/assets/mtc-document/'.$mtc_files_details['file_name']); ?>" class="idattrlink-new" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Purchase Order"></a>
									                    </li>
									                    <li class="delete_mtc_file" mtc-file-id="<?php echo $mtc_files_details['mtc_file_id']; ?>">
									                      	<a data-toggle="tooltip" class="template-delete-icon custom-template-delete"  data-placement="top" title="Delete" data-original-title="Delete"></a>
									                    </li>
									                </ul>
									             </td>         
						                  	</tr>
						                  	<?php } ?>
						                </tbody>
						            </table> 
								</div>
								<input type="hidden" name="mtc_mst_id" value="<?php echo $mtc_details['mtc_mst_id']; ?>">
								<?php } ?>
							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"><?php if(isset($mtc_details)) echo 'Update MTC'; else echo 'Add MTC'; ?></button>
						</div>
					<?php echo form_close(); ?>
					<!-- form -->
				</div>
			</div>
			<!-- new code -->
			<?php if(!empty($quotation_won)) { ?>
			<div class="col-lg-12 col-xl-12 order-lg-1 order-xl-1">
				<div class="kt-portlet" style="padding: 25px 25px;">
					<table class="table">
					  	<thead class="thead-light">
					    	<tr>
					      		<th scope="col" style="width:5%">#(<?php echo count($quotation_won)?>)</th>
					     	 	<th scope="col" style="width:20%">MTC type</th>
					      		<th scope="col" style="width:20%">Proforma #</th>
					      		<th scope="col" style="width:20%">Company Name</th>
					      		<th scope="col" style="width:20%">Assigned To</th>
					      		<th scope="col" style="width:15%">Action</th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		<?php 
					  			foreach ($quotation_won as $quotation_won_key => $quotation_won_value) {
					  		?>	
						    <tr>
					      		<th scope="row"><?php echo $quotation_won_key+1; ?></th>
					      		<td>
					      			<select class="form-control" id="<?php echo 'mtc_type_'.$quotation_won_value['quotation_mst_id'];?>" name="<?php echo 'mtc_type_'.$quotation_won_value['quotation_mst_id'];?>">
										<option value="" >Select</option>
										<option value="sample">Sample MTC</option>
										<option value="pending" selected="selected">Pending Order MTC</option>
										<option value="dispatch">Dispatch Order MTC</option>
									</select>
								</td>	
					      		<td><?php echo $quotation_won_value['quote_no']; ?></td>
					      		<td><?php echo $quotation_won_value['client_name']; ?></td>
					      		<td>
					      			<select class="form-control" id="<?php echo 'assigned_to_'.$quotation_won_value['quotation_mst_id'];?>" name="<?php echo 'assigned_to_'.$quotation_won_value['quotation_mst_id'];?>">
										<option value="" >Select</option>
					      				<?php 
											foreach ($quality_users as $value) {
												echo '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
											}
										?>
									</select>
					      		</td>
					      		<td><button class="btn btn-primary add_mtc_table_data" quotation-mst-id = "<?php echo $quotation_won_value['quotation_mst_id'];?>" quote-no="<?php echo $quotation_won_value['quote_no'];?>" client-id="<?php echo $quotation_won_value['client_id'];?>" client-name="<?php echo $quotation_won_value['client_name'];?>">Add MTC</button></td>
						    </tr>
					  		<?php		
					  			}
					  		?>
					  	</tbody>
					</table>
				</div>	
			</div>
			<?php } ?>
			<!-- new code end -->
		</div>
	</div>
</div>		