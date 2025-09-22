<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Obat_model');
        $this->load->library('session');

        if ($this->session->userdata('role') != 'admin_farmasi' && $this->session->userdata('role') != 'super_admin') {
            redirect('auth/no_access');
        }
    }

    public function index()
    {
        $data['obat'] = $this->Obat_model->get_all();

        if (!empty($data['obat']) && is_array($data['obat'])) {
            foreach ($data['obat'] as $item_obat) {
                foreach ($item_obat as $kolom => $nilai) {
                    if ($nilai === null || $nilai === '') {
                        $item_obat->$kolom = '-';
                    }
                }
            }
        }
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

    public function edit_action()
    {
        $id = $this->input->post('obat_id', TRUE);
    
        if ($id) {
            $data = [
                'NAMA_OBAT'  => $this->input->post('nama_obat', TRUE),
                'JENIS'      => $this->input->post('jenis', TRUE),
                'KATEGORI'   => $this->input->post('kategori', TRUE),
                'GENERIC'    => $this->input->post('generic', TRUE),
                'KETERANGAN' => $this->input->post('keterangan', TRUE),
                'STOK'       => $this->input->post('stok', TRUE),
            ];
    
            if ($this->Obat_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Data obat berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Update gagal.');
            }
        } else {
            $this->session->set_flashdata('error', 'ID Obat tidak ditemukan.');
        }
    
        redirect('obat');
    }
    
    
    public function hapus($id)
    {
        $this->Obat_model->delete($id);
        redirect('obat');
    }
}
