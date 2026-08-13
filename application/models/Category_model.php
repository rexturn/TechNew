<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all categories ordered by name.
     */
    public function get_all()
    {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('categories')->result();
    }

    /**
     * Get a single category by id.
     */
    public function get_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('categories')->row();
    }

    /**
     * Get a category by slug (for visitor category pages).
     */
    public function get_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        return $this->db->get('categories')->row();
    }

    /**
     * Insert a new category.
     */
    public function insert_category($data)
    {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    /**
     * Update a category.
     */
    public function update_category($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    /**
     * Delete a category if it has no articles.
     */
    public function delete_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('categories');
    }

    /**
     * Count total categories.
     */
    public function total_categories()
    {
        return $this->db->count_all('categories');
    }

    /**
     * Check whether a category is used by any article.
     */
    public function has_articles($id)
    {
        $this->db->where('category_id', $id);
        return $this->db->count_all_results('articles') > 0;
    }

    /**
     * Get categories with article count.
     */
    public function get_with_count()
    {
        $this->db->select('categories.*, COUNT(articles.id) AS article_count');
        $this->db->from('categories');
        $this->db->join('articles', 'articles.category_id = categories.id', 'left');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');
        return $this->db->get()->result();
    }
}
