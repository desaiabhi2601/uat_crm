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
						<th>Sales Person</th>
						<th>Client Name</th>
						<th>Member Name</th>
						<th>Contact Mode</th>
						<th>Email Sent</th>
						<th>Comments</th>
						<th>Contacted On</th>
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
			<div class="row">
				<div class="offset-1 col-md-7">
					<figure class="highcharts-figure">
					    <div id="tp-performance-container"></div>
					</figure>	

					<form class="form-inline">
						<div class="form-group">
							<label for="tp_start_date">Start Date</label>
							<input class="form-control hasdatepicker" placeholder="Start Date" id="tp_start_date" value="<?php echo date('d-m-Y', strtotime('-29 day'))?>">
						</div>
						<div class="form-group">
							<button type="button" id="tp_updateChart" class="btn btn-sm btn-warning">Update Chart</button>
						</div>
					</form>
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="col-md-12">
							<div class="card text-center">
								<div class="card-body">
									<div class="card-title">Individual Average Touch-points</div>
									<div class="row">
										<div class="col-md-6"><?php echo date('M y'); ?> - <h2 id="user_monthly_avg"></h2></div>
										<div class="col-md-6">Overall - <h2 id="user_total_avg"></h2></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="card text-center">
								<div class="card-body">
									<div class="card-title">Individual Total Touch-points</div>
									<div class="row">
										<div class="col-md-6"><?php echo date('M y'); ?> - <h2 id="user_monthly_connects"></h2></div>
										<div class="col-md-6">Overall - <h2 id="user_total_connects"></h2></div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="card text-center">
								<div class="card-body">
									<div class="card-title">Sales Team Average Touch-points</div>
									<div class="row">
										<div class="col-md-6"><?php echo date('M y'); ?> - <h2 id="team_monthly_avg"></h2></div>
										<div class="col-md-6">Overall - <h2 id="team_total_avg"></h2></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<style>
				.highcharts-figure, .highcharts-data-table table {
				    min-width: 360px; 
				    max-width: 800px;
				    margin: 1em auto;
				}

				.highcharts-data-table table {
					font-family: Verdana, sans-serif;
					border-collapse: collapse;
					border: 1px solid #EBEBEB;
					margin: 10px auto;
					text-align: center;
					width: %;
					max-width: 0px;
				}
				.highcharts-data-table caption {
				    padding: 1em 0;
				    font-size: 1.2em;
				    color: #555;
				}
				.highcharts-data-table th {
					font-weight: 600;
				    padding: 0.5em;
				}
				.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
				    padding: 0.5em;
				}
				.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
				    background: #f8f8f8;
				}
				.highcharts-data-table tr:hover {
				    background: #f1f7ff;
				}

				.highslide-container{
					z-index: 1060 !important;
				}

			</style>
		</div>
	</div>
</div>