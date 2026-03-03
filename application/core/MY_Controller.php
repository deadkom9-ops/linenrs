<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  public function __construct() {
    parent::__construct();
    // Allow Auth controller
    if ($this->router->class !== 'auth') {
      if (!$this->session->userdata('user_id')) {
        redirect('auth/login');
      }
    }
  }

  protected function render($view, $data = []) {
    $data['content'] = $view;
    $this->load->view('layouts/main', $data);
  }

  protected function require_role($roles = []) {
    $role = $this->session->userdata('role');
    if (!in_array($role, $roles, true)) {
      show_error('Akses ditolak.', 403);
    }
  }
}
