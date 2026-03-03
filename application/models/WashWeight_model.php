<?php defined('BASEPATH') OR exit('No direct script access allowed');

class WashWeight_model extends CI_Model {

  public function all($role, $unit_id) {
    $this->db->select('w.*, u.name as unit_name, s.name as shift_name')
      ->from('wash_weights w')
      ->join('units u','u.id=w.unit_id','left')
      ->join('shifts s','s.id=w.shift_id','left')
      ->order_by('w.id','desc');
    if ($role === 'unit') $this->db->where('w.unit_id', $unit_id);
    return $this->db->get()->result();
  }

  public function create($post, $user_id) {
    $this->db->insert('wash_weights', [
      'unit_id' => (int)$post['unit_id'],
      'report_date' => $post['report_date'],
      'shift_id' => (int)$post['shift_id'],
      'pickup_time' => $post['pickup_time'],
      'weight_kg' => (float)$post['weight_kg'],
      'wash_category' => isset($post['wash_category']) ? $post['wash_category'] : 'NON_INFEKSIUS',
      'notes' => $post['notes'],
      'created_by' => $user_id,
      'created_at' => date('Y-m-d H:i:s')
    ]);
  }

  public function find($id) {
  return $this->db->get_where('wash_weights', array('id' => (int)$id))->row();
  }

public function update_weight($id, $post) {
  $row = $this->find($id);
  if (!$row) return false;

  $this->db->where('id', (int)$id)->update('wash_weights', array(
    'unit_id'     => (int)$post['unit_id'],
    'report_date' => $post['report_date'],
    'shift_id'    => (int)$post['shift_id'],
    'pickup_time' => $post['pickup_time'],
    'weight_kg'   => (float)$post['weight_kg'],
    'wash_category' => isset($post['wash_category']) ? $post['wash_category'] : 'NON_INFEKSIUS',
    'notes'       => isset($post['notes']) ? $post['notes'] : null,
    'updated_at'  => date('Y-m-d H:i:s')
  ));

  return ($this->db->affected_rows() >= 0);
  }

public function delete_weight($id) {
  $row = $this->find($id);
  if (!$row) return false;

  $this->db->where('id', (int)$id)->delete('wash_weights');
  return ($this->db->affected_rows() > 0);
  }


}
