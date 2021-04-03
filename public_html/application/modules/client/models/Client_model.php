<?php 
class Client_model extends CI_Model{
	function addClient($data){
		$this->db->insert('clients', $data);
		return $this->db->insert_id();
	}

	function updateClient($data, $where){
		$this->db->update('clients', $data, $where);
	}

	function getClients(){
		$this->db->select('client_id, client_name, l.lookup_value country');
		$this->db->join('lookup l', 'l.lookup_id = c.country', 'left');
		$this->db->order_by('client_name');
		return $this->db->get_where('clients c', array('status' => 'Y'))->result_array();
	}

	function searchClients($search){
		$this->db->select('client_id, client_name, origin, l.lookup_value country_name');
		$this->db->join('lookup l', 'l.lookup_id = c.country', 'left');
		$this->db->order_by('client_name');
		$this->db->where("client_name like '%".$search."%'");
		return $this->db->get_where('clients c', array('c.status' => 'Y'))->result_array();
	}

	function addClientMember($data){
		$this->db->insert('members', $data);
		return $this->db->insert_id();
	}

	function updateMember($data, $where){
		$this->db->update('members', $data, $where);
	}

	function getMembers($client_id){
		$this->db->select('m.member_id, m.name, l.lookup_value country');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('lookup l', 'l.lookup_id = c.country', 'left');
		$this->db->order_by('m.name');
		return $this->db->get_where('members m', array('m.status' => 'Y', 'm.client_id' => $client_id))->result_array();
	}

	function getClientList($start, $length, $search, $order_by, $dir){		
		$this->db->select('client_id, client_name company_name, l1.lookup_value country, l2.lookup_value region');
		$this->db->join('lookup l1', 'l1.lookup_id = c.country', 'left');
		$this->db->join('lookup l2', 'l2.lookup_id = c.region', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		if($search != ''){
			$this->db->group_start();
			$this->db->where('c.client_name like', '%'.$search.'%');
			$this->db->or_where('l1.lookup_value like', '%'.$search.'%');
			$this->db->or_where('l2.lookup_value like', '%'.$search.'%');
			$this->db->group_end();
		}
		$res = $this->db->get_where('clients c', array('status' => 'Y'))->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;

			$member = $this->db->get_where('members', array('client_id' => $result[$key]['client_id'], 'status' => 'Y'))->row_array();
			if(!empty($member)){
				$result[$key]['name'] = $member['name'];
				$result[$key]['email'] = $member['email'];
				$result[$key]['mobile'] = $member['mobile'];
				$result[$key]['telephone'] = $member['telephone'];
				$result[$key]['whatsapp'] = $member['whatsapp'];
			}else{
				$result[$key]['name'] = $result[$key]['email'] = $result[$key]['mobile'] = $result[$key]['telephone'] = $result[$key]['whatsapp'] = '';
			}
		}
		return $result;
	}

	function getClientListCount($search){
		$this->db->join('lookup l1', 'l1.lookup_id = c.country', 'left');
		$this->db->join('lookup l2', 'l2.lookup_id = c.region', 'left');
		if($search != ''){
			$this->db->group_start();
			$this->db->where('c.client_name like', '%'.$search.'%');
			$this->db->or_where('l1.lookup_value like', '%'.$search.'%');
			$this->db->or_where('l2.lookup_value like', '%'.$search.'%');
			$this->db->group_end();
		}
		$res = $this->db->get_where('clients c', array('status' => 'Y'))->result_array();
		return sizeof($res);
	}

