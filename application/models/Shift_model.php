<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shift_model extends CI_Model {
  public function all() {
    return $this->db->get('shifts')->result();
  }
}
