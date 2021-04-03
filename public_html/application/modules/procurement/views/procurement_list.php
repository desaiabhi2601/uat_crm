<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet ">
		<?php if($this->session->flashdata('success')){ ?>
			<div class="alert alert-success" id="success-alert">
				<strong><?php echo $this->session->flashdata('success'); ?></strong> 
			</div>
		<?php } ?>
		<div class="kt-portlet__head kt-portlet__head--lg">
			<div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-line-chart"></i>
				</span>
				<h3 class="kt-portlet__head-title">
					Follow Up List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="followup_table">
				<thead>
					<tr>
						<th>Sr #</th>
						<th>Quote #</th>
						<th>Date</th>
						<th>Client</th>
						<th>Value</th>
						<th>Country</th>
						<th>Region</th>
						<th>Follow Up Date</th>
						<!-- <th>Importance</th> -->
						<th>Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
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