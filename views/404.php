<?php
$title = '404 - Halaman Tidak Ditemukan';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>404</h1>
            <p>Halaman yang Anda cari tidak ditemukan</p>
        </div>
        
        <p style="text-align: center; margin: 20px 0;">
            <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
$hideFooter = true;
require __DIR__ . '/layouts/main.php';
?>
