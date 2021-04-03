<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends MX_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}/*else{
			if(!in_array('procurement', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}*/
		$this->load->model('vendors_model');
	}

	function index(){
		$this->add_vendor();
	}

	function add_vendor($vendor_id = 0){
		if(!empty($this->input->post())){
			$insert_arr = array(
				'vendor_name' => $this->input->post('vendor_name'),
				'country' => $this->input->post('country'),
				'source' => $this->input->post('source'),
				'website' => $this->input->post('website'),
				'stage' => $this->input->post('stage')
			);

			if($this->input->post('vendor_id') > 0){
				$vendor_id = $this->input->post('vendor_id');
				$this->vendors_model->updateData('vendors', $insert_arr, array('vendor_id' => $vendor_id));
				$this->vendors_model->deleteData('vendor_products', array('vendor_id' => $vendor_id));
				$this->vendors_model->deleteData('vendor_dtl', array('vendor_id' => $vendor_id));
			}else{
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$insert_arr['entered_on'] = $this->session->userdata('user_id');
				$vendor_id = $this->vendors_model->insertData('vendors', $insert_arr);
			}

			if(!empty($this->input->post('product_id'))){
				foreach($this->input->post('product_id') as $key => $value){
					$insert_arr = array(
						'vendor_id' => $vendor_id,
						'product_id' => $this->input->post('product_id')[$key],
						'material_id' => $this->input->post('material_id')[$key],
						'vendor_type' => $this->input->post('vendor_type')[$key],
					);
					$this->vendors_model->insertData('vendor_products', $insert_arr);
				}
			}

			if(!empty($this->input->post('name'))){
				foreach($this->input->post('name') as $key => $value){
					$insert_arr = array(
						'vendor_id' => $vendor_id,
						'name' => $this->input->post('name')[$key],
						'designation' => $this->input->post('designation')[$key],
						'email' => $this->input->post('email')[$key],
						'mobile' => $this->input->post('mobile')[$key],
						'is_whatsapp' => $this->input->post('is_whatsapp')[$key],
						'skype' => $this->input->post('vendor_type')[$key],
						'telephone' => $this->input->post('telephone')[$key],
						'main_seller' => $this->input->post('main_seller')[$key],
						'pmoc' => $this->input->post('pmoc')[$key],
					);
					$this->vendors_model->insertData('vendor_dtl', $insert_arr);
				}
			}
			redirect('vendors/add_vendor/'.$vendor_id);
			
		}else{
			if($vendor_id > 0){
				$data['vendor_id'] = $vendor_id;
				$data['vendor_details'] = $this->vendors_model->getVendorDetails($vendor_id);
				$data['vendor_products'] = $this->vendors_model->getVendorProducts($vendor_id);
			}
			$data['prd_str'] = $data['mat_str'] = '';
			$data['country'] = $this->vendors_model->getData('lookup', 'lookup_group = 2');
			$data['product'] = $product = $this->vendors_model->getData('lookup', 'lookup_group = 259');
			foreach($product as $prod){ 
				$data['prd_str'] .= '<option value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
			}

			$data['material'] = $material = $this->vendors_model->getData('lookup', 'lookup_group = 272');
			foreach($material as $mat){ 
				$data['mat_str'] .= '<option value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
			}
			$this->load->view('header', array('title' => 'Add Vendor'));
			$this->load->view('sidebar', array('title' => 'Add Vendor'));
			$this->load->view('add_vendor', $data);
			$this->load->view('footer');
		}
	}

	function list(){
		$data['prd_str'] = $data['mat_str'] = $data['country_str'] = '';
		$country = $this->vendors_model->getData('lookup', 'lookup_group = 2');
		foreach($country as $cnt){ 
			$data['country_str'] .= '<option value="'.$cnt['lookup_id'].'">'.ucwords(strtolower($cnt['lookup_value'])).'</option>';
		}

		$product = $this->vendors_model->getData('lookup', 'lookup_group = 259');
		foreach($product as $prod){ 
			$data['prd_str'] .= '<option value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
		}

		$material = $this->vendors_model->getData('lookup', 'lookup_group = 272');
		foreach($material as $mat){ 
			$data['mat_str'] .= '<option value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
		}
		$this->load->view('header', array('title' => 'Vendors List'));
		$this->load->view('sidebar', array('title' => 'Vendors List'));
		$this->load->view('vendors_list', $data);
		$this->load->view('footer');
	}

	function list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'vendor_name';
			}else if($key == 2){
				$search_key = 'v.country';
			}else if($key == 3){
				$search_key = 'stage';
			}else if($key == 4){
				$search_key = 'source';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}
		$search['product'] = $this->input->post('searchByProduct');
		$search['material'] = $this->input->post('searchByMaterial');
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'vendor_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->vendors_model->getVendorListData($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->vendors_model->getVendorListCount($search);
		$data['aaData'] = $records;
		//echo "<pre>";print_r($data);
		echo json_encode($data);
	}
}
?>