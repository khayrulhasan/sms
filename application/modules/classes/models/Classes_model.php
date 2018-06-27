<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes_model extends CI_model {

	// get all Class
	public function get_all_class($id = null)
	{
    if($id) $this->db->where('id =', $id);
		$query = $this->db->get('class');
		return ( count($query->row()) ) ? $query->result() : null ;
	}

	//add book list
  public function add_class($from_data)
  {
    // return $from_data['class_id'];
    $query = $this->db->get_where('class',$array = array('class_id' => $from_data['class_id'],'teacher_id' => $from_data['teacher_id'] ));
    // return $query->row();
    if($query->row()==NULL){
      $this->db->insert('class', $from_data);
      if( $this->db->affected_rows() === 1 ){
        $this->session->set_flashdata('success_message', 'Class has been successfully Created.');
      }else{
         $this->session->set_flashdata('error_message', 'Class creation failed');
      }
    }else{
      $this->session->set_flashdata('error_message', 'Already assign this class with this teacher. Please try another....');
    }

  }

  // update class form data
  public function edit_class($id, $from_data)
  {
    $query = $this->db->get_where('class',$array = array('id !=' => $id,'class_id' => $from_data['class_id'],'teacher_id' => $from_data['teacher_id'] ));
    if($query->row()==NULL){
        $this->db->where('id', $id);
        $this->db->update('class', $from_data);
        if($this->db->affected_rows()===1){
          $this->session->set_flashdata('success_message', 'Class has been successfully Edited.');

        }else{
          $this->session->set_flashdata('error_message', 'You Don\'t have any change');
        }
    }else{
      $this->session->set_flashdata('error_message', 'Already assign this class with this teacher. Please try another....');
    }
  }

  // // get class by ID
  // function get_class_by_id( $class_id )
  // {
  //   $query = $this->db->get_where('class', array('class_id' => $class_id));
  //   return ( $query->result() ) ?: null;
  // }

}
