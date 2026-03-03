<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DamageReports extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('DamageReport_model', 'dm');
    $this->load->model('Unit_model', 'unit');
    $this->load->model('LinenType_model', 'lt');
  }

  public function index() {
    $data['title'] = 'Pengajuan Linen Rusak/Cacat';
    $role = $this->session->userdata('role');
    $unit_id = (int)$this->session->userdata('unit_id');
    $data['rows'] = $this->dm->all($role, $unit_id);
    $this->render('damage_reports/index', $data);
  }

  public function show($id) {
    $data['title'] = 'Detail Linen Rusak';
    list($hdr,$items) = $this->dm->find($id);
    if(!$hdr) show_404();
    $data['hdr']=$hdr; $data['items']=$items;
    $this->render('damage_reports/show', $data);
  }

  public function create() {
    $this->require_role(['admin','laundry']); // sesuai dokumen: petugas laundry input
    $data['title'] = 'Input Linen Rusak';
    if ($this->input->method() === 'post') {
      $id = $this->dm->create($this->input->post(), (int)$this->session->userdata('user_id'));
      $this->session->set_flashdata('msg','Report dibuat.');
      redirect('damagereports/show/'.$id);
    }
    $data['units'] = $this->unit->all_active();
    $data['linen'] = $this->lt->all_active();
    $this->render('damage_reports/create', $data);
  }

  public function ack($id) {
    // unit/admin bisa acknowledge
    $this->require_role(['admin','unit']);
    $this->dm->ack($id, (int)$this->session->userdata('user_id'));
    $this->session->set_flashdata('msg','Acknowledged.');
    redirect('damagereports/show/'.$id);
  }

  public function delete($id) {
  // hanya admin & laundry yang boleh hapus (ubah kalau kamu mau unit juga boleh)
  $this->require_role(array('admin','laundry'));

  $ok = $this->dm->delete_request((int)$id);

  if ($ok) {
    $this->session->set_flashdata('msg', 'Berhasil hapus data.');
  } else {
    $this->session->set_flashdata('err', 'Gagal hapus data / data tidak ditemukan.');
  }

  redirect('damagereports');
}

}
