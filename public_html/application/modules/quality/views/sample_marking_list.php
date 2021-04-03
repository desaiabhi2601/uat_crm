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
					PQ Leads List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<table class="table table-striped- table-bordered table-hover table-checkable" id="marking_list">
				<thead>
					<tr>
						<th width="5%">Sr. #</th>
						<th width="10%">Quote #</th>
						<th width="10%">Date</th>
						<th width="15%">Company Name</th>
						<th width="10%">Assigned To</th>
						<th width="10%">Made By</th>
						<th width="10%">Made Status</th>
						<th width="5%">Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="editMTC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="updateMTC" name="updateMTC" autocomplete="off" enctype="multipart/form-data" method="post">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">MTC Update</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php if(in_array($this->session->userdata('role'), array(1, 10)) || $this->session->userdata('user_id') == 33){ ?>
							<div class="col-12 form-group">
								<h5 for="made_flag">Made</h5>
								<label for="made_yes">
									<input type="radio" name="made_flag" id="made_yes" value="Y"> Yes
								</label>
								<label for="made_no">
									<input type="radio" name="made_flag" id="made_no" value="N"> No
								</label>
								<div style="display: inline-block; margin-left: 10px;">
									<a id="mtc_file_name" class="btn btn-warning btn-sm" target="_blank" style="display: none;">View MTC</a>
								</div>
							</div>
						<?php } if(in_array($this->session->userdata('role'), array(1)) || $this->session->userdata('user_id') == 33){ ?>
							<div class="col-12 form-group">
								<h5 for="checked_by_quality_admin">Status - Quality Admin</h5>
								<label for="qadmin_yes">
									<input type="radio" name="checked_by_quality_admin" id="qadmin_yes" value="Y"> Approved
								</label>
								<label for="qadmin_pd">
									<input type="radio" name="checked_by_quality_admin" id="qadmin_pd" value="P"> Pending
								</label>
								<label for="qadmin_no">
									<input type="radio" name="checked_by_quality_admin" id="qadmin_no" value="N"> Disapproved
								</label>
								<label for="qa_comment">Comment
									<input type="text" class="form-control" id="qa_comment" name="qa_comment" placeholder="Quality Admin Comments">
								</label>
								
							</div>
						<?php } if(in_array($this->session->userdata('role'), array(1))){ ?>
							<div class="col-12 form-group">
								<h5 for="checked_by_quality_admin">Status - Super Admin</h5>
								<label for="sadmin_yes">
									<input type="radio" name="checked_by_super_admin" id="sadmin_yes" value="Y"> Approved
								</label>
								<label for="sadmin_pd">
									<input type="radio" name="checked_by_super_admin" id="sadmin_pd" value="P"> Pending
								</label>
								<label for="sadmin_no">
									<input type="radio" name="checked_by_super_admin" id="sadmin_no" value="N"> Disapproved
								</label>
								<label for="sa_comment">Comment
									<input type="text" class="form-control" id="sa_comment" name="sa_comment" placeholder="Super Admin Comments">
								</label>
								
							</div>
						<?php } ?>
               		</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="mtc_mst_id" id="mtc_mst_id">
					<button type="submit" class="btn btn-success" id="saveMTC">Update MTC</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="updateMTC.reset();">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>