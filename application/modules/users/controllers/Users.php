<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

  public function __construct()
  {
    parent::__construct();
    // verify_min_level
    if( ! $this->verify_min_level(6) ){
      $this->session->set_flashdata( 'request_uri', $this->uri->uri_string() );
      redirect('login/logout', 'refresh');
    }
    $this->load->model('user_models');
  }

  public function index()
  {
    //load view with layouts library
    $attr           =   array(
      'user_list'                 =>  $this->user_models->get_all_user()
    );
    $this->layouts->set_title('Add User');
    $this->layouts->view_dashboard(
    'add_user_view',               // container content data
    'backend/header',              //  Load header
    'backend/footer',              //  Load footer
    '',                            //  no layouts
    $attr                          //  pass global parametter
  );
}


public function add_user()
{
  $submit = $this->input->post('add_user_btn');
  $update = $this->input->post('update_user_btn');
  if( !empty( $submit ) )
  {
    $this->form_validation->set_rules('user_name','User Name','trim|min_length[3]|max_length[100]|alpha_numeric|required|xss_clean|is_unique[users.username]', array(
      'min_length'    => 'Username should be minimum 3 charachers.',
      'is_unique'    => 'This Username already have listed. Please try another...',
    ));
    $this->form_validation->set_rules('user_email','User Email','trim|valid_email|required|xss_clean|is_unique[users.email]', array(
      'is_unique'    => 'This Email already have listed. Please try another...',
    ));
    $this->form_validation->set_rules('access_level','Access Level','required|callback_select_default['.$this->input->post('access_level').'0]');

    $pass = $this->input->post('user_pass');
    $this->form_validation->set_rules('user_pass','Password','trim|xss_clean|required|callback_password_strength_check[$pass]');

    $this->form_validation->set_rules('con_pass','Confirm Password','trim|xss_clean|required|matches[user_pass]');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

    if ($this->form_validation->run() == FALSE)
    {
      $this->index();
    }
    else
    {
      $form_data = array(
        'user_id'               => $this->get_unused_id(),
        'username'              => $this->input->post('user_name'),
        'email'                 => $this->input->post('user_email'),
        'auth_level'            => $this->input->post('access_level'),
        'banned'                => '0',
        'passwd'                => $this->authentication->hash_passwd($this->input->post('user_pass')),
        'created_at'            => date('Y-m-d H:i:s'),
      );
      if( $this->user_models->add_user($form_data) ){
        $this->session->set_flashdata('success_message', 'User has been successfully added.');
        redirect('dashboard/users/insert-user');
      }
      else
      {
        $this->session->set_flashdata('error_message', 'User Creation Failed.');
        redirect('dashboard/users/insert-user');
      }
    }
  }
  elseif ( !empty( $update ) )
  {
    $user_id = $this->input->post('user_id', TRUE);
    $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|callback_edit_uniqu[users.username.'.$user_id .']');
    $this->form_validation->set_rules('user_email','User Email','trim|min_length[3]|valid_email|required|xss_clean|callback_edit_uniqu[users.email.'.$user_id .']');

    $this->form_validation->set_rules('access_level','Access Level','required|callback_select_default['.$this->input->post('access_level').'0]');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

    if ($this->form_validation->run() == FALSE)
    {
      $this->update( $user_id );
    }
    else
    {
      $form_data = array(
        'username'              => $this->input->post('user_name'),
        'email'                 => $this->input->post('user_email'),
        'auth_level'            => $this->input->post('access_level'),
        'banned'                => $this->input->post('user_banned'),
      );
      $feedback = $this->user_models->edit_user($user_id, $form_data);
      if( $feedback )
      {
        $this->session->set_flashdata('success_message', 'User has been successfully updated.');
        redirect('dashboard/users/manage-user');
      }
      else{
        $this->session->set_flashdata('error_message', 'User update Failed');

      }
    }
  }
  else
  {
    show_404();
  }
}

public function manage_user()
{
  $attr           =   array(
    'user_lists'                 =>  $this->user_models->get_all_user()
  );
  $this->layouts->set_title('Manage User');
  $this->layouts->view_dashboard(
  'manage_user_view',            // container content data
  'backend/header',              //  Load header
  'backend/footer',              //  Load footer
  '',                            //  no layouts
  $attr                          //  pass global parametter
);
}

public function change_password()
{
  $attr           =   array(
    'user_lists'                 =>  $this->user_models->get_all_user()
  );
  $this->layouts->set_title('Chanage Password');
  $this->layouts->view_dashboard(
  'password_change_view',        // container content data
  'backend/header',              //  Load header
  'backend/footer',              //  Load footer
  '',                            //  no layouts
  $attr                          //  pass global parametter
);
}

