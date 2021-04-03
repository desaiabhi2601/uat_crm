<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma extends MX_Controller {
	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}
		$this->load->model('proforma_model');
	}

	public function index(){
		$this->list();
	}

	function pdf($quote_id){

		$data['quote_details'] = $this->proforma_model->getQuotationDetails($quote_id);
		if($data['quote_details'][0]['status'] != 'Won'){
			echo "Proforma not yet generated";exit;
		}
		if(($data['quote_details'][0]['delivery_name'] == 'CFR Port Name' || $data['quote_details'][0]['delivery_name'] == 'CIF Port Name') && $data['quote_details'][0]['mode'] == 'Sea Worthy'){
			$port_name = $this->proforma_model->getPortName('CIF', 'sea', $data['quote_details'][0]['country']);
			$data['quote_details'][0]['delivery_name'] = $port_name;
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
				<td>'.$value['description'].'</td>
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
		$date = date('d-m-Y', strtotime($data['quote_details'][0]['confirmed_on']));
		$client_name = trim($data['quote_details'][0]['client_name']);

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
		<strong style="font-size: 25px; text-align: right; line-height: 35px;">Proforma Invoice</strong><br/>
		<table style="line-height: 22px;">
		<tr style="background-color: #e4e1e1; border-bottom: 1px solid;">
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;"> Proforma # : </strong></td>
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;">Date : </strong></td>
		</tr>
		<tr>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$data['quote_details'][0]['proforma_no'].'</td>
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
		<td colspan="2" style="padding:5px;vertical-align: text-top;"><strong style="font-size: 12px;">Order # :</strong></td>
		</tr>
		<tr>
		<td colspan="2" style="font-family: courier; font-size: 11px;color: #484545;">'.$data['quote_details'][0]['order_no'].'</td>
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
					This offer is not valid for end users from Iran, Iraq, North Korea, Cuba, Sudan & Syria.
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
			<br/><br/>
			<table>
				<tr>
					<td colspan="2"><strong>Bank Details</strong></td>
				</tr>
				<tr><td width="35%">Bank Name:</td><td width="65%"><span style="font-family: courier;">Kotak Mahindra Bank</span></td></tr>
				<tr><td>Branch Name:</td><td><span style="font-family: courier;">Opera House, Mumbai</span></td></tr>
				<tr><td>Beneficiary Name:</td><td><span style="font-family: courier;">Om Tubes & Fittings Industries</span></td></tr>
				<tr><td>Account Number:</td><td><span style="font-family: courier;">0412413344</span></td></tr>
				<tr><td>Swift Code:</td><td><span style="font-family: courier;">KKBKINBB</span></td></tr>
				<tr><td>IFSC CODE:</td><td><span style="font-family: courier;">KKBK0000666</span></td></tr>
			</table>
		</td>
		<td align="center">
		Thank you for your business<br/>
		For Om Tubes & Fittings Industries<br/><br/>
		<img src="/assets/media/stamp.png"/><br/><br/>
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

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output(str_replace('/', '-', $data['quote_details'][0]['proforma_no']).'.pdf', 'I');
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

	function list(){
		/*$data['records'] = $this->list_data();*/
		$users = $this->proforma_model->getData('users', 'role = 5 and status = 1');
		$user_str = '';
		foreach ($users as $key => $value) {
			$user_str .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		};

		$purchase = $this->proforma_model->getData('users', 'role in (6, 8) and status = 1');
		$purchase_str = '';
		foreach ($purchase as $key => $value) {
			$purchase_str .= '<option value="'.$value['user_id'].'">'.$value['name'].'</option>';
		};

		$countries = $this->proforma_model->getData('lookup', 'lookup_group = 2');
		$country_str = '';
		foreach ($countries as $key => $value) {
			$country_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};

		$region = $this->proforma_model->getData('lookup', 'lookup_group = 1');
		$region_str = '';
		foreach ($region as $key => $value) {
			$region_str .= '<option value="'.$value['lookup_id'].'">'.$value['lookup_value'].'</option>';
		};
		$this->load->view('header', array('title' => 'Proforma List'));
		$this->load->view('sidebar', array('title' => 'Proforma List'));
		$this->load->view('proforma_list_new', array('user_str'=>$user_str, 'country_str'=>$country_str, 'region_str'=>$region_str, 'purchase_str' => $purchase_str));
		$this->load->view('footer');
	}

	function list_data(){
		foreach ($this->input->post('columns') as $key => $value) {
			$search_key = '';
			
			if($this->session->userdata('role') == 1){
					if($key == 1){
						$search_key = 'proforma_no';
					}else if($key == 2){
						$search_key = 'assigned_to';
					}else if($key == 3){
						$search_key = 'purchase_person';
					}else if($key == 4){
						$search_key = 'confirmed_on';
					}else if($key == 5){
						$search_key = 'client_name';
					}else if($key == 6){
						$search_key = 'grand_total';
					}/*else if($key == 8){
						$search_key = 'country';
					}else if($key == 9){
						$search_key = 'region';
					}*/else if($key == 9){
						$search_key = 'importance';
					}else if($key == 10){
						$search_key = 'status';
					}
				}else{
					if($key == 1){
						$search_key = 'proforma_no';
					}else if($key == 3){
						$search_key = 'confirmed_on';
					}else if($key == 4){
						$search_key = 'client_name';
					}else if($key == 5){
						$search_key = 'grand_total';
					}/*else if($key == 8){
						$search_key = 'country';
					}else if($key == 9){
						$search_key = 'region';
					}*/else if($key == 8){
						$search_key = 'importance';
					}else if($key == 9){
						$search_key = 'status';
					}
				}

			// echo $search_key;		

			if($search_key == 'confirmed_on'){
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
		if($order_by == 'record_id'){
			$order_by = 'proforma_no';
			$dir = 'desc';
		}
		$records = $this->proforma_model->getProformaList($this->input->post('start'), $this->input->post('length'), $search, $order_by, $dir);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->proforma_model->getProformaListCount($search);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function deleteOrder(){
		$quote_id = $this->input->post('quote_id');
		$update_arr = array(
			"stage" => "publish",
			"status" => "open",
			"proforma_no" => null,
			"confirmed_on" => null
		);
		$this->proforma_model->updateData('quotation_mst', $update_arr, array('quotation_mst_id' => $quote_id));
	}
}