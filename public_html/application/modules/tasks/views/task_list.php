<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet ">
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-line-chart"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					Tasks List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">
			<div class="pull-left">
	 			<label for="product"> 
		        	<select class="form-control" id="datewise">
		        		<option value="">Select</option>
		        		<option value="open_tasks">Open Tasks</option>
		        		<option value="due_today">Due Today</option>
		        		<option value="due_week">Due this week</option>
		        		<option value="overdue">Overdue</option>
					</select>
				</label>
			</div>

			<table class="table table-striped- table-bordered table-hover table-checkable" id="task_table">
				<thead>
					<tr>
						<th width="3%">No</th>
						<th width="5%">Status</th>
						<th width="25%">Task Details</th>
						<th width="20%">Associated Company</th>
						<th width="20%">Associated Member</th>
						<?php if($this->session->userdata('role') == 1){?>
						<th width="5%">Created By</th>
						<?php } ?>
						<th width="10%">Due Date</th>
						<th width="5%">Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="editTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<form id="updateTask" name="updateTask" autocomplete="off">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Task Update</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 form-group">
							<label for="contact_date">Connect Date</label>
               				<input type="text" id="contact_date" name="contact_date" class="form-control validate hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
						</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Mode</label>
               				<select class="form-control validate[required]" name="connect_mode" id="connect_mode">
               					<option value="">Select</option>
               					<option value="whatsapp">Whatsapp</option>
               					<option value="call">Call</option>
               					<option value="linkedin">LinkedIn</option>
               					<option value="email">Email</option>
               				</select>
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Email Sent</label>
               				<select class="form-control validate[required]" name="email_sent" id="email_sent">
               					<option value="">Select</option>
               					<option value="Yes">Yes</option>
               					<option value="No">No</option>
               				</select>
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_details">Comments</label>
               				<textarea id="contact_details" name="contact_details" class="form-control validate[maxSize[100],required]"></textarea>
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="task_status">Task Status</label>
               				<select class="form-control validate[required]" name="task_status" id="task_status">
               					<option value="">Select</option>
               					<option value="Closed">Close</option>
               					<option value="Open">Postpone</option>
               				</select>
               			</div>

               			<div class="col-md-4 form-group" id="deadlineDiv" style="display: none;">
               				<label for="contact_details">New Deadline</label>
               				<input type="text" class="form-control validate[required]" id="deadline" name="deadline" placeholder="Task Deadline">
               			</div>
               		</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="task_lead_id" name="task_lead_id" value="">
					<input type="hidden" id="task_member_id" name="task_member_id" value="">
					<input type="hidden" id="lead_source" name="lead_source" value="">
					<input type="hidden" id="task_id" name="task_id" value="">
					<button type="submit" class="btn btn-success" id="saveTask">Update Task</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="updateTask.reset();">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>