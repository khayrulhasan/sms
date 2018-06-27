<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booklist_model extends CI_model {

  //add book list
  public function add_booklist($from_data)
  {
    $this->db->insert('booklist', $from_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // update booklist form data
  public function edit_booklist($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('booklist', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }

  // get all booklist
  public function get_all_booklist()
  {
    $query = $this->db->get('booklist');
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

  // get booklist by ID
  function get_booklist_by_id( $booklist_id )
  {
    $query = $this->db->get_where('booklist', array('id' => $booklist_id));
    return ( $query->result() ) ?: null;
  }




}
