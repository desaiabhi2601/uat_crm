<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="kt-portlet">
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
					Member List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="member_table">
				<thead>
					<tr>
						<th>Record ID</th>
						<th>Client Name</th>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile #</th>
						<th>Is Whatsapp</th>
						<th>Telephone</th>
						<th>Skype</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>