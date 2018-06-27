<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    // verify_min_level
    if( ! $this->verify_min_level(6) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
    $this->load->model('page_model');
  }

  public function index()
  {
      $attr           =   array(
      );
      $this->layouts->set_title('Add Page');
      $this->layouts->view_dashboard(
      'add_page_view',               // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }


  public function manage_pages()
  {
    $attr           =   array(
      'page_list'                 =>  $this->page_model->get_all_page()
    );
    $this->layouts->set_title('Manage Page');
    $this->layouts->view_dashboard(
    'manage_page_view',            // container content data
    'backend/header',              //  Load header
    'backend/footer',              //  Load footer
    '',                            //  no layouts
    $attr                          //  pass global parametter
  );
  }

  //Delete Page by id
  public function delete()
  {

    $id =  $this->uri->segment(4);

    $this->db->delete('pages', array('id' => $id));

    if( $this->db->affected_rows() > 0 )
    {
      $this->session->set_flashdata('success_message', 'Page deleted with sucessfully');
      redirect('dashboard/pages/manage-page', 'refresh');
    }  else {
      $this->session->set_flashdata('error_message', 'Invalid Page');
      redirect('dashboard/pages/manage-page','refresh');
    }
  }

  public function update( $id = null )
  {
    //catch page id from edit given id or url segment
    $page_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $page_id ){

      if( ! $this->page_model->get_page_by_id($page_id) ) redirect('dashboard/pages/manage-page');

      //call view page
      $attr           =   array(
        'page_history'               =>  $this->page_model->get_page_by_id($page_id),
        'page_lists'                 =>  $this->page_model->get_all_page($page_id)
      );

      $this->layouts->set_title('Update Page');

      $this->layouts->view_dashboard(
        'add_page_view',               //  container content data
        'backend/header',              //  Load header
        'backend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }

    else{
      $this->manage_page();
    }

  }

  public function add_page()
  {
    $submit = $this->input->post('add_page_btn');
    $update = $this->input->post('update_page_btn');
    if( !empty( $submit ) )
    {
      $this->form_validation->set_rules('page_title','Page Title','trim|min_length[3]|required|xss_clean');
      $this->form_validation->set_rules('page_description','Page Description','trim|required|xss_clean');
      $this->form_validation->set_rules('page_position','Page position','trim|required|xss_clean');

      $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

      if ($this->form_validation->run() == FALSE)
      {
        $this->index();
      }
      else
      {

        // load Slug library
        $config = array(
            'table' => 'pages',
            'field' => 'permalink',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);

        $data = array(
            'title' => $this->input->post('page_title', TRUE),
        );

        $form_data = array(
          'title'              => $this->input->post('page_title'),
          'description'        => $this->input->post('page_description'),
          'created_at'         => date('Y-m-d H:i:s'),
          'permalink'          => $this->slug->create_uri($data),
          'position'           => $this->input->post('page_position'),
          // 'feature_image'      => $this->do_upload(),
        );
        if( $this->page_model->add_page($form_data) ){
          $this->session->set_flashdata('success_message', 'Page has been successfully added.');
          redirect('dashboard/pages/insert-page');
        }
        else
        {
          $this->session->set_flashdata('error_message', 'Page Creation Failed.');
          redirect('dashboard/pages/insert-page');
        }
      }
    }
    elseif ( !empty( $update ) )
    {
      $page_id = $this->input->post('page_id', TRUE);
      $this->form_validation->set_rules('page_title','Page Title','trim|min_length[3]|required|xss_clean');
      $this->form_validation->set_rules('page_description','Page Description','trim|required|xss_clean');
      $this->form_validation->set_rules('page_position','Page position','trim|required|xss_clean');

      $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

      if ($this->form_validation->run() == FALSE)
      {
        $this->update( $page_id );
      }
      else
      {
        // load Slug library
        $config = array(
            'table' => 'pages',
            'field' => 'permalink',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);
        $data = array(
            'title' => $this->input->post('page_title', TRUE),
        );

        // checking other field data not currnet IDs
        $data['uri'] = $this->slug->create_uri($data, $page_id);

        $form_data = array(
          'title'              => $this->input->post('page_title'),
          'description'        => $this->input->post('page_description'),
          'update_at'          => date('Y-m-d H:i:s'),
          'permalink'          => $data['uri'],
          'position'           => $this->input->post('page_position'),
          // 'feature_image'      => $this->do_upload(),
        );
        $feedback = $this->page_model->edit_page($page_id, $form_data);
        if( $feedback )
        {
          $this->session->set_flashdata('success_message', 'Page has been successfully updated.');
          redirect('dashboard/pages/manage-page');
        }
        else{
          $this->session->set_flashdata('error_message', 'Page update Failed');
        }
      }
    }
    else
    {
      show_404();
    }
  }
  //for image upload
  private function do_upload()
  {
    $type = explode('.', $_FILES["userfile"]["name"]);
    $type = strtolower($type[count($type)-1]);
    $url = "./uploads/".uniqid(rand()).'.'.$type;
    if(in_array($type, array("jpg", "jpeg", "gif", "png","JPG", "JPEG", "GIF", "PNG")))
      if(is_uploaded_file($_FILES["userfile"]["tmp_name"]))
        if(move_uploaded_file($_FILES["userfile"]["tmp_name"],$url))
          return $url;
        return "";
  }

}
