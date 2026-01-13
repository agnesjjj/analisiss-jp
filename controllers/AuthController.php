<?php
require_once __DIR__ . '/../config/database.php';

function handleLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header('Location: /admin/dashboard');
                    break;
                case 'stakeholder':
                    header('Location: /stakeholder/dashboard');
                    break;
                default:
                    header('Location: /student/dashboard');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Username atau password salah';
            require __DIR__ . '/../views/login.php';
        }
    } else {
        require __DIR__ . '/../views/login.php';
    }
}

function handleRegister() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $name = $_POST['name'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        
        // Validation
        if (empty($username) || empty($password) || empty($name)) {
            $_SESSION['error'] = 'Semua field harus diisi';
            require __DIR__ . '/../views/register.php';
            return;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Password tidak cocok';
            require __DIR__ . '/../views/register.php';
            return;
        }
        
        $db = getDB();
        
        // Check if username exists
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Username sudah digunakan';
            require __DIR__ . '/../views/register.php';
            return;
        }
        
        // Insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, name, role) VALUES (?, ?, ?, 'student')");
        
        if ($stmt->execute([$username, $hashed_password, $name])) {
            $_SESSION['success'] = 'Registrasi berhasil! Silakan login';
            header('Location: /login');
            exit;
        } else {
            $_SESSION['error'] = 'Registrasi gagal';
            require __DIR__ . '/../views/register.php';
        }
    } else {
        require __DIR__ . '/../views/register.php';
    }
}

function handleLogout() {
    session_destroy();
    header('Location: /');
    exit;
}

function requireAuth($role = null) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    
    if ($role && $_SESSION['role'] !== $role) {
        header('Location: /');
        exit;
    }
}
