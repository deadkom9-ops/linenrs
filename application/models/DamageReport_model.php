<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DamageReport_model extends CI_Model {

  public function all($role, $unit_id) {
    $this->db->select('dr.*, u.name as unit_name')
      ->from('damage_reports dr')
      ->join('units u','u.id=dr.unit_id','left')
      ->order_by('dr.id','desc');
    if ($role === 'unit') $this->db->where('dr.unit_id', $unit_id);
    return $this->db->get()->result();
  }

  public function find($id) {
    $hdr = $this->db->select('dr.*, u.name as unit_name')
      ->from('damage_reports dr')
      ->join('units u','u.id=dr.unit_id','left')
      ->where('dr.id',$id)->get()->row();
    if (!$hdr) return [null, []];
    $items = $this->db->select('i.*, lt.name as linen_name')
      ->from('damage_report_items i')
      ->join('linen_types lt','lt.id=i.linen_type_id','left')
      ->where('i.damage_report_id',$id)->get()->result();
    return [$hdr, $items];
  }

  public function create($post, $user_id) {
    $hdr = [
      'report_no' => 'DM-' . date('Ymd-His'),
      'unit_id' => (int)$post['unit_id'],
      'report_date' => $post['report_date'],
      'status' => 'OPEN',
      'created_by' => $user_id,
      'notes' => $post['notes'],
      'created_at' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('damage_reports', $hdr);
    $id = $this->db->insert_id();

    if (!empty($post['items'])) {
      foreach ($post['items'] as $row) {
        if (empty($row['linen_type_id']) || empty($row['qty']) || empty($row['category'])) continue;
        $this->db->insert('damage_report_items', [
          'damage_report_id' => $id,
          'linen_type_id' => (int)$row['linen_type_id'],
          'qty' => (int)$row['qty'],
          'category' => $row['category'],
          'remark' => $row['remark'] 
        ]);
      }
    }
    return $id;
  }

  public function ack($id, $user_id) {
    $this->db->where('id',$id)->update('damage_reports', [
      'status' => 'ACKNOWLEDGED',
      'acknowledged_by' => $user_id,
      'acknowledged_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
  }

  public function delete_request($id) {
  // pastikan data ada
  $row = $this->db
    ->get_where('damage_reports', array('id' => (int)$id))
    ->row();

  if (!$row) return false;

  // transaksi
  $this->db->trans_begin();

  // 1️⃣ hapus detail dulu
  $this->db
    ->where('damage_report_id', (int)$id)
    ->delete('damage_report_items');

  // 2️⃣ hapus header
  $this->db
    ->where('id', (int)$id)
    ->delete('damage_reports');

  // commit / rollback
  if ($this->db->trans_status() === FALSE) {
    $this->db->trans_rollback();
    return false;
  }

  $this->db->trans_commit();
  return true;
}
}
