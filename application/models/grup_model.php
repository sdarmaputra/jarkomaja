<?php
class Grup_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'grup';
		$this->primary_key = 'idgrup';
	}

	public function getByUserId($user_id) {
		$q = $this->db->get_where($this->table_name, array('user_iduser' => $user_id));
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function getReportNumber($group_id, $user_id) {
		$q = $this->db->get_where('grup_has_nomor', array('grup_idgrup' => $group_id, 'grup_user_iduser' => $user_id));
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function isAvailable($group_id) {
		$q = $this->db->get_where($this->table_name, array($this->primary_key => $group_id));
		if ($q->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function addGroupMember($details) {
		$q = $this->db->insert('grup_has_nomor', $details);
	}

	public function deleteGroupMember($details) {
		$this->db->where($details);
		$q = $this->db->delete('grup_has_nomor');
	}
}
?>