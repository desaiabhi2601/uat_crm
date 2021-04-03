<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('login_model');
	}

	public function index(){
		if($this->session->has_userdata('user_id')){
			redirect('home/dashboard');
		}else{
			if(!empty($this->input->post())){
				$post_fields = $this->security->xss_clean($this->input->post());
				$userdata = $this->login_model->checkLogin($post_fields);
				if($userdata === false){
					redirect('login', 'refresh');
				}else if(is_array($userdata)){
					$this->session->set_userdata($userdata);
					
						 redirect('home/dashboard');
						 
						 /*
						 $id = $this->session->set_userdata($userdata);
						 $oldip = $this->login_model->getipDetails($id);
						 $ip = $this->input->ip_address();
						 date_default_timezone_set('Asia/Karachi');
						 $now = date('Y-m-d H:i:s');
						 $this->login_model->insertIp( $id, $ip, $now);
						 
						 */
					
				
				}
			}else{
				$this->load->view('login');
			}
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}

	public function changePassword(){
		if(!empty($this->input->post())){
			$res = $this->login_model->updatePassword($this->input->post());
			if($res == 0){
				$this->session->set_flashdata('failed', 'Current password is incorrect');
			}else if($res == 1){
				$this->session->set_flashdata('success', 'Password updated successfully!');
			}
			redirect('login/changePassword');
		}else{
			if(!$this->session->has_userdata('user_id')){
				redirect('login');
			}else{
				$this->load->view('header', array('title' => 'Change Password'));
				$this->load->view('sidebar', array('title' => 'Change Password'));
				$this->load->view('password_change');
				$this->load->view('footer');
			}
		}
	}

	public function otherLogin(){
		if(!empty($this->input->post())){
			$current_user = $this->input->post('current_user');
			$next_user = $this->input->post('next_user');
			$verify = $this->login_model->verify_sub_user($current_user, $next_user);
			if($verify == true){
				$this->session->unset_userdata('user_id');
				$this->session->unset_userdata('name');
				$this->session->unset_userdata('username');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('role');
				$this->session->unset_userdata('module');
				$this->session->unset_userdata('email');
				$this->session->unset_userdata('last_ip');
				$this->session->unset_userdata('last_login');
				$this->session->unset_userdata('current_ip');
				$this->session->unset_userdata('current_login');
				$this->session->unset_userdata('sub_users');
				//$this->session->sess_destroy();
				$userdata = $this->login_model->otherLogin($next_user);
				if($userdata === false){
					redirect('login', 'refresh');
				}else if(is_array($userdata)){
					$this->session->set_userdata($userdata);
					redirect('home/dashboard');
				}	
			}else{
				redirect('login');
			}
		}else{
			redirect('login');
		}
	}
}
