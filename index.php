<?php
/**
 * Application Entry Point
 */

require_once 'config/database.php';
require_once 'config/config.php';

// Get the requested URL path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = str_replace('/bank-cms', '', $request_uri);
$request_method = $_SERVER['REQUEST_METHOD'];

// Route the request
$page = isset($_GET['page']) ? sanitize($_GET['page']) : 'home';

ob_start();

try {
    switch ($page) {
        case 'home':
            require_once 'views/frontend/home.php';
            break;
            
        case 'products':
            require_once 'views/frontend/products.php';
            break;
            
        case 'governance':
            require_once 'views/frontend/governance.php';
            break;
            
        case 'jobs':
            require_once 'views/frontend/jobs.php';
            break;
            
        case 'about':
            require_once 'views/frontend/about.php';
            break;
            
        case 'contact':
            require_once 'views/frontend/contact.php';
            break;
            
        case 'admin':
            requireAdmin();
            require_once 'views/admin/dashboard.php';
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

// Load main layout
require_once 'views/frontend/layout.php';
