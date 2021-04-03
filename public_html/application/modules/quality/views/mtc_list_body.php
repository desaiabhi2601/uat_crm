<tr class="subject">
    <th>MTC Status</th>
    <th>Mtc Type</th>
    <th>Mtc For</th>
    <th>Company Name</th>
    <th>Assigned</th>
    <th>Creator</th>
    <th>Action</th>
</tr>
<tr class="subject">
    <th>
        <select class="form-control" id="status_search" name="status_search" style="border-radius: 10px;">
            <option value="">Select</option>
            <option value="Y">Yes/Approved</option>';
            <option value="P">Pending</option>';
            <option value="N">No/Disapproved</option>';
        </select>
    </th>
    <th>
        <select class="form-control" id="mtc_type" name="mtc_type" style="border-radius: 10px;">
            <option value="">Select</option>
            <option value="sample">Sample MTC</option>';
            <option value="pending">Pending Order MTC</option>';
            <option value="dispatch">Dispatch Order MTC</option>';
        </select>
    </th>
    <th><input type="text" class="form-control" id="mtc_for" placeholder="Quotation number" style="border-radius: 10px;"></th>
    <th><input type="text" class="form-control" id="mtc_company_name" placeholder="Company Name" style="border-radius: 10px;"></th>
    <th>
        <?php if(!empty($assigned)) {?>
        <select class="form-control" id="mtc_assigned" name="mtc_assigned" style="border-radius: 10px;">
            <option value="">Select</option>
            <?php foreach($assigned as $assigned_value) {?>
                <option value="<?php echo $assigned_value;?>"><?php echo $users[$assigned_value];?></option>';
            <?php }?>
        </select>
        <?php }?>
    </th>
    <th>
        <?php if(!empty($creater)) {?>
        <select class="form-control" id="mtc_creater" name="mtc_creater" style="border-radius: 10px;">
            <option value="">Select</option>
            <?php foreach($creater as $creator_value) {?>
                <option value="<?php echo $creator_value;?>"><?php echo $users[$creator_value];?></option>';
            <?php }?>
        </select>
        <?php }?>
        </th>
    <th>
        <input type="button" class="btn btn-success" id="mst_search_filter" value="Apply" style="border-radius: 10px; width: 45%;">
        <input type="button" class="btn btn-warning" id="mst_reset_filter" value="Reset" style="border-radius: 10px; width: 45%;">
    </th>
</tr>
<?php  if(!empty($mtc_list)) {
		foreach ($mtc_list as $mtc_list_key => $mtc_list_value) { ?>	
            <tr>
                <td>
                	<span style="width:200px !important;">
                    <i style="cursor: pointer;" data-value="Public" class=""><?php echo $mtc_list_key+1; ?></i>
                    <abbr>
                          <em> Made Status: 
                          	<em class="close_activity_status">
                          		<?php echo $mtc_list_value['made_flag']; ?>
                      		</em>
                  		</em> 
                	  	<em> Quality Status: 
                          	<em class="notpossible_activity_status">
                          		<?php echo $mtc_list_value['checked_by_quality_admin']; ?>
                          	</em>
                      	</em> 
                    	<em> Admin Status: 
                    		<em class="notpossible_activity_status">
                    			<?php echo $mtc_list_value['checked_by_super_admin']; ?>
                    		</em>
                    	</em> 
                	</abbr>
                	</span>
                </td>
                <td><?php echo $mtc_list_value['mtc_type']; ?></td>
                <td><?php echo $mtc_list_value['mtc_for']; ?></td>
                <td><?php echo $mtc_list_value['mtc_company']; ?></td>
                <td><?php echo $mtc_list_value['assigned_to']; ?></td>
                <td><?php echo $mtc_list_value['created_by']; ?></td>
                <td class="activity_action">
                	<ul>
                	<?php if(in_array($this->session->userdata('role'), array(1, 10)) || $this->session->userdata('user_id') == 33){ ?>
                  		<li class="update_mtc_status"  mtc-mst-id="<?php echo $mtc_list_value['mtc_mst_id']; ?>">
                			<a class="mark-completed update_status" data-target="#mtc_status" data-toggle="modal" data-placement="top" title="Update Status" data-original-title="Update Status"></a>
                		</li>
                	<?php }?>
                    <li>
                    	<a href="https://democrm.omtubes.com/quality/add_mtc/<?php echo $mtc_list_value['mtc_mst_id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit" data-original-title="Edit"></a>
                    </li>
                    <?php if(!empty($mtc_list_value['purchase_order'])) {?>
                        <li>
                          	<a href="<?php echo base_url('/assets/purchase_orders/'.$mtc_list_value['purchase_order'])?>" class="idattrlink-new" data-toggle="tooltip" data-placement="top" title="Purchase Order" data-original-title="View Purchase Order"></a>
                        </li>
                    <?php } ?>
                    <li class="delete_mtc_listing" mtc-mst-id="<?php echo $mtc_list_value['mtc_mst_id']; ?>">
                      	<a data-toggle="tooltip" class="delete_mtc_listing template-delete-icon custom-template-delete"  data-placement="top" title="Delete" data-original-title="Delete"></a>
                    </li>
                	</ul>
                </td>
            </tr>
<?php  } 
} ?>