<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
			// var_dump( $this->uri->uri_string() );die();
      redirect('login/logout', 'refresh');
    }

		$this->load->model('classes_model');
  }

	public function index()
	{
		$this->load->model('teachers/teachers_model');
		$attr =   array(
      'teachers'        =>  $this->teachers_model->get_all_teachers()
    );
    $this->layouts->set_title('Add Class Page');
    $this->layouts->view_dashboard(
      'add_class_view',             // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                           //  no layouts
      $attr                          //  pass global parametter
    );
	}

	// Add book list
	public function add()
	{

		$submit = $this->input->post('add_class_btn');
    $edit   = $this->input->post('update_class_btn');

    if( !empty( $submit ) && isset($submit) )
    {
			$this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {
				$from_data = array(
					'class_id'       => $this->input->post('class_id'),
          'teacher_id'       => $this->input->post('teacher_id'),
					'note'      			 => $this->input->post('note')
        );
        $this->classes_model->add_class($from_data);
        redirect('dashboard/class');
        
      }
		}
		elseif ( !empty( $edit ) && isset($edit) )
    {
      //This section is for update class
      
      $id = $this->input->post('class_table_id', TRUE);

      $this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $id );

      }
      else
      {
		    $from_data = array(
          'class_id'       => $this->input->post('class_id'),
          'teacher_id'       => $this->input->post('teacher_id'),
          'note'             => $this->input->post('note')
        );
        $this->classes_model->edit_class($id, $from_data);
        redirect('dashboard/class/manage');
      }
    }
    else
    {
      show_404();
    }

	}

	// validate
  private function _validate()
  {
		$this->form_validation->set_rules('class_id','class name','trim|xss_clean|is_natural_no_zero',array('is_natural_no_zero' => 'Please select class name' ));
		$this->form_validation->set_rules('teacher_id','Teacher','trim|xss_clean|is_natural_no_zero',array('is_natural_no_zero' => 'Please select Teacher name' ));
    $this->form_validation->set_rules('note','Class Note','trim|xss_clean');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }


	// manage class
	public function manage()
  {
    $attr =   array(
      'class'        =>  $this->classes_model->get_all_class()
    );
    $this->layouts->set_title('Manage Class');
    $this->layouts->view_dashboard(
      'manage_class_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// update class
  public function update( $id = null )
  {
    //catch widget id from edit given id or url segment
    $class_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $class_id ){

      if( ! $this->classes_model->get_all_class($class_id) ) redirect('dashboard/class/manage');

			$this->load->model('teachers/teachers_model');
      $attr           =   array(
				'teachers'        =>  $this->teachers_model->get_all_teachers(),
        'class_history'  =>  $this->classes_model->get_all_class($class_id)
      );

      $this->layouts->set_title('Edit Class');
      $this->layouts->view_dashboard(
        'add_class_view',           //  container content data
        'backend/header',              //  Load header
        'backend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else{
      $this->manage();
    }
  }

	// Delete Class
	public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('class', array('class_id' => $id));  // Produces: // DELETE FROM widgets  // WHERE id = $id
    if( $this->db->affected_rows() === 1 ){
      $this->session->set_flashdata('success_message', 'Class deleted sucessfully');
      redirect('dashboard/class/manage', 'refresh');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid ID');
      redirect('dashboard/class/manage', 'refresh');
    }
  }

}
