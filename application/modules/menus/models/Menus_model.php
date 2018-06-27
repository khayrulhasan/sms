<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_model extends CI_Model {

  // get all sms_menu
  public function get_all_menus($id = null)
  {
    if( $id ) $this->db->where('page_id!=', $id);
    $this->db->order_by("menu_name");
    $query = $this->db->get( 'sms_menu' );

    return ( $query->result() ) ?: array() ;
  }

  // get_menu_name_by_id
  public function get_page_name_by_id( $id )
  {
    $query = $this->db->get_where( 'pages', array('id' => $id) );
    return ( $query->row()->title ) ?: null ;
  }

  // save menu
  public function save_menu($data)
  {
    $this->db->insert('sms_menu', $data);
    if( $this->db->affected_rows() === 1 ){
      return true;
    }
    return false;
  }

}
