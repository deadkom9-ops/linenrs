<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LinenTypes extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->require_role(['admin']);
  }

  public function index() {
    $data['title'] = 'Jenis Linen';
    $data['rows'] = $this->db->get('linen_types')->result();
    $this->render('master/linen_types/index', $data);
  }

  public function create() {
    $data['title'] = 'Tambah Jenis Linen';
    if ($this->input->method() === 'post') {
      $this->db->insert('linen_types', [
        'name' => $this->input->post('name', true),
         'is_active' => (int)$this->input->post('is_active')
      ]);
      $this->session->set_flashdata('msg','Berhasil tambah');
      redirect('linen_types');
    }
    $this->render('master/linen_types/form', $data);
  }

  public function edit($id) {
    $data['title'] = 'Edit Jenis Linen';
    $data['row'] = $this->db->get_where('linen_types', ['id'=>$id])->row();
    if (!$data['row']) show_404();

    if ($this->input->method() === 'post') {
      $upd = ['name' => $this->input->post('name', true)];
      $upd['is_active'] = (int)$this->input->post('is_active');
      $this->db->where('id',$id)->update('linen_types', $upd);
      $this->session->set_flashdata('msg','Berhasil update');
      redirect('linen_types');
    }
    $this->render('master/linen_types/form', $data);
  }

  public function delete($id) {
    $this->db->where('id',$id)->delete('linen_types');
    $this->session->set_flashdata('msg','Berhasil hapus');
    redirect('linen_types');
  }
}
