<?php 
Class Tasks_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('marketing', true);
	}

	function insertData($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function insertDataDB2($table, $data){
		$this->db2->insert($table, $data);
		return $this->db2->insert_id();
	}

	function updateData($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	function deleteData($table, $where){
		$this->db->delete($table, $where);
	}

	function getLookup($lookup_id){
		$this->db->order_by('lookup_value');
		return $this->db->get_where('lookup', array('lookup_group' => $lookup_id))->result_array();
	}

	function getData($table, $where=''){
		if($where != ''){
			$this->db->where($where);
		}
		return $this->db->get($table)->result_array();
	}

	function getTaskListData($start, $length, $search, $order, $dir){
		$this->db->select('t.*, a.name assigned_to_name, c.name created_by_name');
		$this->db->join('users c', 'c.user_id = t.created_by', 'inner');
		$this->db->join('users a', 'a.user_id = t.created_by', 'inner');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		/*foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$exp_arr = explode(',', $value);
				$this->db->where_in('EXPORTER_NAME', $exp_arr);
			} else if($key == 2 && $value != ''){
				$imp_arr = explode(',', $value);
				$this->db->where_in('IMPORTER_NAME', $imp_arr);
			} else if($key == 3 && $value != ''){
				$new_imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $new_imp_arr);
			} else if($key == 5 && $value != ''){
				$country_arr = explode(',', $value);
				$this->db->where_in('COUNTRY_OF_DESTINATION', $country_arr);
			}
		}*/
		if($search['datewise'] == 'open_tasks'){
			$this->db->where('t.status', 'Open');
		}else if($search['datewise'] == 'due_today'){
			$this->db->where("date_format(t.deadline, '%Y-%m-%d') = ", date('Y-m-d'));
			$this->db->where('t.status', 'Open');
		}else if($search['datewise'] == 'due_week'){
			$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			$this_week_sd = date("Y-m-d",$monday);
			$this_week_ed = date("Y-m-d",$sunday);

			$this->db->where("date_format(t.deadline, '%Y-%m-%d') >= ", $this_week_sd);
			$this->db->where("date_format(t.deadline, '%Y-%m-%d') <= ", $this_week_ed);
			$this->db->where('t.status', 'Open');
		}else if($search['datewise'] == 'overdue'){
			$this->db->where('t.deadline < ', date('Y-m-d'));
			$this->db->where('t.status', 'Open');
		}
		if($this->session->userdata('role') != 1){
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('tasks t')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			if($result[$key]['lead_id'] != '' || $result[$key]['lead_id'] != null){
				if($result[$key]['lead_source'] == 'main'){
					$this->db->select('client_name');
					$res = $this->db->get_where('clients', array('client_id' => $result[$key]['lead_id']))->row_array();
					$result[$key]['client_name'] = $res['client_name'];

					$res_mem = $this->db->get_where('members', array('member_id' => $result[$key]['member_id']))->row_array();
					$result[$key]['member_name'] = $res_mem['name'];
				}/*else if($result[$key]['lead_source'] == 'hetro leads'){
					$this->db->select('company_name');
					$res = $this->db->get_where('hetro_leads', array('lead_id' => $result[$key]['lead_id']))->row_array();
					$result[$key]['client_name'] = $res['company_name'];

					$res_mem = $this->db->get_where('hetro_lead_detail', array('lead_dtl_id' => $data['member_id']))->row_array();
					$result[$key]['member_name'] = $res_mem['member_name'];
				}*/else if($result[$key]['lead_source'] == 'primary'){
					$this->db2->select('importer_name');
					$res = $this->db2->get_where('lead_mst', array('lead_mst_id' => $result[$key]['lead_id']))->row_array();
					$result[$key]['client_name'] = $res['importer_name'];

					$res_mem = $this->db2->get_where('lead_detail', array('lead_dtl_id' => $result[$key]['member_id']))->row_array();
					$result[$key]['member_name'] = $res_mem['member_name'];
				}
			}
			$result[$key]['deadline'] = date('d M H:i a', strtotime($value['deadline']));
			if($value['assigned_to'] == $this->session->userdata('user_id')){
				$result[$key]['created_by_name'] = 'Self';
			}

			if($value['last_deadline'] == date('Y-m-d')){
				$result[$key]['status'] = 'Postponed';
			}
		}
		return $result;
	}

	function getTaskListCount($search){
		$this->db->select('t.*, a.name assigned_to_name, c.name created_by_name');
		$this->db->join('users c', 'c.user_id = t.created_by', 'inner');
		$this->db->join('users a', 'a.user_id = t.created_by', 'inner');
		/*foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$exp_arr = explode(',', $value);
				$this->db->where_in('EXPORTER_NAME', $exp_arr);
			} else if($key == 2 && $value != ''){
				$imp_arr = explode(',', $value);
				$this->db->where_in('IMPORTER_NAME', $imp_arr);
			} else if($key == 3 && $value != ''){
				$new_imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $new_imp_arr);
			} else if($key == 5 && $value != ''){
				$country_arr = explode(',', $value);
				$this->db->where_in('COUNTRY_OF_DESTINATION', $country_arr);
			}
		}*/
		if($this->session->userdata('role') != 1){
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('tasks t')->result_array();
		return sizeof($res);
	}

}