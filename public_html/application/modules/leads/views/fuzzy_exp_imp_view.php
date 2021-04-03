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
					Invoice List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-2 pull-right">
					<button class="btn btn-primary pull-right" id="merge_records">Merge</button>
				</div>
			</div>
			<table class="table table-striped- table-bordered table-hover table-checkable" id="leads_table">
				<thead>
					<tr>
						<th>Record ID</th>
						<th>Exporter Name</th>
						<th>New Importer Name</th>
						<th>FOB Value INR</th>
						<th>Select to Merge</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Merge Records</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" id="update_imp_name" class="btn btn-primary">Update Importer Name</button>
			</div>
		</div>
	</div>
</div>