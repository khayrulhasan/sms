<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marksheet_model extends CI_model {

  // get all marksheet
  public function get_all_marksheet()
  {
    $query = $this->db->order_by('id', 'DESC')->get('marksheet');
    return ( count( $query->row() ) ) ? $query->result() : null;
  }

  // get marksheet by ID
  public function get_marksheet_by_id( $marksheet_id )
  {
    $query = $this->db->get_where('marksheet', array('id' => $marksheet_id));
    return ( $query->result() ) ?: null;
  }

  // get all students by class id
  public function get_all_students_by_class($arrayName)
  {
    if(isset($arrayName['class_id'])){
      /**
      * first check is class already marked
      */
      $attr = array(
        'class_id' => $arrayName['class_id'],
        'subject_id' => $arrayName['subject_id']
      );
      $q = $this->db->where($attr)->get('marksheet');
      if( ( count($q->row()) ) )
      {
        // var_dump('join');exit;
        $this->db->order_by('id');
        $query = $this->db->query("SELECT s.*, m.*, sum(IFNULL(m.first_ex,0)+IFNULL(m.second_ex,0)+IFNULL(m.final_ex,0)+IFNULL(m.class_test,0)+IFNULL(m.quiz_test,0)+IFNULL(m.lab_test,0)+IFNULL(m.attendence,0)+IFNULL(m.extra_curi,0)+IFNULL(m.class_test,0)) as total_mark

        FROM marksheet as m
        LEFT JOIN student as s
        ON m.student_id = s.id
        where m.class_id = ".$arrayName['class_id']." AND m.subject_id = ". $arrayName['subject_id'] ." group by m.student_id order by total_mark DESC;");
        // echo '<pre>',var_dump($query->result_array());exit;
        return $query->result_array();
      }
      else
      {
        // var_dump('normal');exit;
        $this->db->order_by('id');
        $query = $this->db->get_where('student', array('class_id' => $arrayName['class_id']));
        return ( count($query->row()) ) ? $query->result() : null ;
      }

    }
  return false;
  }

  // get asign class
  public function get_only_asign_class()
  {
    if($this->auth_level == 9){
      $query = $this->db->order_by('class_id', 'ASC')->group_by('class_id')->get('class');
      return ( count($query->row()) ) ? $query->result() : null ;
    }elseif($this->auth_level == 5){
      // $query = $this->db->get_where('teachers',array('user_id' => $this->auth_user_id));
      // $teacher_id = $query->result()[0]->id;
      // $query = $this->db->order_by('class_id', 'ASC')->group_by('class_id')->get_where('class',array('teacher_id'=>$teacher_id));
      $this->db->from('class');
      $this->db->join('teachers', 'teachers.id =  class.teacher_id', 'LEFT');
      $this->db->where('teachers.user_id',$this->auth_user_id);
      $this->db->group_by('class_id');
      $this->db->order_by('class_id','ASC');
      $query =  $this->db->get();




      return ( count($query->row()) ) ? $query->result() : null ;
    }
  }

  public function get_subject_by_assigned_class($class_id = null)
  {
    if($class_id)
    {
      $query = $this->db->where('class_id', $class_id)->group_by('class_id')->get('class');
    }
    else
    {
      $query = $this->db->group_by('class_id')->get('class');
    }
    // echo '<pre>', var_dump($query->result());exit;
    if( count($query->row()) )
    {
      $d = [];
      foreach ($query->result() as $value) {
        $rs = $this->get_subject_by_class_id($value->class_id);

        if( count($rs) == null ) { continue; }
        $d[] = $this->get_subject_by_class_id($value->class_id);
      }
      // echo '<pre>', var_dump($d);exit;
      return $d;
    }

    else
    {
      return null;
    }
  }


  // get all Class
  public function get_class_by_user_access()
  {
    $query = $this->db->get('class');
    return ( count($query->row()) ) ? $query->result() : null ;
  }

  //Add Marksheet
  public function add_marksheet($form_data){
    // return $form_data['subject_id'];
    $query = $this->db->get_where('marksheet', array('student_id' => $form_data['student_id'],'subject_id'=>$form_data['subject_id']));
    if ( $query->result() ){
        $id = $query->result_array()[0]['id'];
        $this->db->where('id', $id);
        $query = $this->db->update('marksheet', $form_data);
        if( $query == 1 ){
          return TRUE;
        }
        return FALSE;
    }else{
      if($this->db->insert('marksheet', $form_data)){
        return true;
      }else{
        return false;
      }
    }
  }
//save mark distribution
  public function add_mark_dist($data){
    $query = $this->db->insert('marks_distribution', $data);
    return ( $query==1 ) ?TRUE: FALSE;
  }
  //update mark distribution
  public function update_mark_dist($data, $id){
    $this->db->where('id',$id);
    $query = $this->db->update('marks_distribution', $data);
    return ( $query==1 ) ?TRUE: FALSE;
  }
  // get all teacher_id by using classid for ajax
  public function get_subject_id_by_class_id($id){
    $this->db->from('class');
    $this->db->join('teachers', 'teachers.id = class.teacher_id', 'INNER');
    $this->db->join('subject', 'subject.subject_id = teachers.subject_id', 'INNER');
    $this->db->where('class_id', $id);
    if($this->auth_level == 5) $this->db->where('teachers.user_id', $this->auth_user_id);
    $query = $this->db->get();
    // var_dump($this->db->last_query());
    if( count($query->row()) )
    {

      $output = "<option value='0'>Empty</option>";
      foreach ($query->result() as $data) {
        $output .= '<option value="'.$data->subject_id.'">'.$data->subject_name.'</option>';
      }
      echo json_encode(array('success' => 1, 'data' => $output ));
    }
    else {
      echo json_encode(array('success' => 0 ));
    }
  }


    // get all Subject for controller
  public function get_subject_by_class_id($id){
    if(isset($id)){
      $this->db->from('class');
      $this->db->join('teachers', 'teachers.id = class.teacher_id', 'INNER');
      $this->db->join('subject', 'subject.subject_id = teachers.subject_id', 'INNER');
      $this->db->where('class_id', $id);
      if($this->auth_level == 5)  $this->db->where('user_id', $this->auth_user_id);
      $query = $this->db->get();
      // echo "<pre>";var_dump($query->result());exit;
      return ( count($query->row()))?$query->result():NULL;
    }else{
      $query = $this->db->order_by('class_id', 'ASC')->get('class');
      if(isset($query->result()[0]->class_id))
      {
        $this->db->from('class');
        $this->db->join('teachers', 'teachers.id = class.teacher_id', 'INNER');
        $this->db->join('subject', 'subject.subject_id = teachers.subject_id', 'INNER');
        if($this->auth_level !=  5) $this->db->where('class_id', $query->result()[0]->class_id);
        if($this->auth_level == 5) $this->db->where('user_id', $this->auth_user_id);
        $query = $this->db->get();
        return ( count($query->row()))?$query->result():NULL;
      }
    }
  }

  // get all teacher_id by using classid
  public function subject_mark_distribution($class_id, $subject_id){
    $this->db->from('class');
    $this->db->join('teachers', 'teachers.id = class.teacher_id', 'INNER');
    $this->db->join('subject', 'subject.subject_id = teachers.subject_id', 'INNER');
    $this->db->where('class_id', $class_id);
    $this->db->where('subject.subject_id', $subject_id);
    $query = $this->db->get();
    if( count($query->row()) ){
      $query = $this->db->get_where('marks_distribution',array('class_id'=>$class_id,'subject_id'=>$subject_id));
          if( count($query->row()) ){
            return $query->result();
          }else{
            return "new";
          }

    }else{

        return false;
    }
  }
   // get marks distribute field
    public function get_marks_dis_field($arrayName){
      if(isset($arrayName['class_id']) && isset($arrayName['subject_id'])){
        $query = $this->db->get_where('marks_distribution', array('class_id'=>$arrayName['class_id'],'subject_id'=>$arrayName['subject_id']));
        return $query->result();
      }
      return false;
    }
}
