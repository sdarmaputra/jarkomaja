<?php
class Report_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'report';
		$this->primary_key = 'idreport';
	}
}
?>