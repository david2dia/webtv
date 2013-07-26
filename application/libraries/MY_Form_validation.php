<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');	

class MY_Form_validation extends CI_Form_validation {

	public function __construct()
	{
		parent::__construct();
	}

	public function clear_field_data() {

		$this->_field_data = array();
		return $this;
	}


	public function valid_date($str)
	{ 
		return (!preg_match('((0[1-9]|1[012])[/](0[1-9]|[12][0-9]|3[01])[/](19|20)\d\d)',$str));
	}
}	
?>