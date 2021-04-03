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
			<div class="pull-left">
	 			<label for="fin_year">Financial Year: 
		        	<select class="form-control" id="fin_year">
		  				<?php 
		  				foreach($finYears as $fin){
		  					echo '<option value="'.$fin['years'].'">'.$fin['years'].'</option>';
		  				}?>
		  				<option value="all">All</option>
					</select>
				</label>
	        </div>

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="invoice_table">
				<thead>
					<tr>
						<th>Record ID</th>
						<th>Invoice #</th>
						<th>Invoice Date</th>
						<th>Company Name</th>
						<th>Attention</th>
						<th>Country</th>
						<th>Total Amount</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>