<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template extends CI_Controller {

	public function index()
	{
		$this->load->view('EmailTemplate/template');
	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */