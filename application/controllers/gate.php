<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gate extends MY_Controller {
	function __construct() {
		parent:: __construct();
	}

	public function index()
	{
		if ((null != $this->session->userdata('is_logged_in')) || $this->session->userdata('is_logged_in')==1) {
			redirect(site_url('dashboard'));
		}
		$this->template->load('login', null, null);
	}

	public function auth() {
		if ((null != $this->session->userdata('is_logged_in')) || $this->session->userdata('is_logged_in')==1) {
			redirect(site_url('dashboard'));
		} else {
			$messages = "";
			$error = false;
			$login_success = false;
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if (!isset($username) || empty($username)) {
				$error = true;
				$messages = $messages."Please provide User Name! ";
			}

			if (!isset($password) || empty($password)) {
				$messages = $messages."Please provide Password! ";
				$error = true;
			}

			if (!$error) {
				$this->load->model('user_model');
				$user = $this->user_model->getByUserName($username);
				if ($user) {
					foreach ($user as $rw) {
						if ($rw['password'] == $password) {
							$login_success = true;	
							$newdata = array(
								'iduser' => $rw['iduser'],
								'username' => $username,
								'password' => $password,
								'is_logged_in' => 1);
							$this->session->set_userdata($newdata);					
						} else {
							$messages = 'Login failed. Please check username or password! ';
							$error = true;
						}
					}
				} else {
					$messages = 'Login failed. Please check username or password! ';
					$error = true;
				}

				if (!$login_success) {
					$this->session->set_flashdata('after_process', true);
					$this->session->set_flashdata('status','error');
					$this->session->set_flashdata('messages', $messages);
					redirect(site_url('gate'), 'refresh');
				} else {
					redirect(site_url('dashboard'), 'refresh');
				}
			} else {
				$this->session->set_flashdata('after_process', true);
				$this->session->set_flashdata('status','error');
				$this->session->set_flashdata('messages', $messages);
				redirect(site_url('gate'), 'refresh');
			}
		}
	}

	public function logout() {
		$logoutdata = array(
			'username' => $this->session->userdata('username'),
			'password' => $this->session->userdata('password'),
			'is_logged_in' => 1
			);
		$this->session->unset_userdata($logoutdata);
		$this->session->set_flashdata('after_process', true);
		$this->session->set_flashdata('status','success');
		$this->session->set_flashdata('messages', 'Logout successfully!');
		redirect(site_url('gate'), 'refresh');
	}
}
