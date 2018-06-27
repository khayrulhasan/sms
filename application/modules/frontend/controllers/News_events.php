<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class News_events extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->is_logged_in();
    $this->load->model('news_event_model');
  }

  public function index()
  {
    $id = $this->uri->segment(3);
    if(empty($id))
    {
      $attr           =   array(
      );
      $this->layouts->set_title('Event');
      $this->layouts->view_frontend(
        'news_event_list_view',         // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else
    {
       $attr           =   array(
        'single_news_event'                  =>  $this->news_event_model->get_news_event($id),
      );
      $this->layouts->set_title('Event');
      $this->layouts->view_frontend(
        'single_event_view',         // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
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
