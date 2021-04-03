<?php 
Class Leads_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('marketing', true);
	}

	function getLeadsList($start, $length, $search, $order, $dir){
		$this->db->select('l.LEAD_ID, l.COUNTRY_OF_DESTINATION COUNTRY, l.EXPORTER_NAME, l.IMPORTER_NAME, l.NEW_IMPORTER_NAME, l.FOB_VALUE_INR, l.COUNTRY_OF_DESTINATION, ld.no_of_employees');
		$this->db->distinct();
		$this->db->join('lead_details ld', 'l.NEW_IMPORTER_NAME = ld.new_importer_name', 'left');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		foreach ($search as $key => $value) {
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
		}
		$res = $this->db->get('fuzzy_matched_level1 l')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getLeadsListCount($search){
		$this->db->select('l.LEAD_ID, l.EXPORTER_NAME, l.IMPORTER_NAME, l.NEW_IMPORTER_NAME, l.FOB_VALUE_INR, l.COUNTRY_OF_DESTINATION, ld.no_of_employees');
		$this->db->distinct();
		$this->db->join('lead_details ld', 'l.NEW_IMPORTER_NAME = ld.new_importer_name', 'left');
		foreach ($search as $key => $value) {
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
		}
		$res = $this->db->get('fuzzy_matched_level1 l')->result_array();
		return sizeof($res);
	}

	function getUniqueData($column, $search = ''){
		if(is_array($search)){
			if($search[1] != ''){
				$arr = explode(',', $search[1]);
				$this->db->where_in('EXPORTER_NAME', $arr);
			}

			if($search[2] != ''){
				$arr = explode(',', $search[2]);
				$this->db->where_in('IMPORTER_NAME', $arr);
			}

			if($search[3] != ''){
				$arr = explode(',', $search[3]);
				$this->db->where_in('NEW_IMPORTER_NAME', $arr);
			}

			if($search[5] != ''){
				$arr = explode(',', $search[5]);
				$this->db->where_in('COUNTRY_OF_DESTINATION', $arr);
			}
		}
		$this->db->select($column);
		$this->db->distinct();
		$this->db->order_by($column);
		return $this->db->get('fuzzy_matched_level1')->result_array();
	}

	function getRecordData($type, $arg1, $arg2=''){
		switch($type){
			case 1:
				$this->db->select('IMPORTER_NAME, LEAD_ID');
				$this->db->where_in('lead_id', $arg1);
				break;

			case 2:
				$this->db->select('NEW_IMPORTER_NAME');
				$this->db->distinct();
				$this->db->where('EXPORTER_NAME', $arg1);
				$this->db->where('NEW_IMPORTER_NAME', $arg2);
				break;

			case 3:
				$this->db->select('NEW_IMPORTER_NAME');
				$this->db->distinct();
				$this->db->where_in('NEW_IMPORTER_NAME', $arg1);
				break;
		}
		
		return $this->db->get('fuzzy_matched_level1')->result_array();
	}

	function updateImporterName($type, $new_imp_name, $ids){
		switch($type){
			case 1:
				$this->db->where_in('lead_id', $ids);
				$this->db->update('fuzzy_matched_level1', array('NEW_IMPORTER_NAME' => $new_imp_name));
				break;

			case 2:
				foreach ($ids as $value) {
					$arr = explode("/", $value);
					$this->db->where('EXPORTER_NAME', $arr[0]);
					$this->db->where('NEW_IMPORTER_NAME', $arr[1]);
					$this->db->update('fuzzy_matched_level1', array('NEW_IMPORTER_NAME' => $new_imp_name));
				}
				break;

			case 3: 
				$this->db->where_in('NEW_IMPORTER_NAME', $ids);
				$this->db->update('fuzzy_matched_level1', array('NEW_IMPORTER_NAME' => $new_imp_name));
				break;
		}
	}

	function getExpImpLeadsList($start, $length, $search, $order, $dir){
		$this->db->select('EXPORTER_NAME, NEW_IMPORTER_NAME, sum(FOB_VALUE_INR) FOB_VALUE_INR');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$this->db->group_by('EXPORTER_NAME, NEW_IMPORTER_NAME');
		foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$exp_arr = explode(',', $value);
				$this->db->where_in('EXPORTER_NAME', $exp_arr);
			} else if($key == 2 && $value != ''){
				$imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $imp_arr);
			}
		}
		$res = $this->db->get('fuzzy_matched_level1')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getExpImpLeadsListCount($search){
		$this->db->select('EXPORTER_NAME, NEW_IMPORTER_NAME, sum(FOB_VALUE_INR) FOB_VALUE_INR');
		$this->db->group_by('EXPORTER_NAME, NEW_IMPORTER_NAME');
		foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$exp_arr = explode(',', $value);
				$this->db->where_in('EXPORTER_NAME', $exp_arr);
			} else if($key == 2 && $value != ''){
				$imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $imp_arr);
			}
		}
		$res = $this->db->get('fuzzy_matched_level1')->result_array();
		return sizeof($res);
	}

	function getImpLeadsList($start, $length, $search, $order, $dir){
		$this->db->select('NEW_IMPORTER_NAME, sum(FOB_VALUE_INR) FOB_VALUE_INR');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$this->db->group_by('NEW_IMPORTER_NAME');
		foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$new_imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $new_imp_arr);
			}
		}
		$res = $this->db->get('fuzzy_matched_level1')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getImpLeadsListCount($search){
		$this->db->select('NEW_IMPORTER_NAME, sum(FOB_VALUE_INR) FOB_VALUE_INR');
		$this->db->group_by('NEW_IMPORTER_NAME');
		foreach ($search as $key => $value) {
			if($key == 1 && $value != ''){
				$new_imp_arr = explode(',', $value);
				$this->db->where_in('NEW_IMPORTER_NAME', $new_imp_arr);
			}
		}
		$res = $this->db->get('fuzzy_matched_level1')->result_array();
		return sizeof($res);
	}


	function getDetails($nimp_name){
		return $this->db->get_where('lead_details', array('new_importer_name' => $nimp_name))->row_array();
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

	function insertDataDB2($table, $data){
		$this->db2->insert($table, $data);
		return $this->db2->insert_id();
	}

	function updateDataDB2($table, $data, $where){
		$this->db2->update($table, $data, $where);
	}

	function deleteDataDB2($table, $where){
		$this->db2->delete($table, $where);
	}

	function getData($table, $where=''){
		if($where != ''){
			$this->db->where($where);
		}
		if($table == 'lead_connects'){
			$this->db->order_by('connected_on', 'desc');
		}
		return $this->db->get($table)->result_array();
	}

	function getDataDB2($table, $where=''){
		if($where != ''){
			$this->db2->where($where);
		}
		if($table == 'lead_connects'){
			$this->db2->order_by('connected_on', 'desc');
		}
		return $this->db2->get($table)->result_array();
	}

	function getLookup($lookup_id){
		$this->db->order_by('lookup_value');
		return $this->db->get_where('lookup', array('lookup_group' => $lookup_id))->result_array();
	}

	function getLeadDetails($lead_id){
		/*$this->db->join('hetro_lead_detail hld', 'hl.lead_id = hld.lead_id', 'left');
		return $this->db->get_where('hetro_leads hl', array('hl.lead_id' => $lead_id))->result_array();*/

		$this->db->join('hetro_lead_detail hld', 'hl.client_id = hld.lead_id', 'left');
		return $this->db->get_where('clients hl', array('hl.client_id' => $lead_id))->result_array();
	}

	function getSources(){
		$this->db->select('source');
		$this->db->distinct();
		$this->db->where('source is not null');
		return $this->db->get('clients')->result_array();
		/*return $this->db->get('hetro_leads')->result_array();*/
	}

	function getHetroLeadsList($start, $length, $search, $order, $dir, $type){
		$this->db->select('hl.*, hld.*, hl.client_id, lc.lookup_value country, lr.lookup_value region, lt.type_name, ls.stage_name, u.name');
		$this->db->distinct();
		$this->db->join('hetro_lead_detail hld', "hl.client_id = hld.lead_id and hld.main_buyer = 'Yes'", 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = hl.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = hl.region', 'left');
		$this->db->join('lead_type lt', 'lt.lead_type_id = hl.lead_type', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = hl.lead_stage', 'left');
		$this->db->join('users u', 'u.user_id = hl.assigned_to', 'inner');
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		foreach ($search as $key => $value) {
			if($key == 'company_name' && $value != ''){
				$this->db->where("hl.client_name like '%".addslashes($value)."%'");
			} else if($key == 'country' && $value != ''){
				$this->db->where("hl.country", $value);
			} else if($key == 'email' && $value != ''){
				$this->db->where("hld.email", $value);
			} else if($key == 'member_name' && $value != ''){
				$this->db->where("hld.member_name like '%".$value."%'");
			} else if($key == 'lead_type' && $value != ''){
				$this->db->where("hl.lead_type", $value);
			} else if($key == 'lead_stage' && $value != ''){
				$this->db->where("hl.lead_stage", $value);
			} else if($key == 'assigned_to' && $value != ''){
				$this->db->where("hl.assigned_to", $value);
			}
		}

		if($type != ''){
			$this->db->where('hl.source', str_replace('%20', ' ', $type));
		}

		if($this->session->userdata('role') == 5){
			$this->db->where('hl.assigned_to', $this->session->userdata('user_id'));
		}

		//$this->db->where('hl.origin', 'Hetro');
		$this->db->where('hl.deleted is null');
		$res = $this->db->get('clients hl')->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			$result[$key]['flag_name'] = '';

			$flag_arr = $this->db2->get_where('country_flags', array('country' => $value['country']))->row_array();
			if(!empty($flag_arr)){
				$result[$key]['flag_name'] = $flag_arr['flag_name'];
			}

			$this->db->select('connected_on, connect_mode, comments');
			$this->db->order_by('connect_id', 'desc');
			$last_contacted = $this->db->get_where('lead_connects', array('lead_id' => $value['client_id']))->row_array();

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

			$members = $this->db->get_where('hetro_lead_detail', array('lead_id' => $value['lead_id']))->result_array();
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

	function getHetroLeadsListCount($search, $type){
		$this->db->select('hl.*, hld.*, hl.client_id, lc.lookup_value country, lr.lookup_value region, lt.type_name, ls.stage_name, u.name');
		$this->db->distinct();
		$this->db->join('hetro_lead_detail hld', "hl.client_id = hld.lead_id and hld.main_buyer = 'Yes'", 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = hl.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = hl.region', 'left');
		$this->db->join('lead_type lt', 'lt.lead_type_id = hl.lead_type', 'left');
		$this->db->join('lead_stages ls', 'ls.lead_stage_id = hl.lead_stage', 'left');
		$this->db->join('users u', 'u.user_id = hl.assigned_to', 'left');
		foreach ($search as $key => $value) {
			if($key == 'company_name' && $value != ''){
				$this->db->where("hl.client_name like '%".addslashes($value)."%'");
			} else if($key == 'country' && $value != ''){
				$this->db->where("hl.country", $value);
			} else if($key == 'email' && $value != ''){
				$this->db->where("hld.email", $value);
			} else if($key == 'member_name' && $value != ''){
				$this->db->where("hld.member_name like '%".$value."%'");
			} else if($key == 'lead_type' && $value != ''){
				$this->db->where("hl.lead_type", $value);
			} else if($key == 'lead_stage' && $value != ''){
				$this->db->where("hl.lead_stage", $value);
			} else if($key == 'assigned_to' && $value != ''){
				$this->db->where("hl.assigned_to", $value);
			}
		}

		if($type != ''){
			$this->db->where('hl.source', str_replace('%20', ' ', $type));
		}

		if($this->session->userdata('role') == 5){
			$this->db->where('hl.assigned_to', $this->session->userdata('user_id'));
		}
		
		//$this->db->where('hl.origin', 'Hetro');
		$this->db->where('hl.deleted is null');
		$res = $this->db->get('clients hl')->result_array();
		return sizeof($res);
	}

	function getDistinctHetroData($column, $type){
		if($type != ''){
			$this->db->where('hl.source', str_replace('%20', ' ', $type));
		}

		if($column == 'country'){
			$this->db->select('l.lookup_id id, l.lookup_value value');
			$this->db->join('lookup l', 'l.lookup_id = hl.country', 'inner');
		} else if($column == 'region'){
			$this->db->select('l.lookup_id id, l.lookup_value value');
			$this->db->join('lookup l', 'l.lookup_id = hl.region', 'inner');
		} else if($column == 'type'){
			$this->db->select('lt.lead_type_id id, lt.type_name value');
			$this->db->join('lead_type lt', 'lt.lead_type_id = hl.lead_type', 'inner');
		} else if($column == 'stage'){
			$this->db->select('s.lead_stage_id id, s.stage_name value');
			$this->db->join('lead_stages s', 's.lead_stage_id = hl.lead_stage', 'inner');
		}
		$this->db->distinct();
		$this->db->order_by('value');

		return $this->db->get('hetro_leads hl')->result_array();
	}

	function getPrimaryLeadsList($start, $length, $search, $order, $dir, $category){
		if(strtolower($category) == 'tubes'){
			$this->db2->select('ct.*, DATE_FORMAT(ct.LAST_PURCHASED, "%b-%y") LAST_PURCHASED, ti.IMP_ID, lm.*, ld.*, cf.flag_name, lm.lead_mst_id');
			$this->db2->join('tubes_importer_id ti', 'ti.IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$this->db2->join('lead_mst lm', "lm.imp_id = ti.IMP_ID and lm.data_category = '".strtoupper($category)."'", 'left');
			$this->db2->join('lead_detail ld', "ld.lead_mst_id = lm.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
			$this->db2->join('country_flags cf', 'cf.country = ct.COUNTRY_OF_DESTINATION', 'left');
			$this->db2->limit($length, $start);
			$this->db2->order_by($order, $dir);
			$this->db2->where('deleted is null');
			$res = $this->db2->get('competitor_ranks_tube ct')->result_array();	
		}else if(strtolower($category) == 'pipes'){
			$ass_to = "";
			if($this->session->userdata('role') == 5){
				$ass_to = " and assigned_to = ".$this->session->userdata('user_id');
			}
			$this->db2->select('ct.*, DATE_FORMAT(ct.LAST_PURCHASED, "%b-%y") LAST_PURCHASED, ti.IMP_ID, lm.*, ld.*, cf.flag_name, lm.lead_mst_id');
			$this->db2->join('pipes_importer_id ti', 'ti.IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$this->db2->join('lead_mst lm', "lm.imp_id = ti.IMP_ID and lm.data_category = '".strtoupper($category)."'".$ass_to, 'left');
			$this->db2->join('lead_detail ld', "ld.lead_mst_id = lm.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
			$this->db2->join('country_flags cf', 'cf.country = ct.COUNTRY_OF_DESTINATION', 'left');
			$this->db2->limit($length, $start);
			$this->db2->order_by($order, $dir);
			$this->db2->where('deleted is null');
			$res = $this->db2->get('competitor_ranks_pipe ct')->result_array();
			//echo $this->db2->last_query();exit;
		}

		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$img = '';
			$lead_type = $this->db->get_where('lead_type', array('lead_type_id' => $result[$key]['lead_type']))->row_array();
			if($value['flag_name'] != ''){
				$img = '<img src="/assets/media/flags/'.$value['flag_name'].'" class="img img-responsive rounded-circle" style="width: 30px">';
			}
			$lead_name = '<div class="row">
				<div class="col-7">
					<p>'.$img.' 
						<strong style="margin-left: 5px;" class="imported">'.$result[$key]['NEW_IMPORTER_NAME'].'</strong> 
						<span style="font-weight: lighter;" class="company_type">'.$lead_type['type_name'].'</span>
						<span style="margin-left: 5px; font-weight: lighter;" class="last-purchased">'.$value['LAST_PURCHASED'].'</span>
					</p>
				</div>';

			if($this->session->userdata('user_id') == 1){
				$lead_name .= '<div class="col-3">'.number_format($value['IMPORTER_TOTAL'], 2).'</div>';
			}
				
			$lead_name .= '<div class="col-2">
					<a target="_blank" href="'.site_url('leads/addPrimaryLeadDetails/'.$value['IMP_ID'].'/'.$category).'" class="btn btn-sm btn-clean btn-icon btn-icon-md pull-right" ><i class="la la-info-circle"></i></a>
					<button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md lead_connect pull-right" title="Contact" member_id="'.$value['lead_dtl_id'].'" ><i class="la la-comment"></i></button>
				</div>
			</div>';
			$result[$key]['lead_name'] = $lead_name;
			$result[$key]['record_id'] = ++$k;

			$this->db2->select('group_concat(lead_dtl_id) member_ids');
			$this->db2->group_by('lead_dtl_id');
			$members = $this->db2->get_where('lead_detail', array('lead_mst_id' => $value['lead_mst_id']))->row_array();
			
			$this->db2->select('connected_on, connect_mode, comments');
			$this->db2->order_by('connect_id', 'desc');
			$this->db2->group_start();
			$this->db2->where('lead_id', $value['lead_mst_id']);
			$this->db2->or_where('member_id in '.$members);
			$this->db2->group_end();
			$last_contacted = $this->db2->get('lead_connects')->row_array();
			if($value['lead_mst_id'] == 5724){
				echo $this->db2->last_query();
			}
			
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

		}
		return $result;
	}

	function getPrimaryLeadsListCount($search, $category){
		if(strtolower($category) == 'tubes'){
			$this->db2->select('ct.*, DATE_FORMAT(ct.LAST_PURCHASED, "%b-%y") LAST_PURCHASED, ti.IMP_ID, lm.*, ld.*, cf.flag_name');
			$this->db2->where('data_category', strtoupper($category));
			$this->db2->join('tubes_importer_id ti', 'ti.IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$this->db2->join('lead_mst lm', "lm.imp_id = ti.IMP_ID and lm.data_category = '".strtoupper($category)."'", 'left');
			$this->db2->join('lead_detail ld', "ld.lead_mst_id = lm.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
			$this->db2->join('country_flags cf', 'cf.country = ct.COUNTRY_OF_DESTINATION', 'left');
			$this->db2->where('deleted is null');
			$res = $this->db2->get('competitor_ranks_tube ct')->result_array();	
		}else if(strtolower($category) == 'pipes'){
			$ass_to = "";
			if($this->session->userdata('role') == 5){
				$ass_to = " and assigned_to = ".$this->session->userdata('user_id');
			}
			$this->db2->select('ct.*, DATE_FORMAT(ct.LAST_PURCHASED, "%b-%y") LAST_PURCHASED, ti.IMP_ID, lm.*, ld.*, cf.flag_name');
			$this->db2->where('data_category', strtoupper($category));
			$this->db2->join('pipes_importer_id ti', 'ti.IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$this->db2->join('lead_mst lm', "lm.imp_id = ti.IMP_ID and lm.data_category = '".strtoupper($category)."'".$ass_to, 'left');
			$this->db2->join('lead_detail ld', "ld.lead_mst_id = lm.lead_mst_id and ld.main_buyer = 'Yes'", 'left');
			$this->db2->join('country_flags cf', 'cf.country = ct.COUNTRY_OF_DESTINATION', 'left');
			$this->db2->where('deleted is null');
			$res = $this->db2->get('competitor_ranks_pipe ct')->result_array();
		}
		return sizeof($res);
	}

	function getPrimaryLeadDetails($imp_id, $category){
		if($category == 'tubes'){
			$this->db2->select('lm.*, ld.*, ti.NEW_IMPORTER_NAME, lm.lead_mst_id, ti.IMP_ID');
			$this->db2->join('lead_mst lm', 'ti.imp_id = lm.imp_id', 'left');
			$this->db2->join('lead_detail ld', 'lm.lead_mst_id = ld.lead_mst_id', 'left');
			$this->db2->where('lm.data_category', $category);
			$this->db2->where('lm.deleted is null');
			$res = $this->db2->get_where('tubes_importer_id ti', array('ti.imp_id' => $imp_id))->result_array();

			$this->db2->join('tubes_importer_id ti', 'ti.NEW_IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$country_res = $this->db2->get_where('competitor_ranks_tube ct', array('ti.imp_id' => $imp_id))->row_array();
			$res[0]['country'] = $country_res['COUNTRY_OF_DESTINATION'];
			return $res;
		}else if($category == 'pipes'){
			$this->db2->select('lm.*, ld.*, ti.IMPORTER_NAME, lm.lead_mst_id, ti.IMP_ID');
			$this->db2->join('lead_mst lm', 'ti.imp_id = lm.imp_id', 'left');
			$this->db2->join('lead_detail ld', 'lm.lead_mst_id = ld.lead_mst_id', 'left');
			$this->db2->where('lm.data_category', $category);
			$this->db2->where('lm.deleted is null');
			$res = $this->db2->get_where('pipes_importer_id ti', array('ti.imp_id' => $imp_id))->result_array();

			$this->db2->join('pipes_importer_id ti', 'ti.IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$country_res = $this->db2->get_where('competitor_ranks_pipe ct', array('ti.imp_id' => $imp_id))->row_array();
			$res[0]['country'] = $country_res['COUNTRY_OF_DESTINATION'];
			return $res;
		}else if($category == 'process control'){
			$this->db2->select('lm.*, ld.*, ti.NEW_IMPORTER_NAME, lm.lead_mst_id, ti.IMP_ID');
			$this->db2->join('lead_mst lm', 'ti.imp_id = lm.imp_id', 'left');
			$this->db2->join('lead_detail ld', 'lm.lead_mst_id = ld.lead_mst_id', 'left');
			$this->db2->where('lm.data_category', $category);
			$this->db2->where('lm.deleted is null');
			$res = $this->db2->get_where('Process_control_importer_id ti', array('ti.imp_id' => $imp_id))->result_array();

			$this->db2->join('Process_control_importer_id ti', 'ti.NEW_IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$country_res = $this->db2->get_where('competitor_ranks_Process_control ct', array('ti.imp_id' => $imp_id))->row_array();
			$res[0]['country'] = $country_res['COUNTRY_OF_DESTINATION'];
			return $res;
		}else if($category == 'tubing'){
			$this->db2->select('lm.*, ld.*, ti.NEW_IMPORTER_NAME, lm.lead_mst_id, ti.IMP_ID');
			$this->db2->join('lead_mst lm', 'ti.imp_id = lm.imp_id', 'left');
			$this->db2->join('lead_detail ld', 'lm.lead_mst_id = ld.lead_mst_id', 'left');
			$this->db2->where('lm.data_category', $category);
			$this->db2->where('lm.deleted is null');
			$res = $this->db2->get_where('tubing_importer_id ti', array('ti.imp_id' => $imp_id))->result_array();

			$this->db2->join('tubing_importer_id ti', 'ti.NEW_IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$country_res = $this->db2->get_where('competitor_ranks_tubing ct', array('ti.imp_id' => $imp_id))->row_array();
			$res[0]['country'] = $country_res['COUNTRY_OF_DESTINATION'];
			return $res;
		}else if($category == 'hammer union'){
			$this->db2->select('lm.*, ld.*, ti.NEW_IMPORTER_NAME, lm.lead_mst_id, ti.IMP_ID');
			$this->db2->join('lead_mst lm', 'ti.imp_id = lm.imp_id', 'left');
			$this->db2->join('lead_detail ld', 'lm.lead_mst_id = ld.lead_mst_id', 'left');
			$this->db2->where('lm.data_category', $category);
			$this->db2->where('lm.deleted is null');
			$res = $this->db2->get_where('hammer_union_importer_id ti', array('ti.imp_id' => $imp_id))->result_array();

			$this->db2->join('hammer_union_importer_id ti', 'ti.NEW_IMPORTER_NAME = ct.NEW_IMPORTER_NAME', 'inner');
			$country_res = $this->db2->get_where('competitor_ranks_hammer_union ct', array('ti.imp_id' => $imp_id))->row_array();
			$res[0]['country'] = $country_res['COUNTRY_OF_DESTINATION'];
			return $res;
		}
	}

	function getPrimaryListData($start, $length, $search, $order, $dir, $category){
		$this->db2->select('lm.*, cf.flag_name, DATE_FORMAT(lm.LAST_PURCHASED, "%b-%y") LAST_PURCHASED, pf1.factor_value factor_value1, pf2.factor_value factor_value2, pf3.factor_value factor_value3,');
		$this->db2->join('country_flags cf', 'cf.country = lm.COUNTRY_OF_DESTINATION', 'left');
		$this->db2->join('purchase_factors pf1', 'pf1.factor_id = lm.purchase_factor_1', 'left');
		$this->db2->join('purchase_factors pf2', 'pf2.factor_id = lm.purchase_factor_2', 'left');
		$this->db2->join('purchase_factors pf3', 'pf3.factor_id = lm.purchase_factor_3', 'left');
		$this->db2->limit($length, $start);
		$this->db2->order_by($order, $dir);
		$this->db2->where('lm.deleted is null');
		if($search['IMPORTER_NAME'] != ''){
			$this->db2->where("lm.IMPORTER_NAME like '%".$search['IMPORTER_NAME']."%'");
		}

		if($search['lead_type'] != '' && $search['lead_type'] != 'blank'){
			$this->db2->where('lm.lead_type', $search['lead_type']);
		}elseif ($search['lead_type'] == 'blank') {
			$this->db2->where('lm.lead_type = 0');
		}

		if($search['lead_stage'] != ''){
			$this->db2->where('lm.lead_stage', $search['lead_stage']);
		}elseif ($search['lead_stage'] == 'blank') {
			$this->db2->where('lm.lead_stage = 0');
		}

		if($search['COUNTRY_OF_DESTINATION'] != ''){
			$this->db2->where('lm.COUNTRY_OF_DESTINATION', $search['COUNTRY_OF_DESTINATION']);
		}

		if($search['assigned_to'] != ''){
			$this->db2->where('lm.assigned_to', $search['assigned_to']);
		}

		if($this->session->userdata('role') == 5){
			$this->db2->where('lm.assigned_to', $this->session->userdata('user_id'));
		}
		$this->db2->where('deleted is null');
		$this->db2->where('imp_id > ', 0);
		$res = $this->db2->get_where('lead_mst lm', array('lm.data_category' => $category))->result_array();
		//echo $this->db2->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['data_category'] = strtolower($value['data_category']);
			$result[$key]['record_id'] = ++$k;
			$lead_type = $this->db->get_where('lead_type', array('lead_type_id' => $result[$key]['lead_type']))->row_array();
			if(!empty($lead_type)){
				$result[$key]['lead_type'] = $lead_type['type_name'];
			}else{
				$result[$key]['lead_type'] = '';
			}


			$this->db2->order_by('FOB_VALUE_INR', 'desc');
			$hs_arr = $this->db2->get_where('hs_buy_percent', array('NEW_IMPORTER_NAME' => $value['IMPORTER_NAME'], 'product' => $category))->result_array();
			if(!empty($hs_arr)){
				
				$hs_graph = array();
				$colors = array('#660033', '#CC6633', '#CCFFFF', '#996600', '#DCEDC8', '#CFD8DC', '#E91E63');
				foreach ($hs_arr as $hs_key => $hs_value) {
					if(round($hs_value['FOB_VALUE_INR']) > 0){
						$bg_color = '';
						if(strtolower(trim($hs_value['hs_desc'])) == 'smls pipe/tube in ss/cs/as'){
							$bg_color = '#00FF00';
						}else if(strtolower(trim($hs_value['hs_desc'])) == 'welded pipe/tube in ss/cs/as'){
							$bg_color = '#FF7F00';
						}else if(strtolower(trim($hs_value['hs_desc'])) == 'fittings flange ss/cs/as'){
							$bg_color = '#FF0000';
						}else if(strtolower(trim($hs_value['hs_desc'])) == 'fasteners'){
							$bg_color = '#0000FF';
						}else if(strtolower(trim($hs_value['hs_desc'])) == 'nickel alloy pipe/tube/fittings'){
							$bg_color = '#4B0082';
						}else{
							$col_key = $hs_key;
							if($hs_key > 6){
								$col_key = $hs_key - $col_key;
							}
							$bg_color = $colors[$col_key];
						}

						$hs_graph[$hs_key]['name'] = $hs_value['hs_desc'];
						$hs_graph[$hs_key]['y'] = round($hs_value['FOB_VALUE_INR']);
						//$hs_graph[$hs_key]['color'] = $bg_color;
					}
					
				}

				$result[$key]['hs_graph'] = $hs_graph;
			}else{
				$result[$key]['hs_graph'] = '';
			}


			$this->db2->select('member_name, decision_maker');
			$this->db2->order_by('decision_maker', 'desc');
			$decision_maker = $this->db2->get_where('lead_detail', array('lead_mst_id' => $value['lead_mst_id'], 'decision_maker > ' => 0 ))->result_array();
			$result[$key]['dm_graph'] = ''; $dm_graph = array();
			if(!empty($decision_maker)){
				foreach ($decision_maker as $dmkey => $dmvalue) {
					$dm_graph[$dmkey]['name'] = $dmvalue['member_name'];
					$dm_graph[$dmkey]['y'] = round($dmvalue['decision_maker']);
				}
				$result[$key]['dm_graph'] = $dm_graph;
			}

			if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 13){
				if($this->session->userdata('role') == 1){
					if($category == 'tubes'){
						$exporters = array();
						$export_data = $this->db2->get_where('competitor_ranks_tube', array('NEW_IMPORTER_NAME' => $value['IMPORTER_NAME']))->result_array();
						foreach ($export_data as $ex_key => $ex_value) {
							$exporters[$ex_key]['name'] = $ex_value['EXPORTER_NAME'];
							$exporters[$ex_key]['y'] = round($ex_value['EXPORTER_CONTRIBUTION'], 2);
						}
						$result[$key]['export_data'] = $exporters;
					}else if($category == 'pipes'){
						$exporters = array();
						$export_data = $this->db2->get_where('competitor_ranks_pipe', array('NEW_IMPORTER_NAME' => $value['IMPORTER_NAME']))->result_array();
						foreach ($export_data as $ex_key => $ex_value) {
							$exporters[$ex_key]['name'] = $ex_value['EXPORTER_NAME'];
							$exporters[$ex_key]['y'] = round($ex_value['EXPORTER_CONTRIBUTION'], 2);
						}
						$result[$key]['export_data'] = $exporters;
					}
				}

				$assigned_arr = $this->db->get_where('users', array('user_id' => $value['assigned_to']))->row_array();
				$result[$key]['assigned_to_name'] = $assigned_arr['name'];
			}
			

			/*$this->db2->order_by('connected_on', 'desc');
			$last_contacted = $this->db2->get_where('lead_connects', array('lead_id' => $value['lead_mst_id']))->row_array();*/
			$this->db2->select('group_concat(lead_dtl_id) member_ids');
			//$this->db2->group_by('lead_dtl_id');
			$members = $this->db2->get_where('lead_detail', array('lead_mst_id' => $value['lead_mst_id']))->row_array();
			
			$this->db2->select('connected_on, connect_mode, comments');
			$this->db2->order_by('connected_on', 'desc');
			$this->db2->group_start();
			$this->db2->where('lead_id', $value['lead_mst_id']);
			if($members['member_ids'] != ''){
				$this->db2->or_where('member_id in ('.$members['member_ids'].')');
			}
			$this->db2->group_end();
			$last_contacted = $this->db2->get('lead_connects')->row_array();
			
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

			$members = $this->db2->get_where('lead_detail', array('lead_mst_id' => $value['lead_mst_id']))->result_array();
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
						if(strtolower($mem['other_member']) == 'y'){
							$non_member_count++;
						}else{
							$member_count++;
						}
					}
				}
			}
			$result[$key]['member_count'] = $member_count;
			$result[$key]['non_member_count'] = $non_member_count;
		}
		return $result;
	}

	function getPrimaryListCount($search, $category){
		$this->db2->select('lm.*, ld.lead_dtl_id, ld.member_name, ld.email, ld.designation, ld.mobile, cf.flag_name');
		$this->db2->join('lead_detail ld', "ld.lead_mst_id = lm.lead_mst_id and main_buyer = 'Yes'", 'left');
		$this->db2->join('country_flags cf', 'cf.country = lm.COUNTRY_OF_DESTINATION', 'left');
		if($this->session->userdata('role') == 5){
			$this->db2->where('lm.assigned_to', $this->session->userdata('user_id'));
		}
		if($search['IMPORTER_NAME'] != ''){
			$this->db2->where("lm.IMPORTER_NAME like '%".$search['IMPORTER_NAME']."%'");
		}

		if($search['lead_type'] != ''){
			$this->db2->where('lm.lead_type', $search['lead_type']);
		}elseif ($search['lead_type'] == 'blank') {
			$this->db2->where('lm.lead_type = 0');
		}

		if($search['lead_stage'] != ''){
			$this->db2->where('lm.lead_stage', $search['lead_stage']);
		}elseif ($search['lead_stage'] == 'blank') {
			$this->db2->where('lm.lead_stage = 0');
		}

		if($search['COUNTRY_OF_DESTINATION'] != ''){
			$this->db2->where('lm.COUNTRY_OF_DESTINATION', $search['COUNTRY_OF_DESTINATION']);
		}

		if($search['assigned_to'] != ''){
			$this->db2->where('lm.assigned_to', $search['assigned_to']);
		}
		$this->db2->where('deleted is null');
		$this->db2->where('imp_id > ', 0);
		$res = $this->db2->get_where('lead_mst lm', array('lm.data_category' => $category))->result_array();
		return sizeof($res);
	}

	function getLeadCountries($category){
		$this->db2->select('COUNTRY_OF_DESTINATION');
		$this->db2->distinct();
		$this->db2->order_by('COUNTRY_OF_DESTINATION');
		return $this->db2->get_where('lead_mst', array('data_category' => strtoupper($category)))->result_array();
	}

	function getYearWiseImport($imp_name, $category){
		if($category == 'tubes'){
			$tbl = 'trending_tubes';
		}else if($category == 'pipes'){
			$tbl = 'trending_pipes';
		}
		
		$this->db2->select('SB_YEAR');
		$this->db2->distinct();
		$years = $this->db2->get_where($tbl, array('NEW_IMPORTER_NAME' => $imp_name))->result_array();

		$ret_arr = $ret_year = array();
		if($this->session->userdata('role') == 5){
			foreach ($years as $yr_key => $yr_value) {
				$ret_arr['data'][$yr_key] = 0;
				$this->db2->select('SUM(SUM_FOB_VALUE_IN) value');
				$value_res = $this->db2->get_where($tbl, array('SB_YEAR' => $yr_value['SB_YEAR'], 'NEW_IMPORTER_NAME' => $imp_name))->row_array();
				if(!empty($value_res)){
					$ret_arr['data'][$yr_key] = round($value_res['value']);
				}
				$ret_year[] = $yr_value['SB_YEAR'];
			}
			$ret_year = array_unique($ret_year);
			sort($ret_year);

			return array($ret_year, $ret_arr);
		}else if($this->session->userdata('role') == 1){
			$this->db2->select('EXPORTER_NAME');
			$this->db2->distinct();
			$exporters = $this->db2->get_where($tbl, array('NEW_IMPORTER_NAME' => $imp_name))->result_array();

			foreach ($exporters as $key => $value) {
				$ret_arr[$key]['name'] = $value['EXPORTER_NAME'];
				foreach ($years as $yr_key => $yr_value) {
					$ret_arr[$key]['data'][$yr_key] = 0;
					$this->db2->select('SUM(SUM_FOB_VALUE_IN) value');
					$value_res = $this->db2->get_where($tbl, array('EXPORTER_NAME' => $value['EXPORTER_NAME'], 'SB_YEAR' => $yr_value['SB_YEAR'], 'NEW_IMPORTER_NAME' => $imp_name))->row_array();
					if(!empty($value_res)){
						$ret_arr[$key]['data'][$yr_key] = round($value_res['value']);
					}
					$ret_year[] = $yr_value['SB_YEAR'];
				}
			}
			$ret_year = array_unique($ret_year);
			sort($ret_year);

			return array($ret_year, $ret_arr);
		}
	}

	function getMembers($lead_mst_id, $type){
		$this->db2->select('member_name, email, mobile, other_member, main_buyer');
		/*if($type == 'mem'){
			$this->db2->where("(other_member is null or other_member = '')");
		}else if($type == 'nonmem'){
			$this->db2->where('other_member', 'Y');
		}*/
		$this->db2->order_by('other_member');
		$this->db2->order_by('lead_dtl_id');
		$res = $this->db2->get_where('lead_detail', array('lead_mst_id' => $lead_mst_id))->result_array();
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

	function getHetroMembers($lead_mst_id, $type){
		$this->db->select('member_name, email, mobile, other_member, main_buyer');
		/*if($type == 'mem'){
			$this->db2->where("(other_member is null or other_member = '')");
		}else if($type == 'nonmem'){
			$this->db2->where('other_member', 'Y');
		}*/
		//$this->db->order_by('other_member');
		$this->db->order_by('lead_dtl_id');
		$res = $this->db->get_where('hetro_lead_detail', array('lead_id' => $lead_mst_id))->result_array();
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

	function getConnectDetailsDB2($lead_id){
		$this->db2->select('lc.*');
		$this->db2->join('lead_detail ld', 'ld.lead_mst_id = lm.lead_mst_id', 'inner');
		$this->db2->join('lead_connects lc', 'lc.member_id = ld.lead_dtl_id', 'inner');
		return $this->db2->get_where('lead_mst lm', array('lm.lead_mst_id' => $lead_id))->result_array();
	}

	function getLeadConnectsDB2($member_id){
		$mem_res = $this->db2->query(
			'select lead_dtl_id, lead_mst_id from lead_detail where lead_mst_id = (select lead_mst_id from lead_detail where lead_dtl_id = '.$member_id.')'
		)->result_array();
		$members = array();
		foreach ($mem_res as $key => $value) {
			$members[] = $value['lead_dtl_id'];
			$lead_id = $value['lead_mst_id'];
		}

		$this->db2->select('lc.*, ld.member_name');
		$this->db2->distinct();
		$this->db2->join('lead_detail ld', 'ld.lead_dtl_id = lc.member_id', 'left');
		$this->db2->group_start();
		$this->db2->where('lc.lead_id', $lead_id);
		$this->db2->or_where_in('lc.member_id', $members);
		$this->db2->group_end();
		$ret = $this->db2->get('lead_connects lc')->result_array();
		return $ret;
	}
}