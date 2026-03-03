<?php defined('BASEPATH') OR exit('No direct script access allowed');

class WashWeights extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('WashWeight_model', 'ww');
    $this->load->model('Unit_model', 'unit');
    $this->load->model('Shift_model', 'shift');
  }

  public function index() {
    $data['title'] = 'Laporan Berat Cucian';
    $role = $this->session->userdata('role');
    $unit_id = (int)$this->session->userdata('unit_id');
    $data['rows'] = $this->ww->all($role, $unit_id);
    $this->render('wash_weights/index', $data);
  }

  public function create() {
    $this->require_role(['admin','laundry']); // sesuai dokumen: petugas laundry input
    $data['title'] = 'Input Berat Cucian';
    if ($this->input->method() === 'post') {
      $this->ww->create($this->input->post(), (int)$this->session->userdata('user_id'));
      $this->session->set_flashdata('msg','Berhasil input berat.');
      redirect('washweights');
    }
    $data['units'] = $this->unit->all_active();
    $data['shifts'] = $this->shift->all();
    $this->render('wash_weights/create', $data);
  }

  public function edit($id) {
  $this->require_role(array('admin','laundry'));

  $data['title'] = 'Edit Berat Cucian';
  $data['row'] = $this->ww->find((int)$id);
  if (!$data['row']) show_404();

  if ($this->input->method() === 'post') {
    $ok = $this->ww->update_weight((int)$id, $this->input->post());

    if ($ok) {
      $this->session->set_flashdata('msg','Berhasil update data.');
      redirect('washweights');
    } else {
      $this->session->set_flashdata('err','Gagal update data.');
    }
  }

  $data['units']  = $this->unit->all_active();
  $data['shifts'] = $this->shift->all();
  $this->render('wash_weights/edit', $data);
}

public function delete($id) {
  $this->require_role(array('admin','laundry'));

  $ok = $this->ww->delete_weight((int)$id);

  if ($ok) {
    $this->session->set_flashdata('msg','Berhasil hapus data.');
  } else {
    $this->session->set_flashdata('err','Gagal hapus data / data tidak ditemukan.');
  }

  redirect('washweights');
}

}
