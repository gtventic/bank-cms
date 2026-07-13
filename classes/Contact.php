<?php
/**
 * Contact Class
 * Handles contact messages
 */

class Contact {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Submit contact message
     */
    public function submitMessage($data) {
        if (empty($data['full_name']) || empty($data['email']) || empty($data['message'])) {
            return ['success' => false, 'message' => 'Name, email, and message are required'];
        }

        if (!isValidEmail($data['email'])) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        $this->db->query('  
            INSERT INTO contact_messages (full_name, email, phone, subject, message, status, created_at)
            VALUES (:full_name, :email, :phone, :subject, :message, :status, NOW())
        ');
        
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone'] ?? '');
        $this->db->bind(':subject', $data['subject'] ?? '');
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':status', 'new');

        if ($this->db->execute()) {
            // Send notification email to admin
            $this->sendAdminNotification($data);
            return ['success' => true, 'message' => 'Message sent successfully'];
        }
        
        return ['success' => false, 'message' => 'Failed to send message'];
    }

    /**
     * Get all messages
     */
    public function getAllMessages($limit = null, $offset = 0, $status = null) {
        $sql = 'SELECT * FROM contact_messages';
        
        if ($status) {
            $sql .= ' WHERE status = :status';
        }
        
        $sql .= ' ORDER BY created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT :limit OFFSET :offset';
        }
        
        $this->db->query($sql);
        
        if ($status) {
            $this->db->bind(':status', $status);
        }
        if ($limit) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        }
        
        return $this->db->resultSet();
    }

    /**
     * Get message by ID
     */
    public function getMessageById($id) {
        $this->db->query('SELECT * FROM contact_messages WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Update message status
     */
    public function updateMessageStatus($id, $status) {
        $validStatuses = ['new', 'read', 'responded', 'archived'];
        
        if (!in_array($status, $validStatuses)) {
            return ['success' => false, 'message' => 'Invalid status'];
        }

        $this->db->query('UPDATE contact_messages SET status = :status WHERE id = :id');
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Status updated successfully'] :
            ['success' => false, 'message' => 'Failed to update status'];
    }

    /**
     * Delete message
     */
    public function deleteMessage($id) {
        $this->db->query('DELETE FROM contact_messages WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Message deleted successfully'] :
            ['success' => false, 'message' => 'Failed to delete message'];
    }

    /**
     * Send admin notification
     */
    private function sendAdminNotification($data) {
        // This is a placeholder for email functionality
        // Implement with your preferred email library (PHPMailer, Swift Mailer, etc.)
        $subject = 'New Contact Message: ' . $data['subject'];
        $message = "New message from {$data['full_name']}\n";
        $message .= "Email: {$data['email']}\n";
        $message .= "Phone: {$data['phone']}\n\n";
        $message .= $data['message'];
        
        // mail(ADMIN_EMAIL, $subject, $message);
    }
}
