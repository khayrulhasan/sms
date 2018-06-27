<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

  // get page
  public function get_page($page = null)
  {
    $this->db->where('permalink=', $page);
    $query = $this->db->get( 'pages' );

    return ( $query->result() ) ?: null;
  }


}
