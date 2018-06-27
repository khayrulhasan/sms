<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model {
  // get all pages
  public function get_all_page($id = null)
  {
    if( $id ) $this->db->where('id!=', $id);
    $this->db->order_by("id", "desc");
    $query = $this->db->get( 'pages' );
    return $query->result();
  }

  // add Page
  public function add_page($form_data)
  {
    $this->db->insert('pages', $form_data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

  // get page by ID
  public function get_page_by_id($page_id)
  {
    $query = $this->db->get_where('pages', array('id' => $page_id));
    return ( count($query->result()) ) ? $query->row() : null;
  }

  // Edit Page
  public function edit_page($page_id, $form_data)
  {
    $this->db->where('id', $page_id);
    $query = $this->db->update('pages', $form_data);
    if( $query == 1 ){
      return TRUE;
    }
    return false;
  }
}
