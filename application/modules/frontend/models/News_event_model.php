<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_event_model extends CI_Model {

  // get page
  public function get_news_event($id = null)
  {
    if( $id ) $this->db->where('id=', $id);
    $query = $this->db->get( 'news_event' );

    return ( $query->result() ) ?: null;
  }


}
