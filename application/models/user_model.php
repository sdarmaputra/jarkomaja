<?php
class User_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'user';
		$this->primary_key = 'iduser';
	}

	public function getByUserName($username) {
		$q = $this->db->get_where($this->table_name, array('username' => $username));
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else return false;
	}
}
?>