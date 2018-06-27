<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_model {

	// get all subjects
	public function get_all_subject()
	{
		$query = $this->db->get('subject');
		return ( count($query->row()) ) ? $query->result() : null ;
	}

}