public function update_password()
{

  $update_pass = $this->input->post('update_pass_btn');
  if ( !empty( $update_pass ) )
  {
    $user_id = $this->input->post('user_id', TRUE);

    $this->form_validation->set_rules('user_id','Eamil Address','trim|xss_clean|is_natural_no_zero',array(
      'is_natural_no_zero'=> 'Please select an email address which you want to change password.'
    ));

    $this->form_validation->set_rules('user_pass','Password','trim|xss_clean|required|callback_password_strength_check[$pass]');

    $this->form_validation->set_rules('con_pass','Confirm Password','trim|xss_clean|required|matches[user_pass]');

    $this->form_validation->set_error_delimiters('<span class="validation_error_message">', '</span>');

    if ($this->form_validation->run() == FALSE)
    {
      $this->change_password();
    }
    else
    {
      $form_data = array(
        'passwd'                => $this->authentication->hash_passwd($this->input->post('user_pass')),
      );
      $feedback = $this->user_models->edit_user($user_id, $form_data);
      if( $feedback )
      {
        $this->session->set_flashdata('success_message', 'Password has been successfully updated.');
        redirect('dashboard/users/change-password');
      }
      else
      {
        $this->session->set_flashdata('error_message', 'Password update Failed');
        redirect('dashboard/users/change-password');
      }
    }
  }
  else
  {
    show_404();
  }
}
//Delete user by id
public function delete()
{

  $id =  $this->uri->segment(4);

  $this->db->delete('users', array('user_id' => $id));

  if( $this->db->affected_rows() > 0 )
  {
    $this->session->set_flashdata('success_message', 'User deleted with sucessfully');
    redirect('dashboard/users/manage-user', 'refresh');
  }  else {
    $this->session->set_flashdata('error_message', 'Invalid User');
    redirect('dashboard/users/manage-user','refresh');
  }
}


public function update( $id = null )
{
  //catch user id from edit given id or url segment
  $user_id = ( $id ) ? $id : xss_clean( $this->uri->segment(4) );
  if( $user_id ){

    if( ! $this->user_models->get_user_by_id($user_id) ) redirect('dashboard/users/manage-user');

    //call view page
    $attr           =   array(
      'user_history'               =>  $this->user_models->get_user_by_id($user_id),
      'user_lists'                 =>  $this->user_models->get_all_user($user_id)
    );

    $this->layouts->set_title('Update User');

    $this->layouts->view_dashboard(
    'add_user_view',           //  container content data
    'backend/header',              //  Load header
    'backend/footer',              //  Load footer
    '',                            //  no layouts
    $attr                          //  pass global parametter
  );
}

else{
  $this->manage_user();
}
}


// randomly unused id
public function get_unused_id()
{
  // Create a random user id between 1200 and 4294967295
  $random_unique_int = 2147483648 + mt_rand( -2147482448, 2147483647 );

  // Make sure the random user_id isn't already in use
  $query = $this->db->where( 'user_id', $random_unique_int )
  ->get_where( config_item('user_table') );

  if( $query->num_rows() > 0 )
  {
    $query->free_result();

    // If the random user_id is already in use, try again
    return $this->get_unused_id();
  }

  return $random_unique_int;
}

//for Validation function
//This function works for validation when update unique databse fild
public function select_default($str, $prem) {
  if ($str == $prem){
    $this->form_validation->set_message('select_default', 'Please select user access level');
    return FALSE;
  }else{
    return TRUE;
  }
}

//for uniqe check when update
public function edit_uniqu($value, $params)
{
  $CI =& get_instance();
  $CI->load->database();

  $CI->form_validation->set_message('edit_uniqu', "Sorry, that %s is already being used.");
  list($table, $field, $current_id) = explode(".", $params);
  $query = $CI->db->select()->from($table)->where($field, $value)->limit(1)->get();
  if ($query->row() && $query->row()->user_id != $current_id)
  {
    return FALSE;
  }
}

//password strength check
public function password_strength_check( $password )
{
  // Password length
  $regex = '(?=.{' . config_item('min_chars_for_password') . ',' . config_item('max_chars_for_password') . '})';
  $error = '<li>At least ' . config_item('min_chars_for_password') . ' characters</li>
  <li>Not more than ' . config_item('max_chars_for_password') . ' characters</li>';

  // At least one digit required
  $regex .= '(?=.*\d)';
  $error .= '<li>One number</li>';

  // At least one lower case letter required
  $regex .= '(?=.*[a-z])';
  $error .= '<li>One lower case letter</li>';

  // At least one upper case letter required
  $regex .= '(?=.*[A-Z])';
  $error .= '<li>One upper case letter</li>';

  // No space, tab, or other whitespace chars allowed
  $regex .= '(?!.*\s)';
  $error .= '<li>No spaces, tabs, or other unseen characters</li>';

  // No backslash, apostrophe or quote chars are allowed
  $regex .= '(?!.*[\\\\\'"])';
  $error .= '<li>No backslash, apostrophe or quote characters</li>';

  // One of the following characters must be in the password,  @ # $ % ^ & + =
  // $regex .= '(?=.*[@#$%^&+=])';
  // $error .= '<li>One of the following characters must be in the password,  @ # $ % ^ & + =</li>';

  if( preg_match( '/^' . $regex . '.*$/', $password, $matches ) )
  {
    return TRUE;
  }

  $this->form_validation->set_message('password_strength_check', $error);

  return FALSE;
}
}
