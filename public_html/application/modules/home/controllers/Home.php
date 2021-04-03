<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('home', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('home_model');
	}

	function index(){
		$this->dashboard();
	}

	public function dashboard(){
		if($this->session->userdata('role') == 5){
			$this->load->view('header', array('title' => 'Sales Dashboard'));
			$this->load->view('sidebar', array('title' => 'Sales Dashboard'));
			$this->load->view('sales_dashboard');
			$this->load->view('footer');
		}else{
			$this->load->view('header', array('title' => 'Dashboard'));
			$this->load->view('sidebar', array('title' => 'Dashboard'));
			$this->load->view('dashboard');
			$this->load->view('footer');
		}
	}

	public function currency(){
		if($this->session->userdata('role') == 1){
			if(!empty($this->input->post())){
				foreach ($this->input->post() as $key => $value) {
					$this->home_model->updateData('currency', array('currency_rate' => $value), array('currency_id' => trim($key, 'curr_')));
				}
				redirect('home/currency');
			}else{
				$data['currency'] = $this->home_model->getData('currency');
				$this->load->view('header', array('title' => 'Currency Rates'));
				$this->load->view('sidebar', array('title' => 'Currency Rates'));
				$this->load->view('currency_view', $data);
				$this->load->view('footer');
			}
		}else{
			redirect($this->session->userdata('module')[0]);
		}
	}

	function updateTask(){

		$already_inserted = $this->home_model->getData('daily_task_update', "user_id = ".$this->session->userdata('user_id')." and date = '".date('Y-m-d', strtotime($this->input->post('date')))."'");
		if(!empty($already_inserted) && $this->input->post('master_id') == ''){
			$msg = 'Details already updated for date - '.$this->input->post('date');
			$status = 'danger';
		}else{
			$insert_arr = array(
				'task_accomplished' => $this->input->post('task_accomplished'),
				'work_in_progress' => $this->input->post('work_in_progress'),
				'plan_for_tomorrow' => $this->input->post('plan_for_tomorrow'),
				'ca' => $this->input->post('ca'),
				'cc' => $this->input->post('cc'),
				'rc' => $this->input->post('rc'),
				'wa' => $this->input->post('wa'),
				'qs' => $this->input->post('qs'),
				'rd' => $this->input->post('rd'),
				'rp' => $this->input->post('rp'),
				'qp' => $this->input->post('qp'),
				'user_id' => $this->session->userdata('user_id'),
				'date' => date('Y-m-d', strtotime($this->input->post('date'))),
				'modified_on' => date('Y-m-d H:i:s')
			);

			if($this->input->post('master_id') > 0){
				$this->home_model->updateData('daily_task_update', $insert_arr, array('master_id' => $this->input->post('master_id')));
			}else{
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$this->home_model->insertData('daily_task_update', $insert_arr);
			}
			$msg = 'Details updated successfully.';
			$status = 'success';
		}

		$list = $this->home_model->getData('daily_task_update', 'user_id = '.$this->session->userdata('user_id'));
		echo json_encode(array('list' => $list, 'msg' => $msg, 'status' => $status));
	}

	function getDailyUpdates(){
		$list = $this->home_model->getData('daily_task_update', 'user_id = '.$this->session->userdata('user_id'));
		echo json_encode(array('list' => $list));
	}

	function deleteTask(){
		$master_id = $this->input->post('master_id');
		$this->home_model->deleteData('daily_task_update', array('master_id' => $master_id));

		$list = $this->home_model->getData('daily_task_update', 'user_id = '.$this->session->userdata('user_id'));
		echo json_encode(array('list' => $list));
	}

	function getTaskDetails(){
		$master_id = $this->input->post('master_id');
		$res = $this->home_model->getData('daily_task_update', 'master_id = '.$master_id);
		$res['date'] = date('d-m-Y', strtotime($res['date']));
		echo json_encode($res[0]);
	}

	function calendar($user_id = 0){
		if($this->session->userdata('role') != 1  && $this->session->userdata('user_id') != 54){
			$user_id = $this->session->userdata('user_id');
		}
		$data['user_dtl'] = $this->home_model->getData('users', 'user_id = '.$user_id);
		$data['daily_tasks'] = $this->home_model->getData('daily_task_update', 'user_id = '.$user_id);
		$data['desktopTime'] = $this->home_model->getMachineTime($user_id);
		if($this->session->userdata('role') == 1 || $this->session->userdata('user_id') == 54){
			$data['user_id'] = $user_id;
			$data['users'] = $this->home_model->getData('users', 'status = 1 and role != 1');
		}
		$this->load->view('header', array('title' => 'Calendar'));
		$this->load->view('sidebar', array('title' => 'Calendar'));
		$this->load->view('calendar_view', $data);
		$this->load->view('footer');
	}

	function action_event()
    {
        //set validation rules
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        $this->form_validation->set_rules('start_time', 'start_time', 'required');
        $this->form_validation->set_rules('end_date', 'end_date', 'required');
        $this->form_validation->set_rules('end_time', 'end_time', 'required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        
        //run validation check
        if ($this->form_validation->run() == FALSE)
        {   //validation fails
            echo validation_errors();
        }
        else
        {
             $insert_arr = array(
            'event_title' => $this->input->post('title'),
            'start_date' => $this->input->post('start_date'),
            'start_time' => $this->input->post('start_time'),
            'end_date' => $this->input->post('end_date'),
            'end_time' => $this->input->post('end_time'),
            'description' => $this->input->post('description'),
            'user_id' => $this->session->userdata('user_id'),
            'modified_on' => date('Y-m-d H:i:s')
            );
            
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$this->home_model->insertData('calendar_events', $insert_arr);
				echo 'YES';
			
            
        }
    }

    function getNotifications(){
    	$list = $this->home_model->getData('notifications', 'for_id = '.$this->session->userdata('user_id'));
    	if(!empty($list)){
    		$ret = array();
    		foreach ($list as $key => $value) {
    			$return[$key]['text'] = urldecode($value['notify_str']);
    			$return[$key]['time'] = $this->time_elapsed_string($value['notify_date']);
    		}
    		echo json_encode(array( 'list' => $return, 'count' => sizeof($return)));
    	}
    }

    function time_elapsed_string($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}
}

?>