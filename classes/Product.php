<?php
/**
 * Product Class
 * Handles bank products and services management
 */

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Get all products
     */
    public function getAllProducts($limit = null, $offset = 0) {
        $sql = '
            SELECT id, name, description, category, features, interest_rate, 
                   minimum_amount, status, created_at
            FROM products
            WHERE status = "active"
            ORDER BY created_at DESC
        ';
        
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($sql);
        if ($limit) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Get product by ID
     */
    public function getProductById($id) {
        $this->db->query('
            SELECT id, name, description, category, features, interest_rate, 
                   minimum_amount, status, created_at
            FROM products
            WHERE id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Get products by category
     */
    public function getProductsByCategory($category, $limit = null, $offset = 0) {
        $sql = '
            SELECT id, name, description, category, features, interest_rate, 
                   minimum_amount, status, created_at
            FROM products
            WHERE category = :category AND status = "active"
            ORDER BY created_at DESC
        ';
        
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($sql);
        $this->db->bind(':category', $category);
        
        if ($limit) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Create product
     */
    public function createProduct($data) {
        if (empty($data['name']) || empty($data['category'])) {
            return ['success' => false, 'message' => 'Name and category are required'];
        }

        $this->db->query('
            INSERT INTO products (name, description, category, features, interest_rate, 
                                minimum_amount, status, created_at)
            VALUES (:name, :description, :category, :features, :interest_rate, 
                   :minimum_amount, :status, NOW())
        ');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':features', json_encode($data['features'] ?? []));
        $this->db->bind(':interest_rate', $data['interest_rate'] ?? null);
        $this->db->bind(':minimum_amount', $data['minimum_amount'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        if ($this->db->execute()) {
            return ['success' => true, 'message' => 'Product created successfully', 'id' => $this->db->lastInsertId()];
        }
        
        return ['success' => false, 'message' => 'Failed to create product'];
    }

    /**
     * Update product
     */
    public function updateProduct($id, $data) {
        $product = $this->getProductById($id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        $this->db->query('
            UPDATE products 
            SET name = :name, description = :description, category = :category, 
                features = :features, interest_rate = :interest_rate, 
                minimum_amount = :minimum_amount, status = :status
            WHERE id = :id
        ');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':features', json_encode($data['features'] ?? []));
        $this->db->bind(':interest_rate', $data['interest_rate'] ?? null);
        $this->db->bind(':minimum_amount', $data['minimum_amount'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Product updated successfully'] :
            ['success' => false, 'message' => 'Failed to update product'];
    }

    /**
     * Delete product
     */
    public function deleteProduct($id) {
        $product = $this->getProductById($id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }

        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Product deleted successfully'] :
            ['success' => false, 'message' => 'Failed to delete product'];
    }

    /**
     * Get total products
     */
    public function getTotalProducts() {
        $this->db->query('SELECT COUNT(*) as count FROM products WHERE status = "active"');
        $result = $this->db->single();
        return $result['count'];
    }

    /**
     * Get product categories
     */
    public function getCategories() {
        $this->db->query('
            SELECT DISTINCT category FROM products 
            WHERE status = "active"
            ORDER BY category ASC
        ');
        return $this->db->resultSet();
    }
}
