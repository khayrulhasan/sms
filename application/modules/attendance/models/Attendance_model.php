<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_model {

  // get all Attendance
  public function get_all_attendance()
  {
    $query = $this->db->order_by('id', 'DESC')->get('attendance');
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

  // get Attendance by ID
  public function get_attendance_by_id( $attendance_id )
  {
    $query = $this->db->get_where('attendance', array('id' => $attendance_id));
    return ( $query->result() ) ?: null;
  }

  // get all students by class id
  public function get_all_students_by_class($class_id)
  {
    $this->db->order_by('id');
    $query = $this->db->get_where('student', array('class_id' => $class_id));
    return ( $query->result() ) ?: null;
  }

  // make attendance
  public function make($attendanceDate = null, $studentID = null, $classID = null, $present = null)
  {
    $attr  = array(
      'date_of_attand'    =>  $attendanceDate,
      's_id'              =>  $studentID,
      's_class'           =>  $classID,
    );
    $this->db->where($attr);
    $query = $this->db->get('attendance');
    if( count($query->row()) > 0 )
    {
      $this->db->where('date_of_attand', $attendanceDate);
      $this->db->where('s_id', $studentID);
      $this->db->update('attendance', array(
        'attend'            =>  $present,
        'attendance_by'     =>  $this->auth_username
      ));
      return ( $this->db->affected_rows() === 1 ) ? true : false;
    }
    else{
      $this->db->insert('attendance', array(
        'date_of_attand'    =>  $attendanceDate,
        's_id'              =>  $studentID,
        's_class'           =>  $classID,
        'attend'            =>  $present,
        'attendance_by'     =>  $this->auth_username
      ));
      return ( $this->db->affected_rows() === 1 ) ? true : false;
    }
  }
  // get all Class
  public function get_class_by_user_access()
  {
    $query = $this->db->get('class');
    return ( count($query->row()) ) ? $query->result() : null ;
  }

}
