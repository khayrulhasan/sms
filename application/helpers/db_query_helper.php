<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Get Class name by ID
if ( ! function_exists('get_class_name'))
{
    function get_class_name( $id = null )
    {
        $all_class = array(
                          '0'  => 'Empty',
                          '1'  => 'One',
                          '2'  => 'Two',
                          '3'  => 'Three',
                          '4'  => 'Four',
                          '5'  => 'Five',
                          '6'  => 'Six',
                          '7'  => 'Seven',
                          '8'  => 'Eight',
                          '9'  => 'Nine',
                          '10' => 'Ten',
          );
        if($id){
            return (isset($all_class[$id]))?$all_class[$id]:null;
        }else{
            return $all_class;
        }

    }
}
// Get Class name by ID get_student_marks_by_subject_id($student_id,$class_id,$subject_id)
if ( ! function_exists('get_student_marks_by_subject_id'))
{
    function get_student_marks_by_subject_id( $student_id, $class_id, $subject_id )
    {
      $CI  =& get_instance(); // Get CI Instance
      $query = $CI->db->get_where('marksheet',array('student_id'=>$student_id,'class_id'=>$class_id,'subject_id'=>$subject_id));
      return ( count( $query->row() )>0 )   ? $query->result()[0] : NULL ;
    }
}

// Get total notice
if ( ! function_exists('get_total_data'))
{
    function get_total_data( $tbl = null)
    {
      $CI	=& get_instance(); // Get CI Instance
      if( $tbl == null ){
        return 0;
      }
      else {
        $query = $CI->db->get($tbl);
        return ( count($query->result()) ) ?: 0;
      }
    }
}

// get dashboard options
if ( ! function_exists('get_dashboard_options') )
{
  function get_dashboard_options()
  {
    $CI	=& get_instance(); // Get CI Instance

    $query =  $CI->db->like('key', 'dashboard_', 'after')
          ->  get( 'options' );
          // echo $query;
    if( $query->num_rows() > 0 )
    {
        $data = $query->result();
        foreach ($data as $key => $meta) {
          $result[$meta->key] = $meta->value;
        }
        return $result;
    }
    return NULL;
  }
}

// get today's attendance history
if ( ! function_exists('is_attendance_made_today') )
{
  function is_attendance_made_today($class = null)
  {
    $CI	=& get_instance(); // Get CI Instance
    $CI->db->where(array(
      'date_of_attand' => date('Y-m-d'),
      's_class'        => $class
    ));
    $query =  $CI->db->get( 'attendance' );
          // echo $query;
    if( $query->num_rows() > 0 )
    {
      return $query->first_row();
    }
    return false;
  }
}


// // Get Subject name by ID
if ( ! function_exists('get_subject'))
{
    function get_subject( $id = null )
    {
      $CI =& get_instance();
      if( $id ) $CI->db->where('subject_id =', $id);
      $query = $CI->db->get('subject');
      return ( count( $query->row() )>0 )   ? $query->result() : NULL ;

    }
}
// Get Subject name by teacher id
if ( ! function_exists('get_subject_by_teacher_id'))
{
    function get_subject_by_teacher_id( $teacher_id = null )
    {
      $CI	=& get_instance(); // Get CI Instance
      if( $teacher_id == null ){
        return null;
      }
      else {
        $CI->db->from('subject');
        $CI->db->join('teachers', 'teachers.subject_id = subject.subject_id', 'INNER');

        if( $teacher_id ) $CI->db->where('id =', $teacher_id);
        $query = $CI->db->get();
        if(count($query->row()) == 0) return NULL;
        return ( count( $query->row() )>0 )   ? $query->result() : NULL ;
      }
    }
}

// Get User by ID
if ( ! function_exists('get_user_by_id'))
{
    function get_user_by_id( $id = null )
    {
      $CI	=& get_instance(); // Get CI Instance
      if( $id == null ){
        return null;
      }
      else {
        $query = $CI->db->get_where('users', array('user_id'  => $id));
        return ( count($query->result()) ) ? $query->row() : null;
      }
    }
}


// Get teacher by ID
if ( ! function_exists('get_teacher_name_by_id'))
{
    function get_teacher_name_by_id( $id = null )
    {
      $CI	=& get_instance(); // Get CI Instance
      if( $id == null ){
        return null;
      }
      else {
        $query = $CI->db->get_where('teachers', array('id'  => $id));
        return ( count($query->result()) ) ? $query->row() : null;
      }
    }
}

// Get student_is_present
if ( ! function_exists('student_is_present'))
{
    function student_is_present($id, $date)
    {
      $CI	=& get_instance(); // Get CI Instance
      $query = $CI->db->get_where('attendance', array('s_id'  => $id, 'date_of_attand' => $date));

      if( count($query->row()) )
      {
        $p = $query->row()->attend;
        return $p;
      }
      return null;
    }
}

// Get total_student_present
if ( ! function_exists('total_student_present'))
{
    function total_student_present()
    {
      $CI	=& get_instance(); // Get CI Instance
      $total_students = $CI->db->count_all_results('student');
      // total class
      $total_class    = [];
      $total_class    = $CI->db->group_by('date_of_attand')->get('attendance');
      $total_class    = count($total_class->result());
      // total present
      $CI->db->where('attend', 1);
      $total_present  = $CI->db->count_all_results('attendance');

      $classXstudent  = $total_class * $total_students;

      $result         = ( $total_present * 100 ) / $classXstudent;

      return ( $result <= 0 ) ? 0 : $result;
    }
}


