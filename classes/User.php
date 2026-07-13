<?php
/**
 * User Class
 * Handles user authentication and management
 */

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->db->connect();
    }

    /**
     * Register new user
     */
    public function register($data) {
        if (!isValidEmail($data['email'])) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }

        if (strlen($data['password']) < MIN_PASSWORD_LENGTH) {
            return ['success' => false, 'message' => 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters'];
        }

        if ($data['password'] !== $data['confirm_password']) {
            return ['success' => false, 'message' => 'Passwords do not match'];
        }

        // Check if email already exists
        $this->db->query('SELECT id FROM users WHERE email = :email');
        $this->db->bind(':email', $data['email']);
        if ($this->db->single()) {
            return ['success' => false, 'message' => 'Email already exists'];
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        // Insert user
        $this->db->query('
            INSERT INTO users (email, password, name, role, created_at)
            VALUES (:email, :password, :name, :role, NOW())
        ');
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':role', 'user');

        if ($this->db->execute()) {
            return ['success' => true, 'message' => 'Registration successful'];
        }
        return ['success' => false, 'message' => 'Registration failed'];
    }

    /**
     * Login user
     */
    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $user = $this->db->single();

        if (!$user) {
            $this->recordLoginAttempt($email);
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        if ($this->isAccountLocked($email)) {
            return ['success' => false, 'message' => 'Account temporarily locked. Try again later.'];
        }

        if (!password_verify($password, $user['password'])) {
            $this->recordLoginAttempt($email);
            return ['success' => false, 'message' => 'Invalid email or password'];
        }

        if ($user['status'] !== 'active') {
            return ['success' => false, 'message' => 'Account is inactive'];
        }

        // Clear login attempts
        $this->clearLoginAttempts($email);

        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Update last login
        $this->db->query('UPDATE users SET last_login = NOW() WHERE id = :id');
        $this->db->bind(':id', $user['id']);
        $this->db->execute();

        return ['success' => true, 'message' => 'Login successful'];
    }

    /**
     * Record login attempt
     */
    private function recordLoginAttempt($email) {
        $this->db->query('
            INSERT INTO login_attempts (email, attempt_time)
            VALUES (:email, NOW())
        ');
        $this->db->bind(':email', $email);
        $this->db->execute();
    }

    /**
     * Check if account is locked
     */
    private function isAccountLocked($email) {
        $this->db->query('
            SELECT COUNT(*) as attempts FROM login_attempts
            WHERE email = :email AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
        ');
        $this->db->bind(':email', $email);
        $result = $this->db->single();
        return $result['attempts'] >= MAX_LOGIN_ATTEMPTS;
    }

    /**
     * Clear login attempts
     */
    private function clearLoginAttempts($email) {
        $this->db->query('DELETE FROM login_attempts WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
    }

    /**
     * Get user by ID
     */
    public function getUserById($id) {
        $this->db->query('SELECT id, email, name, role, status, created_at, last_login FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Get all users
     */
    public function getAllUsers($limit = null, $offset = 0) {
        $sql = 'SELECT id, email, name, role, status, created_at, last_login FROM users ORDER BY created_at DESC';
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
     * Update user
     */
    public function updateUser($id, $data) {
        $this->db->query('
            UPDATE users 
            SET name = :name, email = :email, role = :role, status = :status
            WHERE id = :id
        ');
        $this->db->bind(':id', $id);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    /**
     * Delete user
     */
    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Change password
     */
    public function changePassword($id, $currentPassword, $newPassword) {
        $user = $this->getUserById($id);
        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        // Verify current password
        $this->db->query('SELECT password FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        $userRecord = $this->db->single();

        if (!password_verify($currentPassword, $userRecord['password'])) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }

        if (strlen($newPassword) < MIN_PASSWORD_LENGTH) {
            return ['success' => false, 'message' => 'Password must be at least ' . MIN_PASSWORD_LENGTH . ' characters'];
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);

        $this->db->query('UPDATE users SET password = :password WHERE id = :id');
        $this->db->bind(':password', $hashedPassword);
        $this->db->bind(':id', $id);

        return $this->db->execute() ? 
            ['success' => true, 'message' => 'Password changed successfully'] :
            ['success' => false, 'message' => 'Failed to change password'];
    }

    /**
     * Logout user
     */
    public function logout() {
        session_destroy();
        return true;
    }
}
