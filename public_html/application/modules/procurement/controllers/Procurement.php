<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement extends MX_Controller {
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
		$this->load->model('procurement_model');
	}

	public function index(){
		$this->add();
	}

	public function procurement_form(){
		$this->load->view('header', array('title' => 'Procurement Form'));
		$this->load->view('sidebar', array('title' => 'Procurement Form'));
		$this->load->view('procurement_form');
		$this->load->view('footer');
	}

	public function procurement_list(){
		$this->load->view('header', array('title' => 'Procurement List'));
		$this->load->view('sidebar', array('title' => 'Procurement List'));
		$this->load->view('procurement_list');
		$this->load->view('footer');
	}

	public function addRFQ($rfq_id=0){
		if(!empty($this->input->post())){
			$insert_arr = array(
				'rfq_sentby' => $this->input->post('rfq_sentby'),
				'rfq_company' => $this->input->post('rfq_company'),
				'rfq_buyer' => $this->input->post('rfq_buyer'),
				'client_source' => $this->input->post('client_source'),
				'rfq_rank' => $this->input->post('rfq_rank'),
				'rfq_lastbuy' => $this->input->post('rfq_lastbuy'),
				'rfq_subject' => $this->input->post('rfq_subject'),
				'rfq_importance' => $this->input->post('rfq_importance'),
				'assigned_to' => $this->input->post('assigned_to'),
				'reference' => $this->input->post('reference'),
				'rfq_status' => $this->input->post('rfq_status'),
				'modified_on' => date('Y-m-d H:i:s')
			);

			if($this->input->post('rfq_closedate') != ''){
				$insert_arr['rfq_closedate'] = date('Y-m-d', strtotime($this->input->post('rfq_closedate')));
			}else{
				$insert_arr['rfq_closedate'] = null;
			}

			if($this->input->post('rfq_mst_id') > 0){
				$rfq_mst_id = $this->input->post('rfq_mst_id');
				$this->procurement_model->updateData('rfq_mst', $insert_arr, array('rfq_mst_id' => $rfq_mst_id));
				$this->procurement_model->deleteData('rfq_dtl', array('rfq_mst_id' => $rfq_mst_id));
			}
			else{
				$insert_arr['rfq_date'] = date('Y-m-d');
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$insert_arr['rfq_no'] = 'OM/'.$this->procurement_model->getRFQNo().'/20-21';
				$rfq_mst_id = $this->procurement_model->insertData('rfq_mst', $insert_arr);
			}

			foreach ($this->input->post('product_id') as $key => $value) {
				$dtl_array  = array(
					'rfq_mst_id' => $rfq_mst_id,
					'product_id' => $this->input->post('product_id')[$key],
					'material_id' => $this->input->post('material_id')[$key],
					'description' => $this->input->post('description')[$key],
					'unit' => $this->input->post('unit')[$key],
					'quantity' => $this->input->post('quantity')[$key],
				);
				$this->procurement_model->insertData('rfq_dtl', $dtl_array);
			}
			//echo $this->db->last_query();
			redirect('procurement/addRFQ');
		}else{
			$data['prd_str'] = $data['mat_str'] = $data['unit_str'] = $data['vendor_str'] = '';
			if($rfq_id > 0){
				$data['rfq_id'] = $rfq_id;
				$data['rfq_details'] = $this->procurement_model->getRfq($rfq_id);
				$data['rfq_details'][0]['rfq_company_name'] = $this->procurement_model->getLeadName($data['rfq_details'][0]['rfq_company'], $data['rfq_details'][0]['client_source']);
				$data['vendors'] = $vendors = $this->procurement_model->getData('vendors');
				foreach($vendors as $ven){ 
					$data['vendor_str'] .= '<option value="'.$ven['vendor_id'].'">'.ucwords(strtolower($ven['vendor_name'])).'</option>';
				}
				$data['rfq_to_vendor'] = $this->procurement_model->getData('rfq_to_vendor', 'rfq_id = '.$rfq_id);
				$data['rfq_notes'] = $this->procurement_model->getData('rfq_note_query', "type = 'notes' and rfq_id = ".$rfq_id);
				$data['rfq_query'] = $this->procurement_model->getData('rfq_note_query', "type = 'query' and rfq_id = ".$rfq_id);
			}
			$data['clients'] = $this->procurement_model->getClients();
			$data['sales_person'] = $this->procurement_model->getData('users', 'role = 5 and status = 1');
			$data['purchase_person'] = $this->procurement_model->getData('users', '(role = 6 or role = 8 or role = 13) and status = 1');
			$data['product'] = $product = $this->procurement_model->getData('lookup', 'lookup_group = 259');
			foreach($product as $prod){ 
				$data['prd_str'] .= '<option value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
			}

			$data['material'] = $material = $this->procurement_model->getData('lookup', 'lookup_group = 272');
			foreach($material as $mat){ 
				$data['mat_str'] .= '<option value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
			}

			$data['units'] = $units = $this->procurement_model->getData('units');
			foreach($units as $un){
				$data['unit_str'] .= '<option value="'.$un['unit_id'].'">'.ucwords(strtolower($un['unit_value'])).'</option>';
			}

			$data['country'] = $product = $this->procurement_model->getData('lookup', 'lookup_group = 2');
			$data['region'] = $product = $this->procurement_model->getData('lookup', 'lookup_group = 1');
			
			$this->load->view('header', array('title' => 'Add RFQ'));
			$this->load->view('sidebar', array('title' => 'Add RFQ'));
			$this->load->view('addrfq_form', $data);
			$this->load->view('footer');
		}
	}

	function getMembers(){
		$members = $this->procurement_model->getMembers($this->input->post());
		echo json_encode($members);
	}

	function rfq_list(){
		$data['sales_person'] = $data['purchase_person'] = '';
		$sales_person = $this->procurement_model->getData('users', 'role = 5 and status = 1');
		foreach($sales_person as $sp){
			$data['sales_person'] .= '<option value="'.$sp['user_id'].'">'.ucwords(strtolower($sp['name'])).'</option>';
		}
		
		$purchase_person = $this->procurement_model->getData('users', '(role = 6 or role = 8 or role = 13) and status = 1');
		foreach($purchase_person as $pp){
			$data['purchase_person'] .= '<option value="'.$pp['user_id'].'">'.ucwords(strtolower($pp['name'])).'</option>';
		}
		$this->load->view('header', array('title' => 'RFQ List'));
		$this->load->view('sidebar', array('title' => 'RFQ List'));
		$this->load->view('rfq_list', $data);
		$this->load->view('footer');
	}

	function rfq_list_data(){
		$search = array();
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($this->session->userdata('role') == 5){
				if($key == 1){
					$search_key = 'rfq_no';
				}else if($key == 2){
					$search_key = 'rfq_company';
				}else if($key == 7){
					$search_key = 'r.assigned_to';
				}else if($key == 8){
					$search_key = 'rfq_status';
				}else if($key == 5){
					$search_key = 'rfq_date';
				}else if($key == 6){
					$search_key = 'rfq_importance';
				}else if($key == 9){
					$search_key = 'quote_status';
				}
			}else{
				if($key == 1){
					$search_key = 'rfq_no';
				}else if($key == 2){
					$search_key = 'rfq_company';
				}else if($key == 8){
					$search_key = 'r.assigned_to';
				}else if($key == 9){
					$search_key = 'rfq_status';
				}else if($key == 7){
					$search_key = 'rfq_sentby';
				}else if($key == 5){
					$search_key = 'rfq_date';
				}else if($key == 6){
					$search_key = 'rfq_importance';
				}else if($key == 10){
					$search_key = 'quote_status';
				}
			}

			if($search_key == 'rfq_date'){
				if($this->input->post('columns')[$key]['search']['value'] != ''){
					$search[$search_key] = date('Y-m-d', strtotime($this->input->post('columns')[$key]['search']['value']));	
				}else{
					$search[$search_key] = '';
				}
			}else{
				$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
			}
		}
		//print_r($this->input->post('length'));
		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		$dir = $this->input->post('order')[0]['dir'];
		if($order_by == 'record_id'){
			$order_by = 'rfq_no';
			$dir = 'desc';
		}else if($order_by == 'company_name'){
			$order_by = 'rfq_company';
		}
		$records = $this->procurement_model->getRFQListData($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->procurement_model->getRFQListCount($search);
		$data['aaData'] = $records;
		//echo "<pre>";print_r($data);
		echo json_encode($data);
	}

	function assignVendor(){
		$insert_arr = array(
			'rfq_id' => $this->input->post('rfq_id'),
			'vendor_id' => $this->input->post('vendor_id'),
			'vendor_status' => $this->input->post('vendor_status'),
			'evaluate_price' => $this->input->post('evaluate_price'),
			'evaluate_delivery' => $this->input->post('evaluate_delivery'),
			'modified_on' => date('Y-m-d H:i:s'),
			'modified_by' => $this->session->userdata('user_id')
		);

		if($this->input->post('connect_id') > 0){
			$this->procurement_model->updateData('rfq_to_vendor', $insert_arr);	
		}else{
			$insert_arr['entered_on'] = date('Y-m-d H:i:s');
			$insert_arr['entered_by'] = $this->session->userdata('user_id');
			$this->procurement_model->insertData('rfq_to_vendor', $insert_arr);	
		}

	}

	function viewPdf($connect_id){
		$data['rfq_details'] = $this->procurement_model->getRFQDetails($connect_id);
		$data['vendor_details'] = $this->procurement_model->getVendorDetails($connect_id);
		
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
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

		

		// define some HTML content with style


		$table_str = '';

		$i=0;
        foreach ($data['rfq_details'] as $key => $value) { 
			$bg_color = '';
			if($i%2 != 0){
				$bg_color = '#e4e1e1;';
			}

			if(strpos($value['quantity'], '.') === false){
				$value['quantity'] = $value['quantity'].".00";
			}

			$table_str .= '<tr style="background-color: '.$bg_color.'; font-size: 11px; font-family: courier;">
				<td style="text-align: right;">'.++$i.'</td>
				<td>'.$value['description'].'</td>
				<td style="text-align: right;"> '.$value['quantity'].'</td>
				<td>'.$value['unit_value'].'.</td>
			</tr>';
        }

        $date = date('d-m-Y', strtotime($data['rfq_details'][0]['rfq_date']));
		$client_name = trim($data['vendor_details']['vendor_name']);

		$html = '<!-- EXAMPLE OF CSS STYLE -->
		<table cellpadding="5" cellspacing="0">
		<tr style="background-color: #fff;">
		<td width="50%" style="padding:5px;vertical-align: text-top; ">
		<img src="/assets/media/client-logos/logo.png" width="180" height="50" style="padding-left: 10px;"><br/>
		<strong style="font-size: 17px;">OM TUBES & FITTINGS INDUSTRIES</strong>
		<div class="left_addrs" style="font-size: 14px;color: #484545; line-height: 20px;">10 Bordi Bunglow, 1st Panjarapole Lane, CP Tank, Mumbai, Maharashtra, India <br/>GSTIN 27AFRPM5323E1ZC
		</div>
		<table style="margin-top: -15px;">
		<tr style="background-color: #fff;">
		<td style="font-size: 14px; color: #484545; line-height: 20px;" width="50%">+91 (22) 6743 7634</td>
		</tr>
		<tr style="background-color: #fff;">
		<td style="font-size: 14px; color: #484545; line-height: 20px;" align="left">www.omtubes.com</td>
		</tr>
		</table>
		</td>
		<td width="50%">
		<strong style="font-size: 25px; text-align: right; line-height: 35px;">Request For Quotation</strong><br/>
		<table style="line-height: 22px;">
		<tr style="background-color: #e4e1e1; border-bottom: 1px solid;">
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;"> RFQ # : </strong></td>
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;">Date : </strong></td>
		</tr>
		<tr>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$data['rfq_details'][0]['rfq_no'].'</td>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$date.'</td>
		</tr>
		<tr style="background-color: #e4e1e1;">
		<td colspan="2" style="padding:5px;vertical-align: text-top;"><strong style="font-size: 12px;"> Seller:</strong></td>
		</tr>
		<tr>
		<td colspan="2" style="padding:5px;vertical-align: text-top; font-family: courier;">
		<strong>'.$client_name.'</strong>
		<div class="left_addrs" style="font-size: 11px;color: #484545; line-height: 17px; font-family: courier;">'.$data['vendor_details']['country'].'<br/>'.$data['vendor_details']['name'].'
		</div>
		</td>
		</tr>
		<tr style="background-color: #e4e1e1;">
		<td colspan="2" style="padding:5px;vertical-align: text-top;"><strong style="font-size: 12px;">Our reference :</strong></td>
		</tr>
		<tr>
		<td colspan="2" style="font-family: courier; font-size: 11px;color: #484545;">Test</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td colspan="2"></td>
		</tr>
		<tr>
		<td colspan="2">
		<table cellspacing="0" cellpadding="10" border="0">
		<thead>
		<tr style="background-color: #e4e1e1;">
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="7%;">#</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="63%">Item Description</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="15%">Quantity</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="15%">Unit</td>
		</tr>
		</thead>
		<tbody>'.$table_str.'</tbody>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		</td>
		<td></td>
		</tr>
		<tr>
		<td><b>Terms & Conditions</b><br/>
		<ol>
			<li>Firm delivery time</li>
			<li>Approximate packed weight and dimensions</li>
			<li>Validity</li>
			<li>Payment terms</li>
		</ol></td>
		<td align="center">
		Thank you for your business<br/>
		For Om Tubes & Fittings Industries<br/><br/>
		<img src="http://arihanttubes.com/crm/assets/media/stamp.png"/><br/><br/>
		<table>
		<tr>
			<td width="26%" rowspan="3"></td>
		 	<td align="left" width="74%">Name : '.$data['rfq_details'][0]['uname'].'<span style="font-family: courier;"></span></td>
		</tr>
		<tr>
			<td align="left">Email : '.$data['rfq_details'][0]['uemail'].'<span style="font-family: courier;"></span></td>
		</tr>
		<tr>
			<td align="left">Mobile : '.$data['rfq_details'][0]['umobile'].'<span style="font-family: courier;"></span></td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output(str_replace('/', '-', $data['rfq_details'][0]['rfq_no']).'.pdf', 'I');
	
	}

	function addNotes(){
		$note = $this->input->post('notes');
		$rfq_id = $this->input->post('rfq_id');

		$this->procurement_model->insertData('rfq_note_query', array('rfq_id' => $rfq_id, 'note' => $note, 'entered_on' => date('Y-m-d H:i:s'), 'entered_by' => $this->session->userdata('user_id'), 'type' => 'notes'));
		$res = $this->procurement_model->getData('rfq_note_query', "type='notes' and rfq_id = ".$rfq_id);
		foreach ($res as $key => $value) {
			$res[$key]['entered_on'] = date('d M h:i a', strtotime($value['entered_on']));
		}
		echo json_encode($res);
	}

	function addQuery(){
		$note = $this->input->post('notes');
		$rfq_id = $this->input->post('rfq_id');

		$this->procurement_model->insertData('rfq_note_query', array('rfq_id' => $rfq_id, 'note' => $note, 'entered_on' => date('Y-m-d H:i:s'), 'entered_by' => $this->session->userdata('user_id'), 'type' => 'query'));
		$res = $this->procurement_model->getData('rfq_note_query', "type='query' and rfq_id = ".$rfq_id);
		foreach ($res as $key => $value) {
			$res[$key]['entered_on'] = date('d M h:i a', strtotime($value['entered_on']));
		}
		echo json_encode($res);	
	}

	function searchLead(){
		$search = $this->input->post('search');
		$leads = $this->procurement_model->getClients($search);
		echo json_encode($leads); 
	}

	function deleteRfq(){
		$rfq_id = $this->input->post('rfq_id');
		$this->procurement_model->deleteData('rfq_note_query', array('rfq_id' => $rfq_id));
		$this->procurement_model->deleteData('rfq_to_vendor', array('rfq_id' => $rfq_id));
		$this->procurement_model->deleteData('rfq_dtl', array('rfq_mst_id' => $rfq_id));
		$this->procurement_model->deleteData('rfq_mst', array('rfq_mst_id' => $rfq_id));
	}
}
	