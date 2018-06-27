<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_event extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
			// var_dump( $this->uri->uri_string() );die();
      redirect('login/logout', 'refresh');
    }

		$this->load->model('news_event_model');
  }
   
  public function index()
  {
   
 
    $this->layouts->set_title('News & Event Page');

    $attr           =   array(
      'meta_description'     =>  'Bagladesh Public School',
      );
    $this->layouts->view_dashboard(
      'add_news_event_view',             //  container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );

  }


  // add or update method
  public function add_news_event()
  {
    $submit = $this->input->post('add_news_event_btn');
    $edit   = $this->input->post('update_news_event_btn');

    if( !empty( $submit ) && isset($submit) )
    {
      // checking validation
      $this->_validation_news_event();

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {

        //get data from input
        $from_data = array(
          'title'        => $this->input->post('news_event_title'),
          'description'  => $this->input->post('news_event_description'),
          'image'        => $this->file_name,
          'create_at'    => date('Y-m-d H:i:s'),
        );

        //insert data into database
        if( $this->news_event_model->add_news_event($from_data)){
          $this->session->set_flashdata('success_message', 'News & event has been successfully added.');
          redirect('dashboard/news-event/insert-news-event');
        }

        else{
          $this->session->set_flashdata('error_message', 'News & event Creation Failed.');
          redirect('dashboard/news-event/insert-news-event');
        }

      }
    }
    elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update
      */
      $news_event_id = $this->input->post('news_event_id', TRUE);

      $this->_validation_news_event();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $news_event_id );
      }
      else
      {

        $from_data = array(
          'title'        => $this->input->post('news_event_title'),
          'description'  => $this->input->post('news_event_description'),
          'image'        => $this->file_name,
        );

        if( $this->news_event_model->edit_news_event($news_event_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'News & Event has been successfully Edited.');
          redirect('dashboard/news-event/manage-news-events', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'News & event Editing Failed.');
          redirect('dashboard/news-event/manage-news-events', 'refresh');
        }
      }
    }
    else{
      show_404();
    }
  }

  // form validation of add and update 
  private function _validation_news_event($is_edit = false, $id = null)
  {
    
    $this->form_validation->set_rules('news_event_title', 'News & event title', 'trim|min_length[2]|max_length[100]|required|xss_clean', array(
      'min_length'    => 'News & Event Title should be min 2 charachers.',
    ));
    $this->form_validation->set_rules('news_event_description','News & event description','trim|min_length[3]|required|xss_clean', array(
      'min_length'    => 'News & Event description should be min 3 charachers.',
    ));

    $this->form_validation->set_rules('image','Event image','trim|xss_clean|callback_is_attach');
   
    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

  //Manage Event Page
  public function manage_news_events()
  {
    $attr           =   array(
    'news_events'                  =>  $this->news_event_model->get_news_event(),
    'meta_description'     =>  'Bagladesh Public School',
    );
    $this->layouts->set_title('Manage News & Event Page');
    $this->layouts->view_dashboard(
      'manage_news_event_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

  //delete single event 
  public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('news_event', array('id' => $id));
    if( $this->db->affected_rows() > 0 )
    {
      $this->session->set_flashdata('success_message', 'News & event deleted with sucessfully');
      redirect('dashboard/news-event/manage-news-events', 'refresh');
    }  else {
      $this->session->set_flashdata('error_message', 'Invalid Page');
      redirect('dashboard/news-event/manage-news-evets','refresh');
    }
  }

  public function update( $id = null )
  {
    //catch event id from edit given id or url segment
    $news_evet_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $news_evet_id ){

      if( ! $this->news_event_model->get_news_event($news_evet_id) ) redirect('dashboard/news-event/manage-news-events');
      //call view page
      $attr           =   array(
        'news_event_history'  =>  $this->news_event_model->get_news_event($news_evet_id),
        'meta_description'     =>  'Bagladesh Public School',
      );

      $this->layouts->set_title('Edit News & Event');
      $this->layouts->view_dashboard(
        'add_news_event_view',           //  container content data
        'backend/header',              //  Load header
        'backend/footer',              //  Load footer
        '',                              //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else{
      $this->manage_news_events();
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
      if( !empty( $this->input->post('edited_file_name') ) && $this->input->post('update_news_event_btn') )
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
      $config['upload_path']          = './public/frontend/images/events/';
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
