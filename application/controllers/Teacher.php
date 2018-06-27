<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(5) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		/**
		* If user is admin
		* redirect to admin page
		*/
		if( $this->auth_role == 'admin' )
		{
			redirect('dashboard/admin', 'refresh');
		}

  }


	public function index()
	{
		if( $this->verify_min_level(5) ){
			$this->layouts->view_backend('backend/content');
		}
	}

}
