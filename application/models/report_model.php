<?php
class Report_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'report';
		$this->primary_key = 'idreport';
	}

	public function getWhere($case=null, $order=null, $limit=null, $offset=null) {
		if ($case != null) { $this->db->where($case); }
		if ($order != null) { $this->db->order_by($order); }
		if ($limit != null) { $this->db->limit($limit); }
		if ($offset != null) { $this->db->offset($offset); }
		$this->db->join('grup', 'report.idgrup = grup.idgrup');
		$this->db->join('nomor', 'report.idnomor = nomor.idnomorhp');
		$q = $this->db->get($this->table_name);
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}	
	}
}
?>