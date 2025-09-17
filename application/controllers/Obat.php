<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Obat_model');
        $this->load->library('session');

        // hanya Admin Farmasi yang boleh akses
        if ($this->session->userdata('role') != 'admin_farmasi' && $this->session->userdata('role') != 'super_admin') {
            redirect('auth/no_access');
        }
    }

    public function index()
    {
        $data['obat'] = $this->Obat_model->get_all();
        $this->load->view('farmasi/aturobat/stokobat', $data);
    }

    public function tambah()
    {
        if ($this->input->post()) {
            $data = [
                'NAMA_OBAT'   => $this->input->post('nama_obat'),
                'JENIS'       => $this->input->post('jenis'),
                'KATEGORI'    => $this->input->post('kategori'),
                'GENERIC'     => $this->input->post('generic'),
                'KETERANGAN'  => $this->input->post('keterangan'),
                'STOK'        => $this->input->post('stok'),
            ];
            $this->Obat_model->insert($data);
            redirect('obat');
        }
        $this->load->view('farmasi/aturobat/tambahobat');
    }

    public function edit($id)
    {
        if ($this->input->post()) {
            $data = [
                'NAMA_OBAT'   => $this->input->post('nama_obat'),
                'JENIS'       => $this->input->post('jenis'),
                'KATEGORI'    => $this->input->post('kategori'),
                'GENERIC'     => $this->input->post('generic'),
                'KETERANGAN'  => $this->input->post('keterangan'),
                'STOK'        => $this->input->post('stok'),
            ];
            $this->Obat_model->update($id, $data);
            redirect('obat');
        }
        $data['obat'] = $this->Obat_model->get_by_id($id);
        $this->load->view('farmasi/aturobat/edit', $data);
    }

    public function hapus($id)
    {
        $this->Obat_model->delete($id);
        redirect('obat');
    }
}
