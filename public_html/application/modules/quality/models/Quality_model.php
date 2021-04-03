<?php 
Class Quality_model extends CI_Model{

	function getSuggestions($search, $mtc_for){
		if($mtc_for == 'quotation_no'){
			$this->db->select('c.client_id, c.client_name, m.member_id, m.name, q.assigned_to, q.quote_no mtc_str, q.quotation_mst_id mtc_str_id');
			$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
			$this->db->join('members m', 'm.member_id = q.member_id', 'inner');
			$this->db->where("q.quote_no like '%".$search."%'");
			return $this->db->get('quotation_mst q')->result_array();
		} else if($mtc_for == 'proforma_no'){
			$this->db->select('c.client_id, c.client_name, m.member_id, m.name, q.assigned_to, q.proforma_no mtc_str, q.quotation_mst_id mtc_str_id');
			$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
			$this->db->join('members m', 'm.member_id = q.member_id', 'inner');
			$this->db->where("q.proforma_no like '%".$search."%'");
			return $this->db->get('quotation_mst q')->result_array();
		} else if($mtc_for == 'invoice_no'){
			$this->db->select('c.client_id, c.client_name, i.invoice_no mtc_str, i.invoice_mst_id mtc_str_id');
			$this->db->join('clients c', 'c.client_id = i.company_id', 'inner');
			//$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
			$this->db->where("i.invoice_no like '%".$search."%'");
			return $this->db->get('invoice_mst i')->result_array();
		}
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

	function getMTCList($start, $length, $search, $order, $dir){
		$this->db->select('m.*, uq.name assigned_to, us.name created_by');
		$this->db->join('users us', 'us.user_id = m.created_by', 'inner');
		$this->db->join('users uq', 'uq.user_id = m.assigned_to', 'left');
		$this->db->join('clients c', 'c.client_id = m.mtc_company_id', 'left');
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'company_name' || $key == 'member_name'){
						$this->db->where($key." like '%".$value."%'");
					}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('created_by', $this->session->userdata('user_id'));
		}
		if($this->session->userdata('role') == 10){
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$res = $this->db->get('mtc_mst m')->result_array();

		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			$result[$key]['files'] = $this->getData('mtc_files', 'mtc_mst_id = '.$value['mtc_mst_id']);
		}
		return $result;
	}

	function getMTCListCount($search){
		$this->db->select('m.*, uq.name assigned_to, us.name created_by');
		$this->db->join('users us', 'us.user_id = m.created_by', 'inner');
		$this->db->join('users uq', 'uq.user_id = m.assigned_to', 'left');
		$this->db->join('clients c', 'c.client_id = m.mtc_company_id', 'left');
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'company_name' || $key == 'member_name'){
						$this->db->where($key." like '%".$value."%'");
					}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('created_by', $this->session->userdata('user_id'));
		}
		if($this->session->userdata('role') == 10){
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('mtc_mst m')->result_array();
		return sizeof($res);
	}

	function getSampleMTCStatus($quote_id){
		return $this->db->get_where('mtc_mst', array('mtc_type' => 'sample', 'mtc_for_id' => $quote_id))->row_array();
	}

	function getMTCDetails($mtc_id){
		return $this->db->get_where('mtc_mst', array('mtc_mst_id' => $mtc_id))->row_array();
	}

	function getLineItems($quote_id){
		$this->db->select('qd.*, u.unit_value unit, p.lookup_value product, m.lookup_value material');
		$this->db->join('units u', 'u.unit_id = qd.unit', 'inner');
		$this->db->join('lookup p', 'p.lookup_id = qd.product_id', 'left');
		$this->db->join('lookup m', 'm.lookup_id = qd.material_id', 'left');
		return $this->db->get_where('quotation_dtl qd', array('quotation_mst_id' => $quote_id))->result_array();
	}

	function getHeatNumber($product_id){
		$res = $this->db->get_where('number_logic', array('logic_for' => $product_id))->row_array();
		return $res;
	}

	function getMarkingDetails($marking_id){
		$this->db->select('m.*, md.*, q.quote_no, q.quotation_mst_id, q.proforma_no, q.confirmed_on, q.client_id, q.member_id, qd.*, c.client_name, me.name, u.unit_value');
		$this->db->join('marking_dtl md', 'm.marking_mst_id = md.marking_mst_id', 'inner');
		$this->db->join('quotation_mst q', 'q.quotation_mst_id = m.marking_for_id', 'inner');
		$this->db->join('quotation_dtl qd', 'qd.quotation_dtl_id = md.quotation_dtl_id', 'inner');
		$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
		$this->db->join('members me', 'me.member_id = q.member_id', 'inner');
		$this->db->join('units u', 'u.unit_id = qd.unit', 'inner');
		return $this->db->get_where('marking_mst m', array('m.marking_mst_id' => $marking_id))->result_array();
	}


	function getMarkingList($start, $length, $search, $order, $dir){
		$this->db->select('m.*, uq.name assigned_to, us.name created_by, DATE_FORMAT(q.entered_on, "%d-%b") quote_date, c.client_name');
		$this->db->join('quotation_mst q', 'q.quotation_mst_id = m.marking_for_id', 'inner');
		$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
		$this->db->join('users us', 'us.user_id = m.made_by', 'inner');
		$this->db->join('users uq', 'uq.user_id = m.assigned_to', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'client_name'){
						$this->db->where($key." like '%".$value."%'");
					}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		$res = $this->db->get('marking_mst m')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getMarkingListCount($search){
		$this->db->select('m.*, uq.name assigned_to, us.name created_by, DATE_FORMAT(q.entered_on, "%d-%b") quote_date, c.client_name');
		$this->db->join('quotation_mst q', 'q.quotation_mst_id = m.marking_for_id', 'inner');
		$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
		$this->db->join('users us', 'us.user_id = m.made_by', 'inner');
		$this->db->join('users uq', 'uq.user_id = m.assigned_to', 'left');
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'client_name'){
						$this->db->where($key." like '%".$value."%'");
					}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		$res = $this->db->get('marking_mst m')->result_array();
		return sizeof($res);
	}

	// new code
	public function get_quotaion_won_performa() {

		// echo "<pre>";print_r($this->db);echo"</pre><hr>";exit;
		$this->db->select('quotation_mst.quotation_mst_id, quotation_mst.quote_no, quotation_mst.client_id, clients.client_name');
		$this->db->join('mtc_mst', 'mtc_mst.mtc_for_id = quotation_mst.quotation_mst_id', 'left');
		$this->db->join('clients', 'clients.client_id = quotation_mst.client_id', 'left');
		$this->db->order_by('quotation_mst.quotation_mst_id', 'DESC');
		$res = $this->db->get_where('quotation_mst', array('quotation_mst.status' => 'Won', 'mtc_mst.mtc_for_id' => NULL))->result_array();
		// echo $this->db->last_query(),"<hr>";
		return $res;
	}

	public function getMtcData($where) {

		$this->db->select('mtc_mst.mtc_mst_id, mtc_mst.mtc_type, mtc_mst.mtc_for, mtc_mst.mtc_company, mtc_mst.assigned_to, mtc_mst.created_by, mtc_mst.made_flag, mtc_mst.checked_by_quality_admin , mtc_mst.checked_by_super_admin, quotation_mst.purchase_order');
		$this->db->join('quotation_mst', 'quotation_mst.quotation_mst_id = mtc_mst.mtc_for_id','left');
		$this->db->where($where, NULL, false);
		return $this->db->get('mtc_mst')->result_array();
	}

	public function getDynamicData($select, $where, $table_name, $return_type = 'result_array', $limit = 0, $offset = 0) {

		if(!empty($select)){
			$this->db->select($select);
		} else {
			$this->db->select('*');
		}
		$this->db->where($where);
		return $this->db->get($table_name)->$return_type();
	}
	// new code end
}