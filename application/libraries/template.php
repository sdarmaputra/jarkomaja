<?php
class Template {
	var $ci;
	function __construct()  {
		$this->ci =& get_instance();
	}

	function load($usertype = null, $body = null, $data = null){
		if (!is_null($body)) {
			$body_view = $this->ci->load->view($usertype.'/'.$body, $data, TRUE);
		} else {
			$body_view = '';
		}

		if (is_array($data)) {
			$data['body'] = $body_view;
		} else if (is_null($data)) {
			$data = array('body' => $body);
		}

		$this->ci->load->view($usertype, $data);
	}
}
?>