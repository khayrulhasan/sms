<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    // verify_min_level
    if( ! $this->verify_min_level(5) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
    $this->load->model('profile_models');
  }

  public function index()
  {
    $attr =   array(
      'user'        =>  $this->profile_models->get_profile_by_id($this->auth_user_id),
      'profile'     =>  $this->profile_models->get_profile_and_meta_by_id($this->auth_user_id)
    );
    $this->layouts->set_title('Profile');
    $this->layouts->view_dashboard(
      'profile_view',               // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr
    );
  }

  // upload profile image
  public function upload()
  {
    // for new attach file
    $files = $_FILES['image']['name'];

    if( !empty($files) )
    {
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'jpg|png';
      $config['encrypt_name'] = TRUE;

      $this->load->library('upload', $config);

      if ( $this->upload->do_upload('image') )
      {
        $data = $this->upload->data();
        //$this->file_name = $data['file_name'];
        $this->profile_models->save_url($data['file_name']);
        redirect('dashboard/profile');

      }
      else
      {
        $this->session->set_flashdata('upload_failed', 'Failed');
        redirect('dashboard/profile');
      }
    }
  }

  public function add_profile()
  {

    $profile_id = $this->auth_user_id;
    $this->form_validation->set_rules('full_name', 'Name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('contact','Phone','trim|min_length[11]|xss_clean');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

    if ($this->form_validation->run() == FALSE)
    {
      //echo "string";exit;
      $this->session->set_flashdata('error_message', 'Validation Failed');
      return $this->index();
    }
    else
    {
      $form_data = array(
        'full_name'             => $this->input->post('full_name'),
        'address'               => $this->input->post('address'),
        'bio'                   => $this->input->post('bio')
      );
      $feedback = $this->profile_models->edit_profile($profile_id, $form_data);
      if( $feedback )
      {
        date_default_timezone_set("Asia/Dhaka");
        $date = date("Y-m-d h:i:sa");
        $this->db->update('users', array('phone' => $this->input->post('contact'), 'created_at' => $date));

        $this->session->set_flashdata('success_message', 'Profile has been successfully updated.');
        redirect('dashboard/profile');
      }
      else{
        $this->session->set_flashdata('error_message', 'Profile update Failed');
        redirect('dashboard/profile');
      }
    }

  }



}
