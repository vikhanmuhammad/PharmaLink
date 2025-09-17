<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->database('oracle'); // koneksi ke Oracle

		// Ambil data pegawai
		$query = $this->db->query("
        SELECT p.ID AS PEGAWAI_ID, p.USERNAME, p.PASSWORD, u.NAMA_UNIT
FROM PEGAWAI p
LEFT JOIN UNIT_KERJA u
ON p.UNIT_ID = u.ID

    "); // Query Builder
		$data['pegawai'] = $query->result();

		// Kirim data ke view
		$this->load->view('welcome_message', $data);
	}

}
