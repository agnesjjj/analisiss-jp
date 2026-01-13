<?php
$title = 'Dashboard Siswa';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Dashboard Siswa</h2>
        </div>
        
        <p>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>!</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>📝 Biodata</h3>
                <p style="margin: 15px 0;">
                    <?php if ($biodata): ?>
                        <span style="color: var(--success); font-weight: 600;">✓ Sudah diisi</span>
                    <?php else: ?>
                        <span style="color: var(--warning); font-weight: 600;">⚠ Belum diisi</span>
                    <?php endif; ?>
                </p>
                <a href="/student/biodata" class="btn btn-primary">
                    <?php echo $biodata ? 'Edit Biodata' : 'Isi Biodata'; ?>
                </a>
            </div>
            
            <div class="dashboard-card">
                <h3>📊 Kuesioner</h3>
                <div class="progress-bar" style="margin: 15px 0;">
                    <div class="progress-fill" style="width: <?php echo $completion_percentage; ?>%;">
                        <?php echo $completion_percentage; ?>%
                    </div>
                </div>
                <p style="margin-bottom: 15px;">
                    <?php echo $answered_questions; ?> dari <?php echo $total_questions; ?> pertanyaan
                </p>
                <a href="/student/questionnaire" class="btn btn-primary">
                    <?php echo $answered_questions > 0 ? 'Lanjutkan Kuesioner' : 'Mulai Kuesioner'; ?>
                </a>
            </div>
        </div>
        
        <?php if (!$biodata): ?>
        <div class="alert alert-info">
            <strong>Langkah selanjutnya:</strong> Silakan isi biodata Anda terlebih dahulu sebelum mengisi kuesioner.
        </div>
        <?php elseif ($completion_percentage < 100): ?>
        <div class="alert alert-info">
            <strong>Langkah selanjutnya:</strong> Lengkapi kuesioner untuk membantu analisis minat terhadap Jepang.
        </div>
        <?php else: ?>
        <div class="alert alert-success">
            <strong>Terima kasih!</strong> Anda telah menyelesaikan semua kuesioner. Data Anda akan membantu dalam analisis minat generasi muda terhadap Jepang.
        </div>
        <?php endif; ?>
        
        <div class="card" style="margin-top: 20px; background-color: var(--lightest-blue);">
            <h3 style="color: var(--primary-blue);">ℹ️ Tentang Kuesioner</h3>
            <p>Kuesioner ini mengukur minat Anda terhadap empat aspek Jepang:</p>
            <ul style="margin: 15px 0 15px 30px;">
                <li><strong>Budaya Jepang</strong> - Anime, manga, tradisi, makanan, dll.</li>
                <li><strong>Pendidikan di Jepang</strong> - Kuliah, beasiswa, sistem pendidikan</li>
                <li><strong>Bekerja di Jepang</strong> - Magang, karir, budaya kerja</li>
                <li><strong>Bahasa Jepang</strong> - Belajar, praktik, ujian JLPT</li>
            </ul>
            <p>Setiap pertanyaan menggunakan skala Likert 1-5:</p>
            <p style="margin-left: 20px;">
                <strong>1</strong> = Sangat Tidak Setuju | 
                <strong>2</strong> = Tidak Setuju | 
                <strong>3</strong> = Netral | 
                <strong>4</strong> = Setuju | 
                <strong>5</strong> = Sangat Setuju
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
