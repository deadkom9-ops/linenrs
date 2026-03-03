<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->require_role(['admin']);
  }

  public function index() {
    $data['title'] = 'Shift';
    $data['rows'] = $this->db->get('shifts')->result();
    $this->render('master/shifts/index', $data);
  }

  public function create() {
    $data['title'] = 'Tambah Shift';
    if ($this->input->method() === 'post') {
      $this->db->insert('shifts', [
        'name' => $this->input->post('name', true),

      ]);
      $this->session->set_flashdata('msg','Berhasil tambah');
      redirect('shifts');
    }
    $this->render('master/shifts/form', $data);
  }

  public function edit($id) {
    $data['title'] = 'Edit Shift';
    $data['row'] = $this->db->get_where('shifts', ['id'=>$id])->row();
    if (!$data['row']) show_404();

    if ($this->input->method() === 'post') {
      $upd = ['name' => $this->input->post('name', true)];

      $this->db->where('id',$id)->update('shifts', $upd);
      $this->session->set_flashdata('msg','Berhasil update');
      redirect('shifts');
    }
    $this->render('master/shifts/form', $data);
  }

  public function delete($id) {
    $this->db->where('id',$id)->delete('shifts');
    $this->session->set_flashdata('msg','Berhasil hapus');
    redirect('shifts');
  }
}
