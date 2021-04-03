<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pq extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('pq', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('pq_model');
	}

	function index(){
		redirect('pq/pending_list');
	}

	function add($pq_client_id = 0){
		if(!empty($this->input->post())){
			$insert_data = array(
				'client_category' => $this->input->post('client_category'),
				'client_stage' => $this->input->post('client_stage'),
				'company_name' => $this->input->post('company_name'),
				'website' => $this->input->post('website'),
				'country' => $this->input->post('country'),
				'region' => $this->input->post('region'),
				'assigned_to' => $this->input->post('assigned_to'),
				'priority' => $this->input->post('priority'),
				'registration_method' => $this->input->post('registration_method'),
				'id_password' => $this->input->post('id_password'),
				'important_links' => $this->input->post('important_links'),
				'client_status' => $this->input->post('client_status'),
				'registration_id' => $this->input->post('registration_id'),
				'modified_on' => date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id')
			);

			if($this->input->post('pq_client_id')){
				$pq_client_id = $this->input->post('pq_client_id');
				$insert_data['entered_on'] = date('Y-m-d H:i:s');
				$insert_data['entered_by'] = $this->session->userdata('user_id');
				if($this->input->post('client_status') == 'approved'){
					$insert_data['vendor_id'] = $this->input->post('vendor_id');
					$insert_data['order_system'] = $this->input->post('order_system');
					$insert_data['order'] = $this->input->post('order');
					$insert_data['last_order_date'] = date('Y-m-d', strtotime($this->input->post('last_order_date')));
					$insert_data['enquiry'] = $this->input->post('enquiry');
					$insert_data['last_enquiry_date'] = date('Y-m-d', strtotime($this->input->post('last_enquiry_date')));
					$insert_data['approval_document'] = $this->input->post('approval_document');
				}
				$this->pq_model->updateData('pq_client', $insert_data, array('pq_client_id' => $pq_client_id));
			}else{
				$pq_client_id = $this->pq_model->insertData('pq_client', $insert_data);
			}

			if(!empty($this->input->post('name'))){
				foreach ($this->input->post('name') as $key => $value) {
					$member_array = array(
						'lead_mst_id' => $pq_client_id,
						'member_name' => $this->input->post('name')[$key],
						'designation' => $this->input->post('designation')[$key],
						'email' => $this->input->post('email')[$key],
						'mobile' => $this->input->post('mobile')[$key],
						'is_whatsapp' => $this->input->post('is_whatsapp')[$key],
						'skype' => $this->input->post('skype')[$key],
						'telephone' => $this->input->post('telephone')[$key],
						'main_buyer' => $this->input->post('main_buyer')[$key],
						'other_member' => $this->input->post('other_member')[$key]
					);
					if($this->input->post('lead_dtl_id')[$key] > 0){
						$this->pq_model->updateData('pq_lead_detail', $member_array, array('lead_dtl_id' => $this->input->post('lead_dtl_id')[$key]));
					}else{
						$this->pq_model->insertData('pq_lead_detail', $member_array);
					}
				}
			}
			redirect('pq/add/'.$pq_client_id);
		}else{
			if($pq_client_id > 0){
				$data['client_details'] = $this->pq_model->getPQClientData($pq_client_id);
				$data['client_connects'] = $this->pq_model->getData('pq_lead_connects', 'lead_id = '.$pq_client_id);
				krsort($data['client_connects']);
			}
			$data['users'] = $this->pq_model->getData('users', 'role=5');
			$data['region'] = $this->pq_model->getLookup(1);
			$data['country'] = $this->pq_model->getLookup(2);
			$data['client_category'] = $this->pq_model->getData('lead_type');
			$data['client_stage'] = $this->pq_model->getData('lead_stages');
			$this->load->view('header', array('title' => 'Add / Edit PQ'));
			$this->load->view('sidebar', array('title' => 'Add / Edit PQ'));
			$this->load->view('pq_form_view', $data);
			$this->load->view('footer');
		}
	}

	function addComments(){
		$arr = array(
			'lead_id' => $this->input->post('lead_id'),
			'member_id' => $this->input->post('member_id'),
			'connected_on' => date('Y-m-d', strtotime($this->input->post('contact_date'))),
			'comments' => $this->input->post('contact_details'),
			'connect_mode' => $this->input->post('connect_mode'),
			'email_sent' => $this->input->post('email_sent'),
			'entered_on' => date('Y-m-d H:i:s')
		);
		$this->pq_model->insertData('pq_lead_connects', $arr);
		redirect('pq/add/'.$this->input->post('lead_id'));
	}

	function getConnectDetails(){
		$res = $this->pq_model->getData('pq_lead_connects', 'member_id = '.$this->input->post('member_id'));
		$arr = array();
		foreach ($res as $key => $value) {
			$arr[$key] = $value;
			$arr[$key]['connected_on'] = date('d M', strtotime($value['connected_on']));
		}
		echo json_encode($arr);
	}

	function pending_list(){
		$country = $this->pq_model->getData('lookup', 'lookup_group = 2');
		$data['lead_country'] = '';
		foreach ($country as $key => $value) {
			$data['lead_country'] .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		}

		$region = $this->pq_model->getData('lookup', 'lookup_group = 1');
		$data['lead_region'] = '';
		foreach ($region as $key => $value) {
			$data['lead_region'] .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		}

		$lead_type = $this->pq_model->getData('lead_type');
		$data['lead_type_str'] = '';
		foreach ($lead_type as $key => $value) {
			$data['lead_type_str'] .= '<option value="'.$value['lead_type_id'].'">'.$value['type_name'].'</option>';
		}

		$stage = $this->pq_model->getData('lead_stages');
		$data['lead_stage_str'] = '';
		/*foreach ($stage as $key => $value) {
			$data['lead_stage_str'] .= '<option value="'.$value['lead_stage_id'].'">'.substr($value['stage_name'], 0, 9).'</option>';
		}*/
		$data['lead_stage_str'] .= '<option value="1" >Stage 1 - We have not done anything about it</option>
									<option value="2" >Stage 2 - We tried to initiate the registration but could not move ahead</option>
									<option value="3" >Stage 3 - We initiated the registration</option>
									<option value="4" >Stage 4 - Registration followed up</option>
									<option value="5" >Stage 5 - Registered</option>
									<option value="6" >Stage 6 - We received rfq</option>
									<option value="7" >Stage 7 - We received order</option>
									<option value="8" >Stage 0 - Blacklisted Cos.</option>';

		$users = $this->pq_model->getData('users', 'role = 5');
		$data['user_str'] = '';
		foreach ($users as $key => $value) {
			$data['user_str'] .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		}
		$this->load->view('header', array('title' => 'PQ Client List'));
		$this->load->view('sidebar', array('title' => 'PQ Client List'));
		$this->load->view('pq_list_view', $data);
		$this->load->view('footer');
	}

	function pending_list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'pq.company_name';
			}else if($key == 2){
				$search_key = 'pq.country';
			}else if($key == 3){
				$search_key = 'pq.region';
			}else if($key == 4){
				$search_key = 'pq.client_stage';
			}else if($key == 5){
				$search_key = 'pq.client_category';
			}else if($key == 6){
				$search_key = 'pq.registration_method';
			}/*else if($key == 7){
				$search_key = 'ld.member_name';
			}*/else if($key == 0){
				$search_key = 'user_id';//assigned_to
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'RANK';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->pq_model->getPQListPending($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->pq_model->getPQListPendingCount($search);
		$data['aaData'] = $records;

		echo json_encode($data);
	}

	function approved_list(){
		$country = $this->pq_model->getData('lookup', 'lookup_group = 2');
		$data['lead_country'] = '';
		foreach ($country as $key => $value) {
			$data['lead_country'] .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		}

		$region = $this->pq_model->getData('lookup', 'lookup_group = 1');
		$data['lead_region'] = '';
		foreach ($region as $key => $value) {
			$data['lead_region'] .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		}

		$lead_type = $this->pq_model->getData('lead_type');
		$data['lead_type_str'] = '';
		foreach ($lead_type as $key => $value) {
			$data['lead_type_str'] .= '<option value="'.$value['lead_type_id'].'">'.$value['type_name'].'</option>';
		}

		$stage = $this->pq_model->getData('lead_stages');
		$data['lead_stage_str'] = '';
		foreach ($stage as $key => $value) {
			$data['lead_stage_str'] .= '<option value="'.$value['lead_stage_id'].'">'.substr($value['stage_name'], 0, 9).'</option>';
		}
		$data['lead_stage_str'] .= '<option value="8">Stage - 7</option><option value="9">Stage - 8</option>';

		$users = $this->pq_model->getData('users', 'role = 5');
		$data['user_str'] = '';
		foreach ($users as $key => $value) {
			$data['user_str'] .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		}
		$this->load->view('header', array('title' => 'PQ Client List'));
		$this->load->view('sidebar', array('title' => 'PQ Client List'));
		$this->load->view('pq_list_view_approved', $data);
		$this->load->view('footer');
	}

	function approved_list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'pq.company_name';
			}else if($key == 2){
				$search_key = 'pq.country';
			}else if($key == 3){
				$search_key = 'pq.region';
			}else if($key == 4){
				$search_key = 'pq.client_stage';
			}else if($key == 5){
				$search_key = 'pq.client_category';
			}else if($key == 6){
				$search_key = 'pq.registration_method';
			}/*else if($key == 7){
				$search_key = 'ld.member_name';
			}*/else if($key == 0){
				$search_key = 'user_id';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'RANK';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->pq_model->getPQListApproved($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->pq_model->getPQListApprovedCount($search);
		$data['aaData'] = $records;

		echo json_encode($data);
	}

	function getPQMembers(){
		$res = $this->pq_model->getPQMembers($this->input->post('lead_id'), $this->input->post('member_type'));
		echo json_encode($res);
	}

	function pqAddActivity(){
		$insert_data = array(
			'pq_client_id' => $this->input->post('pq_client_id'),
			'activity_type' => $this->input->post('activity_type'),
			'activity_description' => $this->input->post('activity_description'),
			'activity_date' => date('Y-m-d', strtotime($this->input->post('activity_date'))),
			'client_comments' => $this->input->post('client_comments'),
			'comments_date' => date('Y-m-d', strtotime($this->input->post('comments_date'))),
			'activity_notes' => $this->input->post('activity_notes'),
			'entered_on' => date('Y-m-d H:i:s')
		);
		$this->pq_model->insertData('pq_activity', $insert_data);
	}

	function getActivities(){
		$client_details = $this->pq_model->getPQClientData($this->input->post('pq_client_id'));
		$activity = $this->pq_model->getActivities($this->input->post('pq_client_id'));

		$email_mobile = array();

		foreach ($client_details as $key => $value) {
			if($value['email'] != null){
				$email_mobile[$key]['email'] = $value['email'];
			}else{
				$email_mobile[$key]['email'] = '';
			}

			if($value['mobile'] != null){
				$email_mobile[$key]['mobile'] = $value['mobile'];
			}else{
				$email_mobile[$key]['mobile'] = '';
			}

			if($value['important_links'] != null){
				$temp = explode(',', $value['important_links']);
				$link_str = '';
				foreach ($temp as $link) {
					$link_str .= '<a href="'.$link.'" target="_blank">'.$link.'</a><br/>';
				}
				$client_details[0]['important_links'] = $link_str;
			}
		}

		$array = array('reg_id' => $client_details[0]['registration_id'], 'email_mobile' => $email_mobile, 'imp_links' => $client_details[0]['important_links'], 'id_password' => $client_details[0]['id_password'], 'activity' => $activity);
		echo json_encode($array);
	}

	function delActivity(){
		$this->pq_model->deleteData('pq_activity', array('activity_id' => $this->input->post('act_id')));
	}

	function uploadDocument(){
		if($this->input->post('pq_client_id') > 0){
			$pq_client_id = $this->input->post('pq_client_id');
			$res = $this->pq_model->getData('pq_client', 'pq_client_id = '.$pq_client_id);
			$config['upload_path']          = './assets/pq-document/';
            $config['allowed_types']        = 'pdf';//'jpeg|gif|jpg|png';
            $config['max_size']             = 5242880;
            //$config['max_width']            = 2000;
            //$config['max_height']           = 2000;
            //$config['min_width']            = 1000;
            //$config['min_height']           = 1000;
            $config['file_name']            = $res[0]['pq_client_id'];
            $config['overwrite']            = TRUE;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file'))
            {
				$error = array('error' => $this->upload->display_errors());
				$data = array('status' => 'failed', 'msg' => $error['error']);
            }
            else
            {
            	$file_dtls = $this->upload->data();
	            $data = array('status' => 'success', 'msg' => 'Image uploaded successfully!', 'file_name' => $file_dtls['file_name']);
	            $this->pq_model->updateData('pq_client', array('upload_document' => $file_dtls['file_name']), array('pq_client_id' => $pq_client_id));
            }
		}else{
			$data = array('status' => 'failed', 'msg' => 'Property not created yet.');
		}
		echo json_encode($data);
	}

	function deleteDocument(){
		$pq_client_id = $this->input->post('pq_client_id');
		$img_dtls = $this->pq_model->getData('pq_client', "pq_client_id = ".$pq_client_id);
		$this->property_model->updateData('pq_client', array('upload_document' => NULL), array("pq_client_id = ".$pq_client_id));
		unlink('./assets/property-images/main/'.$img_dtls[0]['upload_document']);
	}

	function deleteMember(){
		$lead_dtl_id = $this->input->post('member_id');
		$this->pq_model->deleteData('pq_lead_detail', array('lead_dtl_id' => $lead_dtl_id));
	}
}