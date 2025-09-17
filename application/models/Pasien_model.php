<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasien_model extends CI_Model {

    private $table = 'PASIEN';

    public function insert($data) {
        $this->db->insert($this->table, $data);
        $this->db->select('PASIEN_SEQ.CURRVAL as id FROM DUAL', FALSE); // gunakan sequence
        $row = $this->db->get()->row();
        return $row->ID;
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['PASIEN_ID' => $id])->row();
    }
}
