<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter_model extends CI_Model {

    public function get_pasien_by_dokter($dokter_id) {
        return $this->db->select('p.*')
            ->from('DOKTER_PASIEN dp')
            ->join('PASIEN p', 'dp.PASIEN_ID = p.PASIEN_ID')
            ->where('dp.DOKTER_ID', $dokter_id)
            ->get()
            ->result();
    }
    

    public function insert_dokter_pasien($dokter_id, $pasien_id) {
        $this->db->insert('DOKTER_PASIEN', [
            'DOKTER_ID' => $dokter_id,
            'PASIEN_ID' => $pasien_id
        ]);
    }
}
