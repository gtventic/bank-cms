<?php
/**
 * Event Class
 * Handles bank events management
 */

class Event {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Get all events
     */
    public function getAllEvents($limit = null, $offset = 0) {
        $sql = '  
            SELECT id, title, description, event_date, location, image_path, status, created_at
            FROM events
            WHERE status = "active"
            ORDER BY event_date DESC
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
     * Get event by ID
     */
    public function getEventById($id) {
        $this->db->query('SELECT * FROM events WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Create event
     */
    public function createEvent($data) {
        if (empty($data['title'])) {
            return ['success' => false, 'message' => 'Title is required'];
        }

        $this->db->query('  
            INSERT INTO events (title, description, event_date, location, image_path, status, created_at)
            VALUES (:title, :description, :event_date, :location, :image_path, :status, NOW())
        ');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':event_date', $data['event_date'] ?? null);
        $this->db->bind(':location', $data['location'] ?? '');
        $this->db->bind(':image_path', $data['image_path'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Event created successfully', 'id' => $this->db->lastInsertId()] :
            ['success' => false, 'message' => 'Failed to create event'];
    }

    /**
     * Update event
     */
    public function updateEvent($id, $data) {
        $event = $this->getEventById($id);
        if (!$event) {
            return ['success' => false, 'message' => 'Event not found'];
        }

        $this->db->query('  
            UPDATE events
            SET title = :title, description = :description, event_date = :event_date,
                location = :location, image_path = :image_path, status = :status
            WHERE id = :id
        ');
        
        $this->db->bind(':id', $id);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description'] ?? '');
        $this->db->bind(':event_date', $data['event_date'] ?? null);
        $this->db->bind(':location', $data['location'] ?? '');
        $this->db->bind(':image_path', $data['image_path'] ?? $event['image_path']);
        $this->db->bind(':status', $data['status'] ?? 'active');

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Event updated successfully'] :
            ['success' => false, 'message' => 'Failed to update event'];
    }

    /**
     * Delete event
     */
    public function deleteEvent($id) {
        $event = $this->getEventById($id);
        if (!$event) {
            return ['success' => false, 'message' => 'Event not found'];
        }

        $this->db->query('DELETE FROM events WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Event deleted successfully'] :
            ['success' => false, 'message' => 'Failed to delete event'];
    }
}
