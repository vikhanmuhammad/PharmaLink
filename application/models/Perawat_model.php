<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perawat_model extends CI_Model {

    public function get_pasien_by_perawat($perawat_id) {
        return $this->db->select('p.*')
            ->from('PERAWAT_PASIEN dp')
            ->join('PASIEN p', 'dp.PASIEN_ID = p.PASIEN_ID')
            ->where('dp.PERAWAT_ID', $perawat_id)
            ->get()
            ->result();
    }
    

    public function insert_perawat_pasien($perawat_id, $pasien_id) {
        $this->db->insert('PERAWAT_PASIEN', [
            'PERAWAT_ID' => $perawat_id,
            'PASIEN_ID' => $pasien_id
        ]);
    }
}
