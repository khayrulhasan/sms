<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_model extends CI_model {

  // Insert Message data into Database
  public function add_message($from_data)
  {
    if($this->db->insert('message', $from_data)){
      return true;
    }else{
      return false;
    }
  }

  // get Message single or multipule
  public function get_message($id = null)
  {

  	if($id != null){

  		$query = $this->db->get_where('message', array('id' => $id));
    	return ( $query->result() ) ?: null;
  
  	}else{

		$query = $this->db->order_by('id', 'DESC')->get('message');
		return ( count( $query->row() ) ) ? $query->result() : null;
  	}
  }


  // update data into database
  public function edit_message($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('message', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }
  
}
