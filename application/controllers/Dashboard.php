<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

  public function index() {
    $data['title'] = 'Dashboard';
    $data['cards'] = [
      'dirty' => $this->db->count_all('dirty_requests'),
      'clean' => $this->db->count_all('clean_orders'),
      'damage' => $this->db->count_all('damage_reports'),
      'weights' => $this->db->count_all('wash_weights'),
    ];
    $this->render('dashboard', $data);
  }
}
