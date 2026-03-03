<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_model extends CI_Model {
  public function all_active() {
    return $this->db->get_where('units', ['is_active'=>1])->result();
  }
}
