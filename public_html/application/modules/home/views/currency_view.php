<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
		<form action="" method="post">
			<?php foreach ($currency as $curr) { ?>
				<div class="row justify-content-md-center">
					<div class="col-md-6 form-group">
						<label><?php echo $curr['currency']; ?></label>
						<input class="form-control validate[required,custom[onlyNumbers]]" name="curr_<?php echo $curr['currency_id']; ?>" value="<?php echo $curr['currency_rate']; ?>">
					</div>
				</div>
			<?php } ?>
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
			</div>
		</form>
	</div>
</div>