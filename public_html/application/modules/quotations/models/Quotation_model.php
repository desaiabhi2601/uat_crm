<?php 
class Quotation_model extends CI_Model{
	function getUsers(){
		$this->db->where('role', 4);
		$this->db->or_where('user_id', 19);
		return $this->db->get_where('users', array('status' => 1))->result_array();
	}

	function getAssignee(){
		$this->db->where('role', 5);
		return $this->db->get_where('users', array('status' => 1))->result_array();
	}

	function getLookup($lookup_id){
		$this->db->order_by('lookup_value');
		return $this->db->get_where('lookup', array('lookup_group' => $lookup_id))->result_array();
	}

	function getData($table, $where = ''){
		if($where != ''){
			$this->db->where($where);
		}
		return $this->db->get($table)->result_array();
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

	function getQuotationDetails($quote_id){
		$this->db->select('m.*, d.*, m.entered_on quote_date, c.client_name, lc.lookup_value country, lr.lookup_value region, mb.name, mb.email, mb.mobile, mb.telephone, mb.skype, dl.delivery_name, dt.dt_value, pt.term_value, oc.country origin, mt.mtc_value, v.validity_value, cr.currency, cr.currency_icon, t.mode, u.unit_value, us.name uname, us.email uemail, us.mobile umobile');
		$this->db->join('quotation_dtl d', 'm.quotation_mst_id = d.quotation_mst_id', 'inner');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'inner');
		$this->db->join('transport_mode t', 'm.transport_mode = t.mode_id', 'inner');
		$this->db->join('payment_terms pt', 'm.payment_term = pt.term_id', 'inner');
		$this->db->join('delivery dl', 'm.delivered_through = dl.delivery_id', 'inner');
		$this->db->join('delivery_time dt', 'm.delivery_time = dt.dt_id', 'inner');
		$this->db->join('origin_country oc', 'm.origin_country = oc.country_id', 'inner');
		$this->db->join('currency cr', 'm.currency = cr.currency_id', 'inner');
		$this->db->join('validity v', 'm.validity = v.validity_id', 'inner');
		$this->db->join('mtc_type mt', 'm.mtc_type = mt.mtc_id', 'inner');
		$this->db->join('units u', 'd.unit = u.unit_id', 'inner');
		$this->db->join('users us', 'm.assigned_to = us.user_id', 'inner');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		return $this->db->get_where('quotation_mst m', array('m.quotation_mst_id' => $quote_id))->result_array();
	}

	function getQuotationList($start, $length, $where, $order, $dir, $type, $searchByYear='all'){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.entered_on) month, WEEK(m.entered_on) week, DATE_FORMAT(m.entered_on, "%d-%b") date, DATE_FORMAT(m.followup_date, "%d-%b") fdate, m.importance, m.status, mb.mobile, mb.is_whatsapp, u.name username, cr.currency_icon');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('users u', 'u.user_id = m.assigned_to', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('currency cr', 'cr.currency_id = m.currency', 'left');
		if(!empty($where)){
			
			foreach ($where as $key => $value) {
				// $this->db->group_start();
				if($key == 'quote_no' && $value != ''){
					$this->db->where("m.quote_no like '%".$value."%'");
				}
				else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
				else if($key == 'date' && $value != ''){
					$this->db->where("m.entered_on like '%".$value."%'");
				}
				else if($key == 'client_name' && $value != ''){
					$this->db->where("c.client_name like '%".$value."%'");
				}
				else if($key == 'grand_total' && $value != ''){
					$this->db->where("m.grand_total like '%".$value."%'");
				} 
				else if($key == 'country' && $value != ''){
					$this->db->where("lc.lookup_id =".$value);
				} 
				else if($key == 'region' && $value != ''){
					$this->db->where("lr.lookup_id = ".$value);
				} 
				else if($key == 'fdate' && $value != ''){
					$this->db->where("m.followup_date like '%".$value."%'");
				} 
				else if($key == 'importance' && $value != ''){
					$this->db->where("m.importance like '%".$value."%'");
				} 
				else if($key == 'status' && $value != ''){
					$this->db->where("m.status like '%".$value."%'");
				} 
			}

			/*foreach ($where as $key => $value){
				$this->db->where('m.quote_no like ', '%'.$value.'%');
				$this->db->or_where('m.entered_on like ', '%'.$value.'%');
				$this->db->or_where('c.client_name like ', '%'.$value.'%');
				$this->db->or_where('mb.name like ', '%'.$value.'%');
				$this->db->or_where('m.grand_total like ', '%'.$value.'%');
				$this->db->or_where('lc.lookup_value like ', '%'.$value.'%');
				$this->db->or_where('lr.lookup_value like ', '%'.$value.'%');
				$this->db->or_where('m.followup_date like ', '%'.$value.'%');
				$this->db->or_where('m.importance like ', '%'.$value.'%');
				$this->db->or_where('m.status like ', '%'.$value.'%');
				$this->db->or_where('u.name like ', '%'.$value.'%');
			}*/
			// $this->db->group_end();
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}
		if($type != ''){
			$this->db->where('stage', $type);
		}else{
			$this->db->where_in('stage', array('publish', 'proforma'));
		}

