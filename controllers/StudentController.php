<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/AuthController.php';

function studentDashboard() {
    requireAuth('student');
    
    $db = getDB();
    $user_id = $_SESSION['user_id'];
    
    // Check if biodata is filled
    $stmt = $db->prepare("SELECT * FROM biodata WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $biodata = $stmt->fetch();
    
    // Check questionnaire completion
    $stmt = $db->prepare("SELECT COUNT(*) as total FROM questions WHERE is_active = 1");
    $stmt->execute();
    $total_questions = $stmt->fetch()['total'];
    
    $stmt = $db->prepare("SELECT COUNT(*) as answered FROM responses WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $answered_questions = $stmt->fetch()['answered'];
    
    $completion_percentage = $total_questions > 0 ? round(($answered_questions / $total_questions) * 100) : 0;
    
    require __DIR__ . '/../views/student/dashboard.php';
}

function handleBiodata() {
    requireAuth('student');
    
    $db = getDB();
    $user_id = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nis = $_POST['nis'] ?? '';
        $kelas = $_POST['kelas'] ?? '';
        $jurusan = $_POST['jurusan'] ?? '';
        $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
        $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $no_telepon = $_POST['no_telepon'] ?? '';
        $email = $_POST['email'] ?? '';
        
        // Check if biodata exists
        $stmt = $db->prepare("SELECT id FROM biodata WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $exists = $stmt->fetch();
        
        if ($exists) {
            // Update
            $stmt = $db->prepare("UPDATE biodata SET nis=?, kelas=?, jurusan=?, jenis_kelamin=?, tanggal_lahir=?, alamat=?, no_telepon=?, email=? WHERE user_id=?");
            $stmt->execute([$nis, $kelas, $jurusan, $jenis_kelamin, $tanggal_lahir, $alamat, $no_telepon, $email, $user_id]);
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO biodata (user_id, nis, kelas, jurusan, jenis_kelamin, tanggal_lahir, alamat, no_telepon, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $nis, $kelas, $jurusan, $jenis_kelamin, $tanggal_lahir, $alamat, $no_telepon, $email]);
        }
        
        $_SESSION['success'] = 'Biodata berhasil disimpan';
        header('Location: /student/dashboard');
        exit;
    }
    
    // Load existing biodata
    $stmt = $db->prepare("SELECT * FROM biodata WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $biodata = $stmt->fetch();
    
    require __DIR__ . '/../views/student/biodata.php';
}

function handleQuestionnaire() {
    requireAuth('student');
    
    $db = getDB();
    $user_id = $_SESSION['user_id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Save responses
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $question_id = str_replace('question_', '', $key);
                
                // Insert or update response
                $stmt = $db->prepare("INSERT INTO responses (user_id, question_id, response_value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE response_value = ?, updated_at = CURRENT_TIMESTAMP");
                $stmt->execute([$user_id, $question_id, $value, $value]);
            }
        }
        
        $_SESSION['success'] = 'Kuesioner berhasil disimpan';
        header('Location: /student/dashboard');
        exit;
    }
    
    // Load questions by category
    $stmt = $db->query("SELECT * FROM categories ORDER BY order_num");
    $categories = $stmt->fetchAll();
    
    $questions_by_category = [];
    foreach ($categories as $category) {
        $stmt = $db->prepare("SELECT * FROM questions WHERE category_id = ? AND is_active = 1 ORDER BY order_num");
        $stmt->execute([$category['id']]);
        $questions_by_category[$category['id']] = [
            'category' => $category,
            'questions' => $stmt->fetchAll()
        ];
    }
    
    // Load existing responses
    $stmt = $db->prepare("SELECT question_id, response_value FROM responses WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $responses = [];
    while ($row = $stmt->fetch()) {
        $responses[$row['question_id']] = $row['response_value'];
    }
    
    require __DIR__ . '/../views/student/questionnaire.php';
}
