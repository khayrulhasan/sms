<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers_model extends CI_model {

  //add book list
  public function add_teacher($from_data)
  {
    $this->db->insert('teachers', $from_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // update teachers form data
  public function edit_teacher($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('teachers', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }

  // get all teachers
  public function get_all_teachers($id = null)
  {
    if ($id != null)
    { 
    // If have $id query for theis $id
    $query = $this->db->get_where("teachers",array("id"=>$id));
    return ( count($query->row()) ) ? $query->row() : null;
    }
    else
    {
    // If don't have $id query all data from Table
    $query = $this->db->get('teachers');
    return ( count($query->row()) ) ? $query->result() : null;
    }
  }


  // get all teacher from user table
  public function get_all_teacher_from_users_table()
  {
    $query = $this->db->order_by('id', 'RANDOM')->get_where('users', array('auth_level ='=>5));
    return ( count( $query->row() ) ) ? $query->result() : null;
  }


}