<?php
class Dashboard extends MY_Controller {
	var $data = array();
	function __construct() {
		parent:: __construct();
		if ((null == $this->session->userdata('is_logged_in')) || $this->session->userdata('is_logged_in')==0) {
			redirect(site_url('gate'));
		}
	}

	function index() {
		$this->template->load('dashboard', null, null);
	}

	function broadcast($option = null) {
		$data = $this->data;
		if ($option == null) {
			$this->load->model('grup_model');
			$data['group_list'] = $this->grup_model->getWhere(array('user_iduser' => $this->session->userdata('iduser'),'status_aktif' => 1));
			$this->template->load('dashboard', 'broadcast_page', $data);	
		} else if ($option == 'send'){
			$this->load->model(array('grup_model','report_model'));
			$url = $this->config->item('gammu_url');
			$smstext = '"'.$this->input->post('smstext').'"';
			$idgrup = $this->input->post('idgrup');
			$iduser = $this->session->userdata('iduser');

			$now = date('Y-m-d H:m:s');
			$coupon = base64_encode($now);
			$numbers = $this->grup_model->getReportNumber($idgrup, $iduser);
			if ($numbers) {
				foreach ($numbers as $rw) {
					$this->report_model->create(array(
						'tanggal' => $now,
						'iduser' => $iduser,
						'idgrup' => $idgrup,
						'idnomor' => $rw['nomor_idnomorhp'],
						'pesan' => '',
						'coupon' => $coupon,
						'sukses' => 0));
				}
			}

			$this->load->library('curl');
			//$result = $this->curl->simple_post($url, array('smstext' => $smstext, 'idgrup' => $idgrup));
			//var_dump($result);
		}
		
	}


	function groups($option = null, $id = null) {
		$data = $this->data;
		$this->load->model('grup_model');
		if ($option == null && $id == null) {
			$data['group_list'] = $this->grup_model->getByUserId($this->session->userdata('iduser'));
			$this->template->load('dashboard', 'groups', $data);	
		} else {
			$data['details'] = $this->grup_model->getById($id);
			if (!$data['details']) redirect(site_url('dashboard/groups'), 'refresh');
			$this->template->load('dashboard', 'group_edit', $data);
		}
	}

	function group_member($group_id = null) {
		$data = $this->data;
		if ($group_id != null) {
			$this->load->model(array('nomor_model', 'grup_model'));
			$isAvailable = $this->grup_model->isAvailable($group_id);
			if ($isAvailable) {
				$data['recipient_list'] = $this->nomor_model->getByGroupId($group_id);	
				$this->template->load('dashboard', 'group_member', $data);
			} else redirect(site_url('dashboard/groups'));
		} else redirect(site_url('dashboard/groups'));
	}

	function add_group() {
		$group_name = $this->input->post('group_name');
		if (isset($group_name) && $group_name != '') {
			$this->load->model('grup_model');
			$now = date('Y-m-d h:m:s');
			$this->grup_model->create(array(
				'namagrup' => $group_name,
				'user_iduser' => $this->session->userdata('iduser'),
				'tanggal_buat' => $now,
				'tanggal_modifikasi' => $now,
				'status_aktif' => 1));
			$this->session->set_flashdata('messages', 'New group successfully added into database :)');
		} else {
			$this->session->set_flashdata('messages', 'Failed to add new group. Please fill the group name!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/groups'), 'refresh');
	}

	function update_group() {
		$group_id = $this->input->post('group_id');
		$group_name = $this->input->post('group_name');
		$group_status = $this->input->post('group_status');
		if (isset($group_name) && $group_name != '' && isset($group_status) && $group_status != '') {
			$this->load->model('grup_model');
			$now = date('Y-m-d h:m:s');
			$this->grup_model->update($group_id, array(
				'namagrup' => $group_name,
				'tanggal_modifikasi' => $now,
				'status_aktif' => $group_status));
			$this->session->set_flashdata('messages', 'Group successfully updated :)');
		} else {
			$this->session->set_flashdata('messages', 'Failed to update group. Please fill the group name or group status!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/groups/edit/'.$group_id), 'refresh');
	}

	function delete_group() {
		$delete_id = $this->input->post('delete_id');
		if (isset($delete_id) && $delete_id != '') {
			$this->load->model('grup_model');
			$this->grup_model->delete($delete_id);
			$this->session->set_flashdata('messages', 'Successfully delete group from database!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/groups'), 'refresh');
	}

	function recipients($option = null, $id = null) {
		$data = $this->data;
		$this->load->model('nomor_model');		
		if ($option == null && $id == null) {
			$data['recipient_list'] = $this->nomor_model->getAll();
			$this->template->load('dashboard', 'recipients', $data);
		} else {
			$data['details'] = $this->nomor_model->getById($id);
			if (!$data['details']) redirect(site_url('dashboard/recipients'), 'refresh');
			$this->template->load('dashboard', 'recipient_edit', $data);
		}
	}

	function add_recipient() {
		$nama = $this->input->post('nama');
		$nomor_hp = $this->input->post('nomor_hp');
		if (isset($nama) && $nama != '' && isset($nomor_hp) && $nomor_hp != '') {
			$this->load->model('nomor_model');
			$now = date('Y-m-d h:m:s');
			$this->nomor_model->create(array(
				'nomorhp' => $nomor_hp,
				'nama' => $nama,
				'tanggal_buat' => $now,
				'tanggal_modifikasi' => $now,
				'status_aktif' => 1));
			$this->session->set_flashdata('messages', 'New recipient successfully added into database :)');
		} else {
			$this->session->set_flashdata('messages', 'Failed to add new recipient. Please fill the name and phone number!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/recipients'), 'refresh');
	}

	function delete_recipient() {
		$delete_id = $this->input->post('delete_id');
		if (isset($delete_id) && $delete_id != '') {
			$this->load->model('nomor_model');
			$this->nomor_model->delete($delete_id);
			$this->session->set_flashdata('messages', 'Successfully delete recipient from database!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/recipients'), 'refresh');
	}

	function update_recipient() {
		$recipient_id = $this->input->post('recipient_id');
		$recipient_name = $this->input->post('recipient_name');
		$recipient_phone = $this->input->post('recipient_phone');
		$recipient_status = $this->input->post('recipient_status');
		if (isset($recipient_name) && $recipient_name != '' && isset($recipient_phone) && $recipient_phone != '' && isset($recipient_status) && $recipient_status != '') {
			$this->load->model('nomor_model');
			$now = date('Y-m-d h:m:s');
			$this->nomor_model->update($recipient_id, array(
				'nama' => $recipient_name,
				'nomorhp' => $recipient_phone,
				'status_aktif' => $recipient_status));
			$this->session->set_flashdata('messages', 'Recipient successfully updated :)');
		} else {
			$this->session->set_flashdata('messages', 'Failed to update recipient. Please fill the name, phone and status!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/recipients/edit/'.$recipient_id), 'refresh');
	}

	function reports() {
		$data = $this->data;
		$this->load->model('report_model');
		$data['reports'] = $this->report_model->getWhere(array('iduser' => $this->session->userdata('iduser')), 'tanggal desc');
		$this->template->load('dashboard', 'reports', $data);
	}
}
?>