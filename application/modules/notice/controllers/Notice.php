<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends MY_Controller {

	public $file_name = '';
	public function __construct()
  {
    parent::__construct();

		// verify_min_level
    if( ! $this->verify_min_level(6) ){
			$this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
			// var_dump( $this->uri->uri_string() );die();
      redirect('login/logout', 'refresh');
    }

		$this->load->model('notice_model');
  }

	public function index()
	{
    $this->layouts->set_title('Add Notice Page');
    $this->layouts->view_dashboard(
      'add_notice_view',             // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      ''                           //  no layouts
      //$attr                          //  pass global parametter
    );
	}

	// Add book list
	public function add()
	{
		$submit = $this->input->post('add_notice_btn');
    $edit   = $this->input->post('update_notice_btn');

    if( !empty( $submit ) && isset($submit) )
    {
			$this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {
				$publish_date = $this->input->post('date');
				$from_data = array(
          'notice_title'     => $this->input->post('notice_title'),
					'upload'    	     => $this->file_name,
					'date'    	       => ( ! empty($publish_date) ) ? $publish_date : date('Y-m-d'),
					'description'      => $this->input->post('description'),
					'added_by'				 => $this->auth_user_id
        );

        if( $this->notice_model->add_notice($from_data) ){
          $this->session->set_flashdata('success_message', 'Notice has been successfully added.');
          redirect('dashboard/notice/');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Notice Creation Failed.');
          redirect('dashboard/notice/');
        }
      }
		}
		elseif ( !empty( $edit ) && isset($edit) )
    {
      /**
      * This section is for update notice
      */
      $notice_id = $this->input->post('notice_id', TRUE);

      $this->_validate();

      if ($this->form_validation->run() == FALSE)
      {
        // rander edit form again with error msg
        $this->update( $notice_id );
      }
      else
      {

				$publish_date = $this->input->post('date');
				$from_data = array(
          'notice_title'     => $this->input->post('notice_title'),
					'upload'    	     => $this->file_name,
					'date'    	       => ( ! empty($publish_date) ) ? $publish_date : date('Y-m-d'),
					'description'      => $this->input->post('description'),
					'added_by'				 => $this->auth_user_id
        );

        if( $this->notice_model->edit_notice($notice_id, $from_data) )
        {
          $this->session->set_flashdata('success_message', 'Notice has been successfully Edited.');
         	redirect('dashboard/notice/manage', 'refresh');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Notice Editing Failed.');
          redirect('dashboard/notice/manage', 'refresh');
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
		$this->form_validation->set_rules('notice_title','Notice Title','required|trim|min_length[10]|xss_clean', array(
      'min_length'    => 'Notice Title should be min 10 charachers more.',
    ));
		$this->form_validation->set_rules('userfile','Attach File','trim|xss_clean|callback_is_attach');
		$this->form_validation->set_rules('date','Publish Date','trim|xss_clean');
    $this->form_validation->set_rules('description','Description','trim|xss_clean');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');
  }

	// Is file attach any file
	public function is_attach()
	{
		if( empty( $_FILES['userfile']['name'] ) )
		{
			if( !empty( $this->input->post('edited_file_name') ) && $this->input->post('update_notice_btn') )
			{
				$this->file_name = $this->input->post('edited_file_name');
				return TRUE;
			}
		}

		// for new attach file
		$files = $_FILES['userfile']['name'];

		if( !empty($files) )
		{
      $config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'gif|jpg|png|docx|doc|pdf|xls|xlsx|csv';
      $config['encrypt_name'] = TRUE;

      $this->load->library('upload', $config);

      if ( $this->upload->do_upload() )
      {
        $data = $this->upload->data();
				$this->file_name = $data['file_name'];
				return TRUE;

      }
      else
      {
				$this->form_validation->set_message('is_attach', 'Upload formate should be gif|jpg|png|docx|doc|pdf|xls|xlsx|csv');
        return FALSE;
      }
		}
		return TRUE;
	}


	// manage notice
	public function manage()
  {
    $attr =   array(
      'notice'        =>  $this->notice_model->get_all_notice()
    );
    $this->layouts->set_title('Manage Notice');
    $this->layouts->view_dashboard(
      'manage_notice_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

	// update notice
  public function update( $id = null )
  {
    //catch widget id from edit given id or url segment
    $notice_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $notice_id ){

      if( ! $this->notice_model->get_notice_by_id($notice_id) ) redirect('dashboard/notice/manage');

      $attr           =   array(
        'notice_history'  =>  $this->notice_model->get_notice_by_id($notice_id)
      );

      $this->layouts->set_title('Edit Notice');
      $this->layouts->view_dashboard(
        'add_notice_view',           //  container content data
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

	// Delete Notice
	public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('notice', array('id' => $id));  // Produces: // DELETE FROM widgets  // WHERE id = $id
    if( $this->db->affected_rows() === 1 ){
      $this->session->set_flashdata('success_message', 'Notice deleted sucessfully');
      redirect('dashboard/notice/manage', 'refresh');
    }
    else{
      $this->session->set_flashdata('error_message', 'Invalid ID');
      redirect('dashboard/notice/manage', 'refresh');
    }
  }


}
