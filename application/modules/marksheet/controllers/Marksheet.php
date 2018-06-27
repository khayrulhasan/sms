<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marksheet extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(5) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('marksheet_model');
		$this->load->model('classes/classes_model');
  }

	// manage marksheet
	public function index()
  {
    $attr =   array(
			'classes'			=>  $this->classes_model->get_all_class()
    );
    $this->layouts->set_title('Manage marksheet');
    $this->layouts->view_dashboard(
      'manage_marksheet_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// Make marksheet
	public function make_marksheet($arrayName = null)
	{
    // var_dump($arrayName);
		// if($this->auth_level < 9){
		// 	if(check_class_id($arrayName['class_id']) == false) redirect('booklist/error404');
		// }

		/**
		* If class and subject is set via GO btn clicked
		*/
		if( !empty($arrayName) )
		{
			// var_dump($arrayName);exit;
			$attr =   array(
				'students'			  =>  $this->marksheet_model->get_all_students_by_class($arrayName),
	      'th_field'        =>  $this->marksheet_model->get_marks_dis_field($arrayName),
	      'asign_class'     =>  $this->marksheet_model->get_only_asign_class(),
	      'get_subject'     =>  $this->marksheet_model->get_subject_by_assigned_class($arrayName['class_id']),
	      'search_data'     =>  $arrayName,
			);
		}
		else
		{
			$attr =   array(
				'students'			  =>  'init',//$this->marksheet_model->get_all_students_by_class($arrayName),
				'th_field'        =>  array(0),//$this->marksheet_model->get_marks_dis_field($arrayName),
				'asign_class'     =>  $this->marksheet_model->get_only_asign_class(),
				'get_subject'     =>  array(),//$this->marksheet_model->get_subject_by_assigned_class(),
				'search_data'     =>  $arrayName,
			);
		}


		$this->layouts->set_title('Make marksheet');
		$this->layouts->view_dashboard(
			'make_marksheet_view',         // container content data
			'backend/header',              //  Load header
			'backend/footer',              //  Load footer
			'',                            //  no layouts
			$attr                          //  pass global parametter
		);
	}

// add or update method
  public function add_or_update_marks()
  {
		// var_dump($_POST);exit;

    $class_id  = $this->input->post('search_class_id');
    $subject_id  = $this->input->post('search_subject_id');
    $arrayName = array('class_id' =>  $class_id, 'subject_id' =>  $subject_id);
    $Save_student_marks = $this->input->post('Save_student_marks');
    $update = $this->input->post('update_mark_dist');
    $submit = $this->input->post('submit');

		/**
		* $submit if is clicked on Go btn
		*/
    if( !empty( $submit ) && isset($submit) )
    {
      //$this->form_validation->set_rules('class_id', 'class', 'trim|is_natural_no_zero',array('is_natural_no_zero'=>'<span>Warning! To Set Marks Distributon Select class > Select Subject > GO'));
      //$this->form_validation->set_rules('subject_id', 'subject', 'trim|is_natural_no_zero',array('is_natural_no_zero'=>'<span>Warning! Select class > Select Subject > GO'));
      //$this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
      //if ($this->form_validation->run() == FALSE)
      //{
        //$this->make_marksheet();
      //}else{
        $this->make_marksheet( $arrayName);
      //}
    }if(!empty( $Save_student_marks ) && isset($Save_student_marks)){

      $first_ex = $this->input->post('first_ex[]');
      $second_ex = $this->input->post('second_ex[]');
      $final_ex = $this->input->post('final_ex[]');
      $class_test = $this->input->post('class_test[]');
      $quiz_test = $this->input->post('quiz_test[]');
      $lab_test = $this->input->post('lab_test[]');
      $attendence = $this->input->post('attendence[]');
      $extra_curi = $this->input->post('extra_curi[]');
      $student_id = $this->input->post('student_id[]');
      $class_id = $this->input->post('class_id[]');
      $subject_id = $this->input->post('subject_id[]');
      $marks_id = $this->input->post('marks_id[]');
      $count = count($student_id);

      for($i=0; $i<$count; $i++) {
      $data = array(
         'first_ex' => $first_ex[$i],
         'second_ex' => $second_ex[$i],
         'final_ex' => $final_ex[$i],
         'class_test' => $class_test[$i],
         'quiz_test' => $quiz_test[$i],
         'lab_test' => $lab_test[$i],
         'attendence' => $attendence[$i],
         'extra_curi' => $extra_curi[$i],
         'student_id' => $student_id[$i],
         'class_id' => $class_id[$i],
         'subject_id' => $subject_id[$i],
         'id' => $marks_id[$i],
      );


      $query = $this->db->get_where('marksheet',array('student_id'=>$data['student_id'],'class_id'=>$data['class_id'], 'subject_id'=>$data['subject_id']));
			//echo $data['student_id'];var_dump($query->result());exit;
        if($query->result()==NULL)
        {
          $this->db->insert('marksheet', $data);
          $this->session->set_flashdata('success_message', 'Student Marks has been successfully added.');
        }elseif($query->num_rows()==1){
          $this->db->where('id', $data['id']);
          $this->db->update('marksheet', $data);
          $this->session->set_flashdata('success_message', 'Student Marks has been successfully updated.');
        }
      }
      $this->make_marksheet( $arrayName);
    }
  }


  //update
  // public function add_update_marksheet(){

  //   $class_id = $this->input->post('class_id');
  //   $get = "dashboard/marksheet/marksheet_sheet/".$class_id;
  //   $this->marksheet_sheet($class_id);
  //       $from_data = array(
  //         'total_marks'         => $this->input->post('total_number'),
  //         'obtained_marks'    => $this->input->post('obtained_number'),
  //         'subject_id'      => $this->input->post('subject_id'),
  //         'student_id'      => $this->input->post('student_id'),
  //         'user_id'           => $this->auth_user_id,
  //         'create_at'         => date('Y-m-d H:i:s'),
  //       );

  //       var_dump($this->marksheet_model->add_marksheet($from_data));

  //       //insert data into database
  //       if( $this->marksheet_model->add_marksheet($from_data)){
  //         $this->session->set_flashdata('success_message', 'This Student Marks has been successfully added.');
  //         redirect($get);
  //           // $this->marksheet_sheet($class_id);
  //       }
  //       else{
  //         $this->session->set_flashdata('error_message', 'This Student Marks Creation Failed.');
  //         redirect($get);
  //         // $this->marksheet_sheet($class_id);
  //       }
  // }


  //Marks Distribution
	public function marks_distribution($arrayName = null){
   $attr =   array(
      'asign_class'     =>  $this->marksheet_model->get_only_asign_class(),
      'get_subject'     =>  $this->marksheet_model->get_subject_by_class_id($arrayName['class_id']),
      'search_data'     =>  $arrayName,
      'marks_dist'      =>  $this->marksheet_model->subject_mark_distribution($arrayName['class_id'], $arrayName['subject_id']),
    );
    $this->layouts->set_title('Manage marksheet');
    $this->layouts->view_dashboard(
      'marks_distribution_view',     // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
	}

  // add or update method
  public function add_or_update()
  {
    $class_id  = $this->input->post('class_id');
    $subject_id  = $this->input->post('subject_id');
    $arrayName = array('class_id' =>  $class_id, 'subject_id' =>  $subject_id);

    $save = $this->input->post('save_mark_dist');
    $update = $this->input->post('update_mark_dist');
    $submit = $this->input->post('submit');
    if( !empty( $submit ) && isset($submit) )
    {
      // var_dump($arrayName);
      $this->form_validation->set_rules('class_id', 'class', 'trim|is_natural_no_zero',array('is_natural_no_zero'=>'<span>Warning! To Set Marks Distributon Select class > Select Subject > GO'));
      $this->form_validation->set_rules('subject_id', 'subject', 'trim|is_natural_no_zero',array('is_natural_no_zero'=>'<span>Warning! Select class > Select Subject > GO'));
      $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
      if ($this->form_validation->run() == FALSE)
      {
        $this->marks_distribution($arrayName);
      }else{
        $this->marks_distribution( $arrayName);
      }
    }
    elseif(!empty( $save ) && isset($save))
    {
      $data = array(
        'first_ex'    =>  $this->input->post('first_ex'),
        'second_ex'   =>  $this->input->post('second_ex'),
        'final_ex'    =>  $this->input->post('final_ex'),
        'class_test'  =>  $this->input->post('class_test'),
        'quiz_test'   =>  $this->input->post('quiz_test'),
        'lab_test'    =>  $this->input->post('lab_test'),
        'attendence'  =>  $this->input->post('attendence'),
        'extra_curi'  =>  $this->input->post('extra_curi'),
        'subject_id'  =>  $arrayName['subject_id'],
        'class_id'    =>  $arrayName['class_id'],
      );
      $total_marks = $data['first_ex']+$data['second_ex']+$data['final_ex']+$data['class_test']+$data['lab_test']+$data['attendence']+$data['extra_curi']+$data['quiz_test'];
      if($total_marks != 100){
        $this->session->set_flashdata('error_message', 'Warning! Total Marks Will be 100');
        $this->marks_distribution($arrayName);
      }else{
        if($this->marksheet_model->add_mark_dist($data))
        {
          $this->session->set_flashdata('success_message', 'Marks Distribution has been successfully added.');
          $this->marks_distribution($arrayName);
        }else{
          $this->session->set_flashdata('error_message', 'Marks Distribution cration failed');
          $this->marks_distribution($arrayName);
        }
      }
    }
    elseif(!empty( $update ) && isset($update))
    {
      $id = $this->input->post('mark_id');

      $data = array(
          'first_ex'    => $this->input->post('first_ex'),
          'second_ex'   => $this->input->post('second_ex'),
          'final_ex'    => $this->input->post('final_ex'),
          'class_test'  => $this->input->post('class_test'),
          'quiz_test'   => $this->input->post('quiz_test'),
          'lab_test'    => $this->input->post('lab_test'),
          'attendence'  => $this->input->post('attendence'),
          'extra_curi'  => $this->input->post('extra_curi'),
        );
        $total_marks = $data['first_ex']+$data['second_ex']+$data['final_ex']+$data['class_test']+$data['lab_test']+$data['attendence']+$data['extra_curi']+$data['quiz_test'];

        if($total_marks != 100){
          $this->session->set_flashdata('error_message', 'Warning! Total Marks Will be 100');
          $this->marks_distribution($arrayName);
        }else{
          if($this->marksheet_model->update_mark_dist($data,$id )){
            $this->session->set_flashdata('success_message', 'Marks Distribution has been successfully updated.');
            $this->marks_distribution($arrayName);
          }else{
            $this->session->set_flashdata('error_message', 'Marks Distribution update failed.');
            $this->marks_distribution($arrayName);
          }
        }
    }
  }

  // For Ajax select subject
  public function get_subject_by_ajax()
  {
    $subject_id = $this->input->post('subject_id');
     $this->marksheet_model->get_subject_id_by_class_id($subject_id);
  }
  // Aajax mark distribution field
  public function get_subject_marks_distribution()
  {
    $subject_id = $this->input->post('subject_id');
    $class_id = $this->input->post('class_id');
    $this->marksheet_model->subject_mark_distribution( $class_id, $subject_id);
  }

}
