<?php
/**
 * Carousel Class
 * Handles carousel/slider management for events and awards
 */

class Carousel {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Get all carousel items
     */
    public function getAllItems($limit = null, $offset = 0) {
        $sql = '
            SELECT ci.id, ci.title, ci.description, ci.image_path, ci.link, ci.type, 
                   ci.status, ci.created_at, co.order_position
            FROM carousel_items ci
            LEFT JOIN carousel_order co ON ci.id = co.item_id
            WHERE ci.status = "active"
            ORDER BY COALESCE(co.order_position, ci.created_at) DESC
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
     * Get active carousel items for frontend
     */
    public function getActiveItems($limit = CAROUSEL_MAX_ITEMS) {
        return $this->getAllItems($limit);
    }

    /**
     * Get carousel item by ID
     */
    public function getItemById($id) {
        $this->db->query('
            SELECT ci.id, ci.title, ci.description, ci.image_path, ci.link, ci.type, 
                   ci.status, ci.created_at, co.order_position
            FROM carousel_items ci
            LEFT JOIN carousel_order co ON ci.id = co.item_id
            WHERE ci.id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create carousel item
     */
    public function createItem($data) {
        // Validate required fields
        if (empty($data['title']) || empty($data['type'])) {
            return ['success' => false, 'message' => 'Title and type are required'];
        }

        $imagePath = null;
        if (isset($data['image_path'])) {
            $imagePath = $this->processImage($data['image_path']);
            if ($imagePath === false) {
                return ['success' => false, 'message' => 'Failed to upload image'];
            }
        }

        $this->db->query('
            INSERT INTO carousel_items (title, description, image_path, link, type, status, created_at)
            VALUES (:title, :description, :image_path, :link, :type, :status, NOW())
        ');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':image_path', $imagePath);
        $this->db->bind(':link', $data['link'] ?? '');
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':status', $data['status'] ?? 'active');

        if ($this->db->execute()) {
            $itemId = $this->db->lastInsertId();
            
            // Add to order table
            $this->db->query('
                INSERT INTO carousel_order (item_id, order_position, created_at)
                VALUES (:item_id, :order_position, NOW())
            ');
            $this->db->bind(':item_id', $itemId);
            $this->db->bind(':order_position', time());
            $this->db->execute();
            
            return ['success' => true, 'message' => 'Carousel item created successfully', 'id' => $itemId];
        }
        
        return ['success' => false, 'message' => 'Failed to create carousel item'];
    }

    /**
     * Update carousel item
     */
    public function updateItem($id, $data) {
        $item = $this->getItemById($id);
        if (!$item) {
            return ['success' => false, 'message' => 'Carousel item not found'];
        }

        $imagePath = $item['image_path'];
        if (isset($data['image_path']) && !empty($data['image_path'])) {
            // Delete old image
            if ($imagePath && file_exists(CAROUSEL_UPLOAD_PATH . '/' . basename($imagePath))) {
                unlink(CAROUSEL_UPLOAD_PATH . '/' . basename($imagePath));
            }
            
            $imagePath = $this->processImage($data['image_path']);
            if ($imagePath === false) {
                return ['success' => false, 'message' => 'Failed to upload image'];
            }
        }

        $this->db->query('
            UPDATE carousel_items 
            SET title = :title, description = :description, image_path = :image_path, 
                link = :link, type = :type, status = :status
            WHERE id = :id
        ');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':image_path', $imagePath);
        $this->db->bind(':link', $data['link'] ?? '');
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Carousel item updated successfully'] :
            ['success' => false, 'message' => 'Failed to update carousel item'];
    }

    /**
     * Delete carousel item
     */
    public function deleteItem($id) {
        $item = $this->getItemById($id);
        if (!$item) {
            return ['success' => false, 'message' => 'Carousel item not found'];
        }

        // Delete image
        if ($item['image_path'] && file_exists(CAROUSEL_UPLOAD_PATH . '/' . basename($item['image_path']))) {
            unlink(CAROUSEL_UPLOAD_PATH . '/' . basename($item['image_path']));
        }

        // Delete item
        $this->db->query('DELETE FROM carousel_items WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Delete order entry
        $this->db->query('DELETE FROM carousel_order WHERE item_id = :id');
        $this->db->bind(':id', $id);
        $this->db->execute();

        return ['success' => true, 'message' => 'Carousel item deleted successfully'];
    }

    /**
     * Reorder carousel items
     */
    public function reorderItems($itemOrder) {
        foreach ($itemOrder as $position => $itemId) {
            $this->db->query('
                UPDATE carousel_order 
                SET order_position = :position
                WHERE item_id = :item_id
            ');
            $this->db->bind(':position', $position);
            $this->db->bind(':item_id', $itemId);
            $this->db->execute();
        }
        
        return ['success' => true, 'message' => 'Carousel order updated successfully'];
    }

    /**
     * Process and save image
     */
    private function processImage($imageFile) {
        if (!isset($imageFile['tmp_name']) || !is_uploaded_file($imageFile['tmp_name'])) {
            return false;
        }

        // Validate file size
        if ($imageFile['size'] > MAX_UPLOAD_SIZE) {
            return false;
        }

        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $imageFile['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
            return false;
        }

        // Validate extension
        $extension = strtolower(pathinfo($imageFile['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ALLOWED_IMAGE_EXTENSIONS)) {
            return false;
        }

        // Create unique filename
        $filename = 'carousel_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = CAROUSEL_UPLOAD_PATH . '/' . $filename;

        // Create directory if not exists
        if (!is_dir(CAROUSEL_UPLOAD_PATH)) {
            mkdir(CAROUSEL_UPLOAD_PATH, 0755, true);
        }

        // Move file
        if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
            // Optimize image
            $this->optimizeImage($uploadPath);
            return '/uploads/carousel/' . $filename;
        }

        return false;
    }

    /**
     * Optimize image
     */
    private function optimizeImage($imagePath) {
        if (!function_exists('imagecreatefromstring')) {
            return;
        }

        $image = imagecreatefromstring(file_get_contents($imagePath));
        if ($image) {
            // Resize if too large
            $width = imagesx($image);
            $height = imagesy($image);
            
            if ($width > 1200 || $height > 800) {
                $newWidth = 1200;
                $newHeight = 800;
                
                if ($width / $height > $newWidth / $newHeight) {
                    $newHeight = intval($newWidth * $height / $width);
                } else {
                    $newWidth = intval($newHeight * $width / $height);
                }
                
                $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                
                imagejpeg($resizedImage, $imagePath, 85);
                imagedestroy($resizedImage);
            }
            imagedestroy($image);
        }
    }

    /**
     * Get total carousel items
     */
    public function getTotalItems() {
        $this->db->query('SELECT COUNT(*) as count FROM carousel_items WHERE status = "active"');
        $result = $this->db->single();
        return $result['count'];
    }
}
