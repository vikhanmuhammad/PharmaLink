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
            SELECT PO.PEMESANAN_ID, PO.TGL_PESAN, PO.JUMLAH, PO.KETERANGAN, PO.STATUS,
                   P.NAMA AS NAMA_PASIEN,
                   O.NAMA_OBAT, O.STOK AS STOK_OBAT,
                   COALESCE(D.NAMA, PR.NAMA) AS NAMA_PENGINPUT,
                   CASE 
                       WHEN D.USER_ID IS NOT NULL THEN 'dokter'
                       WHEN PR.USER_ID IS NOT NULL THEN 'perawat'
                       ELSE 'unknown'
                   END AS ROLE_PENGINPUT
            FROM PEMESANAN_OBAT PO
            JOIN PASIEN P ON PO.PASIEN_ID = P.PASIEN_ID
            JOIN OBAT O ON PO.OBAT_ID = O.OBAT_ID
            LEFT JOIN DOKTER D ON PO.USER_ID = D.USER_ID
            LEFT JOIN PERAWAT PR ON PO.USER_ID = PR.USER_ID
            ORDER BY PO.TGL_PESAN DESC
        ")->result();

        $this->load->view('farmasi/dashboard', $data);
    }

    public function approve($id) {
        $pesan = $this->db->get_where('PEMESANAN_OBAT', ['PEMESANAN_ID' => $id])->row();
        if (!$pesan) {
            $this->session->set_flashdata('error', 'Pemesanan tidak ditemukan.');
            redirect('farmasi');
        }

        $obat = $this->db->get_where('OBAT', ['OBAT_ID' => $pesan->OBAT_ID])->row();
        if ($obat->STOK < $pesan->JUMLAH) {
            $this->session->set_flashdata('error', "Stok obat '$obat->NAMA' tidak cukup untuk ACC.");
            redirect('farmasi');
        }

        $this->db->where('PEMESANAN_ID', $id)
                 ->update('PEMESANAN_OBAT', ['STATUS' => 'approved']);

        $this->db->set('STOK', 'STOK - ' . $pesan->JUMLAH, false)
                 ->where('OBAT_ID', $pesan->OBAT_ID)
                 ->update('OBAT');

        $this->session->set_flashdata('success', "Pemesanan obat ID $id berhasil di-ACC.");
        redirect('farmasi');
    }

    public function reject($id) {
        $this->db->where('PEMESANAN_ID', $id)
                 ->update('PEMESANAN_OBAT', ['STATUS' => 'rejected']);
        $this->session->set_flashdata('error', "Pemesanan obat ID $id ditolak.");
        redirect('farmasi');
    }
}
