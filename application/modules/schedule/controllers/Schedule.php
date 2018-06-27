<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
			// var_dump( $this->uri->uri_string() );die();
      redirect('login/logout', 'refresh');
    }

		$this->load->model('schedule_model');
  }
   
  public function index()
  {
   
 
    $this->layouts->set_title('Slider Page');

    $attr           =   array(
      'meta_description'     =>  'Bagladesh Public School',
      );
    $this->layouts->view_dashboard(
      'view',             //  container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );

  }


  // add or update method
  public function add_slider()
  {
    $submit = $this->input->post('add_slider_btn');
    $edit   = $this->input->post('update_slider_btn');

    if( !empty( $submit ) && isset($submit) )
    {
      // checking validation
      $this->_validation_slider();

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {
        //get data from input
        $from_data = array(
          'title'        => $this->input->post('slider_title'),
          'description'  => $this->input->post('slider_description'),
          'image'        => $this->file_name,
        );

        //insert data into database
        if( $this->sliders_model->add_slider($from_data)){
          $this->session->set_flashdata('success_message', 'Slider has been successfully added.');
          redirect('dashboard/sliders/insert-slider');
        }
        else{
          $this->session->set_flashdata('error_message', 'Slider Creation Failed.');
          redirect('dashboard/sliders/insert-slider');
        }
      }
    }
    elseif ( !empty( $edit ) && isset($edit) )
    {
            /**
      * This section is for update notice
      */
      $slider_id = $this->input->post('slider_id', TRUE);

      $this->_validation_slider();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $slider_id );
      }
      else
      {

        $from_data = array(
          'title'        => $this->input->post('slider_title'),
          'description'  => $this->input->post('slider_description'),
          'image'        => $this->file_name,
        );

        if( $this->sliders_model->edit_slider($slider_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Slider has been successfully Edited.');
          redirect('dashboard/sliders/manage-sliders', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Slider Editing Failed.');
          redirect('dashboard/sliders/manage-sliders', 'refresh');
        }
      }
    }
    else{
      show_404();
    }
  }

  // form validation of add and update slider
  private function _validation_slider($is_edit = false, $id = null)
  {
    
    $this->form_validation->set_rules('slider_title', 'slider title', 'trim|min_length[2]|max_length[100]|required|xss_clean', array(
      'min_length'    => 'Slider Title should be min 2 charachers.',
    ));
    $this->form_validation->set_rules('slider_description','slider description','trim|min_length[3]|required|xss_clean', array(
      'min_length'    => 'Slider description should be min 3 charachers.',
    ));

    $this->form_validation->set_rules('image','slider image','trim|xss_clean|callback_is_attach');
   
    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

  //Manage Slider Page
  public function manage_sliders()
  {
    $attr           =   array(
    'sliders'                  =>  $this->sliders_model->get_slider(),
    'meta_description'     =>  'Bagladesh Public School',
    );
    $this->layouts->set_title('Manage Sliders');
    $this->layouts->view_dashboard(
      'manage_sliders_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

  //delete single slider 
  public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('sliders', array('id' => $id));
    if( $this->db->affected_rows() > 0 )
    {
      $this->session->set_flashdata('success_message', 'Slider deleted with sucessfully');
      redirect('dashboard/sliders/manage-sliders', 'refresh');
    }  else {
      $this->session->set_flashdata('error_message', 'Invalid Page');
      redirect('dashboard/sliders/manage-sliders','refresh');
    }
  }

  public function update( $id = null )
  {
    //catch slider id from edit given id or url segment
    $slider_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $slider_id ){

      if( ! $this->sliders_model->get_slider($slider_id) ) redirect('dashboard/sliders/manage-sliders');
      //call view page
      $attr           =   array(
        'slider_history'  =>  $this->sliders_model->get_slider($slider_id),
        'meta_description'     =>  'Bagladesh Public School',
      );

      $this->layouts->set_title('Edit Slider');
      $this->layouts->view_dashboard(
        'add_slider_view',           //  container content data
        'backend/header',              //  Load header
        'backend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else{
      $this->manage_sliders();
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
      if( !empty( $this->input->post('edited_file_name') ) && $this->input->post('update_slider_btn') )
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
      $config['upload_path']          = './public/frontend/images/slider/';
      $config['allowed_types'] = 'gif|jpeg|jpg|png|JPEG|PNG|GIF|JPG';
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
