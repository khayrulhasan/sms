<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_models extends CI_Model {

  // get all users
  public function get_all_user($id = null)
  {
    if( $id ) $this->db->where('user_id =', $id);
    $this->db->order_by("user_id", "desc");
    $query = $this->db->get( 'users' );

    return $query->result();
  }

  // add category
  public function add_user($form_data)
  {
    $this->db->insert('users', $form_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // get user by ID
  public function get_user_by_id($user_id)
  {
    $query = $this->db->get_where('users', array('user_id' => $user_id));
    return ( count($query->result()) ) ? $query->row() : null;
  }

  // Edit Users
  public function edit_user($user_id, $form_data)
  {
    $this->db->where('user_id', $user_id);
    $query = $this->db->update('users', $form_data);
    if( $query == 1 ){
      return TRUE;
    }
    return false;
  }
}
