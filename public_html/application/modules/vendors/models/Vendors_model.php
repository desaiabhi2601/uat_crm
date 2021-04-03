<?php 
class Vendors_model extends CI_Model{

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

	function getVendorDetails($vendor_id){
		$this->db->select('v.*, vd.*, v.vendor_id');
		$this->db->join('vendor_dtl vd', 'vd.vendor_id = v.vendor_id', 'left' );
		return $this->db->get_where('vendors v', array('v.vendor_id' => $vendor_id))->result_array();
	}

	function getVendorProducts($vendor_id){
		return $this->db->get_where('vendor_products', array('vendor_id' => $vendor_id))->result_array();
	}

	function getVendorListData($start, $length, $search, $order, $dir){
		$vendors = array();
		if($search['product'] != ''){
			$vendor_arr = $this->db->get_where('vendor_products', array('product_id' => $search['product']))->result_array();
			foreach ($vendor_arr as $key => $value) {
				$vendors[] = $value['vendor_id'];
			}
		}

		if($search['material'] != ''){
			$vendor_arr = $this->db->get_where('vendor_products', array('material_id' => $search['material']))->result_array();
			foreach ($vendor_arr as $key => $value) {
				$vendors[] = $value['vendor_id'];
			}
		}
		$this->db->select('v.*, vd.*, v.vendor_id, cf.flag_name');
		$this->db->join('(select *, min(vendor_dtl_id) from vendor_dtl group by vendor_id ) vd', 'vd.vendor_id = v.vendor_id', 'left' );
		$this->db->join('lookup l', 'l.lookup_id = v.country', 'inner');
		$this->db->join('country_flags cf', 'cf.country = l.lookup_value', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'vendor_name'){
						$this->db->where($key." like '%".$value."%'");
					}else if($key == 'product' || $key == 'material'){}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if(!empty($vendors)){
			$this->db->where_in('v.vendor_id', $vendors);
		}
		$res = $this->db->get('vendors v')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getVendorListCount($search){
		$vendors = array();
		if($search['product'] != ''){
			$vendor_arr = $this->db->get_where('vendor_products', array('product_id' => $search['product']))->result_array();
			foreach ($vendor_arr as $key => $value) {
				$vendors[] = $value['vendor_id'];
			}
		}

		if($search['material'] != ''){
			$vendor_arr = $this->db->get_where('vendor_products', array('material_id' => $search['material']))->result_array();
			foreach ($vendor_arr as $key => $value) {
				$vendors[] = $value['vendor_id'];
			}
		}
		$this->db->select('v.*, vd.*, v.vendor_id, cf.flag_name');
		$this->db->join('vendor_dtl vd', 'vd.vendor_id = v.vendor_id', 'left' );
		$this->db->join('lookup l', 'l.lookup_id = v.country', 'inner');
		$this->db->join('country_flags cf', 'cf.country = l.lookup_value', 'left');
		if(!empty($search)){
			foreach ($search as $key => $value) {
				if($value != ''){
					if($key == 'vendor_name'){
						$this->db->where($key." like '%".$value."%'");
					}else if($key == 'product' || $key == 'material'){}else{
						$this->db->where($key, $value);
					}
				}
			}
		}
		if(!empty($vendors)){
			$this->db->where_in('v.vendor_id', $vendors);
		}
		$res = $this->db->get('vendors v')->result_array();
		return sizeof($res);
	}
}
?>