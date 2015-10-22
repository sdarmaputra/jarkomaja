<?php
class MY_Controller extends CI_Controller {
	function __construct() {
		parent:: __construct();
		//date_default_timezone_set("Asia/Jakarta");
		header("Access-Control-Allow-Origin: *");
		$this->load->library('template');
		$this->config->set_item('site_name', 'JARKOMAJA');
		$this->config->set_item('gammu_url', 'http://10.151.36.55:3000/');
	}
}
?>