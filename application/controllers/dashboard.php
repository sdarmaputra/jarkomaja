<?php
class Dashboard extends MY_Controller {
	var $data = array();
	var $paginationConfig;
	function __construct() {
		parent:: __construct();
		if ((null == $this->session->userdata('is_logged_in')) || $this->session->userdata('is_logged_in')==0) {
			redirect(site_url('gate'));
		}

		$this->paginationConfig = array(
			'full_tag_open' => '<ul class="center-align pagination">',
			'full_tag_close' => '</ul>',
			'num_tag_open' => '<li class="waves-effect">',
			'num_tag_close' => '</li>',
			'cur_tag_open' => '<li class="active"><a href=#!>',
			'cur_tag_close' => '</a></li>',
			'prev_link' => '<i class="tiny material-icons">chevron_left</i>',
			'prev_tag_open' => '<li class="waves-effect">',
			'prev_tag_close' => '</li>',
			'next_link' => '<i class="tiny material-icons">chevron_right</i>',
			'next_tag_open' => '<li class="waves-effect">',
			'next_tag_close' => '</li>',
			'first_link' => 'First',
			'first_tag_open' => '<li class="waves-effect">',
			'first_tag_close' => '</li>',
			'last_link' => 'Last',
			'last_tag_open' => '<li class="waves-effect">',
			'last_tag_close' => '</li>'
		);
		
	}

