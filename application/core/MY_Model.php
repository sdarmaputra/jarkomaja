<?php
class MY_Model extends CI_Model {
	protected $table_name, $primary_key;
	function __construct() {
		parent:: __construct();
	}

	// Get all data inside table
	public function getAll() {
		$q = $this->db->get($this->table_name);
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}
	}

	// Get specific data inside table based on ID
	public function getById($id) {
		$this->db->limit(1);
		$q = $this->db->get_where($this->table_name, array($this->primary_key => $id));
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}	
	}

	public function getWhere($case=null, $order=null, $limit=null, $offset=null) {
		if ($case != null) { $this->db->where($case); }
		if ($order != null) { $this->db->order_by($order); }
		if ($limit != null) { $this->db->limit($limit); }
		if ($offset != null) { $this->db->offset($offset); }
		$q = $this->db->get($this->table_name);
		if ($q->num_rows() > 0) {
			return $q->result_array();
		} else {
			return false;
		}	
	}

	// Create new data in table
	public function create($details) {
		$q = $this->db->insert($this->table_name, $details);
	}

	// Update existing data inside table
	public function update($id, $details) {
		$this->db->where($this->primary_key, $id);
		$q = $this->db->update($this->table_name, $details);
	}

	// Delete existing data from table
	public function delete($id) {
		$this->db->where($this->primary_key, $id);
		$q = $this->db->delete($this->table_name);
	}

	//Count all data
	public function countAll() {
		$q = $this->db->get($this->table_name);
		return $q->num_rows();
	}

	//Count data with specific case
	public function countWhere($case) {		
		$q = $this->db->get_where($this->table_name, $case);
		return $q->num_rows();
	}
}
?>