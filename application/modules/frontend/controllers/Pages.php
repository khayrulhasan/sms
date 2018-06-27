<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->is_logged_in();
    $this->load->model('pages_model');
  }

  public function index()
  {
    $page = $this->uri->segment(3);
    $has_page = $this->pages_model->get_page($page);

    if($has_page)
    {
      $attr           =   array(
        'page'  =>  $has_page
      );
      $this->layouts->set_title('Pages');
      $this->layouts->view_frontend(
        'page_full_view',         // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else
    {
      $this->layouts->set_title('Pages not found | 404');
      $this->layouts->view_frontend(
        'frontend/404',         // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        ''                            //  no layouts
      );
    }
  }


}
