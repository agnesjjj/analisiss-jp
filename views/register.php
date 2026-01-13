<?php
$title = 'Registrasi';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>🗾 Registrasi Siswa</h1>
            <p>SMK Yos Sudarso Kawunganten</p>
        </div>
        
        <form method="POST" action="/register">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-bottom: 15px;">Daftar</button>
        </form>
        
        <p style="text-align: center;">
            Sudah punya akun? <a href="/login" style="color: var(--secondary-blue);">Login di sini</a>
        </p>
        
        <p style="text-align: center; margin-top: 15px;">
            <a href="/" style="color: var(--gray-600);">← Kembali ke Beranda</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
$hideFooter = true;
require __DIR__ . '/layouts/main.php';
?>
