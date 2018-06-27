<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booklist extends MY_Controller {

	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(5) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }

		$this->load->model('booklist_model');
  }

	public function index()
	{
		$this->load->model('classes/classes_model');
		$this->load->model('subject/subject_model');
		$attr	=   array(
			// 'class_lists'     =>  $this->classes_model->get_all_class(),
      // 'subject_lists'   =>  $this->subject_model->get_all_subject(),
    );
    $this->layouts->set_title('Add Booklist');
    $this->layouts->view_dashboard(
      'add_booklist_view',           // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
	}

	// Add book list
	public function add()
	{
		$submit = $this->input->post('add_booklist_btn');
    $edit   = $this->input->post('update_booklist_btn');

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
          'subject_id'     	 => $this->input->post('subject_name'),
          'class_id'   		 	 => $this->input->post('class_id'),
          'book_title'  		 => $this->input->post('book_title'),
					'book_writter'     => $this->input->post('book_writter'),
					'copyright'    		 => $this->input->post('copyright'),
          'publisher'    		 => $this->input->post('publisher'),
          'user_id'    		 => $this->auth_user_id
        );

        if( $this->booklist_model->add_booklist($from_data) ){
          $this->session->set_flashdata('success_message', 'Booklist has been successfully added.');
          redirect('dashboard/booklist/');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Booklist Creation Failed.');
          redirect('dashboard/booklist/');
        }
      }
		}
		elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update booklist
      */
      $booklist_id = $this->input->post('booklist_id', TRUE);

      $this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $booklist_id );
      }
      else
      {

				$from_data = array(
          'subject_id'     	 => $this->input->post('subject_name'),
          'class_id'   		 	 => $this->input->post('class_id'),
          'book_title'  		 => $this->input->post('book_title'),
					'book_writter'     => $this->input->post('book_writter'),
					'copyright'    		 => $this->input->post('copyright'),
          'publisher'    		 => $this->input->post('publisher'),
          'user_id'    		 => $this->auth_user_id
        );

        if( $this->booklist_model->edit_booklist($booklist_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Booklist has been successfully Edited.');
         	redirect('dashboard/booklist/manage', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Booklist Editing Failed.');
          redirect('dashboard/booklist/manage', 'refresh');
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
		$this->form_validation->set_rules('subject_name','Subject Name','trim|xss_clean');
    $this->form_validation->set_rules('class_name','Class Name','trim|xss_clean');
    $this->form_validation->set_rules('book_title','Book Title','required|min_length[5]|xss_clean', array(
      'min_length'    => 'Book Title should be min 5 charachers.',
    ));
		$this->form_validation->set_rules('book_writter','Book Writter','required|min_length[5]|xss_clean', array(
      'min_length'    => 'Book Writter should be min 5 charachers.',
    ));
		$this->form_validation->set_rules('copyright','Copyright','min_length[2]|xss_clean', array(
      'min_length'    => 'Copyright should be min 5 charachers.',
    ));
		$this->form_validation->set_rules('publisher','Publisher','min_length[2]|xss_clean', array(
      'min_length'    => 'Publisher should be min 5 charachers.',
    ));

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

	// manage booklist
	public function manage()
  {
    $attr =   array(
      'booklists'        =>  $this->booklist_model->get_all_booklist()
    );
    $this->layouts->set_title('Manage Booklist');
    $this->layouts->view_dashboard(
      'manage_booklist_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// update booklist
  public function update( $id = null )
  {
    //catch widget id from edit given id or url segment
    $booklist_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );

    if(update_method_access_denied('booklist',$booklist_id,9)==FALSE)  redirect('booklist/error404');
    if( $booklist_id ){

      if( ! $this->booklist_model->get_booklist_by_id($booklist_id) ) redirect('dashboard/booklist/manage');
      //call view page
			$this->load->model('classes/classes_model');
			$this->load->model('subject/subject_model');
      $attr           =   array(
				'class_lists'     =>  $this->classes_model->get_all_class(),
	      'subject_lists'   =>  $this->subject_model->get_all_subject(),
        'booklist_history'  =>  $this->booklist_model->get_booklist_by_id($booklist_id)
      );

      $this->layouts->set_title('Edit Booklist');
      $this->layouts->view_dashboard(
        'add_booklist_view',           //  container content data
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

	// Delete Booklist
	public function delete()
  {

    $id =  $this->uri->segment(4);
    if(update_method_access_denied('booklist',$id,9)==FALSE)  redirect('booklist/error404');
    $this->db->delete('booklist', array('id' => $id));  // Produces: // DELETE FROM widgets  // WHERE id = $id
    if( $this->db->affected_rows() === 1 ){
      $this->session->set_flashdata('success_message', 'Booklist deleted sucessfully');
      redirect('dashboard/booklist/manage', 'refresh');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid ID');
      redirect('dashboard/booklist/manage', 'refresh');
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
