<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        if ($this->session->userdata('role') !== 'super_admin') {
            redirect('auth/no_access');
        }
    }

    // Dashboard
    public function index() {
        $data['pasien'] = $this->db->query("
            SELECT PASIEN_ID, NAMA, TGL_LAHIR
            FROM PASIEN
            ORDER BY PASIEN_ID DESC
        ")->result();

        $this->load->view('superadmin/dashboard', $data);
    }

    public function tambah_pasien_action()
    {
        $nama = $this->input->post('nama');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $id = $this->db->query("SELECT PEMESANAN_REQ.NEXTVAL as ID FROM dual")->row()->ID;

        $data = array(
            'PASIEN_ID' => $id,
            'NAMA' => strtoupper($nama),
            'TGL_LAHIR' => $tgl_lahir
        );
        $this->db->insert('PASIEN', $data);
        $this->session->set_flashdata('success', 'Pasien baru berhasil ditambahkan.');
        redirect('superadmin');
    }
}
