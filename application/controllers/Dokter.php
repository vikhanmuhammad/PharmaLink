<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pasien_model');
        $this->load->model('Dokter_model');
        $this->load->library('session');

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Cek role: hanya dokter & super_admin yang boleh
        if (!in_array($this->session->userdata('role'), ['dokter', 'super_admin'])) {
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
    
        $this->load->view('dokter/dashboard', $data);
    }
    

    // ✅ daftar pasien yg terkait dengan dokter
    public function pasien() {
        $user_id = $this->session->userdata('user_id');
        $dokter  = $this->db->get_where('DOKTER', ['USER_ID' => $user_id])->row();
    
        if ($dokter) {
            $dokter_id = $dokter->DOKTER_ID;
            $data['pasien'] = $this->Dokter_model->get_pasien_by_dokter($dokter_id);
        } else {
            $data['pasien'] = [];
        }
    
        $this->load->view('dokter/pasien/LihatPasienDokter', $data);
    }    

    public function tambah_pasien()
    {
        // Cek apakah ada pengiriman data dari form (method POST)
        if ($this->input->post('action')) {
            $action = $this->input->post('action');
    
            if ($action == 'cari') {
                $nama = $this->input->post('nama');
                $tgl_lahir = $this->input->post('tgl_lahir');
    
                // ✅ LANGKAH 1: Ambil ID dokter yang sedang login
                $user_id = $this->session->userdata('user_id');
                $dokter = $this->db->get_where('DOKTER', ['USER_ID' => $user_id])->row();
                $dokter_id = $dokter ? $dokter->DOKTER_ID : null;
    
                // ✅ LANGKAH 2: Modifikasi Query SQL dengan LEFT JOIN
                // Kita memilih DOKTER_PASIEN.DOKTER_ID sebagai penanda apakah sudah di-assign
                $sql = "
                    SELECT 
                        p.*, 
                        dp.DOKTER_ID as ASSIGNED_DOKTER_ID
                    FROM 
                        PASIEN p
                    LEFT JOIN 
                        DOKTER_PASIEN dp ON p.PASIEN_ID = dp.PASIEN_ID AND dp.DOKTER_ID = ?
                    WHERE 
                        p.NAMA = UPPER(?) AND p.TGL_LAHIR = ?
                ";
    
                // Binding untuk query: dokter_id, nama, tgl_lahir
                $query = $this->db->query($sql, [$dokter_id, $nama, $tgl_lahir]);
                $pasien = $query->row();
    
                $data['nama'] = $nama;
                $data['tgl_lahir'] = $tgl_lahir;
                $data['pasien'] = $pasien;
    
                // Muat view dengan data hasil pencarian
                $this->load->view('dokter/pasien/TambahPasienDokter', $data);
            } elseif ($action == 'assign') {
                // ... (kode assign Anda tidak perlu diubah) ...
                $pasien_id = $this->input->post('pasien_id');
                $user_id = $this->session->userdata('user_id');
                $dokter = $this->db->get_where('DOKTER', ['USER_ID' => $user_id])->row();
    
                if ($dokter) {
                    // Sebaiknya cek dulu agar tidak duplikat
                    $is_assigned = $this->db->get_where('DOKTER_PASIEN', [
                        'DOKTER_ID' => $dokter->DOKTER_ID,
                        'PASIEN_ID' => $pasien_id
                    ])->num_rows() > 0;
    
                    if (!$is_assigned) {
                        $this->db->insert('DOKTER_PASIEN', [
                            'DOKTER_ID' => $dokter->DOKTER_ID,
                            'PASIEN_ID' => $pasien_id
                        ]);
                    }
                }
                $this->session->set_flashdata('success', 'Pasien berhasil di-assign.');
                redirect('dokter/pasien');
            } elseif ($action == 'tambah') {
                // ... (kode tambah Anda tidak perlu diubah) ...
                $nama = $this->input->post('nama');
                $tgl_lahir = $this->input->post('tgl_lahir');
    
                $sql_insert = "INSERT INTO PASIEN (PASIEN_ID, NAMA, TGL_LAHIR) VALUES (PASIEN_SEQ.NEXTVAL, UPPER(?), ?)";
                $this->db->query($sql_insert, [$nama, $tgl_lahir]);
    
                $pasien_id = $this->db->query("SELECT PASIEN_SEQ.CURRVAL as id FROM dual")->row()->ID;
                $user_id = $this->session->userdata('user_id');
                $dokter = $this->db->get_where('DOKTER', ['USER_ID' => $user_id])->row();
    
                if ($dokter) {
                    $this->db->insert('DOKTER_PASIEN', [
                        'DOKTER_ID' => $dokter->DOKTER_ID,
                        'PASIEN_ID' => $pasien_id
                    ]);
                }
    
                $this->session->set_flashdata('success', 'Pasien baru berhasil ditambahkan & di-assign.');
                redirect('dokter/pasien');
            }
        } else {
            // --- JIKA TIDAK ADA DATA POST (KUNJUNGAN AWAL) ---
            $this->load->view('dokter/pasien/TambahPasienDokter');
        }
    }
    
    public function pemesanan_obat() {
        $user_id = $this->session->userdata('user_id');
    
        // ambil dokter_id sesuai user login
        $dokter = $this->db->get_where('DOKTER', ['USER_ID' => $user_id])->row();
        if (!$dokter) {
            show_error("Dokter tidak ditemukan.");
        }
    
        // pasien yang terdaftar untuk dokter ini
        $data['pasien'] = $this->Dokter_model->get_pasien_by_dokter($dokter->DOKTER_ID);
    
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
            redirect('dokter/pemesanan_obat');
        }
    
        $this->load->view('dokter/pemesanan/tambahpemesanandokter', $data);
    }
        
}
