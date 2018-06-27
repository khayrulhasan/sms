<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
  {
    parent::__construct();
  }


	public function index()
	{
		if( $this->require_role('admin') ){

			//$this->load->view('welcome_message');
			$this->layouts->view_backend('backend/content');

		}
	}

}
