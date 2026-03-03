<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DirtyRequest_model extends CI_Model {

  public function all($role, $unit_id) {
    $this->db->select('dr.*, u.name as unit_name')
      ->from('dirty_requests dr')
      ->join('units u','u.id=dr.unit_id','left')
      ->order_by('dr.id','desc');
    if ($role === 'unit') $this->db->where('dr.unit_id', $unit_id);
    return $this->db->get()->result();
  }

  public function find($id) {
    $hdr = $this->db->select('dr.*, u.name as unit_name')
      ->from('dirty_requests dr')
      ->join('units u','u.id=dr.unit_id','left')
      ->where('dr.id',$id)->get()->row();
    if (!$hdr) return [null, []];
    $items = $this->db->select('i.*, lt.name as linen_name')
      ->from('dirty_request_items i')
      ->join('linen_types lt','lt.id=i.linen_type_id','left')
      ->where('i.dirty_request_id',$id)->get()->result();
    return [$hdr, $items];
  }

  public function create($post, $user_id, $role_unit_id) {
  $unit_id = isset($post['unit_id']) ? (int)$post['unit_id'] : 0;

  // Jika role unit, paksa unit_id dari user
  if (!empty($role_unit_id)) {
    $unit_id = (int)$role_unit_id;
  }

  $hdr = array(
    'request_no'   => 'DR-' . date('Ymd-His'),
    'unit_id'      => $unit_id,
    'request_date' => isset($post['request_date']) ? $post['request_date'] : date('Y-m-d'),
    'request_time' => isset($post['request_time']) ? $post['request_time'] : date('H:i:s'),
    'notes'        => isset($post['notes']) ? $post['notes'] : null,
    'status'       => 'SUBMITTED',
    'submitted_by' => $user_id,
    'created_at'   => date('Y-m-d H:i:s')
  );

  $this->db->insert('dirty_requests', $hdr);
  $id = $this->db->insert_id();

  if (!empty($post['items']) && is_array($post['items'])) {
    foreach ($post['items'] as $row) {
      $linen_type_id = isset($row['linen_type_id']) ? (int)$row['linen_type_id'] : 0;
      $qty           = isset($row['qty']) ? (int)$row['qty'] : 0;

      if ($linen_type_id <= 0 || $qty <= 0) continue;

      $this->db->insert('dirty_request_items', array(
        'dirty_request_id' => $id,
        'linen_type_id'    => $linen_type_id,
        'qty'              => $qty,
        'remark'           => isset($row['remark']) ? $row['remark'] : null
      ));
    }
  }

  return $id;
}


  public function set_status($id, $status, $user_id, $fieldUser, $fieldTime=null) {
    $data = [
      'status' => $status,
      $fieldUser => $user_id,
      'updated_at' => date('Y-m-d H:i:s')
    ];
    if ($fieldTime) $data[$fieldTime] = date('Y-m-d H:i:s');
    $this->db->where('id',$id)->update('dirty_requests', $data);
  }

public function delete_request($id) {
  // pastikan data ada
  $row = $this->db
    ->get_where('dirty_requests', array('id' => (int)$id))
    ->row();

  if (!$row) return false;

  // transaksi
  $this->db->trans_begin();

  // 1️⃣ hapus detail dulu
  $this->db
    ->where('dirty_request_id', (int)$id)
    ->delete('dirty_request_items');

  // 2️⃣ hapus header
  $this->db
    ->where('id', (int)$id)
    ->delete('dirty_requests');

  // commit / rollback
  if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    return false;
  }

  $this->db->trans_commit();
  return true;
}

  
}
