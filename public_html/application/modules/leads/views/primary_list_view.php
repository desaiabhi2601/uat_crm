<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet ">
		<?php if($this->session->flashdata('lead_success')){ ?>
			<div class="alert alert-success" id="success-alert">
				<strong><?php echo $this->session->flashdata('lead_success'); ?></strong> 
			</div>
		<?php } ?>
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-line-chart"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					Primary Leads List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="primary_leads_table">
				<thead>
					<tr>
						<th width="3%">Rank</th>
						<th width="15%">Lead Details</th>
						<th width="14%">Member Name</th>
						<th width="12%">Contact</th>
						<?php if($this->session->userdata('role') == 1){?>
						<th width="10%">Total</th>
						<th width="15%">Supplier</th>
						<th width="10%">Contribution</th>
						<th width="5%">Handeled By</th>
						<?php } ?>
						<th width="3%">Connect Mode</th>
						<th width="5%">Comments</th>
						<!--<th width="5%">Actions</th>-->
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
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
               				<input type="text" id="contact_date" name="contact_date" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Mode</label>
               				<select class="form-control validate[required]" name="connect_mode" id="connect_mode">
               					<option value=""></option>
               					<option value="whatsapp">Whatsapp</option>
               					<option value="call">Call</option>
               					<option value="linkedin">LinkedIn</option>
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
               				<textarea id="contact_details" name="contact_details" class="form-control validate[required]"></textarea>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="member_id" name="member_id">
							<input type="hidden" id="imp_id" name="imp_id" value="<?php echo $client_details[0]['imp_id']; ?>">
               				<input type="hidden" id="lead_id" name="lead_id" value="<?php echo $client_details[0]['lead_mst_id']; ?>">
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


<!--end::Client form-->