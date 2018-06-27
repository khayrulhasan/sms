<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

  // get Marksheet By student Id
  public function get_markshet_by_student_id($student_id)
  {
  	
    $this->db->from('marksheet');
    $this->db->join('subject', 'subject.subject_id = marksheet.subject_id', 'INNER');
    $this->db->where('student_id =', $student_id);
    $query = $this->db->get();
    return ( count( $query->row() )>0 )   ? $query->result() : NULL ; 
  }
  
  // get student booklist
  public function get_student_booklist()
  {
    $user_id = $this->auth_user_id;
    $this->db->from('booklist');
    $this->db->join('student', 'student.class_id = booklist.class_id', 'INNER');
    $this->db->where('student.user_id =', $user_id);
    $query = $this->db->get();
    return ( count( $query->row() )>0 )   ? $query->result() : NULL ; 
  }
}
