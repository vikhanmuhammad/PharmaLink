<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        if ($this->session->userdata('role') !== 'super_admin') {
            redirect('auth/no_access');
        }
    }

    public function index() {
        $this->load->view('superadmin/dashboard');
    }
}
