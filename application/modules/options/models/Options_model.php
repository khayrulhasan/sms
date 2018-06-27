<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options_model extends CI_Model {

	// update options
  public function update_options( $from_data = array()  )
  {
    foreach( $from_data as $key => $data )
    {
      $query = $this->db->where(array( 'key' => $key ))->get_where('options');

      if( $query->row() )
      {
        // update options
        $id = $query->row()->id;
        $this->db->where('id', $id)->update('options', array( 'value' => $data ));
        // $feedback = ( $this->db->affected_rows() === 1 ) ? true : false;
      }
      else
      {
        $this->db->insert( 'options', array( 'key' => $key, 'value' => $data ) );
        // $feedback = ( $this->db->affected_rows() === 1 ) ? true : false;
      }

    }
    return true; // static
  }


}
