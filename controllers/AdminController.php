<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/AuthController.php';

function adminDashboard() {
    requireAuth('admin');
    
    $db = getDB();
    
    // Get statistics
    $stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
    $total_students = $stmt->fetch()['total'];
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM questions WHERE is_active = 1");
    $total_questions = $stmt->fetch()['total'];
    
    $stmt = $db->query("SELECT COUNT(DISTINCT user_id) as total FROM responses");
    $students_completed = $stmt->fetch()['total'];
    
    $stmt = $db->query("SELECT COUNT(*) as total FROM responses");
    $total_responses = $stmt->fetch()['total'];
    
    require __DIR__ . '/../views/admin/dashboard.php';
}

function manageQuestions() {
    requireAuth('admin');
    
    $db = getDB();
    
    // Handle question operations
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'add') {
            $category_id = $_POST['category_id'] ?? '';
            $question_text = $_POST['question_text'] ?? '';
            $order_num = $_POST['order_num'] ?? 0;
            
            $stmt = $db->prepare("INSERT INTO questions (category_id, question_text, order_num) VALUES (?, ?, ?)");
            $stmt->execute([$category_id, $question_text, $order_num]);
            $_SESSION['success'] = 'Pertanyaan berhasil ditambahkan';
        } elseif ($action === 'edit') {
            $question_id = $_POST['question_id'] ?? '';
            $question_text = $_POST['question_text'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $order_num = $_POST['order_num'] ?? 0;
            
            $stmt = $db->prepare("UPDATE questions SET question_text = ?, category_id = ?, order_num = ? WHERE id = ?");
            $stmt->execute([$question_text, $category_id, $order_num, $question_id]);
            $_SESSION['success'] = 'Pertanyaan berhasil diupdate';
        } elseif ($action === 'delete') {
            $question_id = $_POST['question_id'] ?? '';
            
            $stmt = $db->prepare("DELETE FROM questions WHERE id = ?");
            $stmt->execute([$question_id]);
            $_SESSION['success'] = 'Pertanyaan berhasil dihapus';
        } elseif ($action === 'toggle') {
            $question_id = $_POST['question_id'] ?? '';
            
            $stmt = $db->prepare("UPDATE questions SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$question_id]);
            $_SESSION['success'] = 'Status pertanyaan berhasil diubah';
        }
        
        header('Location: /admin/questions');
        exit;
    }
    
    // Load categories
    $stmt = $db->query("SELECT * FROM categories ORDER BY order_num");
    $categories = $stmt->fetchAll();
    
    // Load all questions with categories
    $stmt = $db->query("SELECT q.*, c.name as category_name FROM questions q JOIN categories c ON q.category_id = c.id ORDER BY c.order_num, q.order_num");
    $questions = $stmt->fetchAll();
    
    require __DIR__ . '/../views/admin/questions.php';
}

function viewReports() {
    requireAuth('admin');
    
    $db = getDB();
    
    // Handle export
    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        exportReportCSV($db);
        exit;
    }
    
    // Get response statistics by category
    $stmt = $db->query("
        SELECT 
            c.id as category_id,
            c.name as category_name,
            q.id as question_id,
            q.question_text,
            AVG(r.response_value) as avg_response,
            COUNT(r.id) as total_responses,
            SUM(CASE WHEN r.response_value = 1 THEN 1 ELSE 0 END) as count_1,
            SUM(CASE WHEN r.response_value = 2 THEN 1 ELSE 0 END) as count_2,
            SUM(CASE WHEN r.response_value = 3 THEN 1 ELSE 0 END) as count_3,
            SUM(CASE WHEN r.response_value = 4 THEN 1 ELSE 0 END) as count_4,
            SUM(CASE WHEN r.response_value = 5 THEN 1 ELSE 0 END) as count_5
        FROM categories c
        JOIN questions q ON c.id = q.category_id
        LEFT JOIN responses r ON q.id = r.question_id
        WHERE q.is_active = 1
        GROUP BY c.id, q.id
        ORDER BY c.order_num, q.order_num
    ");
    $statistics = $stmt->fetchAll();
    
    // Group by category
    $data_by_category = [];
    foreach ($statistics as $stat) {
        $category_id = $stat['category_id'];
        if (!isset($data_by_category[$category_id])) {
            $data_by_category[$category_id] = [
                'name' => $stat['category_name'],
                'questions' => []
            ];
        }
        $data_by_category[$category_id]['questions'][] = $stat;
    }
    
    // Get category averages for chart
    $stmt = $db->query("
        SELECT 
            c.name as category_name,
            AVG(r.response_value) as avg_response
        FROM categories c
        JOIN questions q ON c.id = q.category_id
        LEFT JOIN responses r ON q.id = r.question_id
        WHERE q.is_active = 1
        GROUP BY c.id
        ORDER BY c.order_num
    ");
    $category_averages = $stmt->fetchAll();
    
    require __DIR__ . '/../views/admin/reports.php';
}

function exportReportCSV($db) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=laporan_minat_jepang_' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // Add BOM for Excel UTF-8 support
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Header
    fputcsv($output, ['Kategori', 'Pertanyaan', 'Rata-rata', 'Total Respon', 'Sangat Tidak Setuju', 'Tidak Setuju', 'Netral', 'Setuju', 'Sangat Setuju']);
    
    // Data
    $stmt = $db->query("
        SELECT 
            c.name as category_name,
            q.question_text,
            AVG(r.response_value) as avg_response,
            COUNT(r.id) as total_responses,
            SUM(CASE WHEN r.response_value = 1 THEN 1 ELSE 0 END) as count_1,
            SUM(CASE WHEN r.response_value = 2 THEN 1 ELSE 0 END) as count_2,
            SUM(CASE WHEN r.response_value = 3 THEN 1 ELSE 0 END) as count_3,
            SUM(CASE WHEN r.response_value = 4 THEN 1 ELSE 0 END) as count_4,
            SUM(CASE WHEN r.response_value = 5 THEN 1 ELSE 0 END) as count_5
        FROM categories c
        JOIN questions q ON c.id = q.category_id
        LEFT JOIN responses r ON q.id = r.question_id
        WHERE q.is_active = 1
        GROUP BY c.id, q.id
        ORDER BY c.order_num, q.order_num
    ");
    
    while ($row = $stmt->fetch()) {
        fputcsv($output, [
            $row['category_name'],
            $row['question_text'],
            round($row['avg_response'], 2),
            $row['total_responses'],
            $row['count_1'],
            $row['count_2'],
            $row['count_3'],
            $row['count_4'],
            $row['count_5']
        ]);
    }
    
    fclose($output);
}
