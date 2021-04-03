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
					Touch Points List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">
			<div class="pull-left">
	 			<label for="sales_person">Sales Person: 
		        	<select class="form-control" id="sales_person">
		  				<option value="">All</option>
		  				<?php 
		  				foreach($sales_person as $sp){
		  					echo '<option value="'.$sp['user_id'].'">'.$sp['name'].'</option>';
		  				}?>
					</select>
				</label>
	        </div>
			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="points_table">
				<thead>
					<tr>
						<th>Record ID</th>
						<th>Date</th>
						<th>Sales Person</th>
						<th>Task Accomplished</th>
						<th>Work in Progress</th>
						<th>Next Day Plan</th>
						<th>Touch Points</th>
						<th>Desktop Time</th>
						<th>Idle Time</th>
						<th>Productive Time</th>
						<th>Productivity</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="tp_performance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
		</div>
	</div>
</div>