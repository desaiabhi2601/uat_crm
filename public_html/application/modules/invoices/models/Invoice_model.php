<?php 
Class Invoice_model extends CI_Model{
	function insertInvoice($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function updateInvoice($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	function getInvoiceList($start, $length, $where, $order, $dir, $searchByYear='all'){
		$this->db->select('i.*, c.client_name, m.name, l.lookup_value country, DATE_FORMAT(i.invoice_date, "%d-%b") invoice_date');
		$this->db->join('clients c', 'c.client_id = i.company_id', 'inner');
		$this->db->join('members m', 'm.member_id = i.member_id', 'left');
		$this->db->join('lookup l', 'l.lookup_id = c.country', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$this->db->order_by('i.invoice_no', 'asc');
		
		if($where != ''){
			$this->db->group_start();
			$this->db->where('i.invoice_no like ', '%'.$where.'%');
			$this->db->or_where('i.invoice_date like ', '%'.$where.'%');
			$this->db->or_where('c.client_name like ', '%'.$where.'%');
			$this->db->or_where('m.name like ', '%'.$where.'%');
			$this->db->or_where('i.net_total like ', '%'.$where.'%');
			$this->db->or_where('i.discount like ', '%'.$where.'%');
			$this->db->or_where('i.freight_charge like ', '%'.$where.'%');
			$this->db->or_where('i.other_charge like ', '%'.$where.'%');
			$this->db->or_where('i.grand_total like ', '%'.$where.'%');
			$this->db->group_end();
		}
		if($searchByYear != 'all'){
			$years = explode('-', $searchByYear);
			$this->db->where('i.invoice_date >= ', date($years[0].'-04-01 00:00:00'));
			$this->db->where('i.invoice_date <= ', date($years[1].'-03-31 23:59:59'));
		}
		$res = $this->db->get_where('invoice_mst i', array('is_deleted' => NULL))->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getInvoiceListCount($where, $searchByYear='all'){
		$this->db->select('i.*, c.client_name, m.name');
		$this->db->join('clients c', 'c.client_id = i.company_id', 'inner');
		$this->db->join('members m', 'm.member_id = i.member_id', 'left');
		if($where != ''){
			$this->db->group_start();
			$this->db->where('i.invoice_no like ', '%'.$where.'%');
			$this->db->or_where('i.invoice_date like ', '%'.$where.'%');
			$this->db->or_where('c.client_name like ', '%'.$where.'%');
			$this->db->or_where('m.name like ', '%'.$where.'%');
			$this->db->or_where('i.net_total like ', '%'.$where.'%');
			$this->db->or_where('i.discount like ', '%'.$where.'%');
			$this->db->or_where('i.freight_charge like ', '%'.$where.'%');
			$this->db->or_where('i.other_charge like ', '%'.$where.'%');
			$this->db->or_where('i.grand_total like ', '%'.$where.'%');
			$this->db->group_end();
		}
		if($searchByYear != 'all'){
			$years = explode('-', $searchByYear);
			$this->db->where('i.invoice_date >= ', date($years[0].'-04-01 00:00:00'));
			$this->db->where('i.invoice_date <= ', date($years[1].'-03-31 23:59:59'));
		}
		$res = $this->db->get_where('invoice_mst i', array('is_deleted' => NULL))->result_array();
		return sizeof($res);
	}

	function getInvoiceDetails($invoice_id){
		$this->db->select('m.*, d.*, c.client_name, cm.name, cm.email, cm.mobile, c.website, l3.lookup_value country, l1.lookup_value product, l2.lookup_value material');
		$this->db->join('invoice_dtl d', 'm.invoice_mst_id = d.invoice_mst_id', 'inner');
		$this->db->join('clients c', 'c.client_id = m.company_id', 'inner');
		$this->db->join('members cm', 'cm.member_id = m.member_id', 'left');
		$this->db->join('lookup l3', 'l3.lookup_id = c.country', 'left');
		$this->db->join('lookup l1', 'l1.lookup_id = d.product_id', 'left');
		$this->db->join('lookup l2', 'l2.lookup_id = d.material_id', 'left');
		$this->db->order_by('d.invoice_dtl_id');
		return $this->db->get_where('invoice_mst m', array('m.invoice_mst_id' => $invoice_id))->result_array();
	}

	function deleteInvoice($table, $where){
		$this->db->delete($table, $where);
	}

	function getFinancialYears(){
		$this->db->select('case when month(invoice_date) > 3 then concat(year(invoice_date),"-",year(invoice_date)+1) 
    	else concat(year(invoice_date)-1,"-",year(invoice_date)) end as years');
    	$this->db->distinct();
    	$this->db->order_by('years', 'desc');
    	return $this->db->get('invoice_mst')->result_array();
	}
}
?>