<?php
/**
 * Application Configuration
 * Initialize autoloader and core application settings
 */

// Include constants
require_once dirname(__FILE__) . '/constants.php';

// Autoloader for classes
spl_autoload_register(function($class) {
    $file = CLASSES_PATH . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Initialize database connection
function getDB() {
    static $db = null;
    if ($db === null) {
        $db = new Database();
        $db->connect();
    }
    return $db;
}

// Session management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Enforce HTTPS if required
if (REQUIRE_HTTPS && empty($_SERVER['HTTPS'])) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Generate CSRF token if not exists
if (empty($_SESSION[CSRF_TOKEN_NAME])) {
    $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
}

/**
 * Sanitize input
 */
function sanitize($input) {
    return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate CSRF token
 */
function validateCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Generate CSRF token for forms
 */
function getCSRFToken() {
    return $_SESSION[CSRF_TOKEN_NAME] ?? '';
}

/**
 * Redirect with message
 */
function redirect($url, $message = '', $type = 'info') {
    if (!empty($message)) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
    header('Location: ' . $url);
    exit();
}

/**
 * Get message from session
 */
function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = [
            'text' => $_SESSION['message'],
            'type' => $_SESSION['message_type'] ?? 'info'
        ];
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
        return $message;
    }
    return null;
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Get current user
 */
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['email'],
            'name' => $_SESSION['name'],
            'role' => $_SESSION['role']
        ];
    }
    return null;
}

/**
 * Require login
 */
function requireLogin() {
    if (!isLoggedIn()) {
        redirect(APP_URL . '/login', 'Please log in to continue', 'warning');
    }
}

/**
 * Require admin
 */
function requireAdmin() {
    if (!isAdmin()) {
        redirect(APP_URL . '/admin', 'Access denied', 'danger');
    }
}

/**
 * Format date
 */
function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

/**
 * Get file size in human readable format
 */
function formatFileSize($bytes) {
    $units = ['B', 'KB', 'MB', 'GB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, 2) . ' ' . $units[$pow];
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Generate slug
 */
function generateSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = preg_replace('~-+~', '-', $text);
    $text = trim($text, '-');
    return strtolower($text);
}