	function index() {
		$data = $this->data;
		$this->load->model(array('grup_model', 'report_model'));
		$data['group_count'] = $this->grup_model->countWhere(array('user_iduser' => $this->session->userdata('iduser')));
		$data['report_count'] = $this->report_model->countWhere(array('iduser' => $this->session->userdata('iduser')));
		$this->template->load('dashboard', 'home', $data);
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
			$smstext = $this->input->post('smstext');
			$idgrup = $this->input->post('idgrup');
			$iduser = $this->session->userdata('iduser');
			$msg_len = ceil(strlen($smstext)/160);
			$smstext = '"'.$smstext.'"';

			$now = date('Y-m-d H:i:s');
			$coupon = base64_encode($now);
			$numbers = $this->grup_model->getReportNumber($idgrup, $iduser);
			if ($numbers) {
				foreach ($numbers as $rw) {
					$this->report_model->create(array(
						'tanggal' => $now,
						'iduser' => $iduser,
						'idgrup' => $idgrup,
						'idnomor' => $rw['nomor_idnomorhp'],
						'pesan' => $smstext,
						'coupon' => $coupon,
						'sukses' => 0,
						'biaya' => $msg_len));
				}
			}
			$this->session->set_flashdata('after_process', true);
			$this->session->set_flashdata('messages', 'Your messages have been added into messages queue. Go to report page to see delivery reports.');	
			redirect(site_url('dashboard/broadcast'));
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

	function group_member($group_id = null, $start = 0) {
		$data = $this->data;
		if ($group_id != null) {
			$this->load->model(array('nomor_model', 'grup_model'));
			$isAvailable = $this->grup_model->getById($group_id);
			if ($isAvailable) {
				$data['namagrup'] = '';
				foreach ($isAvailable as $rx) {
					$data['namagrup'] = $rx['namagrup'];
				}
				$data['idgrup'] = $group_id;

				$this->load->library('pagination');
				$limit = 10;
				$offset = $start;	

				$data['recipient_list'] = $this->nomor_model->getByGroupId($group_id, $limit, $offset);	
				$data['recipientCount'] = $this->nomor_model->countByGroupId($group_id);
				$config = $this->paginationConfig;
				$config['base_url'] = site_url('dashboard/group_member/'.$group_id);
				$config['total_rows'] = $data['recipientCount'];
				$config['per_page'] = $limit; 
				$config['uri_segment'] = 4;
				
				$this->pagination->initialize($config); 
				$data['pagination'] = $this->pagination->create_links();
				$data['start'] = $offset;
				$data['limit'] = $limit;

				$this->template->load('dashboard', 'group_member', $data);
			} else redirect(site_url('dashboard/groups'));
		} else redirect(site_url('dashboard/groups'));
	}

	function add_member($group_id = null, $start = 0) {
		$data = $this->data;
		if ($group_id != null) {
			$this->load->model(array('nomor_model', 'grup_model'));
			$isAvailable = $this->grup_model->getById($group_id);
			if ($isAvailable) {
				$data['namagrup'] = '';
				foreach ($isAvailable as $rx) {
					$data['namagrup'] = $rx['namagrup'];
				}
				$data['idgrup'] = $group_id;

				$this->load->library('pagination');
				$limit = 10;
				$offset = $start;	

				$data['recipient_list'] = $this->nomor_model->getNotIncludedIn($group_id, $limit, $offset);
				$data['recipientCount'] = $this->nomor_model->countNotIncludedIn($group_id);
				$config = $this->paginationConfig;
				$config['base_url'] = site_url('dashboard/add_member/'.$group_id);
				$config['total_rows'] = $data['recipientCount'];
				$config['per_page'] = $limit; 
				$config['uri_segment'] = 4;
				
				$this->pagination->initialize($config); 
				$data['pagination'] = $this->pagination->create_links();
				$data['start'] = $offset;
				$data['limit'] = $limit;

				$this->template->load('dashboard', 'add_member', $data);
			} else redirect(site_url('dashboard/groups'));
		} else redirect(site_url('dashboard/groups'));
	}

	function do_add_member() {
		$checked = $this->input->post('add_id');
		$idgrup = $this->input->post('idgrup');
		if (isset($checked) && $checked != null) {
			$this->load->model('grup_model');
			foreach ($checked as $rw) {
				$this->grup_model->addGroupMember(array(
					'grup_idgrup' => $idgrup,
					'grup_user_iduser' => $this->session->userdata('iduser'),
					'nomor_idnomorhp' => $rw));
			}
			$this->session->set_flashdata('after_process', true);
			$this->session->set_flashdata('messages', 'Successfully add recipient(s) into group :)');	
			redirect(site_url('dashboard/group_member/'.$idgrup), 'refresh');
		} else {
			$this->session->set_flashdata('after_process', true);
			$this->session->set_flashdata('messages', 'Failed! Please choose recipient(s) to be added into group!');	
			redirect(site_url('dashboard/add_member/'.$idgrup), 'refresh');
		}
	}

	function delete_from_group() {
		$idgrup = $this->input->post('idgrup');
		$idnomorhp = $this->input->post('delete_id');
		if (isset($idnomorhp) && $idnomorhp != '') {
			$this->load->model('grup_model');
			$this->grup_model->deleteGroupMember(array(
				'grup_idgrup' => $idgrup,
				'grup_user_iduser' => $this->session->userdata('iduser'),
				'nomor_idnomorhp' => $idnomorhp));
			$this->session->set_flashdata('messages', 'Successfully delete recipient from group!');
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/group_member/'.$idgrup), 'refresh');
	}

	function delete_checked_from_group() {
		$checked = $this->input->post('delete_id');
		$idgrup = $this->input->post('idgrup');
		if (isset($checked) && $checked != null) {
			$this->load->model('grup_model');
			foreach ($checked as $rw) {
				$this->grup_model->deleteGroupMember(array(
					'grup_idgrup' => $idgrup,
					'grup_user_iduser' => $this->session->userdata('iduser'),
					'nomor_idnomorhp' => $rw));
			}
			$this->session->set_flashdata('messages', 'Successfully delete recipient(s) from group!');	
			
		} else {
			$this->session->set_flashdata('messages', 'Failed! Please choose recipient(s) to be deleted from group!');	
		}
		$this->session->set_flashdata('after_process', true);
		redirect(site_url('dashboard/group_member/'.$idgrup), 'refresh');
	}

	function add_group() {
		$group_name = $this->input->post('group_name');
		if (isset($group_name) && $group_name != '') {
			$this->load->model('grup_model');
			$now = date('Y-m-d H:i:s');
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
			$now = date('Y-m-d H:i:s');
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

	function recipients($option = 0, $id = null) {
		$data = $this->data;

		$this->load->model('nomor_model');		
		if (($option == 0 && $id == null) || is_numeric($option)) {
			$this->load->library('pagination');
			$limit = 10;
			$offset = $option;	

			$data['recipient_list'] = $this->nomor_model->getWhere(null, null, $limit, $offset);
			$data['recipientCount'] = $this->nomor_model->countAll();
			$config = $this->paginationConfig;
			$config['base_url'] = site_url('dashboard/recipients');
			$config['total_rows'] = $data['recipientCount'];
			$config['per_page'] = $limit; 
			
			$this->pagination->initialize($config); 
			$data['pagination'] = $this->pagination->create_links();
			$data['start'] = $offset;
			$data['limit'] = $limit;

			$this->template->load('dashboard', 'recipients', $data);
		} else if ($option == 'edit'){
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
			$now = date('Y-m-d H:i:s');
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
			$now = date('Y-m-d H:i:s');
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

	function reports($start = 0) {
		$this->load->library('pagination');
		$data = $this->data;
		$limit = 10;
		$offset = $start;

		$this->load->model('report_model');
		$data['reports'] = $this->report_model->getWhere(array('iduser' => $this->session->userdata('iduser')), 'tanggal desc', $limit, $offset);
		$data['reportsCount'] = $this->report_model->countWhere(array('iduser' => $this->session->userdata('iduser')));

		$config = $this->paginationConfig;
		$config['base_url'] = site_url('dashboard/reports');
		$config['total_rows'] = $data['reportsCount'];
		$config['per_page'] = $limit; 
		
		$this->pagination->initialize($config); 
		$data['pagination'] = $this->pagination->create_links();
		$data['start'] = $offset;
		$data['limit'] = $limit;

		$this->template->load('dashboard', 'reports', $data);
	}
}
?>