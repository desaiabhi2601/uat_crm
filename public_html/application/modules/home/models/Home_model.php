<?php 
Class Home_model extends CI_Model{

	function getData($table, $where = ''){
		if($where != ''){
			$this->db->where($where);
		}

		if($table == 'daily_task_update'){
			$this->db->order_by('modified_on', 'desc');
		}
		return $this->db->get($table)->result_array();
	}

	function updateData($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	function insertData($table, $data){
		$this->db->insert($table, $data);
	}

	function deleteData($table, $where){
		$this->db->delete($table, $where);
	}
	
	function getMachineTime($user_id){
		$this->db->join('machine_time mt', 'mt.desktrack_userid = u.desktrack_user_id', 'inner');
		$res = $this->db->get_where('users u', array('u.user_id' => $user_id))->result_array();
		$ret = array();
		foreach ($res as $key => $value) {
			$ret[$value['date']] = $value['desktopTime'];
		}
		return $ret;
	}

	
}
?>