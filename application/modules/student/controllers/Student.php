<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('student_model');
  }

	public function index()
	{

		$this->load->model('classes/classes_model');
		$attr	=   array(
      'student_from_user_table'   =>  $this->student_model->get_all_student_from_users_table(),
    );
    $this->layouts->set_title('Add Student Page');
    $this->layouts->view_dashboard(
      'add_student_view',            // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
	}

	// Add book list
	public function add()
	{
		$submit = $this->input->post('add_student_btn');
    $edit   = $this->input->post('update_student_btn');

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
          'name'       			 => $this->input->post('name'),
					'father_name'    	 => $this->input->post('father_name'),
					'mother_name'    	 => $this->input->post('mother_name'),
					'date_of_birth'    => $this->input->post('date_of_birth'),
          'nid_bs'   		 		 => $this->input->post('nid_bs'),
          'address'  				 => $this->input->post('address'),
					'gender'     			 => $this->input->post('gender'),
					'class_id'    	   => $this->input->post('class_id'),
					'group'    	   		 => $this->input->post('group'),
          'contact_number'   => $this->input->post('contact_number'),
					'user_id'          => $this->input->post('user_id')
        );

        if( $this->student_model->add_student($from_data) ){
          $this->session->set_flashdata('success_message', 'Student has been successfully added.');
          redirect('dashboard/student/');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Student Creation Failed.');
          redirect('dashboard/student/');
        }
      }
		}
		elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update student
      */
      $student_id = $this->input->post('student_id', TRUE);

      $this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $student_id );
      }
      else
      {

				$from_data = array(
          'name'       			 => $this->input->post('name'),
					'father_name'    	 => $this->input->post('father_name'),
					'mother_name'    	 => $this->input->post('mother_name'),
					'date_of_birth'    => $this->input->post('date_of_birth'),
          'nid_bs'   		 		 => $this->input->post('nid_bs'),
          'address'  				 => $this->input->post('address'),
					'gender'     			 => $this->input->post('gender'),
					'class_id'    	   => $this->input->post('class_id'),
					'group'    	   		 => $this->input->post('group'),
          'contact_number'   => $this->input->post('contact_number'),
					'user_id'          => $this->input->post('user_id')
        );

        if( $this->student_model->edit_student($student_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Student has been successfully Edited.');
         	redirect('dashboard/student/manage', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Student Editing Failed.');
          redirect('dashboard/student/manage', 'refresh');
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
		$this->form_validation->set_rules('name','Name','required|trim|min_length[2]|xss_clean', array(
      'min_length'    => 'Name should be min 2 charachers more.',
    ));
		$this->form_validation->set_rules('father_name','Father\'s Name','required|trim|min_length[2]|xss_clean', array(
      'min_length'    => 'Father\'s Name should be min 2 charachers more.',
    ));
		$this->form_validation->set_rules('mother_name','Mother\'s Name','required|trim|min_length[2]|xss_clean', array(
      'min_length'    => 'Mother\'s Name should be min 2 charachers more.',
    ));
		$this->form_validation->set_rules('date_of_birth','Date of Birth','required|trim|xss_clean');
		$this->form_validation->set_rules('nid_bs','NID / Birth Certificate','trim|xss_clean');
    $this->form_validation->set_rules('address','Address','trim|xss_clean');
		$this->form_validation->set_rules('gender','Gender','required|xss_clean');
    $this->form_validation->set_rules('class_id','Class','required|xss_clean');
    $this->form_validation->set_rules('group','Group','required|xss_clean');
    $this->form_validation->set_rules('contact_number','Contact Number','required|xss_clean');
    $this->form_validation->set_rules('user_id','Student Email','required|xss_clean');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

	// manage student
	public function manage()
  {
    $attr =   array(
      'student'        =>  $this->student_model->get_all_student()
    );
    $this->layouts->set_title('Manage Student');
    $this->layouts->view_dashboard(
      'manage_student_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// update student
  public function update( $id = null )
  {
    //catch widget id from edit given id or url segment
    $student_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $student_id ){

      if( ! $this->student_model->get_student_by_id($student_id) ) redirect('dashboard/student/manage');
      //call view page
			$this->load->model('classes/classes_model');
      $attr           =   array(
        'student_history'  =>  $this->student_model->get_student_by_id($student_id),
        'student_from_user_table'   =>  $this->student_model->get_all_student_from_users_table(),
      );

      $this->layouts->set_title('Edit Student');
      $this->layouts->view_dashboard(
        'add_student_view',           //  container content data
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

	// Delete Student
	public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('student', array('id' => $id));  // Produces: // DELETE FROM widgets  // WHERE id = $id
    if( $this->db->affected_rows() === 1 ){
      $this->session->set_flashdata('success_message', 'Student deleted sucessfully');
      redirect('dashboard/student/manage', 'refresh');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid ID');
      redirect('dashboard/student/manage', 'refresh');
    }
  }

}
