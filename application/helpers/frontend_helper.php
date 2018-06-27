<?php
// get all notice
function get_all_data($table_name = null, $limit = null)
{
  $CI	=& get_instance(); // Get CI Instance

  $limit = ($limit) ? $CI->db->limit($limit) : $limit;
  $query = $CI->db->get($table_name);
  return ( count($query->result()) ) ? $query->result() : null;
}


// String split
if ( ! function_exists('substrwords'))
{
	function substrwords($text='Empty', $maxchar = 30, $end='...') {
		if (strlen($text) > $maxchar || $text == '') {
			$words = preg_split('/\s/', $text);
			$output = '';
			$i      = 0;
			while (1) {
				$length = strlen($output)+strlen($words[$i]);
				if ($length > $maxchar) {
					break;
				}
				else {
					$output .= " " . $words[$i];
					++$i;
				}
			}
			$output .= $end;
		}
		else {
			$output = $text;
		}
		return $output;
	}
}

// get all user data by id
if ( ! function_exists('get_username_by_id'))
{
  function get_username_by_id($id=null)
  {
    $CI =& get_instance();

    $args = 'user_id='.$id.' AND key="full_name"';
    $query =  $CI->db->where( $args )->get_where( 'user_meta' );

    if( $query->num_rows() > 0 )
    {
      return $query->row()->value;
    }
    else
    {
      if( $id ) $CI->db->where('user_id', $id);
      $CI->db->order_by("user_id", "desc");
      $query = $CI->db->get('users');
      return (count($query->result())) ? $query->result()[0]->username : null;
    }
  }


   	// get two randaom messge
	if ( ! function_exists('get_two_message'))
	{
	  function get_two_message()
	  {
	    $CI =& get_instance();
	    $CI->db->limit(2);
		$query = $CI->db->order_by('id', 'RANDOM')->get_where('message', array('message_owner !='=>'Head Teacher'));
		return ( count( $query->row() ) ) ? $query->result() : null;
	  }
	}


	// get Head Teacher Message
	if ( ! function_exists('get_head_teacher_message'))
	{
	  function get_head_teacher_message()
	  {
	    $CI =& get_instance();
	    $CI->db->limit(1);
		$query = $CI->db->get_where('message', array('message_owner'=>'Head Teacher'));
		return ( count( $query->row() ) ) ? $query->result() : null;
	  }
	}

	// get News & Event
	if ( ! function_exists('get_news_event'))
	{
	  function get_news_event($limit = null)
	  {
	    $CI =& get_instance();
	    $CI->db->limit($limit);
		$query = $CI->db->order_by('id', 'DESC')->get('news_event');
		return ( count( $query->row() ) ) ? $query->result() : null;
	  }
	}
	
	// get student by user_id
	if ( ! function_exists('get_student_by_user_id'))
	{
	  function get_student_by_user_id($user_id)
	  {
	  	$CI =& get_instance();
		$query = $CI->db->get_where('student',array('user_id'=>$user_id));
		return ( count( $query->row() )) ? $query->result() : null;
	  }
	}	

	
	// GPA SYSTEM
	if ( ! function_exists('gpa_by_obtained_marks'))
	{
	  function gpa_by_obtained_marks($obtain_mark)
	  {
	  	$CI =& get_instance();
		$query = $CI->db->get_where('gpa',array('min_range <= '=>$obtain_mark, 'max_range >='=>$obtain_mark));
		return ( count( $query->row() )) ? $query->result() : null;
	  }
	}
}
