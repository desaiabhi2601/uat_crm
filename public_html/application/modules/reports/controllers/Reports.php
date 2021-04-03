<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MX_Controller {

	function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('reports', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('reports_model');
	}

	function index(){
		redirect('reports/daily_task_list');
	}

	function daily_task_list(){
		$data['sales_person'] = $this->reports_model->getSalesPerson();
		$this->load->view('header', array('title' => 'Add Client'));
		$this->load->view('sidebar', array('title' => 'Add Client'));
		$this->load->view('daily_task_list',$data);
		$this->load->view('footer');
	}

	function daily_task_list_data(){
		$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
		$dir = $this->input->get('order')[0]['dir'];
		if($order_by == 'record_id'){
			$order_by = 'dt.date';
			$dir = 'desc';
		}
		$searchBySalesPerson = $this->input->get('searchBySalesPerson');
		$records = $this->reports_model->getDailyTaskList($this->input->get('start'), $this->input->get('length'), $this->input->get('search')['value'], $order_by, $dir, $searchBySalesPerson);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->reports_model->getDailyTaskListCount($this->input->get('search')['value'], $searchBySalesPerson);
		$data['aaData'] = $records;
		echo json_encode($data);
	}
}