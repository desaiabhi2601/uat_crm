<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotations extends MX_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id') && $this->router->fetch_method() != 'daily_followup'){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('quotations', $this->session->userdata('module')) && $this->router->fetch_method() != 'daily_followup' && $this->router->fetch_method() != 'pdf'){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('quotation_model');
		$this->load->model('client/client_model');
	}

	public function index(){
		$this->add();
	}

	public function add($quote_id=0, $rfq_id=0){
		if(!empty($this->input->post())){
			$insert_arr = array(
				'made_by' => $this->input->post('made_by'),
				'assigned_to' => $this->input->post('assigned_to'),
				'stage' => $this->input->post('stage'),
				'is_new' => 'Y',
				'client_id' => $this->input->post('client_id'),
				'member_id' => $this->input->post('member_id'),
				'reference' => $this->input->post('reference'),
				'delivered_through' => $this->input->post('delivered_through'),
				'delivery_time' => $this->input->post('delivery_time'),
				'payment_term' => $this->input->post('payment_term'),
				'validity' => $this->input->post('validity'),
				'currency' => $this->input->post('currency'),
				'currency_rate' => $this->input->post('currency_rate'),
				'origin_country' => $this->input->post('origin_country'),
				'mtc_type' => $this->input->post('mtc_type'),
				'transport_mode' => $this->input->post('transport_mode'),
				'importance' => $this->input->post('importance'),
				'followup_date' => date('Y-m-d', strtotime('+1 day', time())),
				'modified_on' => date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id'),
				'rfq_id' => $this->input->post('rfq_id'),
				'additional_comment' => $this->input->post('additional_comment'),
			);

			if($this->input->post('quote_date')){
				$insert_arr['entered_on'] = date('Y-m-d H:i:s', strtotime($this->input->post('quote_date')));
			}

			$currency_arr = $this->quotation_model->getData('currency');

			if($this->input->post('stage') == 'draft' || $this->input->post('stage') == 'publish'){
				$insert_arr['status'] = 'Open';
			}else if($this->input->post('stage') == 'proforma'){
				$insert_arr['status'] = 'Won';
				$insert_arr['order_no'] = $this->input->post('order_no');
				if(!isset($_POST['proforma_no']) || $this->input->post('proforma_no') == ''){
					$logic = $this->quotation_model->getData('number_logic', 'logic_id = 2');
					$proforma_value = $logic[0]['logic_value'] +1;
					$proforma_no = 'OM/'.$proforma_value.'/20-21';
					$insert_arr['proforma_no'] = $proforma_no;
					$insert_arr['confirmed_on'] = date('Y-m-d H:i:s');
					$this->quotation_model->updateData('number_logic', array('logic_value' => $proforma_value), array('logic_id' => 2));
				}
			}

			if($this->input->post('quote_id') != ''){
				$quotation_id = $this->input->post('quote_id');
				if($this->input->post('stage') == 'publish' && $this->input->post('quote_no') == ''){
					$logic = $this->quotation_model->getData('number_logic', 'logic_id = 1');
					$quotation_value = $logic[0]['logic_value'] +1;
					$quote_no = 'OM/'.$quotation_value.'/20-21';
					$insert_arr['quote_no'] = $quote_no;
					$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				}
				$this->quotation_model->updateData('quotation_mst', $insert_arr, array('quotation_mst_id' => $quotation_id));
				$this->quotation_model->deleteData('quotation_dtl', array('quotation_mst_id' => $quotation_id));
			}else{
				if($this->input->post('stage') == 'draft'){
					$quote_no = '';
				}else if($this->input->post('stage') == 'publish'){
					$logic = $this->quotation_model->getData('number_logic', 'logic_id = 1');
					$quotation_value = $logic[0]['logic_value'] +1;
					$quote_no = 'OM/'.$quotation_value.'/20-21';
				}
				$insert_arr['quote_no'] = $quote_no;
				$insert_arr['entered_on'] = date('Y-m-d H:i:s');
				$quotation_id = $this->quotation_model->insertData('quotation_mst', $insert_arr);
			}
			if(isset($quotation_value)){
				$this->quotation_model->updateData('number_logic', array('logic_value' => $quotation_value), array('logic_id' => 1));
			}

			$net_total = 0;
			foreach ($this->input->post('description') as $key => $value) {
				if($this->input->post('currency_rate') != ''){
					$base_price = round($this->input->post('unit_rate')[$key] / $this->input->post('currency_rate'), 2);
				} else if($this->input->post('currency') == 1){
					$base_price = round($this->input->post('unit_rate')[$key] / $currency_arr[0]['currency_rate'], 2);
				} else if($this->input->post('currency') == 2){
					$base_price = round($this->input->post('unit_rate')[$key] / $currency_arr[1]['currency_rate'], 2);
				} else if($this->input->post('currency') == 3){
					$base_price = round($this->input->post('unit_rate')[$key] / $currency_arr[2]['currency_rate'], 2);
				}else if($this->input->post('currency') == 4){
					$base_price = round($this->input->post('unit_rate')[$key] / $currency_arr[3]['currency_rate'], 2);
				}

				if($this->input->post('unit_price')[$key] != ''){
					$unit_price = $this->input->post('unit_price')[$key];
					$detail_arr = array(
						'quotation_mst_id' => $quotation_id,
						'product_id' => $this->input->post('product_id')[$key],
						'material_id' => $this->input->post('material_id')[$key],
						'description' => $this->input->post('description')[$key],
						'quantity' => $this->input->post('quantity')[$key],
						'unit' => $this->input->post('unit')[$key],
						'unit_price' => $unit_price
					);
				}else{
					$unit_price = ($base_price + ($base_price * $this->input->post('margin')[$key] / 100) + ($base_price * $this->input->post('packing_charge')[$key] / 100));
					$detail_arr = array(
						'quotation_mst_id' => $quotation_id,
						'product_id' => $this->input->post('product_id')[$key],
						'material_id' => $this->input->post('material_id')[$key],
						'description' => $this->input->post('description')[$key],
						'quantity' => $this->input->post('quantity')[$key],
						'unit' => $this->input->post('unit')[$key],
						'unit_rate' => $this->input->post('unit_rate')[$key],
						'margin' => $this->input->post('margin')[$key],
						'packing_charge' => $this->input->post('packing_charge')[$key],
						'unit_price' => $unit_price,
					);
				}
				$row_price = $this->input->post('quantity')[$key] * $unit_price;
				$net_total += $row_price;
				$detail_arr['row_price'] = $row_price;

				$this->quotation_model->insertData('quotation_dtl', $detail_arr);
			}

			$discount_type = $this->input->post('discount_type');
			$other_charges = $discount = 0;

			if($this->input->post('discount') != ''){
				$discount = $this->input->post('discount');
				if($discount_type == 'percent'){
					$discount = round(($net_total * $discount) / 100, 2);
				}
			}

			$gst = 0;
			if($this->input->post('currency') == 3){
				$gst = round(($net_total * 18) / 100, 2);
			}

			if($this->input->post('other_charges') != ''){
				$other_charges = $this->input->post('other_charges');
			}

			$update_arr = array(
				'net_total' => $net_total,
				'freight' => $this->input->post('freight'),
				'bank_charges' => $this->input->post('bank_charges'),
				'gst' => $gst,
				'discount_type' => $discount_type,
				'discount' => $discount,
				'other_charges' => $other_charges,
				'grand_total' => $net_total + $this->input->post('freight') + $this->input->post('bank_charges') + $gst + $other_charges - $discount,
			);

			$this->quotation_model->updateData('quotation_mst', $update_arr, array('quotation_mst_id' => $quotation_id));


			if(!empty($_FILES['purchase_order'])){
				$config['upload_path']          = './assets/purchase_orders/';
	            $config['allowed_types']        = 'pdf';//'jpeg|gif|jpg|png';
	            $config['max_size']             = 5242880;
	            $config['file_name']            = 'PO-'.$quotation_id;
	            $config['overwrite']            = TRUE;
	            $this->load->library('upload', $config);
	            if ( ! $this->upload->do_upload('purchase_order'))
	            {
					$error = array('error' => $this->upload->display_errors());
					$data = array('status' => 'failed', 'msg' => $error['error']);
	            }
	            else
	            {
	            	$file_dtls = $this->upload->data();
		            $data = array('status' => 'success', 'msg' => 'Image uploaded successfully!', 'file_name' => $file_dtls['file_name']);
		            $this->quotation_model->updateData('quotation_mst', array('purchase_order' => $file_dtls['file_name']), array('quotation_mst_id' => $quotation_id));
	            }
			}

			if($this->input->post('stage') == 'publish'){
				$sms_details = $this->quotation_model->getSMSDetails('quotation', $quotation_id);
				if($sms_details['purchase_user'] != ''){
					$sms_txt = 'Dear '.$sms_details['sales_user'].'%0aYour quotation '.$sms_details['quote_no'].' is ready against your rfq '.$sms_details['rfq_subject'].'%0aMade by%0a'.$sms_details['purchase_user'].'%0aSubmit it to the client a.s.a.p.';
				}else{
					$sms_txt = 'Dear '.$sms_details['sales_user'].'%0aYour quotation '.$sms_details['quote_no'].' is ready.%0aSubmit it to the client a.s.a.p.';	
				}
				$this->quotation_model->insertData('notifications', array('for_id' => $sms_details['user_id'], 'notify_str' => $sms_txt, 'notify_date' => date('Y-m-d H:i:s'), 'notify_viewed' => 0));
				$this->sendSms($sms_details['mobile'], urlencode($sms_txt));
			}else if($this->input->post('stage') == 'proforma'){
				$sms_details = $this->quotation_model->getSMSDetails('proforma', $quotation_id);
				if($sms_details['purchase_user'] != ''){
					$sms_txt = 'Dear '.$sms_details['sales_user'].'%0aYour Proforma '.$sms_details['proforma_no'].' is ready against PO '.$sms_details['rfq_no'].'Made by%0a'.$sms_details['purchase_user'].'%0aSubmit it to the client a.s.a.p.';
				}else{
					$sms_txt = 'Dear '.$sms_details['sales_user'].'%0aYour Proforma '.$sms_details['proforma_no'].' is ready.%0aSubmit it to the client a.s.a.p.';	
				}
				$this->quotation_model->insertData('notifications', array('for_id' => $sms_details['user_id'], 'notify_str' => $sms_txt, 'notify_date' => date('Y-m-d H:i:s'), 'notify_viewed' => 0));
				//$this->sendSms(9821850733, urlencode($sms_txt));
				$this->sendSms($sms_details['mobile'], urlencode($sms_txt));
			}
			
			$this->session->set_flashdata('success', 'Quotation saved successfully');
			redirect('quotations/list');
		}else{
			if($quote_id != 0){
				$data['quote_details'] = $this->quotation_model->getQuotationDetails($quote_id);
				$data['quote_id'] = $quote_id;
			}
			if($rfq_id != 0){
				$data['rfq_details'] = $this->quotation_model->getData('rfq_mst', 'rfq_mst_id = '.$rfq_id);
				$data['rfq_notes'] = $this->quotation_model->getData('rfq_note_query', "type='notes' and rfq_id = ".$rfq_id);
			}
			$data['users'] = $this->quotation_model->getUsers();
			$data['assignee'] = $this->quotation_model->getAssignee();
			$data['clients'] = $this->client_model->getClients();
			$data['region'] = $this->quotation_model->getLookup(1);
			$data['country'] = $this->quotation_model->getLookup(2);
			$data['transport_mode'] = $this->quotation_model->getData('transport_mode');
			$data['delivery'] = $this->quotation_model->getData('delivery');
			$data['delivery_time'] = $this->quotation_model->getData('delivery_time');
			$data['payment_terms'] = $this->quotation_model->getData('payment_terms');
			$data['origin_country'] = $this->quotation_model->getData('origin_country');
			$data['currency'] = $this->quotation_model->getData('currency');
			$data['validity'] = $this->quotation_model->getData('validity');
			$data['mtc_type'] = $this->quotation_model->getData('mtc_type');
			$data['ports'] = $this->quotation_model->getData('ports');
			$data['zones'] = $this->quotation_model->getData('zone_to_country');
			$data['unit_str'] = $data['prd_str'] = $data['mat_str'] = ""; 
			$data['product'] = $product = $this->quotation_model->getLookup(259);
			foreach($product as $prod){ 
				$data['prd_str'] .= '<option value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
			}

			$data['material'] = $material = $this->quotation_model->getLookup(272);
			foreach($material as $mat){ 
				$data['mat_str'] .= '<option value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
			}

			$data['units'] = $units = $this->quotation_model->getData('units');
			foreach($units as $uts){ 
				$data['unit_str'] .= '<option value="'.$uts['unit_id'].'">'.ucwords(strtolower($uts['unit_value'])).'</option>';
			}

			$this->load->view('header', array('title' => 'Add Quotation'));
			$this->load->view('sidebar', array('title' => 'Add Quotation'));
			$this->load->view('quotation_form', $data);
			$this->load->view('footer');
		}
	}

	function pdf($quote_id){
		$data['quote_details'] = $this->quotation_model->getQuotationDetails($quote_id);
		if($this->session->userdata('role') == 5){
			$this->quotation_model->updateData('quotation_mst', array('is_new' => NULL), array('quotation_mst_id' => $quote_id));
		}
		if(($data['quote_details'][0]['delivery_name'] == 'CFR Port Name' || $data['quote_details'][0]['delivery_name'] == 'CIF Port Name') && $data['quote_details'][0]['mode'] == 'Sea Worthy'){
			$port_name = $this->quotation_model->getPortName('CIF', 'sea', $data['quote_details'][0]['country']);
			if($data['quote_details'][0]['delivery_name'] == 'CFR Port Name'){
				$data['quote_details'][0]['delivery_name'] = 'CFR '.$port_name;
			} else if($data['quote_details'][0]['delivery_name'] == 'CIF Port Name'){
				$data['quote_details'][0]['delivery_name'] = 'CIF '.$port_name;
			}
		}
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

		

		// define some HTML content with style


		$table_str = '';

		$i=0;
        foreach ($data['quote_details'] as $key => $value) { 
        	$bg_color = '';
			if($i%2 != 0){
				$bg_color = '#e4e1e1;';
			}

			if(strpos($value['quantity'], '.') === false){
				$value['quantity'] = $value['quantity'].".00";
			}

			if(strpos($value['unit_price'], '.') === false){
				$value['unit_price'] = $value['unit_price'].".00";
			}

			if(strpos($value['row_price'], '.') === false){
				$value['row_price'] = $value['row_price'].".00";
			}

			$table_str .= '<tr style="background-color: '.$bg_color.'; font-size: 11px; font-family: courier;">
				<td style="text-align: right;">'.++$i.'</td>
				<td>'.htmlentities($value['description']).'</td>
				<td style="text-align: right;"> '.$value['quantity'].'</td>
				<td>'.ucwords(strtolower($value['unit_value'])).'.</td>
				<td style="text-align: right;">'.$data['quote_details'][0]['currency_icon'].$value['unit_price'].'</td>
				<td>P.'.ucwords(strtolower($value['unit_value'])).'.</td>
				<td style="text-align: right;">'.$data['quote_details'][0]['currency_icon'].$value['row_price'].'</td>
			</tr>';
        }

        $net_total = $data['quote_details'][0]['net_total'];
        if(strpos($net_total, '.') === false){
        	$net_total = $net_total.'.00';
        }

        $total_table = '<table cellspacing="0" cellpadding="10">
		<tr >
		<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;" width="50%" >Net Total</td>
		<td style="font-size: 12px; font-family: courier; border: solid 1px grey;" width="50%">'.$data['quote_details'][0]['currency_icon'].$net_total.'</td>
		</tr>';

		if($data['quote_details'][0]['freight'] > 0){
			$freight = $data['quote_details'][0]['freight'];
	        if(strpos($freight, '.') === false){
	        	$freight = $freight.'.00';
	        }
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Freight Charges</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$freight.'</td>
			</tr>';	
		}
		
		if($data['quote_details'][0]['bank_charges'] > 0){
			$bank_charges = $data['quote_details'][0]['bank_charges'];
	        if(strpos($bank_charges, '.') === false){
	        	$bank_charges = $bank_charges.'.00';
	        }
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Bank Charges</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$bank_charges.'</td>
			</tr>';
		}

		if($data['quote_details'][0]['gst'] > 0 && $data['quote_details'][0]['currency'] == 'INR'){
			$gst = $data['quote_details'][0]['gst'];
	        if(strpos($gst, '.') === false){
	        	$gst = $gst.'.00';
	        }
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">GST</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$gst.'</td>
			</tr>';
		}

		if($data['quote_details'][0]['other_charges'] > 0){
			$other_charges = $data['quote_details'][0]['other_charges'];
	        if(strpos($other_charges, '.') === false){
	        	$other_charges = $other_charges.'.00';
	        }
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Other Charges</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$other_charges.'</td>
			</tr>';
		}

		if($data['quote_details'][0]['discount'] > 0){
			$discount = $data['quote_details'][0]['discount'];
	        if(strpos($discount, '.') === false){
	        	$discount = $discount.'.00';
	        }
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Discount</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$discount.'</td>
			</tr>';
		}

		$grand_total = $data['quote_details'][0]['grand_total'];
        if(strpos($grand_total, '.') === false){
        	$grand_total = $grand_total.'.00';
        }
		$total_table .= '<tr>
			<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Grand Total</td>
			<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['quote_details'][0]['currency_icon'].$grand_total.'</td>
		</tr>
		</table>';

		$dec_text = 'paise';
		if($data['quote_details'][0]['currency'] != 'INR'){
			$dec_text = 'cents';
		}
		$grand_total_words = $data['quote_details'][0]['currency']." : ".$this->numberTowords($grand_total, $dec_text);
		$date = date('d-m-Y', strtotime($data['quote_details'][0]['entered_on']));
		$client_name = trim($data['quote_details'][0]['client_name']);

		$additional_comment = '';

		if($data['quote_details'][0]['additional_comment'] != ''){
			$additional_comment = '<br/><br/>'.$data['quote_details'][0]['additional_comment'];
		}

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
		<strong style="font-size: 25px; text-align: right; line-height: 35px;">Quotation</strong><br/>
		<table style="line-height: 22px;">
		<tr style="background-color: #e4e1e1; border-bottom: 1px solid;">
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;"> Quote # : </strong></td>
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;">Date : </strong></td>
		</tr>
		<tr>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$data['quote_details'][0]['quote_no'].'</td>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$date.'</td>
		</tr>
		<tr style="background-color: #e4e1e1;">
		<td colspan="2" style="padding:5px;vertical-align: text-top;"><strong style="font-size: 12px;"> Customer:</strong></td>
		</tr>
		<tr>
		<td colspan="2" style="padding:5px;vertical-align: text-top; font-family: courier;">
		<strong>'.$client_name.'</strong>
		<div class="left_addrs" style="font-size: 11px;color: #484545; line-height: 17px; font-family: courier;">'.$data['quote_details'][0]['country'].'<br/>'.$data['quote_details'][0]['name'].'
		</div>
		</td>
		</tr>
		<tr style="background-color: #e4e1e1;">
		<td colspan="2" style="padding:5px;vertical-align: text-top;"><strong style="font-size: 12px;">Reference :</strong></td>
		</tr>
		<tr>
		<td colspan="2" style="font-family: courier; font-size: 11px;color: #484545;">'.$data['quote_details'][0]['reference'].'</td>
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
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="36%">Item Description</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="12%">Qty</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="8%">Unit</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="13%">Price</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="9%">Unit</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="15%">Total</td>
		</tr>
		</thead>
		<tbody>'.$table_str.'</tbody>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<strong>Total in words:</strong><br/><span style="font-family: courier; font-size: 11px;">'.$grand_total_words.'</span><br/>
		<hr/>
		<table cellspacing="0" cellpadding="3" border="0">
		<tr>
		<td><strong>Additional Notes</strong></td>
		</tr>
		<tr>
		<td style="font-family: courier; font-size: 11px;">
		We reserve the right to correct the pricing offered due to any typographical errors.<br/>
		This offer is not valid for end users from Iran, Iraq, North Korea, Cuba, Sudan & Syria.'.$additional_comment.'
		</td>
		</tr>
		</table>
		</td>
		<td>'.$total_table.'</td>
		</tr>
		<tr>
		<td colspan="2"></td>
		</tr>
		<tr>
		<td colspan="2"></td>
		</tr>
		<tr>
		<td>
		<table>
		<tr>
		<td colspan="2"><strong>Terms and Conditions</strong></td>
		</tr>
		<tr>
		<td width="35%">Delivered To : </td> <td width="65%"><span style="font-family: courier;">'.$data['quote_details'][0]['delivery_name'].'</span></td>
		</tr>
		<tr>
		<td>Delivery Time : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['dt_value'].'</span></td>
		</tr>
		<tr>
		<td>Validity : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['validity_value'].'</span></td>
		</tr>
		<tr>
		<td>Currency : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['currency'].'</span></td>
		</tr>
		<tr>
		<td>Country of Origin : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['origin'].'</span></td>
		</tr>
		<tr>
		<td>MTC Type : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['mtc_value'].'</span></td>
		</tr>
		<tr>
		<td>Packing Type : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['mode'].'</span></td>
		</tr>
		<tr>
		<td>Payment : </td> <td><span style="font-family: courier;">'.$data['quote_details'][0]['term_value'].'</span></td>
		</tr>
		</table>
		</td>
		<td align="center">
		Thank you for your business<br/>
		For Om Tubes & Fittings Industries<br/><br/>
		<img src="/assets/media/stamp.png" /><br/><br/>
		<table>
		<tr>
		<td width="26%" rowspan="3"></td>
		<td align="left" width="74%">Name : <span style="font-family: courier;">'.$data['quote_details'][0]['uname'].'</span></td>
		</tr>
		<tr>
		<td align="left">Email : <span style="font-family: courier;">'.$data['quote_details'][0]['uemail'].'</span></td>
		</tr>
		<tr>
		<td align="left">Mobile : <span style="font-family: courier;">'.$data['quote_details'][0]['umobile'].'</span></td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';

		/*$html = <<<HTMLEND
		blah blah blah
		HTMLEND;*/

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output(str_replace('/', '-', $data['quote_details'][0]['quote_no']).'.pdf', 'I');
	}

	function numberTowords($num, $dec_text)
	{

		$ones = array(
		0 =>"ZERO",
		1 => "ONE",
		2 => "TWO",
		3 => "THREE",
		4 => "FOUR",
		5 => "FIVE",
		6 => "SIX",
		7 => "SEVEN",
		8 => "EIGHT",
		9 => "NINE",
		10 => "TEN",
		11 => "ELEVEN",
		12 => "TWELVE",
		13 => "THIRTEEN",
		14 => "FOURTEEN",
		15 => "FIFTEEN",
		16 => "SIXTEEN",
		17 => "SEVENTEEN",
		18 => "EIGHTEEN",
		19 => "NINETEEN",
		"014" => "FOURTEEN"
		);
		$tens = array( 
		0 => "ZERO",
		1 => "TEN",
		2 => "TWENTY",
		3 => "THIRTY", 
		4 => "FORTY", 
		5 => "FIFTY", 
		6 => "SIXTY", 
		7 => "SEVENTY", 
		8 => "EIGHTY", 
		9 => "NINETY" 
		); 
		$hundreds = array( 
		"HUNDRED", 
		"THOUSAND", 
		"MILLION", 
		"BILLION", 
		"TRILLION", 
		"QUARDRILLION" 
		); /*limit t quadrillion */
		$num = number_format($num,2,".",","); 
		$num_arr = explode(".",$num); 
		$wholenum = $num_arr[0]; 
		$decnum = $num_arr[1]; 
		$whole_arr = array_reverse(explode(",",$wholenum)); 
		krsort($whole_arr,1); 
		$rettxt = ""; 
		foreach($whole_arr as $key => $i){
			
		while(substr($i,0,1)=="0")
				$i=substr($i,1,5);
		if($i < 20){ 
		/* echo "getting:".$i; */
		$rettxt .= $ones[$i]; 
		}elseif($i < 100){ 
		if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
		if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
		}else{ 
		if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
		if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
		if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
		} 
		if($key > 0){ 
		$rettxt .= " ".$hundreds[$key]." "; 
		}
		} 
		if($decnum > 0){
			$rettxt .= " and ";
			if($decnum < 20){
				$rettxt .= $ones[$decnum];
			}elseif($decnum < 100){
				$rettxt .= $tens[substr($decnum,0,1)];
				$rettxt .= " ".$ones[substr($decnum,1,1)];
			}

			$rettxt .= " ".$dec_text;
		}
		return $rettxt;
	}

	function list($type = ''){
		/*$data['records'] = $this->list_data();*/
		$finYears = $this->quotation_model->getFinancialYears();
		$this->load->view('header', array('title' => 'Quotations List'));
		$this->load->view('sidebar', array('title' => 'Quotations List'));
		$users = $this->quotation_model->getData('users', 'role = 5 and status = 1');
		$user_str = '';
		foreach ($users as $key => $value) {
			$user_str .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		};

		$countries = $this->quotation_model->getData('lookup', 'lookup_group = 2');
		$country_str = '';
		foreach ($countries as $key => $value) {
			$country_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};

		$region = $this->quotation_model->getData('lookup', 'lookup_group = 1');
		$region_str = '';
		foreach ($region as $key => $value) {
			$region_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};
		$this->load->view('quotation_list_view', array('type' => $type, 'finYears' => $finYears, 'user_str'=>$user_str, 'country_str'=>$country_str, 'region_str'=>$region_str));
		$this->load->view('footer');
	}

	function list_data($type=''){
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			
			if($this->session->userdata('role') == 1){
					if($key == 1){
						$search_key = 'quote_no';
					}else if($key == 2){
						$search_key = 'assigned_to';
					}else if($key == 3){
						$search_key = 'entered_on';
					}else if($key == 4){
						$search_key = 'client_name';
					}else if($key == 5){
						$search_key = 'grand_total';
					}else if($key == 6){
						$search_key = 'country';
					}else if($key == 7){
						$search_key = 'region';
					}else if($key == 8){
						$search_key = 'followup_date';
					}else if($key == 9){
						$search_key = 'importance';
					}else if($key == 10){
						$search_key = 'status';
					}
				}else{
					if($key == 1){
						$search_key = 'quote_no';
					}else if($key == 2){
						$search_key = 'entered_on';
					}else if($key == 3){
						$search_key = 'client_name';
					}else if($key == 4){
						$search_key = 'grand_total';
					}else if($key == 5){
						$search_key = 'country';
					}else if($key == 6){
						$search_key = 'region';
					}else if($key == 7){
						$search_key = 'followup_date';
					}else if($key == 8){
						$search_key = 'importance';
					}else if($key == 9){
						$search_key = 'status';
					}
				}

			// echo $search_key;		

			if($search_key == 'date' || $search_key == 'fdate'){
				if($this->input->post('columns')[$key]['search']['value'] != ''){
					$search[$search_key] = date('Y-m-d', strtotime($this->input->post('columns')[$key]['search']['value']));	
				}else{
					$search[$search_key] = '';
				}
			}else{
				$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
			}
		}

		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		$dir = $this->input->post('order')[0]['dir'];
		if($type == ''){
			if($order_by == 'record_id'){
				$order_by = 'quote_no';
				$dir = 'desc';
			}
		}else if($type == 'draft'){
			if($order_by == 'record_id'){
				$order_by = 'entered_on';
				$dir = 'desc';
			}
		}

		$searchByYear = $this->input->post('searchByFinYear');

		$records = $this->quotation_model->getQuotationList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir, $type, $searchByYear);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->quotation_model->getQuotationListCount($search, $type, $searchByYear);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function followup(){
		$this->load->view('header', array('title' => 'Follow Up List'));
		$this->load->view('sidebar', array('title' => 'Follow Up List'));
		//$this->load->view('followup_list_view');
		$users = $this->quotation_model->getData('users', 'role = 5 and status = 1');
		$user_str = '';
		foreach ($users as $key => $value) {
			$user_str .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		};

		$countries = $this->quotation_model->getData('lookup', 'lookup_group = 2');
		$country_str = '';
		foreach ($countries as $key => $value) {
			$country_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};

		$region = $this->quotation_model->getData('lookup', 'lookup_group = 1');
		$region_str = '';
		foreach ($region as $key => $value) {
			$region_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};
		$this->load->view('followup_list_new', array('user_str'=>$user_str, 'country_str'=>$country_str, 'region_str'=>$region_str));
		$this->load->view('footer');
	}

	function followup_data(){
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			
			if($this->session->userdata('role') == 1){
					if($key == 1){
						$search_key = 'quote_no';
					}else if($key == 2){
						$search_key = 'assigned_to';
					}else if($key == 3){
						$search_key = 'entered_on';
					}else if($key == 4){
						$search_key = 'client_name';
					}else if($key == 5){
						$search_key = 'grand_total';
					}else if($key == 6){
						$search_key = 'country';
					}else if($key == 7){
						$search_key = 'region';
					}else if($key == 8){
						$search_key = 'followup_date';
					}else if($key == 9){
						$search_key = 'importance';
					}else if($key == 10){
						$search_key = 'status';
					}
				}else{
					if($key == 1){
						$search_key = 'quote_no';
					}else if($key == 2){
						$search_key = 'entered_on';
					}else if($key == 3){
						$search_key = 'client_name';
					}else if($key == 4){
						$search_key = 'grand_total';
					}else if($key == 5){
						$search_key = 'country';
					}else if($key == 6){
						$search_key = 'region';
					}else if($key == 7){
						$search_key = 'followup_date';
					}else if($key == 8){
						$search_key = 'importance';
					}else if($key == 9){
						$search_key = 'status';
					}
				}

			// echo $search_key;		

			if($search_key == 'date' || $search_key == 'fdate'){
				if($this->input->post('columns')[$key]['search']['value'] != ''){
					$search[$search_key] = date('Y-m-d', strtotime($this->input->post('columns')[$key]['search']['value']));	
				}else{
					$search[$search_key] = '';
				}
			}else{
				$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
			}
		}

		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		if($order_by == 'record_id'){
			$order_by = 'client_name';
		}
		$dir = $this->input->post('order')[0]['dir'];
		$records = $this->quotation_model->getFollowUpList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->quotation_model->getFollowUpListCount($search);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function getFollowUpHistory(){
		$res = $this->quotation_model->getFollowUpHistory($this->input->post('quote_id'));
		echo json_encode($res);
	}

	function getQueryHistory(){
		$res = $this->quotation_model->getQueryHistory($this->input->post('quote_id'), $this->input->post('query_type'));
		echo json_encode($res);
	}

	function addQuery(){
		// echo $this->input->post('query_text').'<br>'; echo $this->input->post('quote_id'); exit();
		
		$res = $this->quotation_model->getData('query_mst', "query_for_id = ".$this->input->post('quote_id')." and query_type = '".$this->input->post('query_type')."'");
		$is_new = false;		
		if(empty($res)){
			$query_recepient = $this->quotation_model->getQueryRecepient($this->input->post('quote_id'), $this->input->post('query_type'));
			$insert_arr = array(
				'query_for_id' => $this->input->post('quote_id'),
				'query_type' => $this->input->post('query_type'),
				'raised_by' => $this->session->userdata('user_id'),
				'raised_on' => date('Y-m-d H:i:s'),
				'query_status' => 'open',
				'query_recepient' => $query_recepient
			);
			$query_id = $this->quotation_model->insertData('query_mst', $insert_arr);
			$is_new = true;
		}else{
			$query_id = $this->input->post('query_id');
			$this->quotation_model->updateData('query_mst', array('query_status' => $this->input->post('query_status')), array('query_id' => $this->input->post('query_id')));
		}

		$text_arr = array(
			'query_id' => $query_id,
			'query_text' => $this->input->post('query_text'),
			'entered_by' => $this->session->userdata('user_id'),
			'entered_on' => date('Y-m-d H:i:s')
		);
		$this->quotation_model->insertData('query_texts', $text_arr);

		$query_data = $this->quotation_model->getData('query_mst', 'query_id = '.$query_id);
		if($query_data[0]['raised_by'] == $this->session->userdata('user_id')){
			$sender = $this->quotation_model->getData('users', 'user_id = '.$query_data[0]['raised_by']);
			$rece = $this->quotation_model->getData('users', 'user_id = '.$query_data[0]['query_recepient']);
			$sms_type = 'raised';
		}else{
			$sender = $this->quotation_model->getData('users', 'user_id = '.$query_data[0]['query_recepient']);
			$rece = $this->quotation_model->getData('users', 'user_id = '.$query_data[0]['raised_by']);
			$sms_type = 'answered';
		}

		$query_details = $this->quotation_model->getQueryQuote($query_id);

		if($sms_type == 'raised'){
			$sms_text = 'Dear '.$rece[0]['name'].'%0a'.$sender[0]['name'].' has raised a query against '.$query_details['quote_str'].' '.$query_details['quote'].'%0aQuery: ('.substr($this->input->post('query_text'), 0, 20).')';
		}else if($sms_type == 'answered'){
			$sms_text = 'Dear '.$rece[0]['name'].'%0a'.$sender[0]['name'].' has answered to your query against '.$query_details['quote_str'].' '.$query_details['quote'].'%0aQuery: ('.substr($this->input->post('query_text'), 0, 20).')';
		}
		$this->quotation_model->insertData('notifications', array('for_id' => $query_data[0]['query_recepient'], 'notify_str' => $sms_text, 'notify_date' => date('Y-m-d H:i:s'), 'notify_viewed' => 0));
		echo $this->sendSms($rece[0]['mobile'], $sms_text);
	}

	function addFollowUp(){
		$insert_arr = array(
			'followedup_on' => date('Y-m-d', strtotime($this->input->post('followedup_on'))),
			'follow_up_text' => $this->input->post('follow_up_text'),
			'quotation_mst_id' => $this->input->post('quote_id'),
			'entered_on' => date('Y-m-d H:i:s'),
			'entered_by' => $this->session->userdata('user_id')
		);
		$this->quotation_model->insertData('follow_up', $insert_arr);

		$this->quotation_model->updateData('quotation_mst', array('followup_date' => date('Y-m-d', strtotime($this->input->post('followup_date')))), array('quotation_mst_id' => $this->input->post('quote_id')));
		if($this->input->post('redirect') == 'quote_page'){
			redirect('quotations/viewQuotation/'.$this->input->post('quote_id'));
		}else{
			redirect('quotations/followup');
		}
	}

	function viewQuotation($quote_id){
		$data['quote_details'] = $this->quotation_model->getQuotationDetails($quote_id);
		$data['follow_up'] = $this->quotation_model->getFollowUpHistory($quote_id);
		$data['siblings'] = $this->quotation_model->getSiblingQuotation($quote_id);
		$data['client_details'] = $this->quotation_model->getClientDetails($quote_id);
		$data['reason'] = $this->quotation_model->getData('close_reason');
		$data['quote_id'] = $quote_id;
		$this->load->view('header', array('title' => 'Quotations Details'));
		$this->load->view('sidebar', array('title' => 'Quotations Details'));
		$this->load->view('quotation_view', $data);
		$this->load->view('footer');
	}

	function makeChanges(){
		$update_arr = array(
			'importance' => $this->input->post('importance'),
			'status' => $this->input->post('status'),
		);

		if($this->input->post('reason') && $this->input->post('status') == 'Closed'){
			$update_arr['close_reason'] = $this->input->post('reason');
		}

		$this->quotation_model->updateData('quotation_mst', $update_arr, array('quotation_mst_id' => $this->input->post('quote_id')));
		$this->session->set_flashdata('success', 'Quotation updated successfully');
		redirect('quotations/viewQuotation/'.$this->input->post('quote_id'));
	}

	function deleteQuote(){
		$this->quotation_model->deleteData('quotation_dtl', array('quotation_mst_id' => $this->input->post('quote_id')));
		$this->quotation_model->deleteData('quotation_mst', array('quotation_mst_id' => $this->input->post('quote_id')));
	}

	function addDetails(){
		$type = $this->input->post('type');
		$data = $this->input->post('data');

		switch($type){
			case "delivery_time":
				$new_record_id = $this->quotation_model->insertData('delivery_time', array('dt_value' => $data));
				$all_data = $this->quotation_model->getData('delivery_time');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['dt_id'];
					$arr[$key]['value'] = $value['dt_value'];
				}
				break;

			case "payment_terms":
				$new_record_id = $this->quotation_model->insertData('payment_terms', array('term_value' => $data));
				$all_data = $this->quotation_model->getData('payment_terms');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['term_id'];
					$arr[$key]['value'] = $value['term_value'];
				}
				break;

			case "validity":
				$new_record_id = $this->quotation_model->insertData('validity', array('validity_value' => $data));
				$all_data = $this->quotation_model->getData('validity');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['validity_id'];
					$arr[$key]['value'] = $value['validity_value'];
				}
				break;

			case "origin":
				$new_record_id = $this->quotation_model->insertData('origin_country', array('country' => $data));
				$all_data = $this->quotation_model->getData('origin_country');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['country_id'];
					$arr[$key]['value'] = $value['country'];
				}
				break;

			case "unit":
				$new_record_id = $this->quotation_model->insertData('units', array('unit_value' => $data));
				$all_data = $this->quotation_model->getData('units');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['unit_id'];
					$arr[$key]['value'] = $value['unit_value'];
				}
				break;

			case "product":
				$new_record_id = $this->quotation_model->insertData('lookup', array('lookup_value' => $data, 'lookup_group' => 259));
				$all_data = $this->quotation_model->getData('lookup', 'lookup_group = 259');
				$arr = array();
				foreach ($all_data as $key => $value) {
					$arr[$key]['id'] = $value['lookup_id'];
					$arr[$key]['value'] = $value['lookup_value'];
				}
				break;
		}
		echo json_encode(array('new_record_id' => $new_record_id, "records" => $arr));
	}

	function calculateCharge(){
		$weight = $this->input->post('weight');
		$zone_id = $this->input->post('zone_id');

		
		if($weight < 71){
			$mul = 1;
		}else if($weight < 100){
			$mul = $weight;
			$weight = 71; 
		}else if($weight < 300){
			$mul = $weight;
			$weight = 100; 
		}else if($weight < 500){
			$mul = $weight;
			$weight = 300; 
		}else if($weight < 1000){
			$mul = $weight;
			$weight = 500; 
		}else if($weight > 1000){
			$mul = $weight;
			$weight = 1000;
		}
		$res = $this->quotation_model->getData('ddu_charges', 'weight = '.$weight);
		$currency_arr = $this->quotation_model->getData('currency');
		$base_charge_rs = $res[0]['zone_'.$zone_id] * $mul;
		$fuel_surcharge = 0.25 * $base_charge_rs;
		$custom_clearance = 2000;
		$base_total = $base_charge_rs + $fuel_surcharge + $custom_clearance;
		$tax = 0.28 * $base_total;
		$total = $base_total + $tax;
		echo $charge = round($total / $currency_arr[0]['currency_rate'], 2);
	}

	public function sendSms($mobile,$sms_txt){ 
		//$mobile='9821850733';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.msg91.com/api/sendhttp.php?Group_id=OMTUBES&authkey=345434ALgG4fZD72t35f941f44P1&mobiles=".$mobile."&unicode=&country=91&message=".$sms_txt."&sender=OMTUBE&route=4",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}


	}

	function daily_followup(){
		$users = $this->quotation_model->getData('users', 'role = 5 and status = 1');
		foreach ($users as $user) {
			$count = $this->quotation_model->getFollowupCount($user['user_id']);
			if($count > 0){
				$sms_text = 'Dear '.$user['name'].'%0aGood Morning.%0aYou have '.$count.' quotations due for follow up today.%0aKindly check with clients and try to convert these orders.%0aAlso do not forget to update status in CRM.%0aHave a great day ahead.';
				$this->sendSms($user['mobile'], $sms_text);
			}
		}
		
	}

	function query_list($query_type, $query_status){
		$this->load->view('header', array('title' => 'Query List - '.ucfirst(strtolower($query_type)).' - '.ucfirst(strtolower($query_status))));
		$this->load->view('sidebar', array('title' => 'Query List - '.ucfirst(strtolower($query_type)).' - '.ucfirst(strtolower($query_status))));
		/*$purchase_user = $this->quotation_model->getData('users', 'role in (6, 8) and status = 1');
		$user_str = '';
		foreach ($purchase_user as $key => $value) {
			$user_str .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		};*/
		$this->load->view('query_list_view', array('query_type' => $query_type, 'query_status' => $query_status));
		$this->load->view('footer');
	}

	function query_list_data($query_type, $query_status){
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			if($search_key == 'raised_on'){
				if($this->input->post('columns')[$key]['search']['value'] != ''){
					$search[$search_key] = date('Y-m-d', strtotime($this->input->post('columns')[$key]['search']['value']));	
				}else{
					$search[$search_key] = '';
				}
			}else{
				$search[$search_key] = $this->input->post('columns')[$key]['search']['value'];
			}
		}
		$search['query_type'] = $query_type;
		$search['query_status'] = $query_status;

		$order_by = $this->input->post('columns')[$this->input->post('order')[0]['column']]['data'];
		$dir = $this->input->post('order')[0]['dir'];
		if($order_by == 'record_id'){
			$order_by = 'raised_on';
			$dir = 'desc';
		}

		$records = $this->quotation_model->getQueryList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->quotation_model->getQueryListCount($search);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function uploadPO(){
		if(!empty($_FILES['po_file'])){
			$config['upload_path']          = './assets/purchase_orders/';
            $config['allowed_types']        = 'pdf';//'jpeg|gif|jpg|png';
            $config['max_size']             = 5242880;
            $config['file_name']            = 'PO-'.$this->input->post('quote_id');
            $config['overwrite']            = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('po_file'))
            {
				$error = array('error' => $this->upload->display_errors());
				$data = array('status' => 'failed', 'msg' => $error['error']);
            }
            else
            {
            	$file_dtls = $this->upload->data();
	            $data = array('status' => 'success', 'msg' => 'Image uploaded successfully!', 'file_name' => $file_dtls['file_name']);
	            $this->quotation_model->updateData('quotation_mst', array('purchase_order' => $file_dtls['file_name']), array('quotation_mst_id' => $this->input->post('quote_id')));
            }
            echo '<script>window.close();</script>';
		}
	}
}