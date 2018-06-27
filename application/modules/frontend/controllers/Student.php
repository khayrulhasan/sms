<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('student_model');
    // verify_min_level
    if( ! $this->verify_min_level(1) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
  }

  public function index()
  {

      $attr           =   array(

      );
      $this->layouts->set_title('Student');
      $this->layouts->view_frontend(
        'panel/student_index',               // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                             //  no layouts
        $attr                           //  pass global parametter
      );
  }
  public function notice()
  {
    $this->load->model('notice/notice_model');
      $attr           =   array(
        'notice'      => $this->notice_model->get_all_notice(),
      );
      $this->layouts->set_title('Student');
      $this->layouts->view_frontend(
        'panel/student_index',               // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                             //  no layouts
        $attr                           //  pass global parametter
      );
  }
  public function marksheet()
  {

      $attr           =   array(
        'student'           => get_student_by_user_id($this->auth_user_id),
        'student_marksheet' => $this->student_model->get_markshet_by_student_id(get_student_by_user_id($this->auth_user_id)[0]->id),
      );
      $this->layouts->set_title('Student');
      $this->layouts->view_frontend(
        'panel/student_index',               // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                             //  no layouts
        $attr                           //  pass global parametter
      );
  }
  public function booklist()
  {
      $attr           =   array(
          'student_booklist' => $this->student_model->get_student_booklist(),
      );
      $this->layouts->set_title('Student');
      $this->layouts->view_frontend(
        'panel/student_index',               // container content data
        'frontend/header',              //  Load header
        'frontend/footer',              //  Load footer
        '',                             //  no layouts
        $attr                           //  pass global parametter
      );
  }


}
