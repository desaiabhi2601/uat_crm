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
					Hetrogenous Leads List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-2 pull-right">
					<a href="<?php echo site_url('leads/addLeadDetails'); ?>" class="btn btn-primary pull-right" target="_blank">Add New</a>
				</div>
			</div>
			<table class="table table-striped- table-bordered table-hover table-checkable" id="leads_table">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="17%">Lead Details</th>
						<th width="10%">Lead Stage</th>
						<th width="15%">Name</th>
						<th width="15%">Contact</th>
						<th width="5%"></th>
						<?php if($type == '' || $type == 'distributors'){?>
						<th width="5%">Brand</th>
						<?php } if($this->session->userdata('role') == 1){?>
						<th width="5%">Assigned To</th>
						<?php }?>
						<th width="15%">Comments</th>
						<th width="5%">Connect Mode</th>
						<th width="5%">Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>


<div class="modal fade" id="member-contact-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('leads/addComments'); ?>" method="post" id="lead_connect">
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
               				<textarea id="contact_details" name="contact_details" class="form-control validate[required]"></textarea>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="member_id" name="member_id">
							<input type="hidden" id="imp_id" name="imp_id" value="<?php if(isset($client_details)){echo $client_details[0]['imp_id'];}?>">
               				<input type="hidden" id="lead_id" name="lead_id" value="<?php if(isset($client_details)){echo $client_details[0]['lead_mst_id'];} ?>">
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


<div class="modal fade" id="member-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Member Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<style>
					#buyer_table.table-bordered th, #buyer_table.table-bordered td, #member_table.table-bordered th, #member_table.table-bordered td{
						border: 1px solid #ebedf2 !important;
					}
				</style>
				<table class="table table-bordered" id="buyer_table">
					<thead>
						<tr>
							<th colspan="3" style="text-align:center">Buyers</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Whatsapp</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				<table class="table table-bordered" id="member_table">
					<thead>
						<tr>
							<th colspan="3" style="text-align:center">Other Members</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Whatsapp</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
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
					<input type="hidden" id="task_lead_id" name="task_lead_id" >
					<input type="hidden" id="task_member_id" name="task_member_id" value="">
					<input type="hidden" name="lead_source" value="hetro leads">
					<button type="submit" class="btn btn-success" id="saveTask">Save Task</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="addTask.reset();">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>