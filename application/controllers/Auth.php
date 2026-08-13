<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    /**
     * Tampilkan halaman login.
     */
    public function index()
    {
        // Redirect ke dashboard jika sudah login
        if ($this->session->userdata('is_admin_login')) {
            redirect('admin/dashboard');
        }

        $data['page_title'] = 'Login Admin';
        $this->load->view('admin/login', $data);
    }

    /**
     * Proses login.
     */
    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Kembali ke halaman login dengan error validasi
            $data['page_title'] = 'Login Admin';
            $this->load->view('admin/login', $data);
            return;
        }

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->user_model->verify_login($username, $password);
        if ($user) {
            $this->session->set_userdata(array(
                'is_admin_login' => TRUE,
                'admin_id'       => $user->id,
                'admin_username' => $user->username,
                'admin_name'     => $user->full_name
            ));
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('login_error', 'Username atau password salah.');
            redirect('auth');
        }
    }

    /**
     * Logout admin.
     */
    public function logout()
    {
        $this->session->unset_userdata(array('is_admin_login', 'admin_id', 'admin_username', 'admin_name'));
        $this->session->set_flashdata('logout_msg', 'Anda telah logout.');
        redirect('auth');
    }
}
