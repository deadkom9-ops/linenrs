<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LinenType_model extends CI_Model {
  public function all_active() {
    return $this->db->get_where('linen_types', ['is_active'=>1])->result();
  }
}
