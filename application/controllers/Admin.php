<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('category_model');

        // Proteksi: semua halaman admin butuh login
        if ( ! $this->session->userdata('is_admin_login')) {
            redirect('auth');
        }
    }

    /**
     * Dashboard: statistik artikel & kategori.
     */
    public function dashboard()
    {
        $data['total_articles']   = $this->article_model->total_articles();
        $data['total_categories'] = $this->category_model->total_categories();
        $data['recent_articles']  = $this->article_model->get_latest(5);
        $data['page_title']       = 'Dashboard';
        $data['active_page']      = 'dashboard';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Manage artikel: daftar semua artikel.
     */
    public function articles()
    {
        $data['articles']    = $this->article_model->get_all();
        $data['page_title']  = 'Manage Artikel';
        $data['active_page'] = 'articles';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/articles', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Form tambah artikel.
     */
    public function create()
    {
        $data['categories']  = $this->category_model->get_all();
        $data['page_title']  = 'Tambah Artikel';
        $data['active_page'] = 'articles';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/article_form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Simpan artikel baru.
     */
    public function store()
    {
        $this->_set_validation_rules();

        if ($this->form_validation->run() == FALSE) {
            $data['categories']  = $this->category_model->get_all();
            $data['page_title']  = 'Tambah Artikel';
            $data['active_page'] = 'articles';
            $this->load->view('admin/header', $data);
            $this->load->view('admin/article_form', $data);
            $this->load->view('admin/footer', $data);
            return;
        }

        $image_name = $this->_handle_upload();

        $data = array(
            'title'        => $this->input->post('title', TRUE),
            'category_id'  => $this->input->post('category_id', TRUE),
            'author'       => $this->input->post('author', TRUE),
            'content'      => $this->input->post('content'),
            'image'        => ($image_name !== '') ? $image_name : 'placeholder-default.svg',
            'publish_date' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date', TRUE)))
        );

        $this->article_model->insert_article($data);
        $this->session->set_flashdata('success_msg', 'Artikel berhasil ditambahkan.');
        redirect('admin/articles');
    }

    /**
     * Form edit artikel.
     */
    public function edit($id)
    {
        $article = $this->article_model->get_article($id);
        if ( ! $article) {
            show_404();
        }

        $data['article']     = $article;
        $data['categories']  = $this->category_model->get_all();
        $data['page_title']  = 'Edit Artikel';
        $data['active_page'] = 'articles';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/article_form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Update artikel.
     */
    public function update($id)
    {
        $article = $this->article_model->get_article($id);
        if ( ! $article) {
            show_404();
        }

        $this->_set_validation_rules();

        if ($this->form_validation->run() == FALSE) {
            $data['article']     = $article;
            $data['categories']  = $this->category_model->get_all();
            $data['page_title']  = 'Edit Artikel';
            $data['active_page'] = 'articles';
            $this->load->view('admin/header', $data);
            $this->load->view('admin/article_form', $data);
            $this->load->view('admin/footer', $data);
            return;
        }

        $image_name = $this->_handle_upload();

        $data = array(
            'title'        => $this->input->post('title', TRUE),
            'category_id'  => $this->input->post('category_id', TRUE),
            'author'       => $this->input->post('author', TRUE),
            'content'      => $this->input->post('content'),
            'publish_date' => date('Y-m-d H:i:s', strtotime($this->input->post('publish_date', TRUE)))
        );

        // Hanya ganti gambar jika ada file baru di-upload
        if ($image_name !== '') {
            $data['image'] = $image_name;
            $this->_delete_old_image($article->image);
        }

        $this->article_model->update_article($id, $data);
        $this->session->set_flashdata('success_msg', 'Artikel berhasil diperbarui.');
        redirect('admin/articles');
    }

    /**
     * Hapus artikel.
     */
    public function delete($id)
    {
        $article = $this->article_model->get_article($id);
        if ( ! $article) {
            show_404();
        }

        $this->_delete_old_image($article->image);
        $this->article_model->delete_article($id);
        $this->session->set_flashdata('success_msg', 'Artikel berhasil dihapus.');
        redirect('admin/articles');
    }

    /**
     * Aturan validasi form artikel.
     */
    private function _set_validation_rules()
    {
        $this->form_validation->set_rules('title', 'Judul', 'required|min_length[10]|max_length[200]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('author', 'Penulis', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('content', 'Isi Artikel', 'required');
        $this->form_validation->set_rules('publish_date', 'Tanggal Publikasi', 'required');

        $this->form_validation->set_message('required', '%s wajib diisi.');
        $this->form_validation->set_message('min_length', '%s minimal %s karakter.');
        $this->form_validation->set_message('max_length', '%s maksimal %s karakter.');
        $this->form_validation->set_message('integer', '%s wajib dipilih.');
    }

    /**
     * Upload gambar artikel. Returns nama file atau '' jika tidak ada upload.
     */
    private function _handle_upload()
    {
        if (empty($_FILES['image']['name'])) {
            return '';
        }

        $config['upload_path']   = './application/uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp|gif';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image')) {
            $this->session->set_flashdata('upload_error', $this->upload->display_errors('', ''));
            return '';
        }

        return $this->upload->data('file_name');
    }

    /**
     * Hapus file gambar lama dari server.
     */
    private function _delete_old_image($image_name)
    {
        if ($image_name === '' || $image_name === 'placeholder-default.jpg') {
            return;
        }
        $path = FCPATH . 'application/uploads/' . $image_name;
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
