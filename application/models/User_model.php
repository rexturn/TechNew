<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get a user by username.
     */
    public function get_by_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get('users')->row();
    }

    /**
     * Verify login credentials.
     * Returns the user row when valid, FALSE otherwise.
     */
    public function verify_login($username, $password)
    {
        $user = $this->get_by_username($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }
}
