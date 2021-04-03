<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}
		$this->load->model('tasks_model');
	}

	function index(){
		redirect('tasks/list');
	}

	function add_task(){
		if(!empty($this->input->post())){

		}else{
			$data = array();
			$this->load->view('header', array('title' => 'Add / Edit Task'));
			$this->load->view('sidebar', array('title' => 'Add / Edit Task'));
			$this->load->view('add_task', $data);
			$this->load->view('footer');
		}
	}

	function add_task_ajax(){
		$insert_arr = array(
			'lead_id' => $this->input->post('task_lead_id'),
			'member_id' => $this->input->post('task_member_id'),
			'lead_source' => $this->input->post('lead_source'),
			'task_detail' => $this->input->post('task_detail'),
			'deadline' => date('Y-m-d H:i:s', strtotime($this->input->post('deadline'))),
			'created_by' => $this->session->userdata('user_id'),
			'assigned_to' => $this->session->userdata('user_id'),
			'status' => 'Open',
			'entered_on' => date('Y-m-d H:i:s')
		);
		$this->tasks_model->insertData('tasks', $insert_arr);
	}

	function list(){
		$this->load->view('header', array('title' => 'Task List'));
		$this->load->view('sidebar', array('title' => 'Task List'));
		$this->load->view('task_list');
		$this->load->view('footer');
	}

	function list_data(){
		$search = array();
		/*foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'IMPORTER_NAME';
			}else if($key == 2){
				$search_key = 'lead_type';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}*/
		$search['datewise'] = $this->input->post('searchByDatewise');
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'task_id';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->tasks_model->getTaskListData($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->tasks_model->getTaskListCount($search);
		$data['aaData'] = $records;
		//echo "<pre>";print_r($data);
		echo json_encode($data);
	}

	function updateTask(){
		switch ($this->input->post('lead_source')) {
			case 'primary':
				$insert_arr = array(
					'lead_id' => $this->input->post('task_lead_id'),
					'member_id' => $this->input->post('task_member_id'),
					'comments' => $this->input->post('contact_details'),
					'connected_on' => date('Y-m-d', strtotime($this->input->post('contact_date'))),
					'entered_on' => date('Y-m-d H:i:s'),
					'connect_mode' => $this->input->post('connect_mode'),
					'email_sent' => $this->input->post('email_sent')
				);
				$this->tasks_model->insertDataDB2('lead_connects', $insert_arr);
				break;

			case 'hetro leads':
				$insert_arr = array(
					'lead_id' => $this->input->post('task_lead_id'),
					'member_id' => $this->input->post('task_member_id'),
					'comments' => $this->input->post('contact_details'),
					'connected_on' => date('Y-m-d', strtotime($this->input->post('contact_date'))),
					'entered_on' => date('Y-m-d H:i:s'),
					'connect_mode' => $this->input->post('connect_mode'),
					'email_sent' => $this->input->post('email_sent')
				);
				$this->tasks_model->insertData('lead_connects', $insert_arr);
				break;
		}

		$update_arr = array(
			'status' => $this->input->post('task_status'),
			'modified_on' => date('Y-m-d H:i:s'),
			'modified_by' => $this->session->userdata('user_id')
		);

		if($this->input->post('task_status') == 'Open'){
			$this->db->query('update tasks set last_deadline = deadline where task_id = '.$this->input->post('task_id'));
			$update_arr['deadline'] = date('Y-m-d H:i:s', strtotime($this->input->post('deadline')));
			$update_arr['is_postponed'] = 'Y';
		}
		$this->tasks_model->updateData('tasks', $update_arr, array('task_id' => $this->input->post('task_id')));
	}
}