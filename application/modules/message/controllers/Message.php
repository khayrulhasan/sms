<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
			// var_dump( $this->uri->uri_string() );die();
      redirect('login/logout', 'refresh');
    }

		$this->load->model('message_model');
  }
   
  public function index()
  {
   
 
    $this->layouts->set_title('Message Page');

    $attr           =   array(
      'meta_description'     =>  'Bagladesh Public School',
      );
    $this->layouts->view_dashboard(
      'add_message_view',             //  container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );

  }


  // add or update method
  public function add_message()
  {
    $submit = $this->input->post('add_message_btn');
    $edit   = $this->input->post('update_message_btn');

    if( !empty( $submit ) && isset($submit) )
    {
      // checking validation
      $this->_validation_message();

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {
        //get data from input
        $from_data = array(
          'title'        => $this->input->post('message_title'),
          'description'  => $this->input->post('message_description'),
          'image'        => $this->file_name,
          'message_owner'  => $this->input->post('author_type'),
          'create_at'    => date('Y-m-d H:i:s'),
        );

        //insert data into database
        if( $this->message_model->add_message($from_data)){
          $this->session->set_flashdata('success_message', 'Message has been successfully added.');
          redirect('dashboard/message/insert-message');
        }

        else{
          $this->session->set_flashdata('error_message', 'Message Creation Failed.');
          redirect('dashboard/message/insert-message');
        }

      }
    }
    elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update
      */
      $message_id = $this->input->post('message_id', TRUE);

      $this->_validation_message();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $message_id );
      }
      else
      {

        $from_data = array(
          'title'        => $this->input->post('message_title'),
          'description'  => $this->input->post('message_description'),
          'image'        => $this->file_name,
          'message_owner'  => $this->input->post('author_type'),
        );

        if( $this->message_model->edit_message($message_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Message has been successfully Edited.');
          redirect('dashboard/message/manage-message', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Message Editing Failed.');
          redirect('dashboard/message/manage-message', 'refresh');
        }
      }
    }
    else{
      show_404();
    }
  }

  // form validation of add and update 
  private function _validation_message($is_edit = false, $id = null)
  {
    
    $this->form_validation->set_rules('message_title', 'Message title', 'trim|min_length[2]|max_length[100]|required|xss_clean', array(
      'min_length'    => 'Message Title should be min 2 charachers.',
    ));
    $this->form_validation->set_rules('message_description','Message description','trim|min_length[3]|required|xss_clean', array(
      'min_length'    => 'Message description should be min 3 charachers.',
    ));

    $this->form_validation->set_rules('image','Message image','trim|xss_clean|callback_is_attach');
    $this->form_validation->set_rules('author_type','Author Type','trim|xss_clean|min_length[3]', array(
      'min_length'=> 'Please select Author type'
    )); 
   
    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

  //Manage Message Page
  public function manage_message()
  {
    $attr           =   array(
    'messages'                  =>  $this->message_model->get_message(),
    'meta_description'     =>  'Bagladesh Public School',
    );
    $this->layouts->set_title('Manage Message Page');
    $this->layouts->view_dashboard(
      'manage_message_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

  //delete single Message 
  public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('message', array('id' => $id));
    if( $this->db->affected_rows() > 0 )
    {
      $this->session->set_flashdata('success_message', 'Message deleted with sucessfully');
      redirect('dashboard/message/manage-message', 'refresh');
    }  else {
      $this->session->set_flashdata('error_message', 'Invalid Page');
      redirect('dashboard/message/manage-message','refresh');
    }
  }

  public function update( $id = null )
  {
    //catch Message id from edit given id or url segment
    $message_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $message_id ){

      if( ! $this->message_model->get_message($message_id) ) redirect('dashboard/message/manage-message');
      //call view page
      $attr           =   array(
        'message_history'  =>  $this->message_model->get_message($message_id),
        'meta_description'     =>  'Bagladesh Public School',
      );

      $this->layouts->set_title('Edit Message');
      $this->layouts->view_dashboard(
        'add_message_view',             //  container content data
        'backend/header',               //  Load header
        'backend/footer',               //  Load footer
        '',                             //  no layouts
        $attr                           //  pass global parametter
      );
    }
    else{
      $this->manage_messages();
    }
  }


  // This function call in validation
  // image upload in directory
  // and back to error message or file name

  public function is_attach()
  {
    //if image file select empty show error message
    if( empty( $_FILES['image']['name'] ) )
    {

      // hidden field not empty (like as update) and submit button file name get from hidden field
      if( !empty( $this->input->post('edited_file_name') ) && $this->input->post('update_message_btn') )
      {
        $this->file_name = $this->input->post('edited_file_name');
        return TRUE;
      }
      //if attach empty return with error message
      $this->form_validation->set_message('is_attach', 'Pleas attach a valid image file.');
      return FALSE;

    }

    // for new attach file
    //get image name from attach field
    $files = $_FILES['image']['name'];

    // if attach, ready to go upload in directory
    if( !empty($files) )
    {
      $config['upload_path']          = './public/frontend/images/teachers/';
      $config['allowed_types']        = 'jpeg|jpg|png|JPEG|PNG|JPG';
      $config['encrypt_name']         = TRUE;
      // Load upload library
      $this->load->library('upload', $config);
      //if upload return with image name
      if ( $this->upload->do_upload('image') )
      {
        $data = $this->upload->data();
        $this->file_name = $data['file_name'];
        return TRUE;
      }
      else
      {
        //if upload error return with error message
        $this->form_validation->set_message('is_attach', 'Upload formate should be jpeg|jpg|png');
        return FALSE;
      }
    }
    return TRUE;
  }//End is attach for image upload
	
}
