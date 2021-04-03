<?php 
class Procurement_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('marketing', true);
	}
	
	function insertData($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function updateData($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	function deleteData($table, $where){
		$this->db->delete($table, $where);
	}

	function getData($table, $where=''){
		if($where != ''){
			$this->db->where($where);
		}
		return $this->db->get($table)->result_array();
	}

	function getRfq($rfq_id){
		$this->db->join('rfq_dtl d', 'm.rfq_mst_id = d.rfq_mst_id', 'left');
		return $this->db->get_where('rfq_mst m', array('m.rfq_mst_id' => $rfq_id))->result_array();
	}

	function getLeadName($client_id, $source){
		if($source == 'main'){
			$this->db->select('client_name');
			$res = $this->db->get_where('clients', array('client_id' => $client_id))->row_array();
			return $res['client_name'];
		}else if($source == 'hetro leads'){
			$this->db->select('company_name');
			$res = $this->db->get_where('hetro_leads', array('lead_id' => $client_id))->row_array();
			return $res['company_name'];
		}else if($source == 'primary leads'){
			$this->db2->select('importer_name');
			$res = $this->db2->get_where('lead_mst', array('lead_mst_id' => $client_id))->row_array();
			return $res['importer_name'];
		}
	}

	function getRfqs(){
		$this->db->select('*');
		return $this->db->get('rfq')->result_array();
	}

	/*function getRfqDetails($rfq_id){
		return $this->db->get_where('rfq', array('rfq_id' => $rfq_id))->row_array();
	}*/

	function getClients($search=''){
		$client_arr = array();
		$this->db->select('c.client_id, c.client_name, l.lookup_value country');
		$this->db->join('lookup l', 'l.lookup_id = c.country', 'left');
		if($search != ''){
			$this->db->where("c.client_name like '%".$search."%'");
		}
		$clients = $this->db->get('clients c')->result_array();
		$i = 0;
		foreach ($clients as $c) {
			$client_arr[$i]['client_id'] = $c['client_id'];
			$client_arr[$i]['client_name'] = $c['client_name'];
			$client_arr[$i]['client_rank'] = '';
			$client_arr[$i]['last_purchased'] = '';
			$client_arr[$i]['client_source'] = 'main';
			$client_arr[$i]['country'] = $c['country'];
			$i++;
		}

		/*$this->db->select('lead_id, company_name');
		if($search != ''){
			$this->db->where("company_name like '%".$search."%'");
		}
		$hetro_leads = $this->db->get('hetro_leads')->result_array();
		foreach ($hetro_leads as $hl) {
			$client_arr[$i]['client_id'] = $hl['lead_id'];
			$client_arr[$i]['client_name'] = $hl['company_name'];
			$client_arr[$i]['client_rank'] = '';
			$client_arr[$i]['last_purchased'] = '';
			$client_arr[$i]['client_source'] = 'hetro leads';
			$i++;
		}*/

		$this->db2->select('lead_mst_id, importer_name, rank, last_purchased, country_of_destination');
		if($search != ''){
			$this->db2->where("importer_name like '%".$search."%'");
		}
		$primary_leads = $this->db2->get('lead_mst')->result_array();
		foreach ($primary_leads as $pl) {
			$client_arr[$i]['client_id'] = $pl['lead_mst_id'];
			$client_arr[$i]['client_name'] = $pl['importer_name'];
			$client_arr[$i]['client_rank'] = $pl['rank'];
			$client_arr[$i]['last_purchased'] = '';
			if($pl['last_purchased'] != ''){
				$client_arr[$i]['last_purchased'] = date('d-m-Y', strtotime($pl['last_purchased']));
			}
			$client_arr[$i]['client_source'] = 'primary leads';
			$client_arr[$i]['country'] = $pl['country_of_destination'];
			$i++;
		}
		return $client_arr;
	}

	function getMembers($data){
		$members = array();
		if($data['source'] == 'main'){
			$mem = $this->db->get_where('members', array('client_id' => $data['client_id']))->result_array();
			foreach ($mem as $key => $value) {
				$members[$key]['member_id'] = $value['member_id'];
				$members[$key]['member_name'] = $value['name'];
			}
		}else if($data['source'] == 'hetro leads'){
			$mem = $this->db->get_where('hetro_lead_detail', array('lead_id' => $data['client_id']))->result_array();
			foreach ($mem as $key => $value) {
				$members[$key]['member_id'] = $value['lead_dtl_id'];
				$members[$key]['member_name'] = $value['member_name'];
			}
		}else if($data['source'] == 'primary leads'){
			$mem = $this->db2->get_where('lead_detail', array('lead_mst_id' => $data['client_id']))->result_array();
			foreach ($mem as $key => $value) {
				$members[$key]['member_id'] = $value['lead_dtl_id'];
				$members[$key]['member_name'] = $value['member_name'];
			}
		}
		return $members;
	}

	function getRFQListData($start, $length, $search, $order, $dir){
		if($search['rfq_company'] != ''){
			$searched_clients = $this->getClients($search['rfq_company']);
		}

		$this->db->select('r.*, u1.name sentby_name, u2.name assigned_to_name, DATE_FORMAT(r.rfq_date, "%d-%b") rfq_date');//, q.stage quote_status
		//$this->db->distinct();
		$this->db->join('users u1', 'u1.user_id = r.rfq_sentby', 'inner');
		$this->db->join('users u2', 'u2.user_id = r.assigned_to', 'inner');
		//$this->db->join('quotation_mst q', 'q.rfq_id = r.rfq_mst_id', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'rfq_no'){
						$this->db->where($key." like '%".$value."%'");
					} else if($key == 'rfq_company' && !empty($searched_clients)){
						$this->db->group_start();
						foreach ($searched_clients as $key => $value) {
							$this->db->or_where("(rfq_company = ".$value['client_id']." and client_source = '".$value['client_source']."')");
						}
						$this->db->group_end();
					} /*else if($key == 'quote_status'){
						$this->db->where("q.stage = '".$value."'");
					}*/ else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('rfq_sentby', $this->session->userdata('user_id'));
		}
		if($this->session->userdata('role') == 8){
			$this->db->where('r.assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('rfq_mst r')->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			if($value['client_source'] == 'main'){
				$clients = $this->db->get_where('clients', array('client_id' => $value['rfq_company']))->row_array();
				$result[$key]['company_name'] = $clients['client_name'];

				$members = $this->db->get_where('members', array('member_id' => $value['rfq_buyer']))->row_array();
				$result[$key]['member_name'] = $members['name'];
			}else if($value['client_source'] == 'hetro leads'){
				$clients = $this->db->get_where('hetro_leads', array('lead_id' => $value['rfq_company']))->row_array();
				$result[$key]['company_name'] = $clients['company_name'];

				$members = $this->db->get_where('hetro_lead_detail', array('lead_dtl_id' => $value['rfq_buyer']))->row_array();
				$result[$key]['member_name'] = $members['member_name'];
			}else if($value['client_source'] == 'primary leads'){
				$clients = $this->db2->get_where('lead_mst', array('lead_mst_id' => $value['rfq_company']))->row_array();
				$result[$key]['company_name'] = $clients['IMPORTER_NAME'];

				$members = $this->db2->get_where('lead_detail', array('lead_dtl_id' => $value['rfq_buyer']))->row_array();
				$result[$key]['member_name'] = $members['member_name'];
			}
			$result[$key]['record_id'] = ++$k;
			$result[$key]['quote_no'] = '';
			$result[$key]['quote_id'] = 0;
			$quote_arr = $this->db->get_where('quotation_mst', array('rfq_id' => $value['rfq_mst_id']))->row_array();
			if(!empty($quote_arr)){
				$result[$key]['quote_id'] = $quote_arr['quotation_mst_id'];
				if($quote_arr['stage'] == 'draft'){
					$result[$key]['quote_no'] = 'Draft';	
				}else{
					$result[$key]['quote_no'] = $quote_arr['quote_no'];	
				}
			}

			$result[$key]['query'] = '';
			$result[$key]['is_new'] = false;
			$query_res = $this->db->get_where('rfq_note_query', array('rfq_id' => $value['rfq_mst_id'], 'type' => 'query'))->result_array();
			if(!empty($query_res)){
				$sent_by = '';
				foreach ($query_res as $qkey => $qvalue) {
					$sent_by = $qvalue['entered_by'];
					$align = 'left';
					if($this->session->userdata('user_id') == $qvalue['entered_by']){
						$align = 'right';
					}
					$result[$key]['query'] .= '<tr><td style="text-align: '.$align.'">
						'.$qvalue['note'].'<br/><span style="font-size: 10px;">'.date('d M H:i', strtotime($qvalue['entered_on'])).'</span>
					</td></tr>';
				}
				if($this->session->userdata('user_id') != $sent_by){
					$result[$key]['is_new'] = true;
				}
			}

			$result[$key]['notes'] = '';
			$notes_res = $this->db->get_where('rfq_note_query', array('rfq_id' => $value['rfq_mst_id'], 'type' => 'notes'))->result_array();
			if(!empty($query_res)){
				$sent_by = '';
				foreach ($query_res as $qkey => $qvalue) {
					$sent_by = $qvalue['entered_by'];
					$result[$key]['notes'] .= '<tr><td>'.$qvalue['note'].'<br/><span style="font-size: 10px; text-align:right;">'.date('d M H:i', strtotime($qvalue['entered_on'])).'</span>
					</td></tr>';
				}
			}

			$this->db->join('quotation_mst m', 'm.quotation_mst_id = q.query_for_id', 'inner');
			$this->db->join('rfq_mst r', 'r.rfq_mst_id = m.rfq_id', 'inner');
			$query_res = $this->db->get_where('query_mst q', array('r.rfq_mst_id' => $value['rfq_mst_id']))->row_array();
			if(!empty($query_res)){
				$result[$key]['has_query'] = true;
				$result[$key]['quotation_mst_id'] = $query_res['quotation_mst_id'];
				$result[$key]['query_id'] = $query_res['query_id'];
				$result[$key]['query_type'] = $query_res['query_type'];
			}else{
				$result[$key]['has_query'] = false;
				$result[$key]['quotation_mst_id'] = '';
				$result[$key]['query_id'] = '';
				$result[$key]['query_type'] = '';
			}
		}
		return $result;
	}

	function getRFQListCount($search){
		if($search['rfq_company'] != ''){
			$searched_clients = $this->getClients($search['rfq_company']);
		}

		$this->db->select('r.*, u1.name sentby_name, u2.name assigned_to_name');
		$this->db->join('users u1', 'u1.user_id = r.rfq_sentby', 'inner');
		$this->db->join('users u2', 'u2.user_id = r.assigned_to', 'inner');
		//$this->db->join('quotation_mst q', 'q.rfq_id = r.rfq_mst_id', 'left');
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'rfq_no'){
						$this->db->where($key." like '%".$value."%'");
					} else if($key == 'rfq_company' && !empty($searched_clients)){
						$this->db->group_start();
						foreach ($searched_clients as $key => $value) {
							$this->db->or_where("(rfq_company = ".$value['client_id']." and client_source = '".$value['client_source']."')");
						}
						$this->db->group_end();
					} /*else if($key == 'quote_status'){
						$this->db->where("q.stage = '".$value."'");
					}*/ else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('rfq_sentby', $this->session->userdata('user_id'));
		}
		if($this->session->userdata('role') == 8){
			$this->db->where('r.assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('rfq_mst r')->result_array();
		return sizeof($res);
	}

	function getRFQNo(){
		$res = $this->db->get_where('number_logic', array('logic_for' => 'rfq'))->row_array();
		$number = $res['logic_value'];
		$new_number = $number+1;
		$this->db->update('number_logic', array('logic_value' => $new_number), array('logic_for' => 'rfq'));
		return $number;
	}

	function getRFQDetails($connect_id){
		$this->db->select('rfq_id');
		$con = $this->db->get_where('rfq_to_vendor', array('connect_id' => $connect_id ))->row_array();
		$rfq_id = $con['rfq_id'];

		$this->db->select('r.*, rd.*, u.unit_value, us.name uname, us.email uemail, us.mobile umobile');
		$this->db->join('rfq_dtl rd', 'rd.rfq_mst_id = r.rfq_mst_id', 'left');
		$this->db->join('units u', 'u.unit_id = rd.unit', 'inner');
		$this->db->join('users us', 'us.user_id = r.assigned_to', 'inner');
		return $this->db->get_where('rfq_mst r', array('r.rfq_mst_id' => $rfq_id))->result_array();
	}

	function getVendorDetails($connect_id){
		$this->db->select('vendor_id');
		$con = $this->db->get_where('rfq_to_vendor', array('connect_id' => $connect_id ))->row_array();
		$vendor_id = $con['vendor_id'];

		$this->db->select('v.*, vd.*, l.lookup_value country');
		$this->db->join('vendor_dtl vd', 'vd.vendor_id = v.vendor_id', "inner and main_seller = 'yes'");
		$this->db->join('lookup l', 'l.lookup_id = v.country', 'left');
		return $this->db->get_where('vendors v', array('v.vendor_id' => $vendor_id))->row_array();
	}
} 
?>