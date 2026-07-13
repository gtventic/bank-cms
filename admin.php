<?php
/**
 * Admin Entry Point
 */

require_once 'config/database.php';
require_once 'config/config.php';

requireAdmin();

$action = isset($_GET['action']) ? sanitize($_GET['action']) : 'dashboard';

ob_start();

try {
    switch ($action) {
        case 'dashboard':
            require_once 'views/admin/dashboard.php';
            break;
            
        case 'carousel':
            require_once 'views/admin/carousel_manage.php';
            break;
            
        case 'jobs':
            require_once 'views/admin/job_manage.php';
            break;
            
        case 'products':
            require_once 'views/admin/product_manage.php';
            break;
            
        case 'pages':
            require_once 'views/admin/page_manage.php';
            break;
            
        case 'users':
            require_once 'views/admin/user_manage.php';
            break;
            
        case 'messages':
            require_once 'views/admin/message_manage.php';
            break;
            
        default:
            http_response_code(404);
            echo '<div class="container py-5"><h1>404 - Page Not Found</h1></div>';
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo '<div class="container py-5"><h1>Error 500</h1><p>' . htmlspecialchars($e->getMessage()) . '</p></div>';
}

$content = ob_get_clean();

// Load admin layout
require_once 'views/admin/layout.php';
