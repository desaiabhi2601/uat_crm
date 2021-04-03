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
					Quotations List
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
						<th width="3%">Sr #</th>
						<th width="7%">Quote #</th>
						<?php if(in_array($this->session->userdata('role'), array(1, 12))) { ?><th width="5%">Assigned To</th><?php } ?>
						<th width="2%">Date</th>
						<!--<th>Month</th>
						<th>Week</th>-->
						<th width="25%">Client</th>
						<th width="5%">Value</th>
						<th width="5%">Country</th>
						<th width="5%">Reg</th>
						<th width="5%">FUDate</th>
						<th width="5%">Imp</th>
						<th width="5%">Status</th>
						<!--<th>WApp</th>-->
						<th width="20%">Follow Up</th>
						<th width="5%">Actions</th>
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

<div class="modal fade" id="mtc-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sample MTC</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="query-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Query</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('quotations/addQuery'); ?>" method="post" id="query_form" name="query_form">
               		<div class="row">
               			<div class="col-md-6">
               				<label for="query_text">Query Details</label>
               				<textarea id="query_text" name="query_text" class="form-control validate[required]"></textarea>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id">
               				<button class="btn btn-success" type="submit">Add Query</button>
               			</div>
               		</div>
               	</form>
               	<hr/>
               	<h4>Query History</h4>
                <div id="tab_history"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
			</div>
		</div>
	</div>
</div>
