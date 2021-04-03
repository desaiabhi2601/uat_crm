<div class="row">
	<?php if(in_array($this->session->userdata('role'), array(1, 10)) || $this->session->userdata('user_id') == 33){ ?>
		<div class="col-12 form-group">
			<h5 for="made_flag">Made</h5>
			<label for="made_yes">
				<input type="radio" name="made_flag" value="Y" <?php echo ($details[0]['made_flag'] == 'Y') ? 'checked':''?>> Yes
			</label>
			<label for="made_no">
				<input type="radio" name="made_flag" value="N" <?php echo ($details[0]['made_flag'] == 'N') ? 'checked':''?>> No
			</label>
			<?php if(!empty($mtc_files)) { ?>
			<table class="pending_active_issues_table_data" >
                <tbody id="pending_issues_data">
                  	<tr class="subject">
                        <th>Pdf Document Name</th>
                        <th>Action</th>
                  	</tr>
                  	<?php foreach($mtc_files as $mtc_files_details) {?>
                  	<tr class="subject">
                        <td><?php echo $mtc_files_details['file_name']; ?></td>
            			<td class="activity_action">
			              	<ul>
			              		<!-- https://crm.omtubes.com/assets/mtc-document/1602495739-MTC-DOCUMENT-6.pdf -->
			                    <li>
			                      	<a href="<?php echo base_url('/assets/mtc-document/'.$mtc_files_details['file_name']); ?>" class="idattrlink-new" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Purchase Order"></a>
			                    </li>
			                </ul>
			             </td>         
                  	</tr>
                  	<?php } ?>
                </tbody>
            </table>
        	<?php } ?>
		</div>
		<div class="col-12 form-group">
	<?php } if(in_array($this->session->userdata('role'), array(1)) || $this->session->userdata('user_id') == 33){ ?>
		<div class="col-12 form-group">
			<h5 for="checked_by_quality_admin">Status - Quality Admin</h5>
			<label for="qadmin_yes">
				<input type="radio" name="checked_by_quality_admin" value="Y" <?php echo ($details[0]['checked_by_quality_admin'] == 'Y') ? 'checked':''?>> Approved
			</label>
			<label for="qadmin_pd">
				<input type="radio" name="checked_by_quality_admin" value="P" <?php echo ($details[0]['checked_by_quality_admin'] == 'P') ? 'checked':''?>> Pending
			</label>
			<label for="qadmin_no">
				<input type="radio" name="checked_by_quality_admin" value="N" <?php echo ($details[0]['checked_by_quality_admin'] == 'N') ? 'checked':''?>> Disapproved
			</label>
			<label for="qa_comment">Comment
				<input type="text" class="form-control" id="qa_comment" name="qa_comment" placeholder="<?php echo (!empty($details[0]['quality_admin_comment'])) ? $details[0]['quality_admin_comment'] : 'Quality Admin Comments' ?>">
			</label>
			
		</div>
	<?php } if(in_array($this->session->userdata('role'), array(1))){ ?>
		<div class="col-12 form-group">
			<h5 for="checked_by_quality_admin">Status - Super Admin</h5>
			<label for="sadmin_yes">
				<input type="radio" name="checked_by_super_admin" value="Y"<?php echo ($details[0]['checked_by_super_admin'] == 'Y') ? 'checked':''?>> Approved
			</label>
			<label for="sadmin_pd">
				<input type="radio" name="checked_by_super_admin" value="P"<?php echo ($details[0]['checked_by_super_admin'] == 'P') ? 'checked':''?>> Pending
			</label>
			<label for="sadmin_no">
				<input type="radio" name="checked_by_super_admin" value="N"<?php echo ($details[0]['checked_by_super_admin'] == 'N') ? 'checked':''?>> Disapproved
			</label>
			<label for="sa_comment">Comment
				<input type="text" class="form-control" id="sa_comment" name="sa_comment" placeholder="<?php echo (!empty($details[0]['super_admin_comment'])) ? $details[0]['super_admin_comment'] : 'Super Admin Comments' ?>">
			</label>
			
		</div>
	<?php } ?>
	</div>