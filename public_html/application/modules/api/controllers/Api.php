<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('api_model');
	}

	function getMachineTime(){
		$arr = array(
            "company_id" => 6617,
            "user_id" => "0",
            "cmd" => "get_user_data",
            "from_date" => date('Y-m-d', strtotime('-1 Day')),
            "to_date" => date('Y-m-d', strtotime('-1 Day')),
            "access_token" => "NUW7GH4UK7YPjXLPh_A49uBEm13JG6tF"
        );
        $post_data = json_encode(array('data' => $arr));
        
        $url = "https://desktrack.timentask.com/api/desktop_tracking/web/v1/index/index";
        //$token = $this->token;
        $headers = array(
            'content-type:application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($result);
        foreach ($res->data->employees_data as $key => $value) {
        	$temp_arr = array();
        	foreach ($value as $key => $value) {
        		if($key == 'userid'){
        			$key = 'desktrack_userid';
        		}
        		$temp_arr[$key] = $value;
                $temp_arr['entered_on'] = date('Y-m-d H:i:s');
        	}
        	$insert_arr = $temp_arr;
        	$insert_arr['complete_data'] = json_encode($insert_arr);
        	$this->api_model->insertData('machine_time', $insert_arr);
        }
	}


    function clearMargins(){
        $ts = strtotime(date('Y-m-d'));
        $ts_back = strtotime("-2 month", $ts);
        $date_back = date('Y-m-d', $ts_back);
        $quotes = $this->api_model->clearMargins($date_back);
    }
}