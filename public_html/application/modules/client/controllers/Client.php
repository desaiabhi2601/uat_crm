<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends MX_Controller {
	function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}/*else{
			if(!in_array('client', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}*/
		$this->load->model('client_model');
		$this->load->model('quotations/quotation_model');
	}

// By Su

	function index(){
		$this->client_list();
	}

	public function addClients($client_id=0){
		if(!empty($this->input->post())){
			$client_data = array(
				'client_name' => $this->input->post('company_name'),
				'country' => $this->input->post('country'),
				'region' => $this->input->post('region'),
				'website' => $this->input->post('website'),
				'modified_on' => date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id'),
				'status' => 'Y',
				'origin' => 'client'
			);
			if($this->input->post('client_id')){
				$client_id = $this->input->post('client_id');
				$this->client_model->updateClient($client_data, array('client_id' => $client_id));
				$this->session->set_flashdata("success","Client updated successfully!!");
			}else{
				$client_data['entered_on'] = date('Y-m-d H:i:s');
				$client_data['entered_by'] = $this->session->userdata('user_id');
				$client_id = $this->client_model->addClient($client_data);
				$this->session->set_flashdata("success","Client added successfully!!");
			}

			if($this->input->post('name')){
				foreach ($this->input->post('name') as $key => $value) {
					$member_data = array(
						'client_id' => $client_id,
						'name' => $value,
						'email' => $this->input->post('email')[$key],
						'mobile' => $this->input->post('mobile')[$key],
						'is_whatsapp' => $this->input->post('is_whatsapp')[$key],
						'skype' => $this->input->post('skype')[$key],
						'telephone' => $this->input->post('telephone')[$key],
						'status' => 'Y',
						'modified_on' => date('Y-m-d H:i:s'),
						'modified_by' => $this->session->userdata('user_id'),
					);

					if(isset($this->input->post('member_id')[$key])){
						$member_id = $this->input->post('member_id')[$key];
						$this->client_model->updateMember($member_data, array('member_id' => $member_id));
					}else{
						$member_data['entered_on'] = date('Y-m-d H:i:s');
						$member_data['entered_by'] = $this->session->userdata('user_id');
						$member_id = $this->client_model->addClientMember($member_data);
					}
				}
			}
			redirect('client/client_list/');
		}else{
			if($client_id > 0){
				$data['client_details'] = $this->client_model->getClientDetails($client_id);
				$data['client_members'] = $this->client_model->getClientMembers($client_id);
				$data['client_id'] = $client_id;
			}
			$data['region'] = $this->quotation_model->getLookup(1);
			$data['country'] = $this->quotation_model->getLookup(2);
			$this->load->view('header', array('title' => 'Add Client'));
			$this->load->view('sidebar', array('title' => 'Add Client'));
			$this->load->view('add_client',$data);
			$this->load->view('footer');
		}
	}

	public function addMembers(){
		if(!empty($this->input->post())){

		}else{
			// $data['users'] = $this->quotation_model->getUsers();
			// $data['clients'] = $this->client_model->getClients();
			// $data['region'] = $this->quotation_model->getLookup(1);
			// $data['country'] = $this->quotation_model->getLookup(2);
			$this->load->view('header', array('title' => 'Add Member'));
			$this->load->view('sidebar', array('title' => 'Add Member'));
			$this->load->view('add_member');
			$this->load->view('footer');
		}
	}

