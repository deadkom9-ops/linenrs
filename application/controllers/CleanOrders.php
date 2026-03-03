<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CleanOrders extends MY_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('CleanOrder_model', 'co');
    $this->load->model('Unit_model', 'unit');
    $this->load->model('LinenType_model', 'lt');
  }

  public function index() {
    $data['title'] = 'Pendistribusian Linen Bersih';
    $role = $this->session->userdata('role');
    $unit_id = (int)$this->session->userdata('unit_id');
    $data['rows'] = $this->co->all($role, $unit_id);
    $this->render('clean_orders/index', $data);
  }

 public function show($id) {
  $data['title'] = 'Detail Linen Bersih';
  list($hdr, $items) = $this->co->find($id);
  if (!$hdr) show_404();
  $data['hdr'] = $hdr;
  $data['items'] = $items;
  $this->render('clean_orders/show', $data);
}

  public function create() {
    $data['title'] = 'Order Linen Bersih';
    $role = $this->session->userdata('role');

    if ($this->input->method() === 'post') {
      if (!in_array($role, ['admin','unit'], true)) {
        $this->session->set_flashdata('err','Hanya unit/admin yang bisa order.');
        redirect('cleanorders');
      }
      $id = $this->co->create(
        $this->input->post(),
        (int)$this->session->userdata('user_id'),
        $role==='unit' ? (int)$this->session->userdata('unit_id') : 0
      );
      $this->session->set_flashdata('msg','Order dibuat.');
      redirect('cleanorders/show/'.$id);
    }

    $data['units'] = $this->unit->all_active();
    $data['linen'] = $this->lt->all_active();
    $this->render('clean_orders/create', $data);
  }

  public function approve($id) {
    $this->require_role(['admin','laundry']);
    $this->co->set_status($id, 'APPROVED', (int)$this->session->userdata('user_id'), 'approved_by');
    $this->session->set_flashdata('msg','Order approved.');
    redirect('cleanorders/show/'.$id);
  }

  public function reject($id) {
    $this->require_role(['admin','laundry']);
    $this->co->set_status($id, 'REJECTED', (int)$this->session->userdata('user_id'), 'approved_by');
    $this->session->set_flashdata('msg','Order rejected.');
    redirect('cleanorders/show/'.$id);
  }

  public function deliver($id) {
    $this->require_role(['admin','laundry']);
    $this->co->set_status($id, 'DELIVERED', (int)$this->session->userdata('user_id'), 'delivered_by', 'delivered_at');
    $this->session->set_flashdata('msg','Order delivered.');
    redirect('cleanorders/show/'.$id);
  }

   public function delete($id) {
  // hanya admin & laundry yang boleh hapus (ubah kalau kamu mau unit juga boleh)
  $this->require_role(array('admin','laundry'));

  $ok = $this->co->delete_request((int)$id);

  if ($ok) {
    $this->session->set_flashdata('msg', 'Berhasil hapus data.');
  } else {
    $this->session->set_flashdata('err', 'Gagal hapus data / data tidak ditemukan.');
  }

  redirect('cleanorders');
}

}
