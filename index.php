<?php
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'analisiss_jp');
define('DB_USER', 'root');
define('DB_PASS', '');

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$base_path = '/analisiss-jp';

// Remove query string
$request = strtok($request, '?');

// Load configuration
require_once 'config/database.php';

// Route handling
switch ($request) {
    case $base_path . '/':
    case $base_path . '/index.php':
        require __DIR__ . '/views/home.php';
        break;
    case $base_path . '/login':
        require __DIR__ . '/controllers/AuthController.php';
        handleLogin();
        break;
    case $base_path . '/register':
        require __DIR__ . '/controllers/AuthController.php';
        handleRegister();
        break;
    case $base_path . '/student/dashboard':
        require __DIR__ . '/controllers/StudentController.php';
        studentDashboard();
        break;
    case $base_path . '/student/biodata':
        require __DIR__ . '/controllers/StudentController.php';
        handleBiodata();
        break;
    case $base_path . '/student/questionnaire':
        require __DIR__ . '/controllers/StudentController.php';
        handleQuestionnaire();
        break;
    case $base_path . '/admin/dashboard':
        require __DIR__ . '/controllers/AdminController.php';
        adminDashboard();
        break;
    case $base_path . '/admin/questions':
        require __DIR__ . '/controllers/AdminController.php';
        manageQuestions();
        break;
    case $base_path . '/admin/reports':
        require __DIR__ . '/controllers/AdminController.php';
        viewReports();
        break;
    case $base_path . '/stakeholder/dashboard':
        require __DIR__ . '/controllers/StakeholderController.php';
        stakeholderDashboard();
        break;
    case $base_path . '/logout':
        require __DIR__ . '/controllers/AuthController.php';
        handleLogout();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
