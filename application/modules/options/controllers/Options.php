<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Options extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    // verify_min_level
    if( ! $this->verify_min_level(6) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

    $this->load->model('options_model');

  }


  public function index()
  {
    $this->layouts->set_title('Options');
    $this->layouts->view_dashboard(
      'manage_options_view',            // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      ''                            //  no layouts
      //$attr                          //  pass global parametter
    );
  }

  // update options
  public function update_options()
  {
    $this->_validate();

    if ($this->form_validation->run() == FALSE)
    {
      $this->index();
    }
    else
    {
      $from_data = array(
        'dashboard_site_title'        => $this->input->post('site_title'),
        'dashboard_copyright_text'    => $this->input->post('copyright_text'),
        'dashboard_admin_footer_text' => $this->input->post('admin_footer_text'),
        'dashboard_company_address'   => $this->input->post('company_address'),
        'dashboard_google_analytics'  => $this->input->post('google_analytics'),
        'dashboard_custome_css'       => $this->input->post('custome_css'),
      );

      if( $this->options_model->update_options($from_data) ){
        $this->session->set_flashdata('success_message', 'Options has been successfully Updated.');
        redirect('dashboard/options/');
      }
      else
      {
        $this->session->set_flashdata('error_message', 'Options Update Failed.');
        redirect('dashboard/options/');
      }
    }
  }

  // validate
  private function _validate()
  {
    $this->form_validation->set_rules('site_title','Site Title','trim|xss_clean');
    $this->form_validation->set_rules('copyright_text','Copyright Text','trim|xss_clean');
    $this->form_validation->set_rules('admin_footer_text','Admin Footer Text','trim|xss_clean');
    $this->form_validation->set_rules('company_address','Company Address','trim|xss_clean');
    $this->form_validation->set_rules('google_analytics','Google Code','trim');
    $this->form_validation->set_rules('custome_css','Custome CSS','trim|xss_clean');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }


}
