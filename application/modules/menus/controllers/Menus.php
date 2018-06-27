<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends MY_Controller {

  public function __construct()
  {
    parent::__construct();

    // verify_min_level
    if( ! $this->verify_min_level(6) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
    $this->load->model('menus_model');
  }


  public function add_menu()
  {
    $this->form_validation->set_rules('pageSelect','Page Select','trim|required|numeric|xss_clean');

    if ($this->form_validation->run() == FALSE)
    {
      $this->manage_menus();
    }
    else {
      $menu_name = $this->menus_model->get_page_name_by_id( $this->input->post('pageSelect') );
      $menu_parent = $this->input->post('setMenuParent');
      $menu_parent = ( !empty($menu_parent) ) ? $menu_parent : 0;
      $menu_url    = $this->input->post('permalink');
      $menu_url    = ( !empty($menu_url) ) ? $menu_url : '#';

      $data        = array(
        'menu_cat_id' => 1,
        'page_id' => $this->input->post('pageSelect'),
        'menu_cat_name' => 'Header Menu',
        'menu_name' => $menu_name,
        'menu_parent' => $menu_parent,
        'menu_url' => $menu_url
      );
      if( $this->menus_model->save_menu($data) )
      {
        $this->session->set_flashdata('success_message', 'Menu has been successfully added.');
        redirect('dashboard/menus/manage-menus');
      }
      else
      {
        $this->session->set_flashdata('error_message', 'Menu added failed.');
        redirect('dashboard/menus/manage-menus');
      }

    }
  }

  public function manage_menus()
  {
    $attr           =   array(
    );
    $this->layouts->set_title('Manage Menus');
    $this->layouts->view_dashboard(
      'manage_menu_view',         // container content data
      'backend/header',              //  Load header
      'backend/footer',              //  Load footer
      '',                            //  no layouts
      $attr                          //  pass global parametter
    );
  }

  public function get_parent_page()
  {
    $pageID = $this->input->post('pageID');
    $menus  = $this->menus_model->get_all_menus($pageID);
    if( count($menus) )
    {
      $output = "<option value=' '>SELECT</option>";
      foreach ($menus as $menu) {
        $output .= '<option value="'.$menu->ID.'">'.$menu->menu_name.'</option>';
      }
      echo json_encode(array('success' => 1, 'data' => $output ));
    }
    else {
      echo json_encode(array('success' => 0 ));
    }
  }

  public function delete()
  {
    $id =  $this->uri->segment(4);
    $this->db->delete('sms_menu', array('id' => $id));  // Produces: // DELETE FROM products  // WHERE id = $id
    $this->session->set_flashdata('success_message', 'Menus deleted with sucessfully');
    redirect('dashboard/menus/manage-menus');
  }

  public function update( $id = null )
  {
    //catch product id from edit given id or url segment
    $menu_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
    if( $menu_id ){

      if( ! $this->menus_model->get_menu_by_id($menu_id) ) redirect('dashboard/menu/manage-menu');

      //call view page
      $attr           =   array(
        'cat_history'               =>  $this->menus_model->get_menu_by_id($menu_id),
        'cat_lists'                 =>  $this->menus_model->get_all_menu($menu_id)
      );

      $this->layouts->set_title('Update menu');

      $this->layouts->view_dashboard(
        'add_menu_view',           //  container content data
        'backend/header',              //  Load header
        'backend/footer',              //  Load footer
        '',                            //  no layouts
        $attr                          //  pass global parametter
      );
    }
    else{
      $this->manage_menu();
    }
  }


  public function update_menu()
  {

    $submit = $this->input->post('edit_menu_btn');
    //if press edit product button
    if( !empty( $submit ) ){
      $id =  $this->input->post('menu_id');
      //from validation rules for Product edit page
      $this->form_validation->set_rules('menu_name', 'Menus Name', 'trim|required|callback_edit_unique[menu.title.'.$id .']');
      $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

      if ($this->form_validation->run() == FALSE)
      {
        //if have form validation error than show error message in view page
        $attr           =   array(
          'id'                =>  $this->input->post('menu_id') ,
          );

        $this->layouts->set_title('Home Page');

        $this->layouts->view_dashboard(
          'edit_menu_view',           // container content data
          'backend/header',              //  Load header
          'backend/footer',              //  Load footer
          '',                            //  no layouts
          $attr                          //  pass global parametter
        );
      }
      else
      {
        //if don't have any from falidation error, record will be process for update
        $id =  $this->input->post('menu_id');
        $data = array(
          'title'     => $this->input->post('menu_name'),
          'image'     => $this->do_upload(),
        );

        $this->db->where('id', $id);
        $this->db->update('menu', $data);

        //if sucessessfully update redirect and flash message
        $this->session->set_flashdata('success_message', 'Product update with successfully.');
        redirect('dashboard/menu/manage-menu', 'refresh');
      }
    }
  }
}
