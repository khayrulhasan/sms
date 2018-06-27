<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('grade_model');
		$this->load->model('classes/classes_model');
		$this->load->model('subject/subject_model');
  }

	// manage Grade
	public function index()
  {
    $attr =   array(
			'classes'			=>  $this->classes_model->get_all_class(),
			'subjects'		=>  $this->subject_model->get_all_subject()
    );
    $this->layouts->set_title('Manage Grade');
    $this->layouts->view_dashboard(
      'manage_grade_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// grade_sheet grade
	public function grade_sheet($class_id = null, $grade_date = null)
	{
		if( $class_id == null || $grade_date == null ) show_404();

		$attr =   array(
			'students'			=>  $this->grade_model->get_all_students_by_class($class_id)
		);
		$this->layouts->set_title('Make Grade');
		$this->layouts->view_dashboard(
			'make_grade_view',         // container content data
			'backend/header',              //  Load header
			'backend/footer',              //  Load footer
			'',                            //  no layouts
			$attr                          //  pass global parametter
		);

	}


	// make grade
	public function make()
	{
		if( $this->input->is_ajax_request() )
		{
			$gradeDate 	= $this->input->post('gradeDate', TRUE);
			$studentID 				= $this->input->post('studentID', TRUE);
			$classID 					= $this->input->post('classID', TRUE);
			$present 					= $this->input->post('present', TRUE);

			$feedback					=	$this->grade_model->make($gradeDate, $studentID, $classID, $present);
			if( $feedback )
			{
				echo json_encode(array('success' => 1));
			}
			else
			{
				echo json_encode(array('success' => 0));
			}
		}
		else{
			show_404();
		}
	}

}
