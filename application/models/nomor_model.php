<?php
class Nomor_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'nomor';
		$this->primary_key = 'idnomorhp';
	}

	public function getByGroupId($group_id, $limit=null, $offset=null) {
		if ($limit != null) { $this->db->limit($limit); }
		if ($offset != null) { $this->db->offset($offset); }
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->join('grup_has_nomor', 'grup_has_nomor.nomor_idnomorhp = nomor.idnomorhp');
		$this->db->where(array('grup_has_nomor.grup_idgrup' => $group_id));
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function getNotIncludedIn($group_id, $limit=null, $offset=null) {
		if ($limit != null) { $this->db->limit($limit); }
		if ($offset != null) { $this->db->offset($offset); }
		$this->db->select('*');
		$this->db->from($this->table_name);
		$sub = "idnomorhp NOT IN (SELECT nomor_idnomorhp FROM grup_has_nomor WHERE grup_idgrup =".$group_id.") AND status_aktif =1";
		$this->db->where($sub);
		$q = $this->db->get();
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	public function countNotIncludedIn($group_id) {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$sub = "idnomorhp NOT IN (SELECT nomor_idnomorhp FROM grup_has_nomor WHERE grup_idgrup =".$group_id.") AND status_aktif =1";
		$this->db->where($sub);
		$q = $this->db->get();
		return $q->num_rows();
	}

	public function countByGroupId($group_id) {
		$this->db->select('*');
		$this->db->from($this->table_name);
		$this->db->join('grup_has_nomor', 'grup_has_nomor.nomor_idnomorhp = nomor.idnomorhp');
		$this->db->where(array('grup_has_nomor.grup_idgrup' => $group_id));
		$q = $this->db->get();
		return $q->num_rows();
	}
}
?>