	function getMemberList($start, $length, $search, $order_by, $dir){
		$this->db->select('m.*, c.*');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		if($search != ''){
			$this->db->group_start();
			$this->db->where('m.name like', '%'.$search.'%');
			$this->db->or_where('m.email like', '%'.$search.'%');
			$this->db->or_where('m.mobile like', '%'.$search.'%');
			$this->db->or_where('m.skype like', '%'.$search.'%');
			$this->db->or_where('m.telephone like', '%'.$search.'%');
			$this->db->or_where('c.client_name like', '%'.$search.'%');
			$this->db->group_end();
		}
		$res = $this->db->get_where('members m', array('m.status' => 'Y', 'c.status' => 'Y'))->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getMemberListCount($search){
		$this->db->select('m.*, c.*');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		if($search != ''){
			$this->db->group_start();
			$this->db->where('m.name like', '%'.$search.'%');
			$this->db->or_where('m.email like', '%'.$search.'%');
			$this->db->or_where('m.mobile like', '%'.$search.'%');
			$this->db->or_where('m.skype like', '%'.$search.'%');
			$this->db->or_where('m.telephone like', '%'.$search.'%');
			$this->db->or_where('c.client_name like', '%'.$search.'%');
			$this->db->group_end();
		}
		$res = $this->db->get_where('members m', array('m.status' => 'Y', 'c.status' => 'Y'))->result_array();
		return sizeof($res);
	}

	function getClientDetails($client_id){
		return $this->db->get_where('clients', array('client_id' => $client_id))->row_array();
	}

	function getClientMembers($client_id){
		return $this->db->get_where('members', array('client_id' => $client_id))->result_array();
	}

	function deleteClient($client_id){
		$this->db->delete('members', array('client_id' => $client_id));
		$this->db->delete('clients', array('client_id' => $client_id));
	}

	function deleteMember($member_id){
		$this->db->delete('members', array('member_id' => $member_id));
	}

	function insertData($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function updateData($table, $data, $where){
		$this->db->update($table, $data, $where);
	}

	function getConnectList($start, $end){
		$this->db->select("c.client_name, m.name as person_name, cc.*, DATE_FORMAT(cc.contacted_on, '%d-%b') connected_on");
		$this->db->join('clients c', 'c.client_id = cc.client_id');
		$this->db->join('members m', 'm.member_id = cc.member_id');
		if($start != ''){
			$this->db->where('contacted_on >= ', date('Y-m-d', strtotime($start)));
		}

		if($end != ''){
			$this->db->where('contacted_on <= ', date('Y-m-d', strtotime($end)));
		}
		$this->db->order_by('contacted_on', 'desc');
		return $this->db->get_where('client_connect cc', array('user_id' => $this->session->userdata('user_id')))->result_array();
	}

	function getConnectDetails($connect_id){
		$this->db->select("cc.*, DATE_FORMAT(cc.contacted_on, '%d-%m-%Y') contacted_on");
		return $this->db->get_where('client_connect cc', array('cc.connect_id' => $connect_id))->row_array();
	}

	function deleteConnect($connect_id){
		$this->db->delete('client_connect', array('connect_id' => $connect_id));
	}

	function getDayWiseCount($user_id=0){
		if($user_id == 0){
			$user_id = $this->session->userdata('user_id');
		}
		$this->db->select('contacted_on, count(connect_id) count');
		$this->db->group_by('contacted_on');
		return $this->db->get_where('client_connect', array('user_id' => $user_id, 'contact_mode != ' => 'No Touch Point'))->result_array();
	}

	function getDayWiseReason($user_id=0){
		if($user_id == 0){
			$user_id = $this->session->userdata('user_id');
		}
		$this->db->select('contacted_on, comments');
		return $this->db->get_where('client_connect', array('user_id' => $user_id, 'contact_mode' => 'No Touch Point'))->result_array();
	}

	function getPointList($start, $length, $search, $order_by, $dir, $salesPerson){
		$this->db->select('u.name username, c.client_name, m.name member_name, cc.*, DATE_FORMAT(cc.contacted_on, "%d-%b") contacted_on');
		$this->db->join('users u', 'u.user_id = cc.user_id', 'inner');
		$this->db->join('clients c', 'c.client_id = cc.client_id', 'left');
		$this->db->join('members m', 'm.member_id = cc.member_id', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		if($search != ''){
			$this->db->group_start();
			$this->db->where('u.name like', '%'.$search.'%');
			$this->db->or_where('c.client_name like', '%'.$search.'%');
			$this->db->or_where('m.name like', '%'.$search.'%');
			$this->db->or_where('cc.contact_mode like', '%'.$search.'%');
			$this->db->or_where('cc.email_sent like', '%'.$search.'%');
			$this->db->or_where('cc.comments like', '%'.$search.'%');
			$this->db->or_where('cc.contacted_on like', '%'.$search.'%');
			$this->db->group_end();
		}

		if($salesPerson != ''){
			$this->db->where('cc.user_id', $salesPerson);
		}

		$res = $this->db->get('client_connect cc')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getPointListCount($search, $salesPerson){
		$this->db->select('u.name username, c.client_name, m.name member_name, cc.*');
		$this->db->join('users u', 'u.user_id = cc.user_id', 'inner');
		$this->db->join('clients c', 'c.client_id = cc.client_id', 'left');
		$this->db->join('members m', 'm.member_id = cc.member_id', 'left');
		if($search != ''){
			$this->db->group_start();
			$this->db->where('u.name like', '%'.$search.'%');
			$this->db->or_where('c.client_name like', '%'.$search.'%');
			$this->db->or_where('m.name like', '%'.$search.'%');
			$this->db->or_where('cc.contact_mode like', '%'.$search.'%');
			$this->db->or_where('cc.email_sent like', '%'.$search.'%');
			$this->db->or_where('cc.comments like', '%'.$search.'%');
			$this->db->or_where('cc.contacted_on like', '%'.$search.'%');
			$this->db->group_end();
		}

		if($salesPerson != ''){
			$this->db->where('cc.user_id', $salesPerson);
		}
		
		$res = $this->db->get('client_connect cc')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return sizeof($result);
	}

	function getPerformanceCount($user_id){
		if($user_id == 0){
			$user_id = $this->session->userdata('user_id');
		}

		$this->db->select('contacted_on, user_id');
		$this->db->distinct();
		$user_monthly_days = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'month(contacted_on)' => date('m'), 'user_id' => $user_id))->num_rows();

		$this->db->select('contacted_on, user_id');
		$this->db->distinct();
		$user_total_days = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'user_id' => $user_id))->num_rows();

		$this->db->select('contacted_on, user_id');
		$this->db->distinct();
		$team_monthly_days = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'month(contacted_on)' => date('m')))->num_rows();

		$this->db->select('contacted_on, user_id');
		$this->db->distinct();
		$team_total_days = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point'))->num_rows();
		
		$user_total_connects = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'user_id' => $user_id))->num_rows();

		$user_monthly_connects = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'user_id' => $user_id, 'month(contacted_on)' => date('m')))->num_rows();

		$team_total_connects = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point'))->num_rows();

		$team_monthly_connects = $this->db->get_where('client_connect', array('contact_mode != ' => 'No Touch Point', 'month(contacted_on)' => date('m')))->num_rows();

		if($user_monthly_days == 0){
			$user_monthly_days = 1;	
		}

		if($team_monthly_days == 0){
			$team_monthly_days = 1;	
		}

		$ret = array(
			'user_monthly_avg' => round($user_monthly_connects / $user_monthly_days),
			'user_total_avg' => round($user_total_connects / $user_total_days),
			'user_monthly_connects' => $user_monthly_connects,
			'user_total_connects' => $user_total_connects,
			'team_monthly_avg' => round($team_monthly_connects / $team_monthly_days),
			'team_total_avg' => round($team_total_connects / $team_total_days),
			'team_monthly_connects' => $team_monthly_connects,
			'team_total_connects' => $team_total_connects,
		);

		foreach ($ret as $key => $value) {
			if(is_nan($value)){
				$ret[$key] = 0;
			}
		}

		return $ret;
	}

	function getEntryDates($user_id){
		$this->db->select('contacted_on');
		$this->db->distinct();
		$res = $this->db->get_where('client_connect', array('user_id' => $user_id))->result_array();
		$ret = array();
		foreach ($res as $key => $value) {
			$ret[] = $value['contacted_on'];
		}
		return $ret;
	}

	function getTouchPointCounts($user_id = 0){
		if($user_id == 0){
			$user_id = $this->session->userdata('user_id');
		}

		$this->db->select('contact_mode, count(contact_mode) count');
		$this->db->where('user_id', $user_id);
		$this->db->where('contacted_on', date('Y-m-d'));
		$this->db->group_by('contact_mode');
		return $this->db->get('client_connect')->result_array();
	}

	function getSalesPerson(){
		$this->db->select('u.user_id, u.name');
		$this->db->distinct();
		$this->db->join('users u', 'cc.user_id = u.user_id', 'inner');
		return $this->db->get('client_connect cc')->result_array();
	}
}
?>