// Get get_user_avartar
if ( ! function_exists('get_user_avartar'))
{
    function get_user_avartar($auth_user_id)
    {
      $CI	=& get_instance(); // Get CI Instance
      $args = 'user_id='.$auth_user_id.' AND key="profile-image"';
      $query =  $CI->db->where( $args )
            ->  get_where( 'user_meta' );
            // echo $query;
      if( $query->num_rows() > 0 )
      {
          $data = $query->result();
          $url  = $data[0]->value;

          return '<img src="'.base_url('uploads/'.$url).'" alt="image" />';
      }
      return '<img src="https://www.gravatar.com/avatar/'.md5($CI->auth_email).'?d=mm&s=300" alt="image" />';
    }
}

// Get get_user_address
if ( ! function_exists('get_user_address'))
{
    function get_user_address($auth_user_id)
    {
      $CI	=& get_instance(); // Get CI Instance
      $args = 'user_id='.$auth_user_id.' AND key="address"';
      $query =  $CI->db->where( $args )
            ->  get_where( 'user_meta' );
            // echo $query;
      return ( $query->num_rows() > 0 ) ? $query->row()->value : 'Empty';

    }
}

// Get get_user_contact
if ( ! function_exists('get_user_contact'))
{
    function get_user_contact($auth_email)
    {
      $CI	=& get_instance(); // Get CI Instance
      $query =  $CI->db->where( 'email', $auth_email )
            ->  get_where( 'users' );
            // echo $query;
      if( $query->num_rows() > 0 )
      {
        $data = $query->result();
        return $data[0]->phone;
      }
      return '';
    }
}

/**
* Get all pages
*/
if ( ! function_exists('get_pages'))
{
    function get_pages()
    {
      $CI	=& get_instance();
        $CI->db->order_by('title');
        // $CI->db->limit(5);
        $query = $CI->db->get('pages');
        return ( count($query->result()) ) ? $query->result() : null;
    }
}

// booklist access as teacher
if ( ! function_exists('update_method_access_denied'))
{
  function update_method_access_denied($table_name, $field_value, $full_access_level)
  {
    $CI =& get_instance();
    if( $CI->auth_level >= $full_access_level){
      return TRUE;
    }else{
      $query = $CI->db->get_where($table_name, array('user_id' => $CI->auth_user_id));
      if(count($query->row()) == 0) return FALSE;
      if($query->result()[0]->id == $field_value ){
        return TRUE;
      }else{
        return FALSE;
      }
    }
  }
}




  if ( ! function_exists('get_all_subject'))
{
  // get all users or single user
  function get_all_subject($user_id = null)
  {
    $CI =& get_instance();
    $CI->db->from('teachers');
    $CI->db->join('subject', 'subject.subject_id = teachers.subject_id', 'INNER');
    if( $user_id ) $CI->db->where('user_id =', $user_id);
    $query = $CI->db->get();
    return ( count( $query->row() )>0 )   ? $query->result() : NULL ;
  }

}


// get class by teacher Id
if ( ! function_exists('get_class_by_teacher_id'))
{
  // get all users or single user
  function get_class_by_teacher_id($teacher_id = null)
  {
    $CI =& get_instance();
    $CI->db->from('class');
    $CI->db->join('teachers', 'teachers.id = class.teacher_id', 'INNER');
    if( $teacher_id ) $CI->db->where('user_id =', $teacher_id);
    $query = $CI->db->get();
    return ( count( $query->row() )>0 )   ? $query->result() : NULL ;
  }
}


// get total number
if ( ! function_exists('get_total_number_obtain_number'))
{
  // get all users or single user
  function get_total_number_obtain_number($student_id, $subject_id)
  {
    $CI =& get_instance();
    $query = $CI->db->get_where('marksheet', array('student_id' => $student_id,'subject_id'=>$subject_id));
    if(count($query->row()) == 0) return NULL;
     return ( count( $query->row() ) ==1 )   ? $query->result() : NULL ;
  }
}


// check class by teacher
if ( ! function_exists('check_class_id'))
{
  // get all users or single user
  function check_class_id($class_id)
  {
        $CI =& get_instance(); // Get CI Instance
        $query = $CI->db->get_where('teachers', array('user_id'  => $CI->auth_user_id));
        // $teacher_id =  ( count( $query->row() ) == 1 )   ? $query->result()[0]->id : NULL ;
        // return $teachers_id;
        
        if( count( $query->row() ) == 1){
          $query = $CI->db->get_where('class', array('class_id'  => $class_id ,'teacher_id'=>$query->result()[0]->id ));
          return ( count($query->result())>0 ) ? TRUE : FALSE;
        }else{
          return FALSE;
        }

      // if( $id == null ){
      //   return null;
      // }
      // else {
      //   $query = $CI->db->get_where('class', array('class_id'  => $id));
      //   return ( count($query->result()) ) ? $query->row() : null;
      // }
  }
}
