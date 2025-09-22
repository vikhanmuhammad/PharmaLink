<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database('oracle');
    }

    public function get_user_by_username($username) {
        $query = $this->db->get_where('USERS', ['USERNAME' => $username]);
        return $query->row();
    }
}
