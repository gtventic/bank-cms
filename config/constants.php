<?php
/**
 * Application Constants
 * Global constants for the Bank CMS application
 */

// Application settings
define('APP_NAME', 'Bank CMS');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/bank-cms');
define('SITE_TITLE', 'Professional Banking Solutions');

// Database settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bank_cms');

// Directory paths
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CLASSES_PATH', ROOT_PATH . '/classes');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('UPLOADS_PATH', ROOT_PATH . '/uploads');

// Upload directories
define('CAROUSEL_UPLOAD_PATH', UPLOADS_PATH . '/carousel');
define('PRODUCTS_UPLOAD_PATH', UPLOADS_PATH . '/products');
define('EVENTS_UPLOAD_PATH', UPLOADS_PATH . '/events');
define('AWARDS_UPLOAD_PATH', UPLOADS_PATH . '/awards');

// Image settings
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Session settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('REMEMBER_ME_DURATION', 2592000); // 30 days

// Pagination
define('ITEMS_PER_PAGE', 10);
define('ADMIN_ITEMS_PER_PAGE', 20);

// Security
define('MIN_PASSWORD_LENGTH', 8);
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_ATTEMPT_TIMEOUT', 900); // 15 minutes

// Carousel settings
define('CAROUSEL_AUTO_ROTATE_INTERVAL', 5000); // 5 seconds in milliseconds
define('CAROUSEL_MAX_ITEMS', 10);

// Email settings
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
define('ADMIN_EMAIL', 'admin@bank.com');

// Timezone
define('TIMEZONE', 'UTC');
date_default_timezone_set(TIMEZONE);

// Error reporting
define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// HTTPS enforcement
define('REQUIRE_HTTPS', true);

// CSRF Token name
define('CSRF_TOKEN_NAME', 'csrf_token');
