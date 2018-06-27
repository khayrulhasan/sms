<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule_model extends CI_model {

  // Insert slider data into Database
  public function add_slider($from_data)
  {
    if($this->db->insert('sliders', $from_data)){
      return true;
    }else{
      return false;
    }
  }

  // get slider single or multipule
  public function get_slider($id = null)
  {

  	if($id != null){

  		$query = $this->db->get_where('sliders', array('id' => $id));
    	return ( $query->result() ) ?: null;
  
  	}else{

		$query = $this->db->order_by('id', 'DESC')->get('sliders');
		return ( count( $query->row() ) ) ? $query->result() : null;
  	}
  }


  // update data into database
  public function edit_slider($id, $from_data)
  {
    $this->db->where('id', $id);
    $query = $this->db->update('sliders', $from_data);
    if( $query == 1 ){
      return TRUE;
    }
    return FALSE;
  }
  
}
