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
					Proforma List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="proforma_table">
				<thead>
					<tr>
						<th width="3%">Sr #</th>
						<th width="7%">Proforma #</th>
						<?php if($this->session->userdata('role') == 1) { ?><th width="5%">Assigned To</th><?php } ?>
						<th width="5%">Purchase Person</th>
						<th width="2%">Date</th>
						<th width="25%">Client</th>
						<th width="5%">Value</th>
						<th width="5%">Country</th>
						<th width="5%">Reg</th>
						<th width="5%">Imp</th>
						<th width="5%">Status</th>
						<th width="5%">Actions</th>
					</tr>
				</thead>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>

<div class="modal fade" id="po-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">upload Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('quotations/uploadPO'); ?>" method="post" id="po_form" name="po_form" enctype="multipart/form-data" target="_blank">
               		<div class="row">
               			<div class="col-md-6">
               				<label for="po_file">Purchase Order</label>
               				<input type="file" class="form-control validate[required]" name="po_file" id="po_file" accept="application/pdf">
               			</div>
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id">
               				<button class="btn btn-success" type="submit">Upload</button>
               			</div>
               		</div>
               	</form>
			</div>
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
               			<div class="col-md-6" id="close_query" style="display: none;">
               				<label for="close_query">Close Query</label>
               				<select class="form-control" name="query_status" id="query_status">
               					<option value="open">No</option>
               					<option value="closed">Yes</option>
               				</select>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id">
               				<input type="hidden" id="query_id" name="query_id">
               				<input type="hidden" name="query_type" value="proforma">
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

<div class="modal fade" id="pquery-popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Query</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
                <form action="<?php echo site_url('quotations/addQuery'); ?>" method="post" id="pquery_form" name="pquery_form">
               		<div class="row">
               			<div class="col-md-6">
               				<label for="query_text">Query Details</label>
               				<textarea id="query_text" name="query_text" class="form-control validate[required]"></textarea>
               			</div>
               			<div class="col-md-6" id="close_query" style="display: none;">
               				<label for="close_query">Close Query</label>
               				<select class="form-control" name="query_status" id="query_status">
               					<option value="open">No</option>
               					<option value="closed">Yes</option>
               				</select>
               			</div>
               		</div>
               		<div class="clearfix"></div>
               		<div class="row">
               			<div class="col-md-6 align-self-center">
               				<input type="hidden" id="quote_id" name="quote_id">
               				<input type="hidden" id="query_id" name="query_id">
               				<input type="hidden" name="query_type" value="purchase">
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