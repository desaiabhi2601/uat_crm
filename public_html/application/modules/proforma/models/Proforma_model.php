<?php 
class Proforma_model extends CI_Model{

	function getData($table, $where = ''){
		if($where != ''){
			$this->db->where($where);
		}
		return $this->db->get($table)->result_array();
	}
	
	function getQuotationDetails($quote_id){
		$this->db->select('m.*, d.*, c.client_name, lc.lookup_value country, lr.lookup_value region, mb.name, mb.email, mb.mobile, mb.telephone, mb.skype, dl.delivery_name, dt.dt_value, pt.term_value, oc.country origin, mt.mtc_value, v.validity_value, cr.currency, cr.currency_icon, t.mode, u.unit_value, us.name uname, us.email uemail, us.mobile umobile');
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

	function getPortName($port_type, $delivery_type, $country){
		$res = $this->db->get_where('ports', array('port_type' => $port_type, 'delivery_type' => $delivery_type, 'country' => $country))->row_array();
		return $res['port_name'];
	}

	function getProformaList($start, $length, $where, $order, $dir){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.confirmed_on) month, WEEK(m.confirmed_on) week, DATE_FORMAT(m.confirmed_on, "%d-%b") date, mb.mobile, mb.is_whatsapp, ua.name username, up.name purchased_by, cr.currency_icon');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('users ua', 'ua.user_id = m.assigned_to', 'inner');
		$this->db->join('rfq_mst r', 'r.rfq_mst_id = m.rfq_id', 'left');
		$this->db->join('users up', 'up.user_id = r.assigned_to', 'left');
		$this->db->join('currency cr', 'cr.currency_id = m.currency', 'left');
		$this->db->where('m.status', 'Won');
		/*if($where != ''){
			$this->db->group_start();
			$this->db->where('m.quote_no like ', '%'.$where.'%');
			$this->db->or_where('m.confirmed_on like ', '%'.$where.'%');
			$this->db->or_where('c.client_name like ', '%'.$where.'%');
			$this->db->or_where('mb.name like ', '%'.$where.'%');
			$this->db->or_where('m.grand_total like ', '%'.$where.'%');
			$this->db->or_where('lc.lookup_value like ', '%'.$where.'%');
			$this->db->or_where('lr.lookup_value like ', '%'.$where.'%');
			$this->db->group_end();
		}*/

		if(!empty($where)){
			
			foreach ($where as $key => $value) {
				// $this->db->group_start();
				if($key == 'proforma_no' && $value != ''){
					$this->db->where("m.proforma_no like '%".$value."%'");
				}
				else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
				else if($key == 'purchase_person' && $value != ''){
					$this->db->where("r.assigned_to = ".$value);
				}
				else if($key == 'confirmed_on' && $value != ''){
					$this->db->where("m.confirmed_on like '%".$value."%'");
				}
				else if($key == 'client_name' && $value != ''){
					$this->db->where("c.client_name like '%".$value."%'");
				}
				else if($key == 'grand_total' && $value != ''){
					$this->db->where("m.grand_total like '%".$value."%'");
				} 
				else if($key == 'country' && $value != ''){
					$this->db->where("lc.lookup_value = ".$value);
				} 
				else if($key == 'region' && $value != ''){
					$this->db->where("lr.lookup_value = ".$value);
				}
				else if($key == 'importance' && $value != ''){
					$this->db->where("m.importance like '%".$value."%'");
				} 
				else if($key == 'status' && $value != ''){
					$this->db->where("m.status like '%".$value."%'");
				} 
			}
		}

		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}
		$this->db->limit($length, $start);
		$this->db->order_by($order, $dir);
		$res = $this->db->get('quotation_mst m')->result_array();
		$k=0;
		$result = array();
		foreach ($res as $key => $value) {
			$result[$key] = $value;
			$result[$key]['record_id'] = ++$k;
		}
		return $result;
	}

	function getProformaListCount($where){
		$this->db->select('m.*, c.client_name, lc.lookup_value country, lr.lookup_value region, MONTH(m.entered_on) month, WEEK(m.entered_on) week, DATE_FORMAT(m.entered_on, "%d-%b") date, DATE_FORMAT(m.followup_date, "%d-%b") fdate, m.importance, m.status, mb.mobile, mb.is_whatsapp');
		$this->db->join('clients c', 'c.client_id = m.client_id', 'inner');
		$this->db->join('members mb', 'mb.member_id = m.member_id', 'left');
		$this->db->join('lookup lc', 'lc.lookup_id = c.country', 'left');
		$this->db->join('lookup lr', 'lr.lookup_id = c.region', 'left');
		$this->db->join('users ua', 'ua.user_id = m.assigned_to', 'inner');
		$this->db->join('rfq_mst r', 'r.rfq_mst_id = m.rfq_id', 'left');
		$this->db->join('users up', 'up.user_id = r.assigned_to', 'left');
		$this->db->where('m.status', 'Won');
		/*if($where != ''){
			$this->db->group_start();
			$this->db->where('m.quote_no like ', '%'.$where.'%');
			$this->db->or_where('m.entered_on like ', '%'.$where.'%');
			$this->db->or_where('c.client_name like ', '%'.$where.'%');
			$this->db->or_where('mb.name like ', '%'.$where.'%');
			$this->db->or_where('m.grand_total like ', '%'.$where.'%');
			$this->db->or_where('lc.lookup_value like ', '%'.$where.'%');
			$this->db->or_where('lr.lookup_value like ', '%'.$where.'%');
			$this->db->group_end();
		}*/
		if(!empty($where)){
			
			foreach ($where as $key => $value) {
				// $this->db->group_start();
				if($key == 'proforma_no' && $value != ''){
					$this->db->where("m.proforma_no like '%".$value."%'");
				}
				else if($key == 'assigned_to' && $value != ''){
					$this->db->where("m.assigned_to = ".$value);
				}
				else if($key == 'purchase_person' && $value != ''){
					$this->db->where("r.assigned_to = ".$value);
				}
				else if($key == 'confirmed_on' && $value != ''){
					$this->db->where("m.confirmed_on like '%".$value."%'");
				}
				else if($key == 'client_name' && $value != ''){
					$this->db->where("c.client_name like '%".$value."%'");
				}
				else if($key == 'grand_total' && $value != ''){
					$this->db->where("m.grand_total like '%".$value."%'");
				} 
				else if($key == 'country' && $value != ''){
					$this->db->where("lc.lookup_value = ".$value);
				} 
				else if($key == 'region' && $value != ''){
					$this->db->where("lr.lookup_value = ".$value);
				} 
				else if($key == 'importance' && $value != ''){
					$this->db->where("m.importance like '%".$value."%'");
				} 
				else if($key == 'status' && $value != ''){
					$this->db->where("m.status like '%".$value."%'");
				} 
			}
		}
		if($this->session->userdata('role') == 5){
			$this->db->where('m.assigned_to', $this->session->userdata('user_id'));
		}
		$res = $this->db->get('quotation_mst m')->result_array();
		return sizeof($res);
	}

	function updateData($table, $data, $where){
		$this->db->update($table, $data, $where);
	}
} 
?>