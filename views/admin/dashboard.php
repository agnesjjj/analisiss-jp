<?php
$title = 'Dashboard Admin';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>🎛️ Dashboard Admin</h2>
        </div>
        
        <p>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>!</p>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>👥 Total Siswa</h3>
                <div class="stat-number"><?php echo $total_students; ?></div>
                <p>Siswa terdaftar dalam sistem</p>
            </div>
            
            <div class="dashboard-card">
                <h3>✅ Siswa Berpartisipasi</h3>
                <div class="stat-number"><?php echo $students_completed; ?></div>
                <p>Siswa yang telah mengisi kuesioner</p>
            </div>
            
            <div class="dashboard-card">
                <h3>📝 Total Pertanyaan</h3>
                <div class="stat-number"><?php echo $total_questions; ?></div>
                <p>Pertanyaan aktif dalam sistem</p>
            </div>
            
            <div class="dashboard-card">
                <h3>📊 Total Respon</h3>
                <div class="stat-number"><?php echo $total_responses; ?></div>
                <p>Jawaban yang telah dikumpulkan</p>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <h3 style="color: var(--primary-blue); margin-bottom: 20px;">Menu Utama</h3>
            
            <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <a href="/admin/questions" class="dashboard-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.3s;">
                    <h3>📋 Kelola Pertanyaan</h3>
                    <p>Tambah, edit, atau hapus pertanyaan kuesioner</p>
                </a>
                
                <a href="/admin/reports" class="dashboard-card" style="text-decoration: none; color: inherit; cursor: pointer; transition: transform 0.3s;">
                    <h3>📈 Laporan & Grafik</h3>
                    <p>Lihat hasil analisis dan ekspor laporan</p>
                </a>
            </div>
        </div>
        
        <?php if ($students_completed > 0): ?>
        <div class="alert alert-success" style="margin-top: 20px;">
            <strong>Status Sistem:</strong> Sistem berjalan dengan baik. 
            <?php echo $students_completed; ?> siswa telah berpartisipasi dalam survei.
        </div>
        <?php else: ?>
        <div class="alert alert-info" style="margin-top: 20px;">
            <strong>Info:</strong> Belum ada siswa yang mengisi kuesioner. 
            Pastikan siswa telah mendaftar dan mengisi kuesioner.
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}
</style>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
