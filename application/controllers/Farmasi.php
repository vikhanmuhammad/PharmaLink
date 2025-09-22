<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Farmasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','form']);
        $this->load->library('session');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        if (!in_array($this->session->userdata('role'), ['admin_farmasi', 'super_admin'])) {
            redirect('auth/no_access');
        }
    }

    public function index() {
        $data['pemesanan'] = $this->db->query("
            SELECT PO.PEMESANAN_ID, PO.TGL_PESAN, PO.STATUS,
                   P.NAMA AS NAMA_PASIEN,
                   PD.OBAT_ID, O.NAMA_OBAT, PD.JUMLAH, PD.KETERANGAN,
                   COALESCE(D.NAMA, PR.NAMA) AS NAMA_PENGINPUT,
                   CASE 
                       WHEN D.USER_ID IS NOT NULL THEN 'dokter'
                       WHEN PR.USER_ID IS NOT NULL THEN 'perawat'
                       ELSE 'unknown'
                   END AS ROLE_PENGINPUT
            FROM PEMESANAN PO
            JOIN PEMESANAN_DETAIL PD ON PO.PEMESANAN_ID = PD.PEMESANAN_ID
            JOIN PASIEN P ON PO.PASIEN_ID = P.PASIEN_ID
            JOIN OBAT O ON PD.OBAT_ID = O.OBAT_ID
            LEFT JOIN DOKTER D ON PO.USER_ID = D.USER_ID
            LEFT JOIN PERAWAT PR ON PO.USER_ID = PR.USER_ID
            ORDER BY PO.TGL_PESAN DESC
        ")->result();

        $this->load->view('farmasi/dashboard', $data);
    }

    public function approve($id) {
        $pesanan_detail = $this->db->get_where('PEMESANAN_DETAIL', ['PEMESANAN_ID' => $id])->result();

        if (!$pesanan_detail) {
            $this->session->set_flashdata('error', 'Pemesanan tidak ditemukan.');
            redirect('farmasi');
        }

        foreach($pesanan_detail as $pd) {
            $obat = $this->db->get_where('OBAT', ['OBAT_ID' => $pd->OBAT_ID])->row();
            if ($obat->STOK < $pd->JUMLAH) {
                $this->session->set_flashdata('error', "Stok obat '$obat->NAMA_OBAT' tidak cukup untuk ACC.");
                redirect('farmasi');
            }
        }

        $this->db->where('PEMESANAN_ID', $id)->update('PEMESANAN', ['STATUS' => 'approved']);

        foreach($pesanan_detail as $pd) {
            $this->db->set('STOK', 'STOK - ' . $pd->JUMLAH, false)
                     ->where('OBAT_ID', $pd->OBAT_ID)
                     ->update('OBAT');
        }

        $this->session->set_flashdata('success', "Pemesanan ID $id berhasil di-ACC.");
        redirect('farmasi');
    }

    public function reject($id) {
        $this->db->where('PEMESANAN_ID', $id)
                 ->update('PEMESANAN', ['STATUS' => 'rejected']);
        $this->session->set_flashdata('error', "Pemesanan ID $id ditolak.");
        redirect('farmasi');
    }
}