		if($searchByYear != 'all'){
			$years = explode('-', $searchByYear);
			$this->db->where('m.entered_on >= ', date($years[0].'-04-01 00:00:00'));
			$this->db->where('m.entered_on <= ', date($years[1].'-03-31 23:59:59'));
		}
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$res = $this->db->get('quotation_mst m')->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			$this->db->order_by('followedup_on', 'desc');
			$follow_up_res = $this->db->get_where('follow_up', array('quotation_mst_id' => $value['quotation_mst_id']))->row_array();
			if(!empty($follow_up_res)){
				$date1 = date_create($follow_up_res['followedup_on']);
				$date2 = date_create(date('Y-m-d'));
				$diff_obj = date_diff($date1, $date2);
				$diff = $diff_obj->format("%a");

				if($diff < 8){
					$result[$key]['last_followed'] = $diff.' days ago';
				}else if($diff < 30){
					$weeks = round($diff / 7);
					$result[$key]['last_followed'] = $weeks.' weeks ago';
				}else if($diff < 365){
					$months = round($diff / 30);
					$result[$key]['last_followed'] = $months.' months ago';
				}else if($diff > 365){
					$years = round($diff / 365);
					$result[$key]['last_followed'] = $years.' years ago';
				}

				$result[$key]['follow_up_text'] = $follow_up_res['follow_up_text'];

			}else{
				$result[$key]['last_followed'] = '';
				$result[$key]['follow_up_text'] = '';
			}


