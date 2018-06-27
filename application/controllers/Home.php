<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct()
  {

    parent::__construct();
    $this->is_logged_in();
    $this->load->model('home_model');

  }


	public function index()
	{

		$attr	=   array(
			'body_class'					 =>  'home',
			'meta_description'     =>  'Bagladesh Public School',
      'sliders'              =>  $this->home_model->get_slider(),
    );

    $this->layouts->set_title('Home | Welcome Page');

    $this->layouts->view_frontend(
      'frontend/home_content',             // container content data
      'frontend/header',              //  Load header
      'frontend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );

	}

}
