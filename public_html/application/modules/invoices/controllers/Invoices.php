<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->has_userdata('user_id')){
			redirect('login', 'refresh');
			exit;
		}else{
			if(!in_array('invoices', $this->session->userdata('module'))){
				redirect($this->session->userdata('module')[0]);
				exit;
			}
		}
		$this->load->model('client/client_model');
		$this->load->model('invoice_model');
		$this->load->model('quotations/quotation_model');
	}

	public function index(){
		redirect('invoices/new');
	}

	public function new($invoice_id=0){
		if(!empty($this->input->post())){
			$invoice_mst_arr = array(
				'invoice_no' => $this->input->post('invoice_no'),
				'invoice_date' => date('Y-m-d', strtotime($this->input->post('invoice_date'))),
				'company_id' => $this->input->post('company'),
				'member_id' => $this->input->post('attention'),
				'remarks' => $this->input->post('remarks'),
				'freight_charge' => $this->input->post('freight_charges'),
				'other_charge' => $this->input->post('other_charges'),
				'discount' => $this->input->post('discount'),
				'mode' => $this->input->post('mode'),
			);

			if($this->input->post('invoice_id')){
				$invoice_mst_arr['modified_on'] = date('Y-m-d H:i:s');
				$invoice_mst_arr['modified_by'] = $this->session->userdata('user_id');
				$invoice_id = $this->input->post('invoice_id');
				$this->invoice_model->updateInvoice('invoice_mst', $invoice_mst_arr, array('invoice_mst_id' => $invoice_id));
				$this->invoice_model->deleteInvoice('invoice_dtl', array('invoice_mst_id' => $invoice_id));
				$msg = 'Invoice updated successfully';
			}else{
				$invoice_mst_arr['entered_on'] = date('Y-m-d H:i:s');
				$invoice_mst_arr['entered_by'] = $this->session->userdata('user_id');
				$invoice_id = $this->invoice_model->insertInvoice('invoice_mst', $invoice_mst_arr);
				$msg = 'Invoice created successfully';
			}

			$net_total = 0;
			foreach ($this->input->post('description') as $key => $value) {
				$invoice_dtl_arr = array(
					'invoice_mst_id' => $invoice_id,
					'product_id' => $this->input->post('product')[$key],
					'material_id' => $this->input->post('material')[$key],
					'description' => $this->input->post('description')[$key],
					'quantity' => $this->input->post('quantity')[$key],
					'rate' => $this->input->post('rate')[$key],
					'price' => $this->input->post('quantity')[$key] * $this->input->post('rate')[$key]
				);
				$net_total += $this->input->post('quantity')[$key] * $this->input->post('rate')[$key];
				$invoice_dtl_id = $this->invoice_model->insertInvoice('invoice_dtl', $invoice_dtl_arr);
			}
			$update_arr = array(
				'net_total' => $net_total,
				'grand_total' => $net_total+$this->input->post('freight_charges')+$this->input->post('other_charges')-$this->input->post('discount'),
			);
			$this->invoice_model->updateInvoice('invoice_mst', $update_arr, array('invoice_mst_id' => $invoice_id));
			$this->session->set_flashdata('success', $msg);
			redirect('invoices/list');
		}else{
			if($invoice_id != 0){
				$data['invoice_details'] = $this->invoice_model->getInvoiceDetails($invoice_id);
				$data['invoice_id'] = $invoice_id;
			}
			$data['clients'] = $this->client_model->getClients();
			$data['region'] = $this->quotation_model->getLookup(1);
			$data['country'] = $this->quotation_model->getLookup(2);
			$data['product'] = $product = $this->quotation_model->getLookup(259);
			$data['prd_str'] = $data['mat_str'] = ""; 
			foreach($product as $prod){ 
				$data['prd_str'] .= '<option value="'.$prod['lookup_id'].'">'.ucwords(strtolower($prod['lookup_value'])).'</option>';
			}

			$data['material'] = $material = $this->quotation_model->getLookup(272);
			foreach($material as $mat){ 
				$data['mat_str'] .= '<option value="'.$mat['lookup_id'].'">'.ucwords(strtolower($mat['lookup_value'])).'</option>';
			}
			$this->load->view('header', array('title' => 'Add / Edit Invoice'));
			$this->load->view('sidebar', array('title' => 'Add / Edit Invoice'));
			$this->load->view('add_invoice', $data);
			$this->load->view('footer');
		}
	}

	function list(){
		/*$data['records'] = $this->list_data();*/
		$finYears = $this->invoice_model->getFinancialYears();
		$this->load->view('header', array('title' => 'Invoice List'));
		$this->load->view('sidebar', array('title' => 'Invoice List'));
		$this->load->view('invoice_list_view', array('finYears' => $finYears));
		$this->load->view('footer');
	}

	function list_data(){
		$order_by = $this->input->get('columns')[$this->input->get('order')[0]['column']]['data'];
		if($order_by == 'record_id' || $order_by == 'company_name'){
			$order_by = 'client_name';
		}
		else if($order_by =='invoice_date')
		{
			$order_by = 'date(i.invoice_date)';
		}
		$searchByYear = $this->input->get('searchByFinYear');
		$dir = $this->input->get('order')[0]['dir'];
		$records = $this->invoice_model->getInvoiceList($this->input->get('start'), $this->input->get('length'), $this->input->get('search')['value'], $order_by, $dir, $searchByYear);
		$data['iTotalDisplayRecords'] = $data['iTotalRecords'] = $this->invoice_model->getInvoiceListCount($this->input->get('search')['value'], $searchByYear);
		$data['aaData'] = $records;
		echo json_encode($data);
	}

	function invoice_pdf($invoice_id){
		$data['invoice_details'] = $this->invoice_model->getInvoiceDetails($invoice_id);
		$this->load->library('Pdf');
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		/*$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 061');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

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

		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */

		// define some HTML content with style


		$table_str = '';

		$i=0;
        foreach ($data['invoice_details'] as $key => $value) { 
			$bg_color = '';
			if($i%2 != 0){
				$bg_color = '#e4e1e1;';
			}
			$table_str .= '<tr style="background-color: '.$bg_color.'; font-size: 11px; font-family: courier;">
				<td style="text-align: right;">'.++$i.'</td>
				<td>'.$value['description'].'</td>
				<td style="text-align: right;"> '.$value['quantity'].'</td>
				<td>-</td>
				<td style="text-align: right;">'.$value['rate'].'</td>
				<td>-</td>
				<td style="text-align: right;">'.$value['price'].'</td>
			</tr>';
        }


        $total_table = '<table cellspacing="0" cellpadding="10">
		<tr >
		<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;" width="50%" >Net Total</td>
		<td style="font-size: 12px; font-family: courier; border: solid 1px grey;" width="50%">'.$data['invoice_details'][0]['net_total'].'</td>
		</tr>';

		if($data['invoice_details'][0]['freight_charge'] > 0){
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Freight Charges</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['invoice_details'][0]['freight_charge'].'</td>
			</tr>';	
		}
		
		if($data['invoice_details'][0]['other_charge'] > 0){
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Other Charges</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['invoice_details'][0]['other_charge'].'</td>
			</tr>';
		}

		if($data['invoice_details'][0]['discount'] > 0){
			$total_table .= '<tr>
				<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Discount</td>
				<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['invoice_details'][0]['discount'].'</td>
			</tr>';
		}

		$total_table .= '<tr>
			<td style="background-color: #e4e1e1; font-size: 12px; border: solid 1px grey;">Grand Charges</td>
			<td style="font-size: 12px; font-family: courier; border: solid 1px grey;">'.$data['invoice_details'][0]['grand_total'].'</td>
		</tr>
		</table>';

		$grand_total_words = $this->numberTowords($data['invoice_details'][0]['grand_total']);

		$date = date('Y-m-d', strtotime($data['invoice_details'][0]['invoice_date']));

		$html = '<table cellpadding="5" cellspacing="0">
		<tr style="background-color: #fff;">
		<td width="50%" style="padding:5px;vertical-align: text-top; ">
		<img src="/crm/assets/media/client-logos/logo.png" width="180" height="50" style="padding-left: 10px;"><br/>
		<strong style="font-size: 16px;">OM TUBES & FITTINGS INDUSTRIES</strong>
		<div class="left_addrs" style="font-size: 14px;color: #484545;">10 Bordi Bunglow, 1st Panjarapole Lane, CP Tank, Mumbai, Maharashtra, India <br/>GSTIN 27AFRPM5323E1ZC
		</div>
		<table style="margin-top: -15px;">
		<tr style="background-color: #fff;">
		<td style="font-size: 14px;color: #484545;" width="50%">+91 (22) 6743 7634</td>
		</tr>
		<tr style="background-color: #fff;">
		<td style="font-size: 14px;color: #484545;" align="left">www.omtubes.com</td>
		</tr>
		</table>
		</td>
		<td width="50%">
		<strong style="font-size: 25px; text-align: right; line-height: 35px;">Quotation</strong><br/>
		<table style="line-height: 22px;">
		<tr style="background-color: #e4e1e1; border-bottom: 1px solid;">
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;"> Quote: </strong></td>
		<td style="padding:5px;vertical-align: text-top;" width="50%"><strong style="font-size: 12px;">Date: </strong></td>
		</tr>
		<tr>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$data['invoice_details'][0]['invoice_no'].'</td>
		<td style="padding:5px;vertical-align: text-top; font-size: 11px; font-family: courier;">'.$date.'</td>
		</tr>
		<tr style="background-color: #e4e1e1;">
		<td style="padding:5px;vertical-align: text-top;" width="75%"><strong style="font-size: 12px;"> Customer:</strong></td>
		<td style="padding:5px;vertical-align: text-top;" width="25%"><strong style="font-size: 12px;">Reference:</strong></td>
		</tr>
		<tr>
		<td style="padding:5px;vertical-align: text-top; font-family: courier;">
		<strong>'.$data['invoice_details'][0]['client_name'].'</strong>
		<div class="left_addrs" style="font-size: 11px;color: #484545; line-height: 17px; font-family: courier;">'.$data['invoice_details'][0]['country'].'<br/>'.$data['invoice_details'][0]['name'].'
		</div>
		</td>
		<td>Refxxxx</td>
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
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="46%">Item Description</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="9%">Qty</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="8%">Unit</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="11%">Price</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="8%">Unit</td>
		<td class="table_heading" style="font-weight: bold;padding:5px;vertical-align: text-top; font-size: 12px;" width="11%">Total</td>
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
		<td></td>
		<td align="center">
		Thank you for your business<br/>
		For Om Tubes & Fittings Industries<br/><br/>
		<img src="/assets/media/stamp.png" /><br/><br/>
		<table>
		<tr>
			<td width="30%" rowspan="3"></td>
		 	<td align="left" width="70%">Name : <span style="font-family: courier;">ABC XYZ</span></td>
		</tr>
		<tr>
			<td align="left">Email : <span style="font-family: courier;">abc@xyz.com</span></td>
		</tr>
		<tr>
			<td align="left">Mobile : <span style="font-family: courier;">+91 22 2222 2222</span></td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';

		// output the HTML content
		$pdf->writeHTML($html, true, false, true, false, '');

		//Close and output PDF document
		$pdf->Output('example_061.pdf', 'I');
	}

	function deleteInvoice(){
		$invoice_id = $this->input->post('invoice_id');
		$this->invoice_model->deleteInvoice('invoice_dtl', array('invoice_mst_id' => $invoice_id));
		$this->invoice_model->deleteInvoice('invoice_mst', array('invoice_mst_id' => $invoice_id));
	}

	function numberTowords($num)
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
		}
		return $rettxt;
	}
}

?>