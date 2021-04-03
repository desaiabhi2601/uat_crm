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
						<th>Rank</th>
						<th>Company Name</th>
						<th>Country</th>
						<th>Region</th>
						<th>Person</th>
						<th>Email</th>
						<th>Brand</th>
						<th>Type</th>
						<th>Stage</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>