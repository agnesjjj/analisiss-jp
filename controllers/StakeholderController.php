<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/AuthController.php';

function stakeholderDashboard() {
    requireAuth('stakeholder');
    
    $db = getDB();
    
    // Get statistics
    $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
    $total_students = $stmt->fetch()['total'];
    
    $stmt = $db->query("SELECT COUNT(DISTINCT user_id) as total FROM responses");
    $students_participated = $stmt->fetch()['total'];
    
    // Get category averages for display
    $stmt = $db->query("
        SELECT 
            c.id,
            c.name as category_name,
            c.description,
            AVG(r.response_value) as avg_response,
            COUNT(DISTINCT r.user_id) as total_respondents
        FROM categories c
        JOIN questions q ON c.id = q.category_id
        LEFT JOIN responses r ON q.id = r.question_id
        WHERE q.is_active = 1
        GROUP BY c.id
        ORDER BY c.order_num
    ");
    $category_stats = $stmt->fetchAll();
    
    // Get overall statistics
    $stmt = $db->query("
        SELECT 
            AVG(response_value) as overall_avg,
            COUNT(*) as total_responses
        FROM responses
    ");
    $overall_stats = $stmt->fetch();
    
    require __DIR__ . '/../views/stakeholder/dashboard.php';
}
