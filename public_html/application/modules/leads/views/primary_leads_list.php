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
					Primary Leads List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="primary_leads_table">
				<thead>
					<?php if($this->session->userdata('role') == 13){ ?>
					<tr>
						<th width="3%">Rank</th>
						<th width="25%">Lead Details</th>
						<th width="15%">Type / Stage</th>
						<th width="5%">Assigned To</th>
						<th width="5%">Actions</th>
					</tr>
					<?php }else { ?>
					<tr>
						<th width="3%">Rank</th>
						<th width="25%">Lead Details</th>
						<th width="15%">Type / Stage</th>
						<th width="12%">Member Name</th>
						<th width="10%">Contact</th>
						<th width="5%"></th>
						<?php if($this->session->userdata('role') == 1){?>
							<th width="5%">Assigned To</th>
						<?php } ?>
						<th width="20%">Comments</th>
						<th width="3%">Connect Mode</th>
						<th width="5%">Actions</th>
					</tr>
					<?php } ?>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<!--begin::Client form-->
<div class="modal fade" id="member-contact-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Follow Up</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('leads/addCommentsPrimary'); ?>" method="post" id="lead_connect">
               		<div class="row">
               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Date</label>
               				<input type="text" id="contact_date" name="contact_date" class="form-control validate[required] hasdatepicker" value="<?php echo date('d-m-Y'); ?>">
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Connect Mode</label>
               				<select class="form-control validate[required]" name="connect_mode" id="connect_mode">
               					<option value=""></option>
               					<option value="whatsapp">Whatsapp</option>
               					<option value="call">Call</option>
               					<option value="linkedin">LinkedIn</option>
               					<option value="email">Email</option>
               				</select>
               			</div>

               			<div class="col-md-4 form-group">
               				<label for="contact_date">Email Sent</label>
               				<select class="form-control validate[required]" name="email_sent" id="email_sent">
               					<option value=""></option>
               					<option value="Yes">Yes</option>
               					<option value="No">No</option>
               				</select>
               			</div>

               			<div class="col-md-12 form-group">
               				<label for="contact_details">Comments</label>
               				<textarea id="contact_details" name="contact_details" class="form-control validate[required]"></textarea>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="member_id" name="member_id">
							<input type="hidden" id="imp_id" name="imp_id" value="<?php echo $client_details[0]['imp_id']; ?>">
               				<input type="hidden" id="lead_id" name="lead_id" value="<?php echo $client_details[0]['lead_mst_id']; ?>">
               				<input type="hidden" id="data_category" name="data_category" value="<?php echo strtoupper($lead_category); ?>">
               				<input type="hidden" name="from_list" value="Y">
               				<button class="btn btn-success" type="submit">Submit</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Connect History</h4>
                <div id="tab_history">
                	<table class="table table-bordered" id="connect_table">
                		<thead>
	                		<tr>
	                			<th>Contacted To</th>
	                			<th>Contacted On</th>
	                			<th>Contact Mode</th>
	                			<th>Email Sent</th>
	                			<th>Comments</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                		<?php 
                			foreach ($client_connects as $key => $value) {
                				echo '<tr member_id = "'.$value['member_id'].'">
                					<td></td>
                					<td>'.date('d-m-Y', strtotime($value['connected_on'])).'</td>
                					<td>'.ucfirst($value['connect_mode']).'</td>
                					<td>'.$value['email_sent'].'</td>
                					<td>'.$value['comments'].'</td>
                				</tr>';
                			}
                		?>
                		</tbody>
                	</table>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="stats-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<?php if($this->session->userdata('role') == 5){ ?>
					<div class="row">
						<div class="col-6">
							<figure class="highcharts-figure">
							    <div id="import-stats-container"></div>
							</figure>
						</div>

						<div class="col-6">
							<figure class="highcharts-figure">
								<div id="export-stats-yearly-container"></div>
							</figure>
						</div>
						<div class="col-6">
							<figure class="highcharts-figure">
								<div id="decision-maker-container"></div>
							</figure>
						</div>
						<div class="col-6" id="leadtable"></div>
					</div>
				<?php }else if($this->session->userdata('role') == 1){ ?>
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<figure class="highcharts-figure">
							    <div id="import-stats-container"></div>
							</figure>
						</div>
						
						<div class="col-md-6 col-sm-12">
							<figure class="highcharts-figure">
							    <div id="export-stats-container"></div>
							</figure>
						</div>

						<div class="col-6">
							<figure class="highcharts-figure">
								<div id="decision-maker-container"></div>
							</figure>
						</div>

						<div class="col-6" id="leadtable"></div>

						<div class="col-12">
							<figure class="highcharts-figure">
    							<div id="export-stats-yearly-container"></div>
    						</figure>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="member-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Member Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<style>
					#buyer_table.table-bordered th, #buyer_table.table-bordered td, #member_table.table-bordered th, #member_table.table-bordered td{
						border: 1px solid #ebedf2 !important;
					}
				</style>
				<table class="table table-bordered" id="buyer_table">
					<thead>
						<tr>
							<th colspan="3" style="text-align:center">Buyers</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Whatsapp</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>

				<table class="table table-bordered" id="member_table">
					<thead>
						<tr>
							<th colspan="3" style="text-align:center">Other Members</th>
						</tr>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Whatsapp</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<form id="addTask" name="addTask">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">New Task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
               			<div class="col-12 align-self-center form-group">
               				<textarea class="form-control validate[required]" placeholder="Task Details" id="taskDetail" name="task_detail"></textarea>
               			</div>
               			<div class="col-12 align-self-center form-group">
               				<input type="text" class="form-control validate[required]" id="deadline" name="deadline" placeholder="Task Deadline">
               			</div>
               		</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="task_lead_id" name="task_lead_id" >
					<input type="hidden" id="task_member_id" name="task_member_id" value="">
					<input type="hidden" name="lead_source" value="primary">
					<button type="submit" class="btn btn-success" id="saveTask">Save Task</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="addTask.reset();">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--end::Client form-->

<style>
	#primary_leads_table td {
		color: #002 !important;
	}

	.select2-dropdown{
		width:120px !important;
	}

	.bar-chart-bar {
	    background-color: #e8e8e8; 
	    position:relative; 
	    height: 15px; 
	    display: inline-block;
	    float: right;
	    width: 50%;
	}
	.bar {
	    float: left; 
	    height: 100%;
	}

	.highcharts-figure, .highcharts-data-table table {
	    min-width: 320px; 
	    max-width: 660px;
	    margin: 1em auto;
	}

	.highcharts-data-table table {
		font-family: Verdana, sans-serif;
		border-collapse: collapse;
		border: 1px solid #EBEBEB;
		margin: 10px auto;
		text-align: center;
		width: 100%;
		max-width: 500px;
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
</style>