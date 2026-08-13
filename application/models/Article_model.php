<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get articles with category name, paginated.
     */
    public function get_articles($limit, $offset, $search = '')
    {
        $this->db->select('articles.*, categories.name AS category_name, categories.slug AS category_slug');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('articles.title', $search);
            $this->db->or_like('articles.author', $search);
            $this->db->or_like('articles.content', $search);
            $this->db->group_end();
        }
        $this->db->order_by('articles.publish_date', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count articles, optionally filtered by search.
     */
    public function count_articles($search = '')
    {
        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('author', $search);
            $this->db->or_like('content', $search);
            $this->db->group_end();
        }
        return $this->db->count_all_results('articles');
    }

    /**
     * Get a single article by id (with category name).
     */
    public function get_article($id)
    {
        $this->db->select('articles.*, categories.name AS category_name, categories.slug AS category_slug');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        $this->db->where('articles.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get latest N articles (for sidebar / related).
     */
    public function get_latest($limit = 4, $exclude_id = 0)
    {
        $this->db->select('articles.*, categories.name AS category_name, categories.slug AS category_slug');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        if ($exclude_id > 0) {
            $this->db->where('articles.id !=', $exclude_id);
        }
        $this->db->order_by('articles.publish_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    /**
     * Get article by category slug, paginated.
     */
    public function get_by_category($slug, $limit, $offset)
    {
        $this->db->select('articles.*, categories.name AS category_name, categories.slug AS category_slug');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        $this->db->where('categories.slug', $slug);
        $this->db->order_by('articles.publish_date', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    /**
     * Count articles in a category.
     */
    public function count_by_category($slug)
    {
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        $this->db->where('categories.slug', $slug);
        return $this->db->count_all_results();
    }

    /**
     * Get all articles (for admin manage page) ordered by publish date desc.
     */
    public function get_all()
    {
        $this->db->select('articles.*, categories.name AS category_name, categories.slug AS category_slug');
        $this->db->from('articles');
        $this->db->join('categories', 'categories.id = articles.category_id', 'left');
        $this->db->order_by('articles.publish_date', 'DESC');
        return $this->db->get()->result();
    }

    /**
     * Insert a new article.
     * @return int inserted id
     */
    public function insert_article($data)
    {
        $this->db->insert('articles', $data);
        return $this->db->insert_id();
    }

    /**
     * Update an article.
     */
    public function update_article($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('articles', $data);
    }

    /**
     * Delete an article.
     */
    public function delete_article($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('articles');
    }

    /**
     * Count total articles.
     */
    public function total_articles()
    {
        return $this->db->count_all('articles');
    }
}
