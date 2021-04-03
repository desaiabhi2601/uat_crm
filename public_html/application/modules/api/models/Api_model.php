<?php 
Class Api_model extends CI_Model{

	function insertData($table, $data){
		$this->db->insert($table, $data);
	}

	function clearMargins($date){
		$quotes = $this->db->get_where('quotation_mst', array('entered_on <= ' => $date))->result_array();
		foreach ($quotes as $key => $value) {
			$this->db->update('quotation_dtl', array('unit_rate' => null, 'margin' => null, 'packing_charge' => null), array('quotation_mst_id' => $value['quotation_mst_id']));
		}
	}
}