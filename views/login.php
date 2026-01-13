<?php
$title = 'Login';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>🗾 Login</h1>
            <p>Sistem Informasi Minat Jepang</p>
        </div>
        
        <form method="POST" action="/login">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 15px;">Masuk</button>
        </form>
        
        <p style="text-align: center;">
            Belum punya akun? <a href="/register" style="color: var(--secondary-blue);">Daftar di sini</a>
        </p>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="/" style="color: var(--gray-600);">← Kembali ke Beranda</a>
        </p>
        
        <div class="alert alert-info" style="margin-top: 20px;">
            <strong>Demo Login:</strong><br>
            Username: <code>admin</code><br>
            Password: <code>admin123</code>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$hideFooter = true;
require __DIR__ . '/layouts/main.php';
?>
