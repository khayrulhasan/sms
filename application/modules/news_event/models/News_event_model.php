<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_event_model extends CI_model {

  // Insert News & Event data into Database
  public function add_news_event($from_data)
  {
    if($this->db->insert('news_event', $from_data)){
      return true;
    }else{
      return false;
    }
  }

  // get News & Event single or multipule
  public function get_news_event($id = null)
  {

  	if($id != null){

  		$query = $this->db->get_where('news_event', array('id' => $id));
    	return ( $query->result() ) ?: null;
  
  	}else{

		$query = $this->db->order_by('id', 'DESC')->get('news_event');
		return ( count( $query->row() ) ) ? $query->result() : null;
  	}
  }


  // update data into database
  public function edit_news_event($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('news_event', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }
  
}
