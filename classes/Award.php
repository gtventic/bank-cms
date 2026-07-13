<?php
/**
 * Award Class
 * Handles bank awards management
 */

class Award {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Get all awards
     */
    public function getAllAwards($limit = null, $offset = 0) {
        $sql = '  
            SELECT id, title, description, award_date, awarding_organization, image_path, status, created_at
            FROM awards
            WHERE status = "active"
            ORDER BY award_date DESC
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
     * Get award by ID
     */
    public function getAwardById($id) {
        $this->db->query('SELECT * FROM awards WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create award
     */
    public function createAward($data) {
        if (empty($data['title'])) {
            return ['success' => false, 'message' => 'Title is required'];
        }

        $this->db->query('  
            INSERT INTO awards (title, description, award_date, awarding_organization, image_path, status, created_at)
            VALUES (:title, :description, :award_date, :awarding_organization, :image_path, :status, NOW())
        ');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':award_date', $data['award_date'] ?? null);
        $this->db->bind(':awarding_organization', $data['awarding_organization'] ?? '');
        $this->db->bind(':image_path', $data['image_path'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Award created successfully', 'id' => $this->db->lastInsertId()] :
            ['success' => false, 'message' => 'Failed to create award'];
    }

    /**
     * Update award
     */
    public function updateAward($id, $data) {
        $award = $this->getAwardById($id);
        if (!$award) {
            return ['success' => false, 'message' => 'Award not found'];
        }

        $this->db->query('  
            UPDATE awards
            SET title = :title, description = :description, award_date = :award_date,
                awarding_organization = :awarding_organization, image_path = :image_path, status = :status
            WHERE id = :id
        ');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':award_date', $data['award_date'] ?? null);
        $this->db->bind(':awarding_organization', $data['awarding_organization'] ?? '');
        $this->db->bind(':image_path', $data['image_path'] ?? $award['image_path']);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Award updated successfully'] :
            ['success' => false, 'message' => 'Failed to update award'];
    }

    /**
     * Delete award
     */
    public function deleteAward($id) {
        $award = $this->getAwardById($id);
        if (!$award) {
            return ['success' => false, 'message' => 'Award not found'];
        }

        $this->db->query('DELETE FROM awards WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Award deleted successfully'] :
            ['success' => false, 'message' => 'Failed to delete award'];
    }
}
