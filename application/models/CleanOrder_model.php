<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CleanOrder_model extends CI_Model {

  public function all($role, $unit_id) {
    $this->db->select('co.*, u.name as unit_name')
      ->from('clean_orders co')
      ->join('units u','u.id=co.unit_id','left')
      ->order_by('co.id','desc');
    if ($role === 'unit') $this->db->where('co.unit_id', $unit_id);
    return $this->db->get()->result();
  }

  public function find($id) {
    $hdr = $this->db->select('co.*, u.name as unit_name')
      ->from('clean_orders co')
      ->join('units u','u.id=co.unit_id','left')
      ->where('co.id',$id)->get()->row();
    if (!$hdr) return [null, []];
    $items = $this->db->select('i.*, lt.name as linen_name')
      ->from('clean_order_items i')
      ->join('linen_types lt','lt.id=i.linen_type_id','left')
      ->where('i.clean_order_id',$id)->get()->result();
    return [$hdr, $items];
  }

  public function create($post, $user_id, $role_unit_id) {
    $unit_id = (int)$post['unit_id'];
    if (!empty($role_unit_id)) $unit_id = (int)$role_unit_id;

    $hdr = [
      'order_no'   => 'CO-' . date('Ymd-His'),
      'unit_id'    => $unit_id,
      'order_date' => $post['order_date'],
      'notes'      => $post['notes'],
      'status'     => 'SUBMITTED',
      'requested_by' => $user_id,
      'created_at' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('clean_orders', $hdr);
    $id = $this->db->insert_id();

    if (!empty($post['items'])) {
      foreach ($post['items'] as $row) {
        if (empty($row['linen_type_id']) || empty($row['qty'])) continue;
        $this->db->insert('clean_order_items', [
          'clean_order_id' => $id,
          'linen_type_id' => (int)$row['linen_type_id'],
          'qty' => (int)$row['qty'],
          'remark' => $row['remark']
        ]);
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
    $this->db->where('id',$id)->update('clean_orders', $data);
  }

  public function delete_request($id) {
  // pastikan data ada
  $row = $this->db
    ->get_where('clean_orders', array('id' => (int)$id))
    ->row();

  if (!$row) return false;

  // transaksi
  $this->db->trans_begin();

  // 1️⃣ hapus detail dulu
  $this->db
    ->where('clean_order_id', (int)$id)
    ->delete('clean_order_items');

  // 2️⃣ hapus header
  $this->db
    ->where('id', (int)$id)
    ->delete('clean_orders');

  // commit / rollback
  if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    return false;
  }

  $this->db->trans_commit();
  return true;
}


}
