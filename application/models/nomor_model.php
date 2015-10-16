<?php
class Nomor_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'nomor';
		$this->primary_key = 'idnomorhp';
	}

	public function getByGrupId($group_id) {
		$q = $this->db->get($this->table_name);
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}
}
?>