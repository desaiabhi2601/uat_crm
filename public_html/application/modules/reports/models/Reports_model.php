<?php 
class Reports_model extends CI_Model{

	function getSalesPerson(){
		$this->db->select('u.user_id, u.name');
		$this->db->distinct();
		$this->db->join('users u', 'cc.user_id = u.user_id', 'inner');
		return $this->db->get('client_connect cc')->result_array();
	}
	
	function getDailyTaskList($start, $length, $search, $order_by, $dir, $salesPerson){
		$this->db->select('dt.*,  dt.date contacted_date, DATE_FORMAT(dt.date, "%d-%b") date, u.name, mt.desktopTime, mt.IdleTime, mt.productivetime, mt.productivity_percentage');
		$this->db->join('users u', 'u.user_id = dt.user_id', 'inner');
		$this->db->join('machine_time mt', 'mt.date = dt.date and u.desktrack_user_id = mt.desktrack_userid', 'left');
		if($search != ''){
			$this->db->group_start();
			$this->db->where('u.name like', '%'.$search.'%');
			$this->db->or_where('dt.task_accomplished like', '%'.$search.'%');
			$this->db->or_where('dt.work_in_progress like', '%'.$search.'%');
			$this->db->or_where('dt.plan_for_tomorrow like', '%'.$search.'%');
			$this->db->or_where('mt.desktopTime like', '%'.$search.'%');
			$this->db->or_where('mt.IdleTime like', '%'.$search.'%');
			$this->db->or_where('mt.productivetime like', '%'.$search.'%');
			$this->db->or_where('mt.productivity_percentage like', '%'.$search.'%');
			$this->db->group_end();
		}
		if($salesPerson != ''){
			$this->db->where('u.user_id', $salesPerson);
		}

		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		$res = $this->db->get('daily_task_update dt')->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			$touch_points = $this->getTouchPointCounts($value['user_id'], $value['contacted_date']);
			$result[$key]['touch_points'] = $touch_points;
		}
		return $result;
	}

	function getDailyTaskListCount($search, $salesPerson){
		$this->db->select('dt.*, DATE_FORMAT(dt.date, "%d-%b") date, u.name, mt.desktopTime, mt.IdleTime, mt.productivetime, mt.productivity_percentage');
		$this->db->join('users u', 'u.user_id = dt.user_id', 'inner');
		$this->db->join('machine_time mt', 'mt.date = dt.date and u.desktrack_user_id = mt.desktrack_userid', 'left');
		if($search != ''){
			$this->db->group_start();
			$this->db->where('u.name like', '%'.$search.'%');
			$this->db->or_where('dt.task_accomplished like', '%'.$search.'%');
			$this->db->or_where('dt.work_in_progress like', '%'.$search.'%');
			$this->db->or_where('dt.plan_for_tomorrow like', '%'.$search.'%');
			$this->db->or_where('mt.desktopTime like', '%'.$search.'%');
			$this->db->or_where('mt.IdleTime like', '%'.$search.'%');
			$this->db->or_where('mt.productivetime like', '%'.$search.'%');
			$this->db->or_where('mt.productivity_percentage like', '%'.$search.'%');
			$this->db->group_end();
		}
		if($salesPerson != ''){
			$this->db->where('u.user_id', $salesPerson);
		}
		
		$res = $this->db->get('daily_task_update dt')->result_array();
		return sizeof($res);
	}
	
	function getTouchPointCounts($user_id, $date){
		$this->db->select('contact_mode, count(contact_mode) count');
		$this->db->where('user_id', $user_id);
		$this->db->where('contacted_on', $date);
		$this->db->group_by('contact_mode');
		return $this->db->get('client_connect')->result_array();
	}
}