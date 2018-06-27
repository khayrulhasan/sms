<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_model {

  //add book list
  public function add_student($from_data)
  {
    $this->db->insert('student', $from_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // update student form data
  public function edit_student($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('student', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }

  // get all student
  public function get_all_student()
  {
    $query = $this->db->get('student');
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

  // get student by ID
  function get_student_by_id( $student_id )
  {
    $query = $this->db->get_where('student', array('id' => $student_id));
    return ( $query->result() ) ?: null;
  }

  // get all Student from user table
  public function get_all_student_from_users_table()
  {
    $query = $this->db->order_by('id', 'RANDOM')->get_where('users', array('auth_level ='=>1));
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

}
