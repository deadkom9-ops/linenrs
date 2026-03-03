<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Units extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->require_role(['admin']);
  }

  public function index() {
    $data['title'] = 'Unit/Ruangan';
    $data['rows'] = $this->db->get('units')->result();
    $this->render('master/units/index', $data);
  }

  public function create() {
    $data['title'] = 'Tambah Unit/Ruangan';
    if ($this->input->method() === 'post') {
      $this->db->insert('units', [
        'name' => $this->input->post('name', true),
         'is_active' => (int)$this->input->post('is_active')
      ]);
      $this->session->set_flashdata('msg','Berhasil tambah');
      redirect('units');
    }
    $this->render('master/units/form', $data);
  }

  public function edit($id) {
    $data['title'] = 'Edit Unit/Ruangan';
    $data['row'] = $this->db->get_where('units', ['id'=>$id])->row();
    if (!$data['row']) show_404();

    if ($this->input->method() === 'post') {
      $upd = ['name' => $this->input->post('name', true)];
      $upd['is_active'] = (int)$this->input->post('is_active');
      $this->db->where('id',$id)->update('units', $upd);
      $this->session->set_flashdata('msg','Berhasil update');
      redirect('units');
    }
    $this->render('master/units/form', $data);
  }

  public function delete($id) {
    $this->db->where('id',$id)->delete('units');
    $this->session->set_flashdata('msg','Berhasil hapus');
    redirect('units');
  }
}