// By Su

	function addClientAjax($call=''){
		$client_data = array(
			"client_name" => $this->input->post('company_name'),
			"country" => $this->input->post('country'),
			"region" => $this->input->post('region'),
			"website" => $this->input->post('website'),
			"entered_on" => date('Y-m-d H:i:s'),
			"entered_by" => $this->session->userdata('user_id'),
			"status" => 'Y',
			'origin' => 'client'
		);

		$client_id = $this->client_model->addClient($client_data);

		if($call==''){
			$clients = $this->client_model->getClients();
			echo json_encode(array("client_id" => $client_id, "clients" => $clients));
		}
		else{
			$this->session->set_flashdata("success","Client added successfully!!");
			redirect('client/addClients');
		}
	}

	function addClientMemberAjax(){
		$member_data = array(
			"client_id" => $this->input->post('client_id'),
			"name" => $this->input->post('name'),
			"email" => $this->input->post('email'),
			"mobile" => $this->input->post('mobile'),
			"is_whatsapp" => $this->input->post('is_whatsapp'),
			"skype" => $this->input->post('skype'),
			"telephone" => $this->input->post('telephone'),
			"entered_on" => date('Y-m-d H:i:s'),
			"entered_by" => $this->session->userdata('user_id'),
			"status" => 'Y'
		);

		$member_id = $this->client_model->addClientMember($member_data);
		$members = $this->client_model->getMembers($this->input->post('client_id'));
		echo json_encode(array("member_id" => $member_id, "members" => $members));
	}

	function client_list(){
		if($this->session->userdata('role') != 1){
			redirect('client/addClients');
			exit;
		}
		$this->load->view('header', array('title' => 'Client List'));
		$this->load->view('sidebar', array('title' => 'Client List'));
		$this->load->view('client_list_view');
		$this->load->view('footer');
	}

	function client_data(){
		$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'company_name'){
			$order_by = 'client_name';
		}else if($order_by == 'country'){
			$order_by = 'l1.lookup_value';
		}else if($order_by == 'region'){
			$order_by = 'l2.lookup_value';
		}
		$dir = $this->input->get('order')[0]['dir'];
		$records = $this->client_model->getClientList($this->input->get('start'), $this->input->get('length'), $this->input->get('search')['value'], $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->client_model->getClientListCount($this->input->get('search')['value']);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function member_list(){
		if($this->session->userdata('role') != 1){
			redirect('client/addClients');
			exit;
		}
		$this->load->view('header', array('title' => 'Member List'));
		$this->load->view('sidebar', array('title' => 'Member List'));
		$this->load->view('member_list_view');
		$this->load->view('footer');
	}

	function member_data(){
		$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'client_name'){
			$order_by = 'c.client_name';
		}else if($order_by == 'email'){
			$order_by = 'm.email';
		}else if($order_by == 'mobile'){
			$order_by = 'm.mobile';
		}else if($order_by == 'telepone'){
			$order_by = 'm.telepone';
		}else if($order_by == 'name'){
			$order_by = 'm.name';
		}
		$dir = $this->input->get('order')[0]['dir'];
		$records = $this->client_model->getMemberList($this->input->get('start'), $this->input->get('length'), $this->input->get('search')['value'], $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->client_model->getMemberListCount($this->input->get('search')['value']);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function deleteClient(){
		$this->client_model->deleteClient($this->input->post('client_id'));
		$this->session->set_flashdata("success","Client deleted successfully!!");
	}

	function deleteMember(){
		$this->client_model->deleteMember($this->input->post('member_id'));
		$this->session->set_flashdata("success","Member deleted successfully!!");
	}

	function getClientMembers(){
		$members = $this->client_model->getMembers($this->input->post('client_id'));
		echo json_encode(array('members' => $members));
	}

	function clientListJson(){
		if($this->session->userdata('role') == 5){
			$clients = $this->client_model->getClients();
			$region = $this->quotation_model->getLookup(1);
			$country = $this->quotation_model->getLookup(2);
			$connect_list = $this->getConnectList(); //date("Y-m-d", strtotime('monday this week'))
			
			$counts = $this->client_model->getPerformanceCount($this->session->userdata('user_id'));
			$daywise = $this->client_model->getDayWiseCount();
			$reasons = $this->client_model->getDayWiseReason();
			$array = array();
		    $Date2 = date('Y-m-d'); 
			$date = new DateTime($Date2);
			$date->modify('-29 day');
			$Date1 = $date->format('Y-m-d');
			$array = array(); 
			$Variable1 = strtotime($Date1); 
			$Variable2 = strtotime($Date2);
			$i=1;
			for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) { 
				$Store = date('Y-m-d', $currentDate); 
				//$array[] = $Store;
				$array[$i]['key'] = date('d M', strtotime($Store));
				$array[$i]['value'] = 0.5;
				$array[$i]['reason'] = '';
				foreach ($daywise as $dw) {
					if($dw['contacted_on'] == $Store){
						$array[$i]['value'] = $dw['count'];
						break;
					}
				}

				foreach ($reasons as $res) {
					if($res['contacted_on'] == $Store){
						$array[$i]['reason'] = $res['comments'];
						break;
					}
				}
				$i++;
			}

			$dates = $this->client_model->getEntryDates($this->session->userdata('user_id'));
			$Variable1 = strtotime('2020-04-01'); 
			$Variable2 = strtotime(date('Y-m-d'));
			$no_entry = array();
			for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
				$cur_date = date('Y-m-d', $currentDate);
				if(!in_array($cur_date, $dates)){
					$no_entry[] = $cur_date;
				}
			}

			echo json_encode(array('clients' => $clients, 'connect_list' => $connect_list, 'region' => $region, 'country' => $country, 'monthly_count' => $array, 'counts' => $counts, 'no_entry' => $no_entry));
		}
	}

	function clientConnect(){
		if(!empty($this->input->post()) && $this->session->userdata('role') == 5){
			$arr = array(
				'user_id' => $this->session->userdata('user_id'),
				'client_id' => $this->input->post('qc_client'),
				'member_id' => $this->input->post('qc_member'),
				'contact_mode' => $this->input->post('qc_contact_via'),
				'email_sent' => $this->input->post('qc_email_sent'),
				'comments' => $this->input->post('qc_comments'),
				'contacted_on' => date('Y-m-d', strtotime($this->input->post('qc_contacted_on')))
			);
			if($this->input->post('qc_connect_id') > 0){
				$id = $this->input->post('qc_connect_id');
				$this->client_model->updateData('client_connect', $arr, array('connect_id' => $id));
			}else{
				$id = $this->client_model->insertData('client_connect', $arr);
			}
			if($id > 0){
				$connect_list = $this->getConnectList(); //date("Y-m-d", strtotime('monday this week'))
				echo json_encode(array('status' => 'cc_success', 'connect_list' => $connect_list));
			}else{
				echo json_encode(array('status' => 'cc_failed'));
			}
		}
	}

	function getConnectList($start = '', $end = ''){
		if($this->session->userdata('role') == 5){
			$client_data = $this->client_model->getConnectList($start, $end);
			return $client_data;
		}
	}

	function getConnectDetails(){
		if($this->session->userdata('role') == 5){
			$connectDetails = $this->client_model->getConnectDetails($this->input->post('connect_id'));
			echo json_encode($connectDetails);
		}
	}

	function deleteConnect(){
		if($this->session->userdata('role') == 5){
			$this->client_model->deleteConnect($this->input->post('connect_id'));
			$connect_list = $this->getConnectList(); //date("Y-m-d", strtotime('monday this week'))
			echo json_encode(array('status' => 'cc_success', 'connect_list' => $connect_list));
		}
	}

	function updateNoReason(){
		if($this->session->userdata('role') == 5){
			$array = array(
				'user_id' => $this->session->userdata('user_id'),
				'client_id' => 0,
				'member_id' => 0,
				'contact_mode' => 'No Touch Point',
				'comments' => $this->input->post('qc_no_reason'),
				'contacted_on' => date('Y-m-d', strtotime($this->input->post('qc_no_date'))),
				'entered_on' => date('Y-m-d H:i:s')
			);
			$res = $this->client_model->insertData('client_connect', $array);
			
			$dates = $this->client_model->getEntryDates($this->session->userdata('user_id'));
			$Variable1 = strtotime('2020-04-01'); 
			$Variable2 = strtotime(date('Y-m-d'));
			$no_entry = array();
			for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) {
				$cur_date = date('Y-m-d', $currentDate);
				if(!in_array($cur_date, $dates)){
					$no_entry[] = $cur_date;
				}
			}

			echo json_encode(array('no_entry' => $no_entry));
		}
	}

	function touchpoint_list(){
		if($this->session->userdata('role') != 1){
			redirect('client/addClients');
			exit;
		}
		$data['sales_person'] = $this->client_model->getSalesPerson();
		$this->load->view('header', array('title' => 'Touch Points List'));
		$this->load->view('sidebar', array('title' => 'Touch Points List'));
		$this->load->view('tpoints_list_view', $data);
		$this->load->view('footer');
	}

	function touchpoint_list_data(){
		$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'username'){
			$order_by = 'u.name';
		}
		if($order_by == 'member_name'){
			$order_by = 'm.name';
		}
		$searchBySalesPerson = $this->input->get('searchBySalesPerson');
		$dir = $this->input->get('order')[0]['dir'];
		$records = $this->client_model->getPointList($this->input->get('start'), $this->input->get('length'), $this->input->get('search')['value'], $order_by, $dir, $searchBySalesPerson);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->client_model->getPointListCount($this->input->get('search')['value'], $searchBySalesPerson);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function getTPPerformance(){
		$user_id = $this->input->post('user_id');
		$counts = $this->client_model->getPerformanceCount($user_id);
		$daywise = $this->client_model->getDayWiseCount($user_id);
		$reasons = $this->client_model->getDayWiseReason($user_id);
		$Date2 = date('Y-m-d'); 
		$date = new DateTime($Date2);
		$date->modify('-29 day');
		$Date1 = $date->format('Y-m-d');
		$array = array(); 
		$Variable1 = strtotime($Date1); 
		$Variable2 = strtotime($Date2);

		if(isset($_POST['start_date'])){
			$Variable1 = strtotime($this->input->post('start_date'));
			$date = new DateTime(date('Y-m-d', $Variable1));
			$date->modify('+29 day');
			$Date2 = $date->format('Y-m-d');
			$Variable2 = strtotime($Date2);
		}

		$i=1;
		for ($currentDate = $Variable1; $currentDate <= $Variable2; $currentDate += (86400)) { 
			$Store = date('Y-m-d', $currentDate); 
			//$array[] = $Store;
			$array[$i]['key'] = date('d M', strtotime($Store));
			$array[$i]['value'] = 0.5;
			$array[$i]['reason'] = '';
			foreach ($daywise as $dw) {
				if($dw['contacted_on'] == $Store){
					$array[$i]['value'] = $dw['count'];
					break;
				}
			}

			foreach ($reasons as $res) {
				if($res['contacted_on'] == $Store){
					$array[$i]['reason'] = $res['comments'];
					break;
				}
			}
			$i++;
		}
		echo json_encode(array('monthly_count' => $array, 'counts' => $counts));
	}

	function getTouchPointCounts(){
		$res = $this->client_model->getTouchPointCounts();
		$ret_arr = array(
			'call' => 0,
			'whatsapp' => 0,
			'linkedIn' => 0
		);

		foreach ($res as $key => $value) {
			if($value['contact_mode'] == 'call'){
				$ret_arr['call'] = $value['count'];
			}

			else if($value['contact_mode'] == 'whatsapp'){
				$ret_arr['whatsapp'] = $value['count'];
			}

			else if($value['contact_mode'] == 'linkedIn'){
				$ret_arr['linkedIn'] = $value['count'];
			}
		}

		echo json_encode($ret_arr);
	}

	function searchClients(){
		$search = $this->input->post('search');
		$leads = $this->client_model->searchClients($search);
		echo json_encode($leads);
	}
}