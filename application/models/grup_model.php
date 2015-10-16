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
}
?>