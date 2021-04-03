<?php 
class Login_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('marketing', true);
	}

	function checkLogin($input){
		$this->db->select('u.user_id, name, username, email, role, m.module_controller, u.sub_users');
		$this->db->join('user_to_module um', 'u.user_id = um.user_id', 'left');
		$this->db->join('modules m', 'm.module_id = um.module_id', 'inner');
		$this->db->group_start();
		$this->db->where('username', $input['email']);
		$this->db->or_where('email', $input['email']);
		$this->db->group_end();
		$this->db->where('password', md5($input['password']));
		$res = $this->db->get('users u')->result_array();

		if(!empty($res)){
			$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $res[0]['user_id']));
			
			$this->db->order_by('log_id', 'desc');
			$this->db->limit(1);
			$ip_details = $this->db->get('ip_logs', array('user_id' => $res[0]['user_id']))->row_array();
			
			$ret = array();
			foreach ($res as $key => $value) {
				$ret['user_id'] = $value['user_id'];
				$ret['name'] = $value['name'];
				$ret['username'] = $value['username'];
				$ret['email'] = $value['email'];
				$ret['role'] = $value['role'];
				$ret['module'][] = $value['module_controller'];
				if(!empty($ip_details)){
					$ret['last_ip'] = $ip_details['ip_address'];
					$ret['last_login'] = $ip_details['login_time'];
				}else{
					$ret['last_ip'] = '';
					$ret['last_login'] = '';
				}
				$ret['current_ip'] = $_SERVER['REMOTE_ADDR'];
				$ret['current_login'] = date('Y-m-d H:i:s');
				$sub_users = $value['sub_users'];
			}

			if($sub_users != '' && $sub_users != null){
				$this->db->select('user_id, name');
				$this->db->where('user_id in ('.$sub_users.')');
				$ret['sub_users'] = $this->db->get('users')->result_array();
			}

			if($ret['role'] == 5){
				$this->db->select('source');
				$this->db->distinct();
				$sales_res = $this->db->get_where('hetro_leads', array('assigned_to' => $ret['user_id']))->result_array();
				$ret['sales_access'] = array();
				if(!empty($sales_res)){
					foreach ($sales_res as $key => $value) {
						$ret['sales_access'][] = strtolower($value['source']);
					}
				}

				$this->db2->select('data_category');
				$this->db2->distinct();
				$sales_res = $this->db2->get_where('lead_mst', array('assigned_to' => $ret['user_id']))->result_array();
				if(!empty($sales_res)){
					foreach ($sales_res as $key => $value) {
						$ret['sales_access'][] = strtolower($value['data_category']);
					}
				}
			}
			
			$data = array(
				'user_id'      =>  $res[0]['user_id'],
				'ip_address'   =>  $_SERVER['REMOTE_ADDR'],
				'login_time '  =>  date('Y-m-d H:i:s')
			);
			$this->db->insert('ip_logs', $data);
			//insert new ip
			return $ret;
		}else{
			return false;
		}
	}
//fetch old ip from db and insert ip
/*
	public function insertIp($id, $ip, $now)
    {
        $data = array(
            'user_id'      =>  $id,
            'ip_address'   =>  $ip,
            'login_time '  =>  $now
        );
        $this->db->insert('ip_logs', $data);
        $insert_id = $this->db->insert_id(); 
    }
    
    public function getipDetails($id)
    {
        $query = $this->db->query("SELECT * FROM ip WHERE user_id = '$id' ORDER BY login_time DESC");
        $result = $query->result_array();
        return $result;
    }    
	
*/
	function updatePassword($arr){
		$this->db->select('password');
		$res = $this->db->get_where('users', array('user_id' => $this->session->userdata('user_id')))->row_array();

		if($res['password'] == md5($arr['current_password'])){
			$this->db->update('users', array('password' => md5($arr['new_password'])), array('user_id' => $this->session->userdata('user_id')));
			return 1;
		}else{
			return 0;
		}
	}


	function verify_sub_user($current_id, $next_id){
		$row = $this->db->get_where('users', array('user_id' => $current_id))->row_array();
		$sub_users = explode(',', $row['sub_users']);
		if(in_array($next_id, $sub_users)){
			return true;
		}else{
			return false;
		}
	}

	function otherLogin($next_id){
		$this->db->select('u.user_id, name, username, email, role, m.module_controller, u.sub_users');
		$this->db->join('user_to_module um', 'u.user_id = um.user_id', 'left');
		$this->db->join('modules m', 'm.module_id = um.module_id', 'inner');
		$this->db->where('u.user_id', $next_id);
		$res = $this->db->get('users u')->result_array();

		if(!empty($res)){
			$this->db->update('users', array('last_login' => date('Y-m-d H:i:s')), array('user_id' => $res[0]['user_id']));
			
			$this->db->order_by('log_id', 'desc');
			$this->db->limit(1);
			$ip_details = $this->db->get('ip_logs', array('user_id' => $res[0]['user_id']))->row_array();
			
			$ret = array();
			foreach ($res as $key => $value) {
				$ret['user_id'] = $value['user_id'];
				$ret['name'] = $value['name'];
				$ret['username'] = $value['username'];
				$ret['email'] = $value['email'];
				$ret['role'] = $value['role'];
				$ret['module'][] = $value['module_controller'];
				if(!empty($ip_details)){
					$ret['last_ip'] = $ip_details['ip_address'];
					$ret['last_login'] = $ip_details['login_time'];
				}else{
					$ret['last_ip'] = '';
					$ret['last_login'] = '';
				}
				$ret['current_ip'] = $_SERVER['REMOTE_ADDR'];
				$ret['current_login'] = date('Y-m-d H:i:s');
				$sub_users = $value['sub_users'];
			}

			if($sub_users != '' && $sub_users != null){
				$this->db->select('user_id, name');
				$this->db->where('user_id in ('.$sub_users.')');
				$ret['sub_users'] = $this->db->get('users')->result_array();
			}

			if($ret['role'] == 5){
				$this->db->select('source');
				$this->db->distinct();
				$sales_res = $this->db->get_where('hetro_leads', array('assigned_to' => $ret['user_id']))->result_array();
				$ret['sales_access'] = array();
				if(!empty($sales_res)){
					foreach ($sales_res as $key => $value) {
						$ret['sales_access'][] = $value['source'];
					}
				}

				$this->db2->select('data_category');
				$this->db2->distinct();
				$sales_res = $this->db2->get_where('lead_mst', array('assigned_to' => $ret['user_id']))->result_array();
				if(!empty($sales_res)){
					foreach ($sales_res as $key => $value) {
						$ret['sales_access'][] = $value['data_category'];
					}
				}
			}
			
			$data = array(
				'user_id'      =>  $res[0]['user_id'],
				'ip_address'   =>  $_SERVER['REMOTE_ADDR'],
				'login_time '  =>  date('Y-m-d H:i:s')
			);
			$this->db->insert('ip_logs', $data);
			//insert new ip
			return $ret;
		}else{
			return false;
		}
	}
}
?>