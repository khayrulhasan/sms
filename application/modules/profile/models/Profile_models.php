<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_models extends CI_Model {

  // save profile image URL
  public function save_url($name)
  {
    // checking already have a key
    $query = $this->db->get_where('user_meta', array('user_id' => $this->auth_user_id, 'key' => 'profile-image'));
    if( count($query->result()) )
    {
      // update
      $attr = array(
        'user_id'   =>  $this->auth_user_id,
        'key'       =>  'profile-image',
      );
      $this->db->where($attr);
      $this->db->update('user_meta', array('value' => $name));
      return true;
    }
    else {
      // create
      $attr = array(
        'user_id'   =>  $this->auth_user_id,
        'key'       =>  'profile-image',
        'value'     =>  $name,
      );
      $this->db->insert('user_meta', $attr);
      return true;
    }
    return false;
  }

  // add category
  public function add_profile($form_data)
  {
    $this->db->insert('profiles', $form_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // get profile by ID
  public function get_profile_by_id($user_id)
  {
    $query = $this->db->get_where('users', array('user_id' => $user_id));
    return ( count($query->result()) ) ? $query->row() : null;
  }

  // get profile by ID
  public function get_profile_and_meta_by_id($user_id)
  {
    $query = $this->db->get_where('users', array('user_id' => $user_id));
    $meta  = $this->db->get_where('user_meta', array('user_id' => $user_id));

    $metadata = [];
    if( count($meta->result()) )
    {
      foreach ($meta->result() as $key => $value) {
        $metadata[$value->key] = $value->value;
      }
    }

    $data = (object) array_merge((array) $query->row(), (array) $metadata);
    return ( count($data) ) ? $data : array();
  }

  // Edit Users
  public function edit_profile($profile_id, $form_data)
  {
    foreach( $form_data as $key => $data )
    {
      $query = $this->db->where(array( 'user_id' => $profile_id, 'key' => $key ))->get_where('user_meta');

      if( $query->row() )
      {
        // update user_meta
        $id = $query->row()->id;
        $this->db->where('id', $id)->update('user_meta', array( 'value' => $data ));
        // $feedback = ( $this->db->affected_rows() === 1 ) ? true : false;
      }
      else
      {
        $this->db->insert( 'user_meta', array( 'user_id' => $profile_id, 'key' => $key, 'value' => $data ) );
        // $feedback = ( $this->db->affected_rows() === 1 ) ? true : false;
      }

    }
    return true; // static
  }
}
