<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('leads', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('leads_model');
	}

	function index(){
		$this->list();
	}

	function list(){
		$data['country_str'] = $data['port_str'] = $data['exporter_name'] = $data['importer_name'] = $data['new_importer_name'] = '';
		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION');
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$exporter_name = $this->leads_model->getUniqueData('EXPORTER_NAME');
		foreach($exporter_name as $ename){ 
			$data['exporter_name'] .= '<option value="'.addslashes($ename['EXPORTER_NAME']).'">'.ucwords(strtolower(addslashes($ename['EXPORTER_NAME']))).'</option>';
		}

		$importer_name = $this->leads_model->getUniqueData('IMPORTER_NAME');
		foreach($importer_name as $iname){ 
			$data['importer_name'] .= '<option value="'.addslashes($iname['IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($iname['IMPORTER_NAME']))).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME');
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('lead_list_view', $data);
		$this->load->view('footer');
	}

	function list_data(){
		ini_set('memory_limit', -1);
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search[$key] = $this->input->post('columns')[$key]['search']['value'];
		}
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'exporter_name'){
			$order_by = 'exporter_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getLeadsList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getLeadsListCount($search);
		$data['aaData'] = $records;

		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION', $search);
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$exporter_name = $this->leads_model->getUniqueData('EXPORTER_NAME', $search);
		foreach($exporter_name as $ename){ 
			$data['exporter_name'] .= '<option value="'.addslashes($ename['EXPORTER_NAME']).'">'.ucwords(strtolower(addslashes($ename['EXPORTER_NAME']))).'</option>';
		}

		$importer_name = $this->leads_model->getUniqueData('IMPORTER_NAME', $search);
		foreach($importer_name as $iname){ 
			$data['importer_name'] .= '<option value="'.addslashes($iname['IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($iname['IMPORTER_NAME']))).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME', $search);
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}

		echo json_encode($data);
	}

	function fuzzy_exp_imp_list(){
		$data['country_str'] = $data['port_str'] = $data['exporter_name'] = $data['importer_name'] = $data['new_importer_name'] = '';
		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION');
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$exporter_name = $this->leads_model->getUniqueData('EXPORTER_NAME');
		foreach($exporter_name as $ename){ 
			$data['exporter_name'] .= '<option value="'.addslashes($ename['EXPORTER_NAME']).'">'.ucwords(strtolower(addslashes($ename['EXPORTER_NAME']))).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME');
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('fuzzy_exp_imp_view', $data);
		$this->load->view('footer');
	}

	function fuzzy_exp_imp_list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search[$key] = $this->input->post('columns')[$key]['search']['value'];
		}
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'exporter_name'){
			$order_by = 'exporter_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getExpImpLeadsList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getExpImpLeadsListCount($search);
		$data['aaData'] = $records;

		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION', $search);
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$exporter_name = $this->leads_model->getUniqueData('EXPORTER_NAME', $search);
		foreach($exporter_name as $ename){ 
			$data['exporter_name'] .= '<option value="'.addslashes($ename['EXPORTER_NAME']).'">'.ucwords(strtolower(addslashes($ename['EXPORTER_NAME']))).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME', $search);
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}
		echo json_encode($data);
	}

	function fuzzy_imp_list(){
		$data['country_str'] = $data['port_str'] = $data['exporter_name'] = $data['importer_name'] = $data['new_importer_name'] = '';
		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION');
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME');
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('fuzzy_imp_view', $data);
		$this->load->view('footer');
	}

	function fuzzy_imp_list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search[$key] = $this->input->post('columns')[$key]['search']['value'];
		}
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'exporter_name'){
			$order_by = 'exporter_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getImpLeadsList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getImpLeadsListCount($search);
		$data['aaData'] = $records;

		$countries = $this->leads_model->getUniqueData('COUNTRY_OF_DESTINATION', $search);
		foreach($countries as $country){ 
			$data['country_str'] .= '<option value="'.$country['COUNTRY_OF_DESTINATION'].'">'.ucwords(strtolower($country['COUNTRY_OF_DESTINATION'])).'</option>';
		}

		$new_importer_name = $this->leads_model->getUniqueData('NEW_IMPORTER_NAME', $search);
		foreach($new_importer_name as $niname){ 
			$data['new_importer_name'] .= '<option value="'.addslashes($niname['NEW_IMPORTER_NAME']).'">'.ucwords(strtolower(addslashes($niname['NEW_IMPORTER_NAME']))).'</option>';
		}
		echo json_encode($data);
	}

	function getImporterNames($type){
		switch($type){
			case 1:
				$ids = explode(",", trim($this->input->post('record_ids'), ","));
				$data = $this->leads_model->getRecordData(1, $ids);
				break;

			case 2:
				$exp_imp = explode(",", trim($this->input->post('record_ids'), ","));
				$data = array();
				foreach ($exp_imp as $value) {
					$exp_imp_arr = explode("/", $value);
					$data[] = $this->leads_model->getRecordData(2, $exp_imp_arr[0], $exp_imp_arr[1]);
				}
				break;

			case 3:
				$new_imp_name = explode(",", trim($this->input->post('record_ids'), ","));
				$data = $this->leads_model->getRecordData(3, $new_imp_name);
				break;
		}
		echo json_encode($data);
	}

	function updateImporterName($type){
		$ids = explode(",", trim($this->input->post('ids'), ","));
		$this->leads_model->updateImporterName($type, $this->input->post('new_imp_name'), $ids);
	}

	function getDetails(){
		$res = $this->leads_model->getDetails($this->input->post('nimp_name'));
		echo json_encode($res);
	}

	function updateDetails(){
		$insert_arr = array(
			'new_importer_name' => $this->input->post('new_importer_name'),
			'no_of_employees' => $this->input->post('no_of_employees'),
			'buyer_name' => $this->input->post('buyer_name'),
			'designation' => $this->input->post('designation'),
			'email' => $this->input->post('email'),
			'telephone' => $this->input->post('telephone'),
			'mobile' => $this->input->post('mobile'),
			'is_whatsapp' => $this->input->post('is_whatsapp'),
			'skype' => $this->input->post('skype'),
			'entered_on' => date('Y-m-d H:i:s'),
			'entered_by' => $this->session->userdata('user_id')
		);
		$this->leads_model->insertData('lead_details', $insert_arr);
		redirect('leads/list');
	}

	function addLeadDetails($lead_id=0){
		if(!empty($this->input->post())){
			$main_array = array(
				//'company_name' => $this->input->post('lead_name'),
				'client_name' => $this->input->post('lead_name'),
				'country' => $this->input->post('lead_country'),
				'region' => $this->input->post('lead_region'),
				'brand' => $this->input->post('brand'),
				'source' => $this->input->post('source'),
				'website' => $this->input->post('website'),
				'no_of_employees' => $this->input->post('no_of_employees'),
				'lead_type' => $this->input->post('lead_type'),
				'lead_industry' => $this->input->post('lead_industry'),
				'lead_stage' => $this->input->post('lead_stage'),
				'stage_reason' => $this->input->post('stage_reason'),
				'modified_on' => date('Y-m-d H:i:s'),
				'status' => 'Y' 
			);

			if($this->input->post('assigned_to') > 0){
				$main_array['assigned_to'] = $this->input->post('assigned_to');
			}

			if($this->input->post('lead_id') > 0){
				$lead_id = $this->input->post('lead_id');
				$this->leads_model->updateData('clients', $main_array, array('client_id' => $lead_id));
				//$this->leads_model->deleteData('hetro_lead_detail', array('lead_id' => $lead_id));
			}else{
				$main_array['entered_on'] = date('Y-m-d H:i:s');
				$lead_id = $this->leads_model->insertData('clients', $main_array);
			}

			if(!empty($this->input->post('name'))){
				foreach ($this->input->post('name') as $key => $value) {
					$member_array = array(
						'lead_id' => $lead_id,
						'member_name' => $this->input->post('name')[$key],
						'designation' => $this->input->post('designation')[$key],
						'email' => $this->input->post('email')[$key],
						'mobile' => $this->input->post('mobile')[$key],
						'is_whatsapp' => $this->input->post('is_whatsapp')[$key],
						'skype' => $this->input->post('skype')[$key],
						'telephone' => $this->input->post('telephone')[$key],
						'main_buyer' => $this->input->post('main_buyer')[$key],
						'other_member' => $this->input->post('other_member')[$key],
					);
					if($this->input->post('member_id')[$key] > 0){
						$this->leads_model->updateData('hetro_lead_detail', $member_array, array('lead_dtl_id' => $this->input->post('member_id')[$key]));
					}else{
						$this->leads_model->insertData('hetro_lead_detail', $member_array);
					}
				}
			}
			$this->session->set_flashdata('lead_success', 'Lead updated successfully.');
			redirect('leads/hetregenous_leads/'.$this->input->post('source'), 'refresh');
		}else{
			if($lead_id != 0){
				$data['lead_id'] = $lead_id;
				$data['client_details'] = $this->leads_model->getLeadDetails($lead_id);
				$data['client_connects'] = $this->leads_model->getData('lead_connects', 'lead_id = '.$lead_id);
			}
			$data['source'] = $this->leads_model->getSources();
			$data['users'] = $this->leads_model->getData('users', 'role=5');
			$data['region'] = $this->leads_model->getLookup(1);
			$data['country'] = $this->leads_model->getLookup(2);
			$data['lead_type'] = $this->leads_model->getData('lead_type');
			$data['lead_industry'] = $this->leads_model->getData('lead_industry');
			$data['lead_stages'] = $this->leads_model->getData('lead_stages');
			$data['lead_stage_reasons'] = $this->leads_model->getData('lead_stage_reasons');
			$this->load->view('header', array('title' => 'Add / Edit Lead'));
			$this->load->view('sidebar', array('title' => 'Add / Edit Lead'));
			$this->load->view('lead_details', $data);
			$this->load->view('footer');
		}
	}

	function hetregenous_leads_old($type = ''){
		$country = $this->leads_model->getDistinctHetroData('country', $type);
		$data['lead_country_str'] = '';
		foreach ($country as $key => $value) {
			$data['lead_country_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$region = $this->leads_model->getDistinctHetroData('region', $type);
		$data['lead_region_str'] = '';
		foreach ($region as $key => $value) {
			$data['lead_region_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$lead_type = $this->leads_model->getDistinctHetroData('type', $type);
		$data['lead_type_str'] = '';
		foreach ($lead_type as $key => $value) {
			$data['lead_type_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$stage = $this->leads_model->getDistinctHetroData('stage', $type);
		$data['lead_stage_str'] = '';
		foreach ($stage as $key => $value) {
			$data['lead_stage_str'] .= '<option value="'.$value['id'].'">'.substr($value['value'], 0, 9).'</option>';
		}

		$data['type'] = $type;
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('hetro_list_view', $data);
		$this->load->view('footer');
	} 

	function hetro_lead_data($type = ''){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'company_name';
			}else if($key == 2){
				$search_key = 'country';
			}else if($key == 3){
				$search_key = 'member_name';
			}else if($key == 4){
				$search_key = 'email';
			}else if($key == 6){
				$search_key = 'lead_type';
			}else if($key == 7){
				$search_key = 'lead_stage';
			}else if($key == 8){
				$search_key = 'assigned_to';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'client_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getHetroLeadsList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir, $type);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getHetroLeadsListCount($search, $type);
		$data['aaData'] = $records;

		echo json_encode($data);
	}


	function hetregenous_leads($type = ''){
		$country = $this->leads_model->getDistinctHetroData('country', $type);
		$data['lead_country_str'] = '';
		foreach ($country as $key => $value) {
			$data['lead_country_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$region = $this->leads_model->getDistinctHetroData('region', $type);
		$data['lead_region_str'] = '';
		foreach ($region as $key => $value) {
			$data['lead_region_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$lead_type = $this->leads_model->getDistinctHetroData('type', $type);
		$data['lead_type_str'] = '';
		foreach ($lead_type as $key => $value) {
			$data['lead_type_str'] .= '<option value="'.$value['id'].'">'.$value['value'].'</option>';
		}

		$stage = $this->leads_model->getDistinctHetroData('stage', $type);
		$data['lead_stage_str'] = '';
		foreach ($stage as $key => $value) {
			$data['lead_stage_str'] .= '<option value="'.$value['id'].'">'.substr($value['value'], 0, 9).'</option>';
		}

		$users = $this->leads_model->getData('users', 'role = 5');
		$data['user_str'] = '';
		foreach ($users as $key => $value) {
			$data['user_str'] .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		}

		$data['type'] = $type;
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('hetro_leads_list', $data);
		$this->load->view('footer');
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
		$this->leads_model->insertData('lead_connects', $arr);
		redirect('leads/addLeadDetails/'.$this->input->post('lead_id'));
	}

	function addCommentsPrimary(){
		$arr = array(
			'lead_id' => $this->input->post('lead_id'),
			'member_id' => $this->input->post('member_id'),
			'connected_on' => date('Y-m-d', strtotime($this->input->post('contact_date'))),
			'comments' => $this->input->post('contact_details'),
			'connect_mode' => $this->input->post('connect_mode'),
			'email_sent' => $this->input->post('email_sent'),
			'entered_on' => date('Y-m-d H:i:s')
		);
		$this->leads_model->insertDataDB2('lead_connects', $arr);
		if($this->input->post('from_list')){
			echo "Here";
		}else{
			redirect('leads/addPrimaryLeadDetails/'.$this->input->post('imp_id').'/'.$this->input->post('category'));	
		}
		
	}

	function deleteMember(){
		$this->leads_model->deleteData('hetro_lead_detail', array('lead_dtl_id' => $this->input->post('member_id')));
	}

	function deleteMemberDB2(){
		$this->leads_model->deleteDataDB2('lead_detail', array('lead_dtl_id' => $this->input->post('member_id')));
	}

	function primary_leads($category=''){
		$data['lead_category'] = $category;
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('primary_list_view', $data);
		$this->load->view('footer');
	}

	function primary_leads_data($category=''){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search[$this->input->post('columns')[$key]['data']] = $this->input->post('columns')[$key]['search']['value'];
		}
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'RANK';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getPrimaryLeadsList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir, $category);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getPrimaryLeadsListCount($search, $category);
		$data['aaData'] = $records;

		echo json_encode($data);
	}

	function addPrimaryLeadDetails($lead_id=0, $category){
		$category = urldecode($category);
		if(!empty($this->input->post())){
			//echo "<pre>";print_r($this->input->post());exit;
			$main_array = array(
				'imp_id' => $this->input->post('imp_id'),
				'source' => $this->input->post('source'),
				'data_category' => $this->input->post('data_category'),
				'website' => $this->input->post('website'),
				'no_of_employees' => $this->input->post('no_of_employees'),
				'lead_type' => $this->input->post('lead_type'),
				'lead_industry' => $this->input->post('lead_industry'),
				'lead_stage' => $this->input->post('lead_stage'),
				'stage_reason' => $this->input->post('stage_reason'),
				'purchase_factor_1' => $this->input->post('purchase_factor_1'),
				'purchase_factor_2' => $this->input->post('purchase_factor_2'),
				'purchase_factor_3' => $this->input->post('purchase_factor_3'),
				'sales_notes' => $this->input->post('sales_notes'),
				'modified_on' => date('Y-m-d H:i:s') 
			);

			if($this->input->post('product_pitch')){
				$main_array = array(
					'product_pitch' => $this->input->post('product_pitch'),
					'purchase_comments' => $this->input->post('purchase_comments'),
					'margins' => $this->input->post('margins'),
				);
			}

			if($this->input->post('assigned_to')){
				$main_array['assigned_to'] = $this->input->post('assigned_to');
			}

			if($this->input->post('lead_mst_id') > 0){
				$lead_id = $this->input->post('lead_mst_id');
				$this->leads_model->updateDataDB2('lead_mst', $main_array, array('lead_mst_id' => $lead_id));
				//$this->leads_model->deleteDataDB2('lead_detail', array('lead_mst_id' => $lead_id));
			}else{
				$main_array['entered_on'] = date('Y-m-d H:i:s');
				$lead_id = $this->leads_model->insertDataDB2('lead_mst', $main_array);
			}

			if(!empty($this->input->post('name'))){
				foreach ($this->input->post('name') as $key => $value) {
					$member_array = array(
						'lead_mst_id' => $lead_id,
						'member_name' => $this->input->post('name')[$key],
						'designation' => $this->input->post('designation')[$key],
						'email' => $this->input->post('email')[$key],
						'mobile' => $this->input->post('mobile')[$key],
						'is_whatsapp' => $this->input->post('is_whatsapp')[$key],
						'skype' => $this->input->post('skype')[$key],
						'telephone' => $this->input->post('telephone')[$key],
						'main_buyer' => $this->input->post('main_buyer')[$key],
						'other_member' => $this->input->post('other_member')[$key],
						'decision_maker' => $this->input->post('decision_maker')[$key],
					);

					if($this->input->post('lead_dtl_id')[$key] > 0){
						$this->leads_model->updateDataDB2('lead_detail', $member_array, array('lead_dtl_id' => $this->input->post('lead_dtl_id')[$key]));
					}else{
						$this->leads_model->insertDataDB2('lead_detail', $member_array);
					}
				}
			}
			$this->session->set_flashdata('lead_success', 'Lead updated successfully.');
			redirect('leads/primary_leads_list/'.$category, 'refresh');
		}else{
			if($lead_id != 0){
				$data['lead_id'] = $lead_id;
				$data['lead_category'] = $category;
				$data['client_details'] = $this->leads_model->getPrimaryLeadDetails($lead_id, $category);
				$lead_id = $data['client_details'][0]['lead_mst_id'];
				if($lead_id > 0){
					$data['client_connects'] = $this->leads_model->getConnectDetailsDB2($lead_id);
					krsort($data['client_connects']);
				}
			}
			$data['users'] = $this->leads_model->getData('users', 'role=5');
			$data['region'] = $this->leads_model->getLookup(1);
			$data['country'] = $this->leads_model->getLookup(2);
			$data['lead_type'] = $this->leads_model->getData('lead_type');
			$data['lead_industry'] = $this->leads_model->getData('lead_industry');
			$data['lead_stages'] = $this->leads_model->getData('lead_stages');
			$data['lead_stage_reasons'] = $this->leads_model->getData('lead_stage_reasons');
			$data['purchase_factors'] = $this->leads_model->getData('purchase_factors');
			$this->load->view('header', array('title' => 'Add / Edit Lead'));
			$this->load->view('sidebar', array('title' => 'Add / Edit Lead'));
			$this->load->view('primary_lead_details', $data);
			$this->load->view('footer');
		}
	}

	function getConnectDetailsDB2(){
		/*$res = $this->leads_model->getDataDB2('lead_connects', 'member_id = '.$this->input->post('member_id'));
		$arr = array();
		foreach ($res as $key => $value) {
			$arr[$key] = $value;
			$arr[$key]['connected_on'] = date('d M', strtotime($value['connected_on']));
		}
		echo json_encode($arr);*/

		$res = $this->leads_model->getLeadConnectsDB2($this->input->post('member_id'));
		$arr = array();
		foreach ($res as $key => $value) {
			$arr[$key] = $value;
			$arr[$key]['connected_on'] = date('d M', strtotime($value['connected_on']));
		}
		echo json_encode($arr);
	}

	function getConnectDetails(){
		$res = $this->leads_model->getData('hetro_lead_detail', 'lead_dtl_id = '.$this->input->post('member_id'));
		$res = $this->leads_model->getData('lead_connects', 'lead_id = '.$res[0]['lead_id']);
		$arr = array();
		foreach ($res as $key => $value) {
			$arr[$key] = $value;
			$arr[$key]['connected_on'] = date('d M', strtotime($value['connected_on']));
		}
		echo json_encode($arr);
	}

	function updatePrimaryLeadStage(){
		$this->leads_model->updateDataDB2('lead_mst', array('lead_stage' => $this->input->post('stage')), array('lead_mst_id' => $this->input->post('lead_mst_id')));
	}

	function primary_leads_list($category){
		$category = urldecode($category);
		$lead_type = $this->leads_model->getData('lead_type');
		$data['lead_type_str'] = '<option value="blank">Blank Lead Type</option>';
		foreach ($lead_type as $key => $value) {
			$data['lead_type_str'] .= '<option value="'.$value['lead_type_id'].'">'.$value['type_name'].'</option>';
		}

		$stage = $this->leads_model->getData('lead_stages');
		$data['lead_stage_str'] = '<option value="blank">Blank Lead Stage</option>';
		foreach ($stage as $key => $value) {
			$data['lead_stage_str'] .= '<option value="'.$value['lead_stage_id'].'">'.substr($value['stage_name'], 0, 9).'</option>';
		}

		$users = $this->leads_model->getData('users', 'role = 5');
		$data['user_str'] = '<option value="500">Blank User</option>';
		foreach ($users as $key => $value) {
			$data['user_str'] .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		}

		$country = $this->leads_model->getLeadCountries($category);
		$data['lead_country'] = '';
		foreach ($country as $key => $value) {
			$data['lead_country'] .= '<option value="'.$value['COUNTRY_OF_DESTINATION'].'">'.substr($value['COUNTRY_OF_DESTINATION'], 0, 9).'</option>';
		}

		$data['lead_category'] = $category;
		$this->load->view('header', array('title' => 'Leads List'));
		$this->load->view('sidebar', array('title' => 'Leads List'));
		$this->load->view('primary_leads_list', $data);
		$this->load->view('footer');
	} 

	function primary_list_data($category){
		$category = urldecode($category);
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'IMPORTER_NAME';
			}else if($key == 2){
				$search_key = 'lead_type';
			}else if($key == 3){
				$search_key = 'lead_stage';
			}else if($key == 4){
				$search_key = 'COUNTRY_OF_DESTINATION';
			}else if($key == 6){
				$search_key = 'assigned_to';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 't1.IMPORTER_NAME';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->leads_model->getPrimaryListData($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir, $category);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->leads_model->getPrimaryListCount($search, $category);
		$data['aaData'] = $records;
		//echo "<pre>";print_r($data);
		echo json_encode($data);
	}

	function getYearWiseImport(){
		$imp_name = $this->input->post('imp_name');
		$category = $this->input->post('category');
		$res = $this->leads_model->getYearWiseImport($imp_name, $category);
		echo json_encode($res);
	}

	function getMembers(){
		$res = $this->leads_model->getMembers($this->input->post('lead_id'), $this->input->post('member_type'));
		echo json_encode($res);
	}

	function getHetroMembers(){
		$res = $this->leads_model->getHetroMembers($this->input->post('lead_id'), $this->input->post('member_type'));
		echo json_encode($res);
	}
}
