<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(5) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('attendance_model');
		$this->load->model('classes/classes_model');
  }

	// manage Attendance
	public function index()
  {
    $attr =   array(
			'classes'			=>  $this->classes_model->get_all_class()
    );
    $this->layouts->set_title('Manage Attendance');
    $this->layouts->view_dashboard(
      'manage_attendance_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// attendance_sheet attendance
	public function attendance_sheet($class_id = null, $attendance_date = null)
	{
		
		if($this->auth_level < 9){
			if(! get_class_by_id($class_id)) redirect('booklist/error404');
		}	

		if( $class_id == null || $attendance_date == null ) show_404();

		$attr =   array(
			'students'			=>  $this->attendance_model->get_all_students_by_class($class_id)
		);
		$this->layouts->set_title('Make Attendance');
		$this->layouts->view_dashboard(
			'make_attendance_view',         // container content data
			'backend/header',              //  Load header
			'backend/footer',              //  Load footer
			'',                            //  no layouts
			$attr                          //  pass global parametter
		);

	}


	// make attendance
	public function make()
	{
		if( $this->input->is_ajax_request() )
		{
			$attendanceDate 	= $this->input->post('attendanceDate', TRUE);
			$studentID 				= $this->input->post('studentID', TRUE);
			$classID 					= $this->input->post('classID', TRUE);
			$present 					= $this->input->post('present', TRUE);

			$feedback					=	$this->attendance_model->make($attendanceDate, $studentID, $classID, $present);
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
