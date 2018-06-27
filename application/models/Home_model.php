<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_model {

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

	// get News & Event single or multipule
	public function get_news_event($id = null)
	{

		if($id != null){

			$query = $this->db->get_where('news_event', array('id' => $id));

			return ( $query->result() ) ?: null;

		}else{

			$query = $this->db->order_by('id', 'DESC')->get('news_event');
			
			return ( count( $query->row() ) ) ? $query->result() : null;

		}
	}
  

}
