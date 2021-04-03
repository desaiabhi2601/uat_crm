<!-- begin:: Content -->
<link href="https://v7push-5900.kxcdn.com/css/styles.css" rel="stylesheet" type="text/css" media="all">
<link href='https://v7push-5900.kxcdn.com/css/styles_v2.css?version=1' rel='stylesheet' type='text/css'  media='all'>
<style type="text/css">
	.tr_active{
		display: block !important;
	}
	.tr_inactive{
		display: none !important;
	}
</style>
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
					PQ Leads List
				</h3>
			</div>
		</div>
		<div class="kt-portlet__body">
			<table class="pending_active_issues_table_data" >
                <tbody id="pending_issues_data">
                    <?php $this->load->view('quality/mtc_list_body');?>
            	</tbody>
          	</table>
		</div>
	</div>
</div>

<div class="modal fade" id="mtc_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- <form id="updateMTC" name="updateMTC" autocomplete="off" enctype="multipart/form-data" method="post"> -->
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">MTC Status Update</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body" id="mtc_status_body">
				<?php //$this->load->view('quality/update_status_model');?>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="update_mst_id" id="update_mst_id">
				<button type="submit" class="btn btn-success" id="mtc_status_update">Update MTC</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" onclick="">Close</button>
			</div>
			<!-- </form> -->
		</div>
	</div>
</div>