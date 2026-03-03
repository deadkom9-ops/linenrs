<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DirtyRequests extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('DirtyRequest_model', 'dr');
    $this->load->model('Unit_model', 'unit');
    $this->load->model('LinenType_model', 'lt');
  }

  public function index() {
    $data['title'] = 'Pengambilan Linen Kotor';
    $role = $this->session->userdata('role');
    $unit_id = (int)$this->session->userdata('unit_id');
    $data['rows'] = $this->dr->all($role, $unit_id);
    $this->render('dirty_requests/index', $data);
  }

  public function show($id) {
    $data['title'] = 'Detail Linen Kotor';
    list($hdr, $items) = $this->dr->find($id);
    if (!$hdr) show_404();
    $data['hdr'] = $hdr;
    $data['items'] = $items;
    $this->render('dirty_requests/show', $data);
  }



  public function create() {
    $data['title'] = 'Input Linen Kotor';
    $role = $this->session->userdata('role');

    if ($this->input->method() === 'post') {
      if (!in_array($role, ['admin','unit'], true)) {
        $this->session->set_flashdata('err','Hanya unit/admin yang bisa input.');
        redirect('dirtyrequests');
      }
      $id = $this->dr->create(
        $this->input->post(),
        (int)$this->session->userdata('user_id'),
        $role==='unit' ? (int)$this->session->userdata('unit_id') : 0
      );
      $this->session->set_flashdata('msg','Berhasil input linen kotor.');
      redirect('dirtyrequests/show/'.$id);
    }

    $data['units'] = $this->unit->all_active();
    $data['linen'] = $this->lt->all_active();
    $this->render('dirty_requests/create', $data);
  }

  public function take($id) {
    $this->require_role(['admin','laundry']);
    $this->dr->set_status($id, 'TAKEN', (int)$this->session->userdata('user_id'), 'taken_by');
    $this->session->set_flashdata('msg','Status: diambil laundry.');
    redirect('dirtyrequests/show/'.$id);
  }

  public function approve($id) {
    $this->require_role(['admin','laundry']);
    $this->dr->set_status($id, 'APPROVED', (int)$this->session->userdata('user_id'), 'approved_by', 'approved_at');
    $this->session->set_flashdata('msg','Request approved.');
    redirect('dirtyrequests/show/'.$id);
  }

  public function reject($id) {
    $this->require_role(['admin','laundry']);
    $this->dr->set_status($id, 'REJECTED', (int)$this->session->userdata('user_id'), 'approved_by', 'approved_at');
    $this->session->set_flashdata('msg','Request rejected.');
    redirect('dirtyrequests/show/'.$id);
  }

  public function delete($id) {
  // hanya admin & laundry yang boleh hapus (ubah kalau kamu mau unit juga boleh)
  $this->require_role(array('admin','laundry'));

  $ok = $this->dr->delete_request((int)$id);

  if ($ok) {
    $this->session->set_flashdata('msg', 'Berhasil hapus data.');
  } else {
    $this->session->set_flashdata('err', 'Gagal hapus data / data tidak ditemukan.');
  }

  redirect('dirtyrequests');
}

}
