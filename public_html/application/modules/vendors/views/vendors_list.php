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
					Vendors List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">
			<div class="pull-left">
	 			<label for="product">Product: 
		        	<select class="form-control" id="product">
		        		<option value="">Select</option>
		  				<?php echo $prd_str; ?>
					</select>
				</label>

				<label for="material">Material: 
		        	<select class="form-control" id="material">
		  				<option value="">Select</option>
		  				<?php echo $mat_str; ?>
					</select>
				</label>
	        </div>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="vendors_list">
				<thead>
					<tr>
						<th width="3%">Sr #</th>
						<th width="20%">Vendor Name</th>
						<th width="15%">Stage</th>
						<th width="15%">Person</th>
						<th width="12%">Contact</th>
						<th width="8%">Contact Mode</th>
						<th width="17%">Comments</th>
						<th width="10%">Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>
<style type="text/css">
	.select2-container{
		width: 120px !important;
	}

	#vendors_list tbody td{
		border: none;
	}
</style>