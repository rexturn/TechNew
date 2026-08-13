<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('category_model');
    }

    /**
     * Beranda: menampilkan artikel terbaru dengan pagination + hero utama.
     */
    public function index()
    {
        $config['base_url']   = site_url('home/index');
        $config['total_rows'] = $this->article_model->count_articles();
        $config['per_page']   = 6;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<nav class="pagination-wrap"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);

        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['articles']  = $this->article_model->get_articles($config['per_page'], $offset);
        $data['hero']      = $this->article_model->get_latest(1);
        $data['featured']  = $this->article_model->get_latest(4);
        $data['categories'] = $this->category_model->get_all();
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Beranda';

        $this->load->view('visitor/header', $data);
        $this->load->view('visitor/home', $data);
        $this->load->view('visitor/footer', $data);
    }

    /**
     * Detail artikel.
     */
    public function detail($id)
    {
        $article = $this->article_model->get_article($id);
        if ( ! $article) {
            show_404();
        }

        $data['article']    = $article;
        $data['related']    = $this->article_model->get_latest(4, $id);
        $data['categories'] = $this->category_model->get_with_count();
        $data['page_title'] = $article->title;

        $this->load->view('visitor/header', $data);
        $this->load->view('visitor/detail', $data);
        $this->load->view('visitor/footer', $data);
    }

    /**
     * Artikel per kategori.
     */
    public function category($slug)
    {
        $category = $this->category_model->get_by_slug($slug);
        if ( ! $category) {
            show_404();
        }

        $config['base_url']   = site_url('home/category/' . $slug);
        $config['total_rows'] = $this->article_model->count_by_category($slug);
        $config['per_page']   = 6;
        $config['uri_segment'] = 4;
        $config['full_tag_open'] = '<nav class="pagination-wrap"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);

        $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['articles']   = $this->article_model->get_by_category($slug, $config['per_page'], $offset);
        $data['category']   = $category;
        $data['categories'] = $this->category_model->get_all();
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Kategori: ' . $category->name;

        $this->load->view('visitor/header', $data);
        $this->load->view('visitor/category', $data);
        $this->load->view('visitor/footer', $data);
    }

    /**
     * Pencarian artikel.
     */
    public function search()
    {
        $keyword = $this->input->get('q', TRUE);

        $config['base_url']   = site_url('home/search');
        $config['total_rows'] = $this->article_model->count_articles($keyword);
        $config['per_page']   = 6;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<nav class="pagination-wrap"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);

        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['articles']   = $this->article_model->get_articles($config['per_page'], $offset, $keyword);
        $data['keyword']    = $keyword;
        $data['categories'] = $this->category_model->get_all();
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Hasil Pencarian: "' . $keyword . '"';

        $this->load->view('visitor/header', $data);
        $this->load->view('visitor/search', $data);
        $this->load->view('visitor/footer', $data);
    }
}
