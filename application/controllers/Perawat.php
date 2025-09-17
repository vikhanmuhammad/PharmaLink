<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perawat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pasien_model');
        $this->load->model('Perawat_model');
        $this->load->library('session');

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        if (!in_array($this->session->userdata('role'), ['perawat', 'super_admin'])) {
            redirect('auth/no_access');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
    
        // Ambil daftar pemesanan obat milik dokter ini
        $data['pemesanan'] = $this->db
            ->select('po.PEMESANAN_ID, p.NAMA as NAMA_PASIEN, o.NAMA_OBAT, po.JUMLAH, po.KETERANGAN, po.TGL_PESAN, po.STATUS')
            ->from('PEMESANAN_OBAT po')
            ->join('PASIEN p', 'p.PASIEN_ID = po.PASIEN_ID')
            ->join('OBAT o', 'o.OBAT_ID = po.OBAT_ID')
            ->where('po.USER_ID', $user_id)
            ->order_by('po.TGL_PESAN', 'DESC')
            ->get()
            ->result();

        $this->load->view('perawat/dashboard', $data);
    }

    // ✅ daftar pasien yg terkait dengan perawat
    public function pasien() {
        $user_id = $this->session->userdata('user_id');
        $perawat  = $this->db->get_where('PERAWAT', ['USER_ID' => $user_id])->row();
    
        if ($perawat) {
            $perawat_id = $perawat->PERAWAT_ID;
            $data['pasien'] = $this->Perawat_model->get_pasien_by_perawat($perawat_id);
        } else {
            $data['pasien'] = [];
        }
    
        $this->load->view('perawat/pasien/LihatPasienPerawat', $data);
    }

    // ✅ tambah pasien baru
    public function tambah_pasien()
    {
        // Cek apakah ada pengiriman data dari form (method POST)
        if ($this->input->post('action')) {
            $action = $this->input->post('action');

            if ($action == 'cari') {
                $nama = $this->input->post('nama');
                $tgl_lahir = $this->input->post('tgl_lahir');

                // Ambil ID perawat yang sedang login
                $user_id = $this->session->userdata('user_id');
                $perawat = $this->db->get_where('PERAWAT', ['USER_ID' => $user_id])->row();
                $perawat_id = $perawat ? $perawat->PERAWAT_ID : null;

                // Modifikasi Query SQL dengan LEFT JOIN
                $sql = "
                    SELECT 
                        p.*, 
                        pp.PERAWAT_ID as ASSIGNED_PERAWAT_ID
                    FROM 
                        PASIEN p
                    LEFT JOIN 
                        PERAWAT_PASIEN pp ON p.PASIEN_ID = pp.PASIEN_ID AND pp.PERAWAT_ID = ?
                    WHERE 
                        p.NAMA = UPPER(?) AND p.TGL_LAHIR = ?
                ";

                // Binding untuk query: perawat_id, nama, tgl_lahir
                $query = $this->db->query($sql, [$perawat_id, $nama, $tgl_lahir]);
                $pasien = $query->row();

                $data['nama'] = $nama;
                $data['tgl_lahir'] = $tgl_lahir;
                $data['pasien'] = $pasien;

                // Muat view dengan data hasil pencarian
                $this->load->view('perawat/pasien/TambahPasienPerawat', $data);

            } elseif ($action == 'assign') {
                $pasien_id = $this->input->post('pasien_id');
                $user_id = $this->session->userdata('user_id');
                $perawat = $this->db->get_where('PERAWAT', ['USER_ID' => $user_id])->row();

                if ($perawat) {
                    $is_assigned = $this->db->get_where('PERAWAT_PASIEN', [
                        'PERAWAT_ID' => $perawat->PERAWAT_ID,
                        'PASIEN_ID' => $pasien_id
                    ])->num_rows() > 0;

                    if (!$is_assigned) {
                        $this->db->insert('PERAWAT_PASIEN', [
                            'PERAWAT_ID' => $perawat->PERAWAT_ID,
                            'PASIEN_ID' => $pasien_id
                        ]);
                    }
                }
                $this->session->set_flashdata('success', 'Pasien berhasil di-assign.');
                redirect('perawat/pasien');

            } elseif ($action == 'tambah') {
                $nama = $this->input->post('nama');
                $tgl_lahir = $this->input->post('tgl_lahir');

                $sql_insert = "INSERT INTO PASIEN (PASIEN_ID, NAMA, TGL_LAHIR) VALUES (PASIEN_SEQ.NEXTVAL, UPPER(?), ?)";
                $this->db->query($sql_insert, [$nama, $tgl_lahir]);

                $pasien_id = $this->db->query("SELECT PASIEN_SEQ.CURRVAL as id FROM dual")->row()->ID;
                $user_id = $this->session->userdata('user_id');
                $perawat = $this->db->get_where('PERAWAT', ['USER_ID' => $user_id])->row();

                if ($perawat) {
                    $this->db->insert('PERAWAT_PASIEN', [
                        'PERAWAT_ID' => $perawat->PERAWAT_ID,
                        'PASIEN_ID' => $pasien_id
                    ]);
                }

                $this->session->set_flashdata('success', 'Pasien baru berhasil ditambahkan & di-assign.');
                redirect('perawat/pasien');
            }
        } else {
            // JIKA TIDAK ADA DATA POST (KUNJUNGAN AWAL)
            $this->load->view('perawat/pasien/TambahPasienPerawat');
        }
    }

    public function pemesanan_obat() {
        $user_id = $this->session->userdata('user_id');
    
        // ambil perawat_id sesuai user login
        $perawat = $this->db->get_where('PERAWAT', ['USER_ID' => $user_id])->row();
        if (!$perawat) {
            show_error("Perawat tidak ditemukan.");
        }
    
        // pasien yang terdaftar untuk Perawat ini
        $data['pasien'] = $this->Perawat_model->get_pasien_by_perawat($perawat->PERAWAT_ID);
    
        // daftar obat
        $data['obat'] = $this->db->get('OBAT')->result();

        $id = $this->db->query("SELECT PEMESANAN_REQ.NEXTVAL as ID FROM dual")->row()->ID;
    
        if ($this->input->post()) {
            $data = [
                'PEMESANAN_ID' => $id,
                'PASIEN_ID'   => $this->input->post('pasien_id'),
                'OBAT_ID'     => $this->input->post('obat_id'),
                'JUMLAH'      => $this->input->post('jumlah'),
                'KETERANGAN'  => $this->input->post('keterangan'),
                'USER_ID'     => $this->session->userdata('user_id'),
                'STATUS'      => 'pending'
            ];
            
            // tambahkan kolom TGL_PESAN dengan TO_DATE tanpa di-escape
            $this->db->set('TGL_PESAN', "TO_DATE('" . date('Y-m-d H:i:s') . "', 'YYYY-MM-DD HH24:MI:SS')", false);
            
            $this->db->insert('PEMESANAN_OBAT', $data);
    
            $this->session->set_flashdata('success', 'Pemesanan obat berhasil dibuat.');
            redirect('perawat/pemesanan_obat');
        }
    
        $this->load->view('perawat/pemesanan/tambahpemesananperawat', $data);
    }
}
