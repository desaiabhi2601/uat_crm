<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quality extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('quality', $this->session->userdata('module')) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest'){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		error_reporting(E_ALL);
		$this->load->model('quality_model');
	}

	function index(){
		redirect('quality/mtc_list');
	}

	function add_mtc($mtc_id = 0){
		if(!empty($this->input->post())){
			$insert_arr = array(
				'mtc_type' => $this->input->post('mtc_type'),
				'mtc_for' => $this->input->post('mtc_for'),
				'mtc_for_id' => $this->input->post('mtc_for_hidden'),
				'mtc_company' => $this->input->post('mtc_company'),
				'mtc_company_id' => $this->input->post('mtc_company_id'),
				'assigned_to' => $this->input->post('assigned_to'),
			);
			if($this->input->post('mtc_mst_id') > 0){
				$insert_arr['modified_on'] = date('Y-m-d H:i:s');
				$insert_arr['modified_by'] = $this->session->userdata('user_id');
				$insert_arr['made_flag'] = $this->input->post('made_flag');
				if($this->input->post('made_flag') == 'Y'){
					$insert_arr['made_flag_on'] = date('Y-m-d H:i:s');
				}
				
				$this->quality_model->updateData('mtc_mst', $insert_arr, array('mtc_mst_id' => $this->input->post('mtc_mst_id')));
				/*if(!empty($_FILES)){
					$config['upload_path']          = './assets/mtc-document/';
		            $config['allowed_types']        = 'pdf';//'jpeg|gif|jpg|png';
		            $config['max_size']             = 5242880;
		            //$config['max_width']            = 2000;
		            //$config['max_height']           = 2000;
		            //$config['min_width']            = 1000;
		            //$config['min_height']           = 1000;
		            $config['file_name']            = 'mtc-'.$this->input->post('mtc_mst_id');
		            $config['overwrite']            = TRUE;

		            $this->load->library('upload', $config);

		            if ( ! $this->upload->do_upload('mtc_file'))
		            {
						$error = array('error' => $this->upload->display_errors());
						$data = array('status' => 'failed', 'msg' => $error['error']);
		            }
		            else
		            {
		            	$file_dtls = $this->upload->data();
			        	$insert_arr['mtc_file_name'] = $file_dtls['file_name'];
		            }

		            $this->quality_model->updateData('mtc_mst', $insert_arr, array('mtc_mst_id' => $this->input->post('mtc_mst_id')));
		            
				}*/
				redirect('quality/mtc_list');
			}else{
				$insert_arr['created_by'] = $this->session->userdata('user_id');
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$this->quality_model->insertData('mtc_mst', $insert_arr);
				if($this->input->post('is_ajax') == 1){
					echo 'submitted';
				}else{
					redirect('quality/mtc_list');
				}
			}
		}else{
			if($mtc_id > 0){
				$data['mtc_details'] = $this->quality_model->getMTCDetails($mtc_id);
				$data['mtc_files'] = $this->quality_model->getData('mtc_files', 'status="active" AND mtc_mst_id = '.$mtc_id);
			}

			//new code
			// checking proforma invoice created any new if records found then showing it in quality module
			$data['quotation_won'] = $this->quality_model->get_quotaion_won_performa();
			// echo "<pre>";print_r($data);echo"</pre><hr>";exit;
			//new code end
			$data['title'] = 'Add Mtc';
			$data['quality_users'] = $this->quality_model->getData('users', 'role in (9, 10)');
			$this->load->view('header', array('title' => 'Add Mtc'));
			$this->load->view('sidebar');
			$this->load->view('add_mtc', $data);
			$this->load->view('footer');
		}
	}

	function getSuggestions(){
		$search = $this->input->post('search');
		$mtc_for = $this->input->post('mtc_for');
		$result = $this->quality_model->getSuggestions($search, $mtc_for);
		echo json_encode($result);
	}	

	function mtc_list(){

		$data = $this->create_mtc_list_data("mtc_mst.status='active'");
		$this->load->view('header', array('title' => 'MTC List'));
		$this->load->view('sidebar', array('title' => 'MTC List'));
		$this->load->view('mtc_list', $data);
		$this->load->view('footer');
	}
	

	function mtc_list_data(){
		$search = array();
		/*foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'pq.company_name';
			}else if($key == 2){
				$search_key = 'pq.country';
			}else if($key == 3){
				$search_key = 'pq.region';
			}else if($key == 4){
				$search_key = 'pq.client_category';
			}else if($key == 5){
				$search_key = 'pq.client_stage';
			}else if($key == 6){
				$search_key = 'pq.registration_method';
			}else if($key == 7){
				$search_key = 'ld.member_name';
			}else if($key == 0){
				$search_key = 'assigned_to';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}*/
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'mtc_mst_id';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->quality_model->getMTCList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->quality_model->getMTCListCount($search);
		$data['aaData'] = $records;

		echo json_encode($data);
	}

	function getSampleMTCStatus(){
		$mtc = $this->quality_model->getSampleMTCStatus($this->input->post('quote_id'));
		if($mtc['made_flag'] == 'Y'){
			$mtc_files = $this->quality_model->getData('mtc_files', 'mtc_mst_id = '.$mtc['mtc_mst_id']);
		}
		if(!empty($mtc)){
			echo json_encode(array('mtc' => $mtc, 'files' => $mtc_files));
		}else{
			echo json_encode(array());
		}
	}

	function updateMTC(){
		if($this->input->post('made_flag')){
			$update_arr['made_flag'] = $this->input->post('made_flag');
			$update_arr['made_flag_on'] = date('Y-m-d H:i:s');
		}

		if($this->input->post('checked_by_quality_admin')){
			$update_arr['checked_by_quality_admin'] = $this->input->post('checked_by_quality_admin');
			$update_arr['checked_by_quality_admin_on'] = date('Y-m-d H:i:s');
			$update_arr['qa_comment'] = $this->input->post('qa_comment');
		}

		if($this->input->post('checked_by_super_admin')){
			$update_arr['checked_by_super_admin'] = $this->input->post('checked_by_super_admin');
			$update_arr['checked_by_super_admin_on'] = date('Y-m-d H:i:s');
			$update_arr['sa_comment'] = $this->input->post('sa_comment');
		}
		$update_arr['modified_on'] = date('Y-m-d H:i:s');
		$update_arr['modified_by'] = $this->session->userdata('user_id');

		$this->quality_model->updateData('mtc_mst', $update_arr, array('mtc_mst_id' => $this->input->post('mtc_mst_id')));
	}

	function uploadDocument(){
		if($this->input->post('mtc_mst_id') > 0){
			$mtc_mst_id = $this->input->post('mtc_mst_id');
			//$res = $this->quality_model->getData('mtc_files', 'mtc_file_id = '.$mtc_mst_id);
			$config['upload_path']          = './assets/mtc-document/';
            $config['allowed_types']        = 'pdf';//'jpeg|gif|jpg|png';
            $config['max_size']             = 5242880;
            //$config['max_width']            = 2000;
            //$config['max_height']           = 2000;
            //$config['min_width']            = 1000;
            //$config['min_height']           = 1000;
            $config['file_name']            = time().'-MTC-DOCUMENT-'.$mtc_mst_id;
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
	            $this->quality_model->insertData('mtc_files', array('file_name' => $file_dtls['file_name'], 'mtc_mst_id' => $this->input->post('mtc_mst_id')));
            }
		}else{
			$data = array('status' => 'failed', 'msg' => '');
		}
		echo json_encode($data);
	}

	function deleteDocument(){
		/*$mtc_for_id = $this->input->post('mtc_for_id');
		$img_dtls = $this->mtc-document->getData('mtc_files', "pq_client_id = ".$mtc_for_id);
		$this->quality_model->updateData('pq_client', array('upload_document' => NULL), array("pq_client_id = ".$mtc_for_id));
		unlink('./assets/property-images/main/'.$img_dtls[0]['upload_document']);*/
	}


	function add_marking($marking_id=0){
		if(!empty($this->input->post())){
			$master_arr = array(
				'marking_type' => $this->input->post('marking_type'),
				'marking_for' => $this->input->post('marking_for'),
				'marking_for_id' => $this->input->post('marking_for_hidden'),
				'made_by' => $this->input->post('made_by'),
				'assigned_to' => $this->input->post('assigned_to'),
				'reference' => $this->input->post('reference'),
				'comments' => $this->input->post('comments'),
				'modified_on' => date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id')
			);
			if($this->input->post('marking_mst_id') > 0){
				$marking_id = $this->input->post('marking_mst_id');
				$this->quality_model->deleteData('marking_dtl', array('marking_mst_id' => $marking_id));
			}else{
				$master_arr['entered_on'] = date('Y-m-d H:i:s');
				$master_arr['entered_by'] = $this->session->userdata('user_id');
				$master_arr['made_status'] = 'Yes';
				$marking_id = $this->quality_model->insertData('marking_mst', $master_arr);
			}
			foreach ($this->input->post('quote_dtl_id') as $key => $value) {
				$detail_arr = array(
					'marking_mst_id' => $marking_id,
					'quotation_dtl_id' => $value,
					'product_id' => $this->input->post('product')[$key],
					'material_id' => $this->input->post('material')[$key],
					'heat_no' => $this->input->post('heat_number')[$key],
					'specification' => $this->input->post('specification')[$key],
					'marking' => $this->input->post('marking')[$key],
				);
				$this->quality_model->insertData('marking_dtl', $detail_arr);

				$update_arr = array(
					'product_id' => $this->input->post('product')[$key],
					'material_id' => $this->input->post('material')[$key],
				);
				$this->quality_model->updateData('quotation_dtl', $update_arr, array('quotation_dtl_id' => $value));
			}
			redirect('quality/marking_list/'.$this->input->post('marking_type'));
		}else{
			if($marking_id > 0){
				$data['marking_id'] = $marking_id;
				$data['marking_details'] = $this->quality_model->getMarkingDetails($marking_id);
			}
			$data['quality_users'] = $this->quality_model->getData('users', 'role in (9, 10)');
			$data['sales_users'] = $this->quality_model->getData('users', 'role in (5)');
			$data['product'] = $this->quality_model->getData('lookup', 'lookup_group = 259');
			$data['material'] = $this->quality_model->getData('lookup', 'lookup_group = 272');
			$this->load->view('header', array('title' => 'Add / Edit Marking'));
			$this->load->view('sidebar', array('title' => 'Add / Edit Marking'));
			$this->load->view('add_marking', $data);
			$this->load->view('footer');
		}
	}

	function getLineItems(){
		$details = $this->quality_model->getLineItems($this->input->post('quotation_mst_id'));
		echo json_encode($details);
	}

	function generateHeat(){
		$product_id = $this->input->post('product_id');
		$heat_arr = $this->quality_model->getHeatNumber($product_id);
		if(!empty($heat_arr)){
			$prefix = $heat_arr['prefix'];
			switch ($product_id) {
				case 289:
					$heat_no = $heat_arr['logic_value'];
					$heat_number = $prefix.$heat_no;
					$new_heat_no = $heat_no + 1;
					if($new_heat_no == 100){
						$new_heat_no = 1;
						$prefix++;
					}
					$new_prefix = $prefix;
					$this->quality_model->updateData('number_logic', array('logic_value' => $new_heat_no, 'prefix' => $new_prefix), array('logic_for' => $product_id));
					break;

				case 264:
				case 263:
				case 295: 
				case 265: 
				case 267:
				case 266:
				case 300:
				case 262:
				case 268:
				case 302:
					$heat_no = $heat_arr['logic_value'];
					$new_heat_no = $heat_no + 1;
					switch (strlen($heat_no)) {
						case 1:
							$heat_no = '000'.$heat_no;
							break;

						case 2:
							$heat_no = '00'.$heat_no;
							break;

						case 3:
							$heat_no = '0'.$heat_no;
							break;
						
						default:
							$heat_no = $heat_no;
							break;
					}
					$heat_number = $prefix.$heat_no;
					$this->quality_model->updateData('number_logic', array('logic_value' => $new_heat_no), array('logic_for' => $product_id));
					break;

				case 260:
					$heat_no = $heat_arr['logic_value'];
					$heat_number = $heat_no.$prefix;
					$new_heat_no = $heat_no + 1;
					$this->quality_model->updateData('number_logic', array('logic_value' => $new_heat_no), array('logic_for' => $product_id));
					break;
			}
			echo $heat_number;
		}
	}

	function marking_list($marking_type){
		$data['marking_type'] = $marking_type;
		$data['quality_users'] = $this->quality_model->getData('users', 'role in (9, 10)');
		$data['sales_users'] = $this->quality_model->getData('users', 'role in (5)');
		$this->load->view('header', array('title' => 'Marking List'));
		$this->load->view('sidebar', array('title' => 'Marking List'));
		$this->load->view($marking_type.'_marking_list', $data);
		$this->load->view('footer');
	}

	function marking_list_data($type){
		$search = array('marking_type' => $type);
		/*foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($key == 1){
				$search_key = 'pq.company_name';
			}else if($key == 2){
				$search_key = 'pq.country';
			}else if($key == 3){
				$search_key = 'pq.region';
			}else if($key == 4){
				$search_key = 'pq.client_category';
			}else if($key == 5){
				$search_key = 'pq.client_stage';
			}else if($key == 6){
				$search_key = 'pq.registration_method';
			}else if($key == 7){
				$search_key = 'ld.member_name';
			}else if($key == 0){
				$search_key = 'assigned_to';
			}

			$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
		}*/
		//print_r($search);
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'marking_mst_id';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->quality_model->getMarkingList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->quality_model->getMarkingListCount($search);
		$data['aaData'] = $records;

		echo json_encode($data);
	}

	function updateMarking(){
		$marking_detail = $this->quality_model->getData('marking_mst', 'marking_mst_id = '.$this->input->post('marking_mst_id'));
		if($this->input->post('made_status')){
			$update_arr['made_status'] = $this->input->post('made_status');
		}

		if($this->input->post('quality_admin_status')){
			$update_arr['quality_admin_status'] = $this->input->post('quality_admin_status');
			$update_arr['qa_comment'] = $this->input->post('qa_comment');
			if($this->input->post('quality_admin_status_on') == '' || $update_arr['quality_admin_status'] != $marking_detail['quality_admin_status']){
				$update_arr['quality_admin_status_on'] = date('Y-m-d H:i:s');
			}
		}

		if($this->input->post('super_admin_status')){
			$update_arr['super_admin_status'] = $this->input->post('super_admin_status');
			$update_arr['super_admin_status_on'] = date('Y-m-d H:i:s');
			$update_arr['sa_comment'] = $this->input->post('sa_comment');
			if($this->input->post('super_admin_status_on') == '' || $update_arr['super_admin_status'] != $marking_detail['super_admin_status']){
				$update_arr['super_admin_status_on'] = date('Y-m-d H:i:s');
			}
		}
		$update_arr['modified_on'] = date('Y-m-d H:i:s');
		$update_arr['modified_by'] = $this->session->userdata('user_id');

		$this->quality_model->updateData('marking_mst', $update_arr, array('marking_mst_id' => $this->input->post('marking_mst_id')));
		echo $this->db->last_query();
	}

	function viewMarking($marking_id){
		$marking_details = $this->quality_model->getMarkingDetails($marking_id);

		$this->load->library('Pdf');
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, NULL, '', array(0,0,0), array(255,255,255));
		$pdf->SetFooterData(array(0,0,0), array(255,255,255));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(10, PDF_MARGIN_TOP-10, 10);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER-5);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM-15);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();

		$tbl = ''; $i = 1;

		foreach ($marking_details as $key => $value) {
			$tbl .= '<tr>
				<td colspan="3" style="font-family: courier; font-size: 12px;">Line Item # '.$i++.'</td>
			</tr>
			<tr>
				<td style="font-family:courier;font-size: 11px;" align="left">'.addslashes($marking_details[$key]['description']).'</td>
				<td style="font-family: courier; font-size: 11px;" align="right">'.$value['quantity'].'</td>
				<td style="font-family: courier; font-size: 11px;" align="left">'.$value['unit_value'].'</td>
			</tr>
			<tr>
				<td style="font-family: courier; font-size: 16px;" colspan="3">'.nl2br($value['marking']).'</td>
			</tr>
			<tr><td colspan="3"></td></tr>
			';
		}


		$html = '
			<table cellpadding="5" cellspacing="0">
				<tr style="background-color: #fff;">
					<td style="vertical-align: text-top;" align="center">
						<img src="/assets/media/client-logos/logo.png" width="180" height="50">
					</td>
				</tr>
				<tr>
					<td>
						<table cellpadding="5" cellspacing="0" border="1">
							<tr>
								<td>Order #: -</td>
								<td>Proforma #: '.$marking_details[0]['proforma_no'].'</td>
								<td>Date: '.date('d M, Y', strtotime($marking_details[0]['confirmed_on'])).'</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<table cellspacing="10" cellpadding="0" border="0" style="border: solid 1px grey;">
							<tr>
								<th align="center" colspan="3"><h3>Marking Details</h3></th>
							</tr>
							<tr>
								<th width="80%">Description</th>
								<th width="10%">Quantity</th>
								<th width="10%">Unit</th>
							</tr>
							'.$tbl.'
						</table>
					</td>
				</tr>
			</table>
		';

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output(str_replace('/', '-', $marking_details[0]['proforma_no']).'.pdf', 'I');
	}
	//new code
	public function ajax_function() {

		if($this->input->is_ajax_request()){
			$call_type = $this->input->post('call_type');
			$response['status'] = 'successful';	
			switch ($call_type) {
				case 'add_mtc_data':
					$insert_data['mtc_type'] = $this->input->post('mtc_type');
					$insert_data['mtc_for'] = $this->input->post('mtc_for');
					$insert_data['mtc_for_id'] = $this->input->post('mtc_for_id');
					$insert_data['mtc_company'] = $this->input->post('mtc_company');
					$insert_data['mtc_company_id'] = $this->input->post('mtc_company_id');
					$insert_data['assigned_to'] = $this->input->post('assigned_to');
					$insert_data['created_by'] = $this->session->userdata('user_id');
					$insert_data['entered_on'] = date('Y-m-d H:i:s');
					$this->quality_model->insertData('mtc_mst', $insert_data);
					break;
				
				case 'get_mtc_status':
					$mtc_mst_id = $this->input->post('mtc_mst_id');
					$mtc_status_details['details'] = $this->quality_model->getData('mtc_mst', array('mtc_mst_id' => $mtc_mst_id));
					$mtc_status_details['mtc_files'] = $this->quality_model->getData('mtc_files', array('status' => 'active', 'mtc_mst_id' => $mtc_mst_id));
					// echo "<pre>";print_r($mtc_status_details);echo"</pre><hr>";exit;
					$response['html_body'] = $this->load->view('quality/update_status_model', $mtc_status_details, true);
					break;

				case 'update_mtc_status':
					$mtc_mst_id = $this->input->post('mtc_mst_id');
					$update_data['made_flag'] = $this->input->post('made_by');
					if(!empty($update_data['made_flag'])) {
						$update_data['made_flag_on'] = date('Y-m-d H:i:s');
					}
					$update_data['checked_by_quality_admin'] = $this->input->post('quality_admin');
					if(!empty($update_data['checked_by_quality_admin'])) {
						$update_data['checked_by_quality_admin_on'] = date('Y-m-d H:i:s');
					}
					$update_data['quality_admin_comment'] = $this->input->post('quality_admin_comment');
					$update_data['checked_by_super_admin'] = $this->input->post('super_admin');
					if(!empty($update_data['checked_by_super_admin'])) {
						$update_data['checked_by_super_admin_on'] = date('Y-m-d H:i:s');
					}
					$update_data['super_admin_comment'] = $this->input->post('super_admin_comment');
					$this->quality_model->updateData('mtc_mst', $update_data, array('mtc_mst_id' => $mtc_mst_id));
					break;	

				case 'delete_mtc_details':
					$mtc_mst_id = $this->input->post('mtc_mst_id');
					$this->quality_model->updateData('mtc_mst', array('status'=> 'inactive'), array('mtc_mst_id' => $mtc_mst_id));
					break;	

				case 'search_status':
					$search_value = $this->input->post('search_value');
					$mtc_type = $this->input->post('mtc_type');
					$mtc_for = $this->input->post('mtc_for');
					$company_name = $this->input->post('company_name');
					$assigned = $this->input->post('assigned');
					$creater = $this->input->post('creater');
					$where_string = "mtc_mst.status='active' ";
					if(!empty($search_value)) {
						$where_string = $where_string . "AND (mtc_mst.made_flag = '".$search_value."' OR mtc_mst.checked_by_quality_admin = '".$search_value."' OR mtc_mst.checked_by_super_admin = '".$search_value."') ";
					}
					if(!empty($mtc_type)) {
						$where_string = $where_string . "AND mtc_mst.mtc_type='".$mtc_type."' ";
					}
					if(!empty($mtc_for)) {
						$where_string = $where_string . "AND mtc_mst.mtc_for LIKE '%".$mtc_for."%' ";
					}
					if(!empty($company_name)) {
						$where_string = $where_string . "AND mtc_mst.mtc_company LIKE '%".$company_name."%' ";
					}
					if(!empty($assigned)) {
						$where_string = $where_string . "AND mtc_mst.assigned_to='".$assigned."' ";
					}
					if(!empty($creater)) {
						$where_string = $where_string . "AND mtc_mst.created_by='".$creater."' ";
					}
					// echo $where_string, "</hr>";die;
					$data = $this->create_mtc_list_data($where_string);	
					// echo count($data),"<hr>";
					// echo $this->db->last_query();die;

					$response['html_body'] = $this->load->view('quality/mtc_list_body', $data, TRUE);
					break;	

				case 'delete_mtc_file':
					$mtc_file_id = $this->input->post('mtc_file_id');
					$this->quality_model->updateData('mtc_files', array('status'=>'inactive'), array('mtc_file_id'=> $mtc_file_id));
					break;	
				default:
					$response = "call type not found";
					break;
			}
			echo json_encode($response);

		} else{
			die('access is not allowed to this function');
		}
	}

	private function create_mtc_list_data($where) {

		$data = array();
		$users = $this->quality_model->getData('users', array('status'=> '1'));
		$data['users'] = array_column($users, 'username', 'user_id');
		$creater = $this->quality_model->getDynamicData('group_concat(distinct(created_by)) As creater', array('status'=>'active'), 'mtc_mst', 'row_array');
		$data['creater'] = explode(',', $creater['creater']);
		$assigned = $this->quality_model->getDynamicData('group_concat(distinct(assigned_to)) As assigned', array('status'=>'active'), 'mtc_mst', 'row_array');
		$data['assigned'] = explode(',', $assigned['assigned']);
		$data['mtc_list'] = $this->quality_model->getMtcData($where);
		foreach ($data['mtc_list'] as $key => $value) {
			$data['mtc_list'][$key]['checked_by_quality_admin'] = $this->change_format($value, 'checked_by_quality_admin');
			$data['mtc_list'][$key]['checked_by_super_admin'] = $this->change_format($value, 'checked_by_super_admin');
			$data['mtc_list'][$key]['made_flag'] = '';
			$data['mtc_list'][$key]['made_flag'] = (!empty($value['made_flag']) && $value['made_flag'] == 'Y') ? 'Yes':'No';
			$data['mtc_list'][$key]['assigned_to'] = $data['users'][$value['assigned_to']];
			$data['mtc_list'][$key]['created_by'] = $data['users'][$value['created_by']];
		}
		// echo $this->db->last_query(),"<hr>";
		return $data;
	}
	private function change_format($value_check, $value_key) {
		$check_value = '';
		if($value_check[$value_key] == 'Y') {
			$check_value = 'Approved';
		} else if ($value_check[$value_key] == 'P') {
			$check_value = 'Pending';	
		} else if ($value_check[$value_key] == 'N') {
			$check_value = 'Disapproved';
		}
		return $check_value;
	}

	//new code end
}