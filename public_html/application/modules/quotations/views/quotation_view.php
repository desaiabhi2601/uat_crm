<?php 
if(($quote_details[0]['delivery_name'] == 'CFR Port Name' || $quote_details[0]['delivery_name'] == 'CIF Port Name') && $quote_details[0]['mode'] == 'Sea Worthy'){
	$port_name = $this->quotation_model->getPortName('CIF', 'sea', $quote_details[0]['country']);
	$quote_details[0]['delivery_name'] = $port_name;
}
?>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="row">
		<div class="col-lg-12">

			<!--begin::Portlet-->
			<div class="kt-portlet">
				<div class="kt-portlet__head">
					<div class="kt-portlet__head-label col-md-3">
						<h3 class="kt-portlet__head-title">
							<?php echo $quote_details['0']['quote_no']; ?>
						</h3>
					</div>
					<div class="kt-portlet__head-label col-md-5">
						<h3 class="kt-portlet__head-title">
							Company Name: <?php echo $quote_details['0']['client_name']; ?>
						</h3>
					</div>
					<div class="kt-portlet__head-label col-md-4">
						<h3 class="kt-portlet__head-title">
							Value: <?php echo $quote_details[0]['currency_icon'].$quote_details['0']['grand_total']; ?>
						</h3>
					</div>
				</div>
				<div class="kt-portlet__body">
					<div class="card">
						<div class="card-body">
							<form id="quoteChanges" action="<?php echo site_url('quotations/makeChanges');?>" method="post">
								<div class="form-group row">
									<div class="col-md-4">
										<label for="importance">Importance</label>
										<select class="form-control" name="importance" id="importance">
											<option value="L" <?php if($quote_details[0]['importance'] == 'L') echo 'selected="selected"';?>>Low</option>
											<option value="M" <?php if($quote_details[0]['importance'] == 'M') echo 'selected="selected"';?>>Medium</option>
											<option value="H" <?php if($quote_details[0]['importance'] == 'H') echo 'selected="selected"';?>>High</option>
											<option value="V" <?php if($quote_details[0]['importance'] == 'V') echo 'selected="selected"';?>>Very High</option>
										</select>
									</div>

									<div class="col-md-4">
										<label for="status">Status</label>
										<select class="form-control" name="status" id="status">
											<option value="Open" <?php if($quote_details[0]['status'] == 'Open') echo 'selected="selected"';?>>Open</option>
											<option value="Won" <?php if($quote_details[0]['status'] == 'Won') echo 'selected="selected"';?>>Won</option>
											<option value="Closed" <?php if($quote_details[0]['status'] == 'Closed') echo 'selected="selected"';?>>Closed</option>
										</select>
									</div>
								
									<div class="col-md-4">
										<label for="reason">Reason</label>
										<select class="form-control" name="reason" id="reason" <?php if($quote_details[0]['close_reason'] == null) echo 'disabled="disabled"'; ?> required>
											<option value="" >Select</option>
											<?php foreach($reason as $res){ ?>
											<option value="<?php echo $res['reason_id'];?>"  <?php if($quote_details[0]['close_reason'] == $res['reason_id']) echo 'selected="selected"';?>><?php echo $res['reason_text'];?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
									<button type="submit" class="btn btn-success">Update</button>
								</div>
							</form>
						</div>
					</div>

					<br/><br/>

					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#" data-target="#kt_tabs_1_1">Quotation Details</a>
						</li>
						<li class="nav-item ">
							<a class="nav-link" data-toggle="tab" href="#" data-target="#kt_tabs_1_2">Follow Up</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#" data-target="#kt_tabs_1_3">Contact Client</a>
						</li>
						<?php /*<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#" data-target="#kt_tabs_1_4">Make Changes</a>
						</li>*/ ?>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#" data-target="#kt_tabs_1_5">Other Active Quotations</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">
							<table class="table table-bordered" cellspacing="0" cellpadding="10" border="0">
								<thead>
									<tr>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="7%;">#</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="38%">Item Description</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="12%">Qty</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="8%">Unit</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="13%">Price</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="9%">Unit</td>
										<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top;" width="13%">Total</td>
									</tr>
								</thead>
								<tbody>
									<?php $i = 0;
									foreach ($quote_details as $key => $value) { 
										if(strpos($value['quantity'], '.') === false){
											$value['quantity'] = $value['quantity'].".00";
										}

										if(strpos($value['unit_price'], '.') === false){
											$value['unit_price'] = $value['unit_price'].".00";
										}

										if(strpos($value['row_price'], '.') === false){
											$value['row_price'] = $value['row_price'].".00";
										}
										echo '<tr>
											<td style="text-align: right;">'.++$i.'</td>
											<td>'.$value['description'].'</td>
											<td style="text-align: right;"> '.$value['quantity'].'</td>
											<td>'.ucwords(strtolower($value['unit_value'])).'.</td>
											<td style="text-align: right;">'.$quote_details[0]['currency_icon'].$value['unit_price'].'</td>
											<td>P.'.ucwords(strtolower($value['unit_value'])).'.</td>
											<td style="text-align: right;">'.$quote_details[0]['currency_icon'].$value['row_price'].'</td>
										</tr>';
							        }
							        ?>
								</tbody>
							</table>


							<?php 
								$net_total = $quote_details[0]['net_total'];
						        if(strpos($net_total, '.') === false){
						        	$net_total = $net_total.'.00';
						        }
								$total_table = '<table class="table table-bordered" style="width:30%" align="right">
								<tr >
								<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;" width="50%" >Net Total</td>
								<td style="font-size: 12px;  border: solid 1px grey;" width="50%">'.$quote_details[0]['currency_icon'].$net_total.'</td>
								</tr>';

								if($quote_details[0]['freight'] > 0){
									$freight = $quote_details[0]['freight'];
							        if(strpos($freight, '.') === false){
							        	$freight = $freight.'.00';
							        }
									$total_table .= '<tr>
										<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Freight Charges</td>
										<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$freight.'</td>
									</tr>';	
								}
								
								if($quote_details[0]['bank_charges'] > 0){
									$bank_charges = $quote_details[0]['bank_charges'];
							        if(strpos($bank_charges, '.') === false){
							        	$bank_charges = $bank_charges.'.00';
							        }
									$total_table .= '<tr>
										<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Bank Charges</td>
										<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$bank_charges.'</td>
									</tr>';
								}

								if($quote_details[0]['gst'] > 0){
									$gst = $quote_details[0]['gst'];
							        if(strpos($gst, '.') === false){
							        	$gst = $gst.'.00';
							        }
									$total_table .= '<tr>
										<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">GST</td>
										<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$gst.'</td>
									</tr>';
								}

								if($quote_details[0]['other_charges'] > 0){
									$other_charges = $quote_details[0]['other_charges'];
							        if(strpos($other_charges, '.') === false){
							        	$other_charges = $other_charges.'.00';
							        }
									$total_table .= '<tr>
										<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Other Charges</td>
										<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$other_charges.'</td>
									</tr>';
								}

								if($quote_details[0]['discount'] > 0){
									$discount = $quote_details[0]['discount'];
							        if(strpos($discount, '.') === false){
							        	$discount = $discount.'.00';
							        }
									$total_table .= '<tr>
										<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Discount</td>
										<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$discount.'</td>
									</tr>';
								}

								$grand_total = $quote_details[0]['grand_total'];
						        if(strpos($grand_total, '.') === false){
						        	$grand_total = $grand_total.'.00';
						        }
								$total_table .= '<tr>
									<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Grand Total</td>
									<td style="font-size: 12px;  border: solid 1px grey;">'.$quote_details[0]['currency_icon'].$grand_total.'</td>
								</tr>
								</table>'; 
								echo $total_table;
							?>
							<table class="table table-bordered" style="width:30%">
								<tr>
									<td colspan="2"><strong>Terms and Conditions</strong></td>
								</tr>
								<tr>
									<td width="40%">Delivered To : </td> 
									<td width="60%"><span style=""><?php echo $quote_details[0]['delivery_name']; ?></span></td>
								</tr>
								<tr>
									<td>Delivery Time : </td>
									<td><span style=""><?php echo $quote_details[0]['dt_value']; ?></span></td>
								</tr>
								<tr>
									<td>Validity : </td>
									<td><span style=""><?php echo $quote_details[0]['validity_value']; ?></span></td>
								</tr>
								<tr>
									<td>Currency : </td>
									<td><span style=""><?php echo $quote_details[0]['currency']; ?></span></td>
								</tr>
								<tr>
									<td>Country of Origin : </td>
									<td><span style=""><?php echo $quote_details[0]['origin']; ?></span></td>
								</tr>
								<tr>
									<td>MTC Type : </td>
									<td><span style=""><?php echo $quote_details[0]['mtc_value']; ?></span></td>
								</tr>
								<tr>
									<td>Packing Type : </td>
									<td><span style=""><?php echo $quote_details[0]['mode']; ?></span></td>
								</tr>
								<tr>
									<td>Payment : </td>
									<td><span style=""><?php echo $quote_details[0]['term_value']; ?></span></td>
								</tr>
							</table>
						</div>
						<div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
							<button class="btn btn-warning pull-right" type="button" id="addFollowUp" data-toggle="modal" data-target="#followup-popup-single">Add Follow up Details</button>
							<table class="table table-bordered">
								<tr>
									<th>Sr #</th>
									<th>Date</th>
									<th>Remarks</th>
								</tr>
								<?php foreach($follow_up as $key => $value){ ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo date('d-m-Y', strtotime($value['followedup_on'])); ?></td>
										<td><?php echo $value['follow_up_text']; ?></td>
									</tr>
								<?php } ?>
							</table>
						</div>
						<div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-stripped">
										<tr>
											<th width="30%">Company Name</th>
											<td width="70%"><?php echo $client_details[0]['client_name'];?></td>
										</tr>
										<tr>
											<th>Country</th>
											<td><?php echo $client_details[0]['country'];?></td>
										</tr>
										<tr>
											<th>Region</th>
											<td><?php echo $client_details[0]['region'];?></td>
										</tr>
										<?php  foreach ($client_details as $key => $value) { ?>
											<tr>
												<td colspan="2"></td>
											</tr>
											<tr>
												<th>Member Name</th>
												<td><?php echo $value['name'];?></td>
											</tr>
											<tr>
												<th>Email</th>
												<td><a href="mailto:<?php echo $value['email'];?>"><?php echo $value['email'];?></a></td>
											</tr>
											<tr>
												<th>Telephone</th>
												<td><?php echo $value['telephone'];?></td>
											</tr>
											<tr>
												<th>Mobile</th>
												<td>
													<?php echo $value['mobile'];?>
													<?php if($value['is_whatsapp'] == 'Y'){?>
														<a href="https://web.whatsapp.com/send?phone=<?php echo $value['mobile'];?>&text=" class="btn btn-xs btn-clean btn-icon btn-icon-sm" title="View Quotation Details" target="_blank" >
							                            	<i class="la la-whatsapp"></i>
							                        	</a>
						                        	<?php } ?>
												</td>
											</tr>
											<tr>
												<th>Skype Id</th>
												<td><?php echo $value['skype'];?></td>
											</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<?php /*<div class="tab-pane" id="kt_tabs_1_4" role="tabpanel">
							<form id="quoteChanges" action="<?php echo site_url('quotations/makeChanges');?>" method="post">
								<div class="form-group row">
									<div class="col-md-4">
										<label for="importance">Importance</label>
										<select class="form-control" name="importance" id="importance">
											<option value="L" <?php if($quote_details[0]['importance'] == 'L') echo 'selected="selected"';?>>L</option>
											<option value="M" <?php if($quote_details[0]['importance'] == 'M') echo 'selected="selected"';?>>M</option>
											<option value="H" <?php if($quote_details[0]['importance'] == 'H') echo 'selected="selected"';?>>H</option>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-4">
										<label for="status">Status</label>
										<select class="form-control" name="status" id="status">
											<option value="Open" <?php if($quote_details[0]['status'] == 'Open') echo 'selected="selected"';?>>Open</option>
											<option value="Won" <?php if($quote_details[0]['status'] == 'Won') echo 'selected="selected"';?>>Won</option>
											<option value="Closed" <?php if($quote_details[0]['status'] == 'Closed') echo 'selected="selected"';?>>Closed</option>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-4">
										<label for="reason">Reason</label>
										<select class="form-control" name="reason" id="reason" <?php if($quote_details[0]['close_reason'] == null) echo 'disabled="disabled"'; ?>>
											<?php foreach($reason as $res){ ?>
											<option value="<?php echo $res['reason_id'];?>"  <?php if($quote_details[0]['close_reason'] == $res['reason_id']) echo 'selected="selected"';?>><?php echo $res['reason_text'];?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<input type="hidden" name="quote_id" value="<?php echo $quote_id; ?>">
									<button type="submit" class="btn btn-success">Update</button>
								</div>
							</form>
						</div> */ ?>
						<div class="tab-pane" id="kt_tabs_1_5" role="tabpanel">
							<table class="table table-bordered" id="siblingInvoice">
								<tr>
									<th>Sr #</th>
									<th>Quotation #</th>
									<th>Value</th>
									<th>Action</th>
								</tr>
								<?php foreach($siblings as $key => $value){ ?>
									<tr>
										<td><?php echo $key+1;?></td>
										<td><?php echo $value['quote_no']; ?></td>
										<td><?php echo $value['grand_total']; ?></td>
										<td>
											<a href="<?php echo site_url('quotations/viewQuotation/'.$value['quotation_mst_id']); ?>" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Quotation Details" target="_blank" >
					                            <i class="fa fa-file-invoice"></i>
					                        </a>
					                        <a href="<?php echo site_url('quotations/pdf/'.$value['quotation_mst_id']); ?>" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View Invoice" target="_blank" >
					                            <i class="la la-eye"></i>
					                        </a>
					                        <button class="btn btn-sm btn-clean btn-icon btn-icon-md followup" title="Follow Up" quote_id="<?php echo $value['quotation_mst_id']; ?>">
					                        	<i class="la la-calendar-plus-o"></i>
					                        </button>
										</td>
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>

			<!--end::Portlet-->
		</div>
	</div>
</div>


<div class="modal fade" id="followup-popup-single" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('quotations/addFollowUp'); ?>" method="post">
               		<div class="row">
               			<div class="col-md-6">
               				<label for="followedup_on">Follow Up Date</label>
               				<input type="text" id="followedup_on" name="followedup_on" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
               			</div>
               			<div class="col-md-6">
               				<label for="follow_up_text">Follow Up Details</label>
               				<textarea id="follow_up_text" name="follow_up_text" class="form-control validate[required]"></textarea>
               			</div>
               			<div class="col-md-6">
               				<label for="next_followup_date">Next Follow Up Date</label>
               				<input type="text" id="next_followup_date" name="followup_date" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y', strtotime('+7 day', strtotime(date('Y-m-d')))); ?>">
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id" value="<?php echo $quote_id; ?>">
               				<input type="hidden" name="redirect" value="quote_page">
               				<button class="btn btn-success" type="submit">Update Follow Up Details</button>
               			</div>
               		</div>
               	</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="followup-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('quotations/addFollowUp'); ?>" method="post">
               		<div class="row">
               			<div class="col-md-6">
               				<label for="followedup_on">Follow Up Date</label>
               				<input type="text" id="followedup_on" name="followedup_on" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
               			</div>
               			<div class="col-md-6">
               				<label for="follow_up_text">Follow Up Details</label>
               				<textarea id="follow_up_text" name="follow_up_text" class="form-control validate[required]"></textarea>
               			</div>
               			<div class="col-md-6">
               				<label for="next_followup_date">Next Follow Up Date</label>
               				<input type="text" id="next_followup_date" name="followup_date" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y', strtotime('+7 day', strtotime(date('Y-m-d')))); ?>">
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id">
               				<button class="btn btn-success" type="submit">Update Follow Up Details</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Follow Up History</h4>
                <div id="tab_history"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>