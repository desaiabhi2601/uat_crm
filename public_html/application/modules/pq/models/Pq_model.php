<?php 
Class PQ_model extends CI_Model{
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

	function getPQListPending($start, $length, $search, $order, $dir){
		$this->db->select("pq.*, ld.*, u.name, lt.type_name, lc.lookup_value country, lr.lookup_value region, cf.flag_name, lt.type_name, case when client_stage = 8 then 'Inquiry' when client_stage = 9 then 'Order' else ls.stage_name end as stage_name");
		$this->db->distinct();
		$this->db->join('pq_lead_detail ld', "pq.pq_client_id = ld.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
		$this->db->join('users u', 'u.user_id = pq.assigned_to', 'inner');
		$this->db->join('lead_type lt', 'lt.lead_type_id = pq.client_category', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = pq.client_stage', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = pq.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = pq.region', 'left');
		$this->db->join('country_flags cf', 'cf.country = lc.lookup_value', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);

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
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}

		$res = $this->db->get_where('pq_client pq', array('client_status' => 'pending'))->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;

			$this->db->select('connected_on, connect_mode, comments');
			$this->db->order_by('connect_id', 'desc');
			$last_contacted = $this->db->get_where('pq_lead_connects', array('lead_id' => $value['pq_client_id']))->row_array();

			if(!empty($last_contacted)){
				$date1 = date_create($last_contacted['connected_on']);
				$date2 = date_create(date('Y-m-d'));
				$diff_obj = date_diff($date1, $date2);
				$diff = $diff_obj->format("%a");

				if($diff < 8){
					$result[$key]['last_contacted'] = $diff.' days ago';
				}else if($diff < 30){
					$weeks = round($diff / 7);
					$result[$key]['last_contacted'] = $weeks.' weeks ago';
				}else if($diff < 365){
					$months = round($diff / 30);
					$result[$key]['last_contacted'] = $months.' months ago';
				}else if($diff > 365){
					$years = round($diff / 365);
					$result[$key]['last_contacted'] = $years.' years ago';
				}

				$result[$key]['comments'] = $last_contacted['comments'];
				$result[$key]['connect_mode'] = $last_contacted['connect_mode'];

			}else{
				$result[$key]['last_contacted'] = '';
				$result[$key]['comments'] = '';
				$result[$key]['connect_mode'] = '';
			}

			$members = $this->db->get_where('pq_lead_detail', array('lead_mst_id' => $value['pq_client_id']))->result_array();
			$member_count = $non_member_count = 0;
			$result[$key]['lead_dtl_id'] = $result[$key]['member_name'] = $result[$key]['email'] = $result[$key]['designation'] = $result[$key]['mobile'] = null;
			if(!empty($members)){
				foreach ($members as $mem) {
					if(strtolower($mem['main_buyer']) == 'yes' && $result[$key]['lead_dtl_id'] == null){
						$result[$key]['lead_dtl_id'] = $mem['lead_dtl_id'];
						$result[$key]['member_name'] = $mem['member_name'];
						$result[$key]['email'] = $mem['email'];
						$result[$key]['designation'] = $mem['designation'];
						$result[$key]['mobile'] = $mem['mobile'];
					}else{
						if($mem['member_name'] == '' && $mem['email'] == '' && $mem['mobile'] == ''){}else{
							if(strtolower($mem['other_member']) == 'y'){
								$non_member_count++;
							}else{
								$member_count++;
							}
						}
					}
				}
			}
			$result[$key]['member_count'] = $member_count;
			$result[$key]['non_member_count'] = $non_member_count;
		}
		return $result;
	}

	function getPQListPendingCount($search){
		$this->db->select("pq.*, ld.*, u.name, lt.type_name, lc.lookup_value country, lr.lookup_value region, cf.flag_name, lt.type_name, case when client_stage = 8 then 'Inquiry' when client_stage = 9 then 'Order' else ls.stage_name end as stage_name");
		$this->db->distinct();
		$this->db->join('pq_lead_detail ld', "pq.pq_client_id = ld.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
		$this->db->join('users u', 'u.user_id = pq.assigned_to', 'inner');
		$this->db->join('lead_type lt', 'lt.lead_type_id = pq.client_category', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = pq.client_stage', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = pq.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = pq.region', 'left');
		$this->db->join('country_flags cf', 'cf.country = lc.lookup_value', 'left');
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
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get_where('pq_client pq', array('client_status' => 'pending'))->result_array();
		return sizeof($res);
	}

	function getPQListApproved($start, $length, $search, $order, $dir){
		$this->db->select("pq.*, ld.*, u.name, lt.type_name, lc.lookup_value country, lr.lookup_value region, cf.flag_name, lt.type_name, case when client_stage = 8 then 'Inquiry' when client_stage = 9 then 'Order' else ls.stage_name end as stage_name");
		$this->db->distinct();
		$this->db->join('pq_lead_detail ld', "pq.pq_client_id = ld.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
		$this->db->join('users u', 'u.user_id = pq.assigned_to', 'inner');
		$this->db->join('lead_type lt', 'lt.lead_type_id = pq.client_category', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = pq.client_stage', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = pq.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = pq.region', 'left');
		$this->db->join('country_flags cf', 'cf.country = lc.lookup_value', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
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
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get_where('pq_client pq', array('client_status' => 'approved'))->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;

			$this->db->select('connected_on, connect_mode, comments');
			$this->db->order_by('connect_id', 'desc');
			$last_contacted = $this->db->get_where('pq_lead_connects', array('lead_id' => $value['pq_client_id']))->row_array();

			if(!empty($last_contacted)){
				$date1 = date_create($last_contacted['connected_on']);
				$date2 = date_create(date('Y-m-d'));
				$diff_obj = date_diff($date1, $date2);
				$diff = $diff_obj->format("%a");

				if($diff < 8){
					$result[$key]['last_contacted'] = $diff.' days ago';
				}else if($diff < 30){
					$weeks = round($diff / 7);
					$result[$key]['last_contacted'] = $weeks.' weeks ago';
				}else if($diff < 365){
					$months = round($diff / 30);
					$result[$key]['last_contacted'] = $months.' months ago';
				}else if($diff > 365){
					$years = round($diff / 365);
					$result[$key]['last_contacted'] = $years.' years ago';
				}

				$result[$key]['comments'] = $last_contacted['comments'];
				$result[$key]['connect_mode'] = $last_contacted['connect_mode'];

			}else{
				$result[$key]['last_contacted'] = '';
				$result[$key]['comments'] = '';
				$result[$key]['connect_mode'] = '';
			}

			$members = $this->db->get_where('pq_lead_detail', array('lead_mst_id' => $value['pq_client_id']))->result_array();
			$member_count = $non_member_count = 0;
			$result[$key]['lead_dtl_id'] = $result[$key]['member_name'] = $result[$key]['email'] = $result[$key]['designation'] = $result[$key]['mobile'] = null;
			if(!empty($members)){
				foreach ($members as $mem) {
					if(strtolower($mem['main_buyer']) == 'yes' && $result[$key]['lead_dtl_id'] == null){
						$result[$key]['lead_dtl_id'] = $mem['lead_dtl_id'];
						$result[$key]['member_name'] = $mem['member_name'];
						$result[$key]['email'] = $mem['email'];
						$result[$key]['designation'] = $mem['designation'];
						$result[$key]['mobile'] = $mem['mobile'];
					}else{
						if($mem['member_name'] == '' && $mem['email'] == '' && $mem['mobile'] == ''){}else{
							if(strtolower($mem['other_member']) == 'y'){
								$non_member_count++;
							}else{
								$member_count++;
							}
						}
					}
				}
			}
			$result[$key]['member_count'] = $member_count;
			$result[$key]['non_member_count'] = $non_member_count;
		}
		return $result;
	}

	function getPQListApprovedCount($search){
		$this->db->select("pq.*, ld.*, u.name, lt.type_name, lc.lookup_value country, lr.lookup_value region, cf.flag_name, lt.type_name, case when client_stage = 8 then 'Inquiry' when client_stage = 9 then 'Order' else ls.stage_name end as stage_name");
		$this->db->distinct();
		$this->db->join('pq_lead_detail ld', "pq.pq_client_id = ld.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
		$this->db->join('users u', 'u.user_id = pq.assigned_to', 'inner');
		$this->db->join('lead_type lt', 'lt.lead_type_id = pq.client_category', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = pq.client_stage', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = pq.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = pq.region', 'left');
		$this->db->join('country_flags cf', 'cf.country = lc.lookup_value', 'left');
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
			$this->db->where('assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get_where('pq_client pq', array('client_status' => 'approved'))->result_array();
		return sizeof($res);
	}

	function getPQClientData($pq_client_id){
		$this->db->select('pq.*, pqd.*');
		$this->db->join('pq_lead_detail pqd', 'pqd.lead_mst_id = pq.pq_client_id', 'left');
		return $this->db->get_where('pq_client pq', array('pq_client_id' => $pq_client_id))->result_array();
	}

	function getPQMembers($lead_mst_id, $type){
		$this->db->select('member_name, email, mobile, other_member, main_buyer');
		/*if($type == 'mem'){
			$this->db2->where("(other_member is null or other_member = '')");
		}else if($type == 'nonmem'){
			$this->db2->where('other_member', 'Y');
		}*/
		//$this->db->order_by('other_member');
		$this->db->order_by('lead_dtl_id');
		$res = $this->db->get_where('pq_lead_detail', array('lead_mst_id' => $lead_mst_id))->result_array();
		//echo $this->db2->last_query();
		$ret = array(); $skip = false;
		foreach ($res as $mem) {
			if($skip == false && strtolower($mem['main_buyer']) == 'yes'){
				$skip = true;
				continue;
			}else{
				$ret[] = $mem;
			}
		}
		return $ret;
	}

	function getActivities($pq_client_id){
		$this->db->select("*, case when activity_date = '1970-01-01' then '' else DATE_FORMAT(activity_date, '%d %b %y') end as activity_date, case when comments_date = '1970-01-01' then '' else DATE_FORMAT(comments_date, '%d %b %y') end as comments_date");
		$res = $this->db->get_where('pq_activity', array('pq_client_id' => $pq_client_id))->result_array();
		return $res;
	}
}