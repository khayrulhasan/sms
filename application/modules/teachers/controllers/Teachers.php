<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('teachers_model');
  }

	public function index()
	{

    $user_id =  $this->auth_data->user_id;
		$this->load->model('subject/subject_model');
		$attr	=   array(
      'subject_lists'               =>  $this->subject_model->get_all_subject(),
      'teacher_from_user_table'     =>  $this->teachers_model->get_all_teacher_from_users_table(),
    );
    $this->layouts->set_title('Add Teachers Page');
    $this->layouts->view_dashboard(
      'add_teacher_view',             // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
	}

	// Add book list
	public function add()
	{
		$submit = $this->input->post('add_teacher_btn');
    $edit   = $this->input->post('update_teacher_btn');

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
          'first_name'       => $this->input->post('first_name'),
          'last_name'   		 => $this->input->post('last_name'),
          'teacher_address'  => $this->input->post('teacher_address'),
					'gender'     			 => $this->input->post('gender'),
          'subject_id'       => $this->input->post('subject_name'),
					'user_id'    	 => $this->input->post('user_id')
        );

        if( $this->teachers_model->add_teacher($from_data) ){
          $this->session->set_flashdata('success_message', 'Teacher has been successfully added.');
          redirect('dashboard/teachers/');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Teacher Creation Failed.');
          redirect('dashboard/teachers/');
        }
      }
		}
		elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update teachers
      */
      $teacher_id = $this->input->post('teacher_id', TRUE);

      $this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $teacher_id );
      }
      else
      {
				$from_data = array(
          'first_name'       => $this->input->post('first_name'),
          'last_name'   		 => $this->input->post('last_name'),
          'teacher_address'  => $this->input->post('teacher_address'),
					'gender'     			 => $this->input->post('gender'),
					'subject_id'    	 => $this->input->post('subject_name'),
          'user_id'      => $this->input->post('user_id')
        );

        if( $this->teachers_model->edit_teacher($teacher_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Teacher has been successfully Edited.');
         	redirect('dashboard/teachers/manage', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Teacher Editing Failed.');
          redirect('dashboard/teachers/manage', 'refresh');
        }
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
		$this->form_validation->set_rules('first_name','First Name','required|trim|min_length[2]|xss_clean', array(
      'min_length'    => 'First Name should be min 2 charachers more.',
    ));
		$this->form_validation->set_rules('last_name','Last Name','required|trim|min_length[2]|xss_clean', array(
      'min_length'    => 'Last Name should be min 2 charachers more.',
    ));
    $this->form_validation->set_rules('teacher_address','Address','trim|xss_clean');
		$this->form_validation->set_rules('gender','Gender','required|xss_clean');
    $this->form_validation->set_rules('subject_name','Subject','required|xss_clean');
    $this->form_validation->set_rules('user_id','Teacher','trim|xss_clean|min_length[3]', array(
      'min_length'=> 'Please select a teacher email address which you want to add information'
    ));

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

	// manage teachers
	public function manage()
  {
    $attr =   array(
      'teachers'        =>  $this->teachers_model->get_all_teachers()
    );
    $this->layouts->set_title('Manage Teachers');
    $this->layouts->view_dashboard(
      'manage_teachers_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// update teachers
  public function update( $id = null )
  {
     $user_id =  $this->auth_data->user_id;
    //catch widget id from edit given id or url segment
    $teacher_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $teacher_id ){

      if( ! $this->teachers_model->get_all_teachers($teacher_id) ) redirect('dashboard/teachers/manage');
      //call view page
			$this->load->model('subject/subject_model');
      $attr           =   array(
	    'subject_lists'               =>  $this->subject_model->get_all_subject(),
      'teacher_history'             =>  $this->teachers_model->get_all_teachers($teacher_id),
      'teacher_from_user_table'     =>  $this->teachers_model->get_all_teacher_from_users_table(),
      );

      $this->layouts->set_title('Edit Teacher');
      $this->layouts->view_dashboard(
        'add_teacher_view',           //  container content data
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

	// Delete Teacher
	public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('teachers', array('id' => $id));  // Produces: // DELETE FROM widgets  // WHERE id = $id
    if( $this->db->affected_rows() === 1 ){
      $this->session->set_flashdata('success_message', 'Teacher deleted sucessfully');
      redirect('dashboard/teachers/manage', 'refresh');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid ID');
      redirect('dashboard/teachers/manage', 'refresh');
    }
  }



  public function error404()
  {
    $this->layouts->set_title('Pages not found | 404');
    $this->layouts->view_frontend(
      'backend/404',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      ''                            //  no layouts
    );
  }

  
}
