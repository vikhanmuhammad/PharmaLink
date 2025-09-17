<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        // kalau user sudah login, jangan biarkan akses halaman login lagi
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role();
        }

        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->User_model->get_user_by_username($username);

        // if ($user && password_verify($password, $user->password)) {
        if ($user && $password === $user->PASSWORD) {
            // simpan session
            $this->session->set_userdata([
                'user_id' => $user->ID,
                'username' => $user->USERNAME,
                'role' => $user->ROLE,
                'logged_in' => TRUE
            ]);

            // redirect sesuai role
            if ($user->ROLE == 'dokter') {
                redirect('dokter');
            } elseif ($user->ROLE == 'perawat') {
                redirect('perawat');
            } elseif ($user->ROLE == 'admin_farmasi') {
                redirect('farmasi');
            } elseif ($user->ROLE == 'super_admin') {
                redirect('superadmin');
            } else {
                redirect('auth/no_access');
            }

        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth');
        }
    }

    private function _redirect_by_role()
    {
        $role = $this->session->userdata('role');

        if ($role == 'superadmin') {
            redirect('superadmin');
        } elseif ($role == 'dokter') {
            redirect('dokter');
        } elseif ($role == 'perawat') {
            redirect('perawat');
        } elseif ($role == 'admin_farmasi') {
            redirect('farmasi');
        } else {
            // default kalau role tidak dikenali
            redirect('auth/logout');
        }
    }


    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function no_access() {
        echo "Anda tidak memiliki akses ke halaman ini.";
    }
}
