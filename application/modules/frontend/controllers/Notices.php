<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notices extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->is_logged_in();
    $this->load->model('notices_model');
  }

  public function index()
  {
    $id = $this->uri->segment(3);
    if(empty($id))
    {
      $has_notices = $this->notices_model->get_notice();

      $attr           =   array(
        'notices'  =>  $has_notices
      );
      $this->layouts->set_title('Notice List');
      $this->layouts->view_frontend(
        'notice_list_view',         // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else
    {
      $has_notice = $this->notices_model->get_notice($id);
      if($has_notice)
      {
        $attr           =   array(
          'notice'  =>  $has_notice
        );
        $this->layouts->set_title('Notice');
        $this->layouts->view_frontend(
          'notice_full_view',         // container content data
          'frontend/header',              //  Load header
          'frontend/footer',              //  Load footer
          '',                            //  no layouts
          $attr                          //  pass global parametter
        );
      }
      else
      {
        $this->error404();
      }
    }
  }

  public function error404()
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
