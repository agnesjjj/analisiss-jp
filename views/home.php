<?php
$title = 'Beranda';
ob_start();
?>

<div class="auth-container">
    <div class="auth-card" style="max-width: 600px;">
        <div class="auth-header">
            <h1>🗾 Selamat Datang</h1>
            <h2>Sistem Informasi Minat Generasi Muda Terhadap Jepang</h2>
            <p>SMK Yos Sudarso Kawunganten</p>
        </div>
        
        <div class="card" style="margin: 20px 0;">
            <h3 style="color: var(--primary-blue); margin-bottom: 15px;">Tentang Sistem</h3>
            <p style="margin-bottom: 15px;">
                Sistem ini dirancang untuk menganalisis minat siswa SMK Yos Sudarso Kawunganten terhadap berbagai aspek Jepang, meliputi:
            </p>
            <ul style="margin-left: 20px; margin-bottom: 20px;">
                <li>🎌 Budaya Jepang</li>
                <li>🎓 Pendidikan di Jepang</li>
                <li>💼 Bekerja di Jepang</li>
                <li>🗣️ Bahasa Jepang</li>
            </ul>
        </div>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="/login" class="btn btn-primary" style="flex: 1; min-width: 150px;">Masuk</a>
            <a href="/register" class="btn btn-secondary" style="flex: 1; min-width: 150px;">Daftar Siswa</a>
        </div>
        
        <div class="alert alert-info" style="margin-top: 20px; text-align: left;">
            <strong>Informasi:</strong>
            <ul style="margin: 10px 0 0 20px;">
                <li><strong>Siswa:</strong> Daftar, isi biodata, dan lengkapi kuesioner</li>
                <li><strong>Admin:</strong> Kelola pertanyaan dan lihat laporan</li>
                <li><strong>Stakeholder:</strong> Lihat hasil analisis</li>
            </ul>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$hideFooter = true;
require __DIR__ . '/layouts/main.php';
?>
