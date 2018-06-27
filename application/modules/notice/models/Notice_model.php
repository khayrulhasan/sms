<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice_model extends CI_model {

  //add book list
  public function add_notice($from_data)
  {
    $this->db->insert('notice', $from_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // update notice form data
  public function edit_notice($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('notice', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }

  // get all notice
  public function get_all_notice()
  {
    $query = $this->db->order_by('id', 'DESC')->get('notice');
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

  // get notice by ID
  function get_notice_by_id( $notice_id )
  {
    $query = $this->db->get_where('notice', array('id' => $notice_id));
    return ( $query->result() ) ?: null;
  }


}
