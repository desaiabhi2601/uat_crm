<div class="kt-portlet" id="kt_portlet">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<span class="kt-portlet__head-icon">
				<i class="flaticon-calendar-2"></i>
			</span>
			<h3 class="kt-portlet__head-title">
				Daily Task Report
			</h3>
		</div>
        <?php if($this->session->userdata('role') == 1 || $this->session->userdata('user_id') == 54){ ?>
        <div class="kt-portlet__head-toolbar">
            <select class="form-control" id="view_user">
                <option value="">Select User</option>
                <?php foreach ($users as $key => $value) {
                    $selected = '';
                    if($value['user_id'] == $user_id){
                        $selected = 'selected="selected"';
                    }
                    echo '<option value="'.$value['user_id'].'" '.$selected.'>'.$value['name'].'</option>';
                } ?>
            </select>
        </div>
        <?php } ?>
		<div class="kt-portlet__head-toolbar">
			<a href="#" class="btn btn-brand btn-elevate" data-toggle="modal" data-target="#daily_task_modal" id="daily_task_btn">
				<i class="la la-plus"></i>
				Daily Task Update
			</a>
		</div>
	</div>
	<div class="kt-portlet__body">
		<div id="daily_task_calendar"></div>
	</div>
</div>

<div id="myModal" class="modal fade" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php $attributes = array("name" => "add_event", "id" => "add_event");
            echo form_open("home/action_event", $attributes);?>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Add Event</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <div id="alert-msg"></div>
                <div class="form-group">
                    <label for="name">Title</label>
                    <input class="form-control" id="title" name="title" placeholder="Title" type="text" value="" />
                </div>
                
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input class="form-control hasdatepicker" id="start_date" name="start_date" placeholder="start date" type="text" value="" />
                </div>
 
                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input class="form-control" id="start_time" name="start_time" placeholder="start time" type="text" value="" />
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input class="form-control hasdatepicker" id="end_date" name="end_date" placeholder="end date" type="text" value="" />
                </div>

                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input class="form-control" id="end_time" name="end_time" placeholder="end time" type="text" value="" />
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <input class="btn btn-default" id="submit" name="submit" type="button" value="Submit" />
                <input class="btn btn-default" type="button" data-dismiss="modal" value="Close" />
            </div>
            <?php echo form_close(); ?>            
        </div>
    </div>
</div>