			if($value['rfq_id'] > 0){
				$this->db->join('rfq_mst r', 'r.rfq_mst_id = q.query_for_id', 'inner');
				$this->db->join('quotation_mst m', 'r.rfq_mst_id = m.rfq_id', 'inner');
				$query_res = $this->db->get_where('query_mst q', array('r.rfq_mst_id' => $value['rfq_id'], 'query_type' => 'purchase'))->row_array();
				if(!empty($query_res)){
					$result[$key]['has_query'] = true;
					$result[$key]['rfq_id'] = $query_res['rfq_id'];
					$result[$key]['query_id'] = $query_res['query_id'];
					$result[$key]['query_type'] = $query_res['query_type'];
				}else{
					$result[$key]['has_query'] = false;
					$result[$key]['rfq_id'] = '';
					$result[$key]['query_id'] = '';
					$result[$key]['query_type'] = '';
				}	
			}else{
				$result[$key]['has_query'] = false;
				$result[$key]['rfq_id'] = '';
				$result[$key]['query_id'] = '';
				$result[$key]['query_type'] = '';
			}
			
		}
		return $result;
	}

	function getQuotationListCount($where, $type, $searchByYear='all'){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.entered_on) month, WEEK(m.entered_on) week, DATE_FORMAT(m.entered_on, "%d-%b") date, DATE_FORMAT(m.followup_date, "%d-%b") fdate, m.importance, m.status, mb.mobile, mb.is_whatsapp, u.name username');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('users u', 'u.user_id = m.assigned_to', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('currency cr', 'cr.currency_id = m.currency', 'left');
		if(!empty($where)){
			
			foreach ($where as $key => $value) {
				// $this->db->group_start();
				if($key == 'quote_no' && $value != ''){
					$this->db->where("m.quote_no like '%".$value."%'");
				}
				else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
				else if($key == 'date' && $value != ''){
					$this->db->where("m.entered_on like '%".$value."%'");
				}
				else if($key == 'client_name' && $value != ''){
					$this->db->where("c.client_name like '%".$value."%'");
				}
				else if($key == 'grand_total' && $value != ''){
					$this->db->where("m.grand_total like '%".$value."%'");
				} 
				else if($key == 'country' && $value != ''){
					$this->db->where("lc.lookup_id = ".$value);
				} 
				else if($key == 'region' && $value != ''){
					$this->db->where("lr.lookup_id = ".$value);
				}
				else if($key == 'fdate' && $value != ''){
					$this->db->where("m.followup_date like '%".$value."%'");
				} 
				else if($key == 'importance' && $value != ''){
					$this->db->where("m.importance like '%".$value."%'");
				} 
				else if($key == 'status' && $value != ''){
					$this->db->where("m.status like '%".$value."%'");
				} 
			}
		}

		/*if($where != ''){
			$this->db->group_start();
			$this->db->where('m.quote_no like ', '%'.$where.'%');
			$this->db->or_where('m.entered_on like ', '%'.$where.'%');
			$this->db->or_where('c.client_name like ', '%'.$where.'%');
			$this->db->or_where('mb.name like ', '%'.$where.'%');
			$this->db->or_where('m.grand_total like ', '%'.$where.'%');
			$this->db->or_where('lc.lookup_value like ', '%'.$where.'%');
			$this->db->or_where('lr.lookup_value like ', '%'.$where.'%');
			$this->db->or_where('m.followup_date like ', '%'.$where.'%');
			$this->db->or_where('m.importance like ', '%'.$where.'%');
			$this->db->or_where('m.status like ', '%'.$where.'%');
			$this->db->or_where('u.name like ', '%'.$where.'%');
			$this->db->group_end();
		}*/
		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}
		if($type != ''){
			$this->db->where('stage', $type);
		}else{
			$this->db->where_in('stage', array('publish', 'proforma'));
		}
		if($searchByYear != 'all'){
			$years = explode('-', $searchByYear);
			$this->db->where('m.entered_on >= ', date($years[0].'-04-01 00:00:00'));
			$this->db->where('m.entered_on <= ', date($years[1].'-03-31 23:59:59'));
		}
		$res = $this->db->get('quotation_mst m')->result_array();
		//echo $this->db->last_query();
		return sizeof($res);
	}

	function getFollowUpList($start, $length, $search, $order_by, $dir){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.entered_on) month, WEEK(m.entered_on) week, DATE_FORMAT(m.entered_on, "%d-%b") date, DATE_FORMAT(m.followup_date, "%d-%b") fdate, m.importance, m.status, mb.mobile, mb.is_whatsapp, u.name username, cr.currency_icon');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('users u', 'u.user_id = m.assigned_to', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('currency cr', 'cr.currency_id = m.currency', 'left');
		$this->db->where('m.followup_date <=', date('Y-m-d'));
		$this->db->where("m.quote_no != '' and m.quote_no is not null");
		$this->db->where("m.status", "open");
		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}

		/*if($search != ''){
			$this->db->group_start();
			$this->db->where('m.quote_no like ', '%'.$search.'%');
			$this->db->or_where('m.entered_on like ', '%'.$search.'%');
			$this->db->or_where('c.client_name like ', '%'.$search.'%');
			$this->db->or_where('m.grand_total like ', '%'.$search.'%');
			$this->db->or_where('lc.lookup_value like ', '%'.$search.'%');
			$this->db->or_where('lr.lookup_value like ', '%'.$search.'%');
			$this->db->or_where('m.followup_date like ', '%'.$search.'%');
			$this->db->or_where('u.name like ', '%'.$search.'%');
			$this->db->group_end();
		}*/

		foreach ($search as $key => $value) {
			// $this->db->group_start();
			if($key == 'quote_no' && $value != ''){
				$this->db->where("m.quote_no like '%".$value."%'");
			}
			else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
			else if($key == 'date' && $value != ''){
				$this->db->where("m.entered_on like '%".$value."%'");
			}
			else if($key == 'client_name' && $value != ''){
				$this->db->where("c.client_name like '%".$value."%'");
			}
			else if($key == 'grand_total' && $value != ''){
				$this->db->where("m.grand_total like '%".$value."%'");
			} 
			else if($key == 'country' && $value != ''){
				$this->db->where("lc.lookup_id =".$value);
			} 
			else if($key == 'region' && $value != ''){
				$this->db->where("lr.lookup_id = ".$value);
			}
			else if($key == 'fdate' && $value != ''){
				$this->db->where("m.followup_date like '%".$value."%'");
			} 
			else if($key == 'importance' && $value != ''){
				$this->db->where("m.importance like '%".$value."%'");
			} 
			else if($key == 'status' && $value != ''){
				$this->db->where("m.status like '%".$value."%'");
			} 
		}

		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		$res = $this->db->get('quotation_mst m')->result_array();
		//echo $this->db->last_query();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			$follow_up_res = $this->db->get_where('follow_up', array('quotation_mst_id' => $value['quotation_mst_id']))->row_array();
			if(!empty($follow_up_res)){
				$date1 = date_create($follow_up_res['followedup_on']);
				$date2 = date_create(date('Y-m-d'));
				$diff_obj = date_diff($date1, $date2);
				$diff = $diff_obj->format("%a");

				if($diff < 8){
					$result[$key]['last_followed'] = $diff.' days ago';
				}else if($diff < 30){
					$weeks = round($diff / 7);
					$result[$key]['last_followed'] = $weeks.' weeks ago';
				}else if($diff < 365){
					$months = round($diff / 30);
					$result[$key]['last_followed'] = $months.' months ago';
				}else if($diff > 365){
					$years = round($diff / 365);
					$result[$key]['last_followed'] = $years.' years ago';
				}

				$result[$key]['follow_up_text'] = $follow_up_res['follow_up_text'];

			}else{
				$result[$key]['last_followed'] = '';
				$result[$key]['follow_up_text'] = '';
			}
		}
		return $result;
	}

	function getFollowUpListCount($search){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.entered_on) month, WEEK(m.entered_on) week, DATE(m.entered_on) date');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('users u', 'u.user_id = m.assigned_to', 'inner');
		$this->db->where('m.followup_date <=', date('Y-m-d'));
		$this->db->where("m.quote_no != '' and m.quote_no is not null");
		$this->db->where("m.status", "open");
		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}

		/*if($search != ''){
			$this->db->group_start();
			$this->db->where('m.quote_no like ', '%'.$search.'%');
			$this->db->or_where('m.entered_on like ', '%'.$search.'%');
			$this->db->or_where('c.client_name like ', '%'.$search.'%');
			$this->db->or_where('m.grand_total like ', '%'.$search.'%');
			$this->db->or_where('lc.lookup_value like ', '%'.$search.'%');
			$this->db->or_where('lr.lookup_value like ', '%'.$search.'%');
			$this->db->or_where('m.followup_date like ', '%'.$search.'%');
			$this->db->or_where('u.name like ', '%'.$search.'%');
			$this->db->group_end();
		}*/

		foreach ($search as $key => $value) {
			// $this->db->group_start();
			if($key == 'quote_no' && $value != ''){
				$this->db->where("m.quote_no like '%".$value."%'");
			}
			else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
			else if($key == 'date' && $value != ''){
				$this->db->where("m.entered_on like '%".$value."%'");
			}
			else if($key == 'client_name' && $value != ''){
				$this->db->where("c.client_name like '%".$value."%'");
			}
			else if($key == 'grand_total' && $value != ''){
				$this->db->where("m.grand_total like '%".$value."%'");
			} 
			else if($key == 'country' && $value != ''){
				$this->db->where("lc.lookup_id =".$value);
			} 
			else if($key == 'region' && $value != ''){
				$this->db->where("lr.lookup_id = ".$value);
			}
			else if($key == 'fdate' && $value != ''){
				$this->db->where("m.followup_date like '%".$value."%'");
			} 
			else if($key == 'importance' && $value != ''){
				$this->db->where("m.importance like '%".$value."%'");
			} 
			else if($key == 'status' && $value != ''){
				$this->db->where("m.status like '%".$value."%'");
			} 
		}

		$res = $this->db->get('quotation_mst m')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return sizeof($result);
	}


	function getFollowUpHistory($quote_id){
		$this->db->select('q.quote_no, f.*, c.client_name');
		$this->db->join('quotation_mst q', 'q.quotation_mst_id = f.quotation_mst_id', 'inner');
		$this->db->join('clients c', 'c.client_id = q.client_id', 'inner');
		$this->db->where_in('q.stage', array('publish', 'proforma'));
		return $this->db->get_where('follow_up f', array('f.quotation_mst_id' => $quote_id))->result_array();
	}

	function getQueryHistory($quote_id, $query_type){
		$this->db->join('query_texts qt', 'qt.query_id = q.query_id', 'inner');
		return $this->db->get_where('query_mst q', array('q.query_for_id' => $quote_id, 'q.query_type' => $query_type))->result_array();
	}

	function getSiblingQuotation($quote_id){
		$this->db->select('client_id');
		$res = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $quote_id))->row_array();

		$this->db->where('quotation_mst_id !=', $quote_id);
		return $this->db->get_where('quotation_mst', array('client_id' => $res['client_id'], 'stage' => 'publish'))->result_array();
	}

	function getPortName($port_type, $delivery_type, $country){
		$res = $this->db->get_where('ports', array('port_type' => $port_type, 'delivery_type' => $delivery_type, 'country' => $country))->row_array();
		return $res['port_name'];
	}

	function getClientDetails($quote_id){
		$this->db->select('client_id');
		$res = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $quote_id))->row_array();

		$this->db->select('m.*, c.*, lc.lookup_value country, lr.lookup_value region');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');		
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');		
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');		
		return $this->db->get_where('members m', array('m.client_id' => $res['client_id']))->result_array();
	}

	function getFinancialYears(){
		$this->db->select('case when month(entered_on) > 3 then concat(year(entered_on),"-",year(entered_on)+1) 
    	else concat(year(entered_on)-1,"-",year(entered_on)) end as years');
    	$this->db->distinct();
    	$this->db->order_by('years', 'desc');
    	return $this->db->get('quotation_mst')->result_array();
	}

	function getSMSDetails($type, $quote_id){
		if($type == 'quotation'){
			$this->db->select('q.quote_no, qu.name sales_user, qu.mobile, r.rfq_subject, ru.name purchase_user, qu.user_id user_id');
			$this->db->join('users qu', 'qu.user_id = q.assigned_to', 'inner');
			$this->db->join('rfq_mst r', 'r.rfq_mst_id = q.rfq_id', 'left');
			$this->db->join('users ru', 'ru.user_id = r.assigned_to', 'left');
			$res = $this->db->get_where('quotation_mst q', array('q.quotation_mst_id' => $quote_id))->row_array();
			return $res;
		}else if($type == 'proforma'){
			$this->db->select('q.proforma_no, qu.name sales_user, qu.mobile, r.rfq_no, ru.name purchase_user, qu.user_id user_id');
			$this->db->join('users qu', 'qu.user_id = q.assigned_to', 'inner');
			$this->db->join('rfq_mst r', 'r.rfq_mst_id = q.rfq_id', 'left');
			$this->db->join('users ru', 'ru.user_id = r.assigned_to', 'left');
			$res = $this->db->get_where('quotation_mst q', array('q.quotation_mst_id' => $quote_id))->row_array();
			return $res;
		}
	}

	function getFollowupCount($user_id){
		$this->db->where("quote_no != '' and quote_no is not null");
		$this->db->where("status", "open");
		$this->db->where('followup_date <=', date('Y-m-d'));
		$res = $this->db->get_where('quotation_mst', array('assigned_to' => $user_id))->result_array();
		return sizeof($res);
	}

	function getQueryRecepient($quote_id, $query_type){
		if($query_type == 'sales' || $query_type == 'proforma'){
			$this->db->select('r.assigned_to');
			$this->db->join('rfq_mst r', 'q.rfq_id = r.rfq_mst_id', 'inner');
			$res = $this->db->get_where('quotation_mst q', array('q.quotation_mst_id' => $quote_id))->row_array();
			return $res['assigned_to'];	
		}else if($query_type == 'purchase'){
			$this->db->select('q.assigned_to');
			$this->db->join('quotation_mst q', 'q.rfq_id = r.rfq_mst_id', 'inner');
			$res = $this->db->get_where('rfq_mst r', array('r.rfq_mst_id' => $quote_id))->row_array();
			return $res['assigned_to'];
		}
		
	}

	function getQueryList($start, $length, $search, $order_by, $dir){
		$this->db->select('q.*, t.name recepient, f.name sender, DATE_FORMAT(q.raised_on, "%d-%b") raised_on');
		$this->db->join('users f', 'q.raised_by = f.user_id', 'inner');
		$this->db->join('users t', 'q.query_recepient = t.user_id', 'inner');
		if($this->session->userdata('role') == 5 && in_array($search['query_type'], array('sales', 'proforma'))){
			$this->db->where('q.raised_by', $this->session->userdata('user_id'));
		}
		if($this->session->userdata('role') == 5 && in_array($search['query_type'], array('purchase'))){
			$this->db->where('q.query_recepient', $this->session->userdata('user_id'));
		}
		$this->db->limit($length, $start);
		$this->db->order_by($order_by, $dir);
		$res = $this->db->get_where('query_mst q', array('query_type' => $search['query_type'], 'query_status' => $search['query_status']))->result_array();
		//echo $this->db->last_query();
		
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
			switch ($value['query_type']) {
				case 'sales':
					$for = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $value['query_for_id']))->row_array();
					$result[$key]['query_for'] = $for['quote_no'];
					break;

				case 'proforma':
					$for = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $value['query_for_id']))->row_array();
					$result[$key]['query_for'] = $for['proforma_no'];
					break;

				case 'purchase':
					$for = $this->db->get_where('rfq_mst', array('rfq_mst_id' => $value['query_for_id']))->row_array();
					$result[$key]['query_for'] = $for['rfq_no'];
					break;
			}
		}
		return $result;
	}

	function getQueryListCount($search){
		$this->db->select('q.*, t.name recepient, f.name sender');
		$this->db->join('users f', 'q.raised_by = f.user_id', 'inner');
		$this->db->join('users t', 'q.query_recepient = t.user_id', 'inner');
		if($this->session->userdata('role') == 5){
			$this->db->where('q.raised_by', $this->session->userdata('user_id'));
		}
		$res = $this->db->get_where('query_mst q', array('query_type' => $search['query_type'], 'query_status' => $search['query_status']))->result_array();
		return sizeof($res);
	}

	function getQueryQuote($query_id){
		$res = $this->db->get_where('query_mst', array('query_id' => $query_id))->row_array();
		if($res['query_type'] == 'sales'){
			$res1 = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $res['query_for_id']))->row_array();
			$quote = $res1['quote_no'];
			$quote_str = 'Quote';
		} else if($res['query_type'] == 'proforma'){
			$res1 = $this->db->get_where('quotation_mst', array('quotation_mst_id' => $res['query_for_id']))->row_array();
			$quote = $res1['proforma_no'];
			$quote_str = 'Quote';
		} else if($res['query_type'] == 'purchase'){
			$res1 = $this->db->get_where('rfq_mst', array('rfq_mst_id' => $res['query_for_id']))->row_array();
			$quote = $res1['rfq_no'];
			$quote_str = 'RFQ';
		}
		return array('quote_str' => $quote_str, 'quote' => $quote);
	}
} 
?>