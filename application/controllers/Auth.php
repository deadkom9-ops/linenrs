<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->library('session');
    $this->load->model('User_model', 'user');
  }

  public function login()
  {
    if ($this->session->userdata('user_id')) {
      redirect('dashboard');
    }

    if ($this->input->method() === 'post') {
      $username = trim($this->input->post('username', true));
      //$password = $this->input->post('password');

      $u = $this->user->find_by_username($username);
      if (!$u || !$u->is_active) {
        $this->session->set_flashdata('err', 'User tidak ditemukan / nonaktif.');
        redirect('auth/login');
      }

      /*if (!password_verify($password, $u->password_hash)) {
        $this->session->set_flashdata('err', 'Password salah.');
        redirect('Auth/login');
      }*/

      $this->session->set_userdata([
        'user_id' => $u->id,
        'username' => $u->username,
        'full_name' => $u->full_name,
        'role' => $u->role,
        'unit_id'  => $u->unit_id
      ]);

      redirect('dashboard');
    }

    $this->load->view('auth/login', ['title' => 'Login']);
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('auth/login');
  }
}
