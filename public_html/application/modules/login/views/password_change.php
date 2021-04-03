<!--Begin:: App Content-->
<div class="kt-grid__item kt-grid__item--fluid kt-app__content">
	<div class="row">
		<div class="col-xl-12">
			<div class="kt-portlet kt-portlet--height-fluid">
				<?php if($this->session->flashdata('success')){ ?>
					<div class="alert alert-success" id="success-alert">
						<strong><?php echo $this->session->flashdata('success'); ?></strong> 
					</div>
				<?php } else if($this->session->flashdata('failed')){ ?>
					<div class="alert alert-danger" id="failed-alert">
						<strong><?php echo $this->session->flashdata('failed'); ?></strong> 
					</div>
				<?php } ?>
				<div class="kt-portlet__head">
					<div class="kt-portlet__head-label">
						<h3 class="kt-portlet__head-title">Change Password</h3>
					</div>
				</div>
				<form class="kt-form kt-form--label-right" method="post" id="pwd_change" action="">
					<div class="kt-portlet__body">
						<div class="kt-section kt-section--first">
							<div class="kt-section__body">
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
									<div class="col-lg-9 col-xl-6">
										<input type="password" class="form-control validate[required]" name="current_password" id="cur_pwd" value="" placeholder="Current password">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
									<div class="col-lg-9 col-xl-6">
										<input type="password" class="form-control validate[required,minSize[8]]" id="new_pwd" name="new_password" value="" placeholder="New password">
									</div>
								</div>
								<div class="form-group form-group-last row">
									<label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
									<div class="col-lg-9 col-xl-6">
										<input type="password" class="form-control validate[required,equals[new_pwd]]" id="ver_pwd" value="" placeholder="Verify password">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-3 col-xl-3">
								</div>
								<div class="col-lg-9 col-xl-9">
									<button type="submit" class="btn btn-brand btn-bold">Change Password</button>&nbsp;
									<button type="reset" class="btn btn-secondary">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>