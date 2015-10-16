<?php
class User_model extends MY_Model {
	function __construct() {
		parent:: __construct();
		$this->table_name = 'user';
		$this->primary_key = 'iduser';
	}
}
?>