<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media_model extends CI_Model {
  public function total_upload_image_count() {
       $images =  preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/"));
      echo count(preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/")));
  }

  public function get_users($limit, $start) {
    $this->db->limit($limit, $start);
    $query = preg_grep('~\.(jpeg|jpg|png)$~', scandir("./uploads/"));

    if (count($query) > 0) {
      var_dump ( $query);
    }
    return false;
  }
}
