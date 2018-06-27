<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notices_model extends CI_Model {

  // get page
  public function get_notice($id = null)
  {
    if( $id ) $this->db->where('id=', $id);
    $query = $this->db->get( 'notice' );

    return ( $query->result() ) ?: null;
  }


}
