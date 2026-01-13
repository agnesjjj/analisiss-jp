<?php
$title = 'Dashboard Stakeholder';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>👔 Dashboard Stakeholder</h2>
        </div>
        
        <p>Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['name']); ?></strong>!</p>
        
        <div class="alert alert-info">
            <strong>Informasi:</strong> Halaman ini menampilkan hasil analisis minat siswa SMK Yos Sudarso Kawunganten terhadap Jepang untuk mendukung pengambilan keputusan.
        </div>
        
        <!-- Statistics Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>👥 Total Siswa</h3>
                <div class="stat-number"><?php echo $total_students; ?></div>
                <p>Siswa terdaftar</p>
            </div>
            
            <div class="dashboard-card">
                <h3>✅ Partisipasi</h3>
                <div class="stat-number"><?php echo $students_participated; ?></div>
                <p>Siswa berpartisipasi</p>
            </div>
            
            <div class="dashboard-card">
                <h3>📊 Tingkat Partisipasi</h3>
                <div class="stat-number">
                    <?php echo $total_students > 0 ? round(($students_participated / $total_students) * 100) : 0; ?>%
                </div>
                <p>Dari total siswa</p>
            </div>
            
            <div class="dashboard-card">
                <h3>⭐ Minat Keseluruhan</h3>
                <div class="stat-number">
                    <?php echo isset($overall_stats['overall_avg']) ? number_format($overall_stats['overall_avg'], 2) : '0.00'; ?>
                </div>
                <p>Rata-rata (skala 1-5)</p>
            </div>
        </div>
        
        <?php if (!empty($category_stats)): ?>
            <!-- Category Statistics Chart -->
            <div class="card" style="margin-top: 30px; background-color: var(--gray-50);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    📊 Minat Siswa per Kategori
                </h3>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            
            <!-- Detailed Category Statistics -->
            <div class="card" style="margin-top: 30px;">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    📋 Detail Minat per Kategori
                </h3>
                
                <?php foreach ($category_stats as $index => $stat): ?>
                    <div style="background: var(--white); border: 2px solid var(--lightest-blue); padding: 20px; margin: 15px 0; border-radius: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <div>
                                <h4 style="color: var(--primary-blue); margin-bottom: 5px;">
                                    <?php echo htmlspecialchars($stat['category_name']); ?>
                                </h4>
                                <p style="color: var(--gray-600); margin: 0;">
                                    <?php echo htmlspecialchars($stat['description']); ?>
                                </p>
                            </div>
                            <div style="text-align: center; min-width: 120px;">
                                <div style="font-size: 2.5rem; font-weight: 700; color: var(--secondary-blue);">
                                    <?php echo number_format($stat['avg_response'], 2); ?>
                                </div>
                                <div style="font-size: 0.9rem; color: var(--gray-600);">
                                    dari 5.00
                                </div>
                            </div>
                        </div>
                        
                        <div class="progress-bar" style="height: 25px;">
                            <?php
                            $percentage = ($stat['avg_response'] / 5) * 100;
                            ?>
                            <div class="progress-fill" style="width: <?php echo $percentage; ?>%;">
                                <?php echo round($percentage); ?>%
                            </div>
                        </div>
                        
                        <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <div style="color: var(--gray-600); font-size: 0.9rem;">
                                <?php echo $stat['total_respondents']; ?> siswa berpartisipasi
                            </div>
                            <div style="font-weight: 600;">
                                <?php
                                $avg = $stat['avg_response'];
                                if ($avg >= 4.5) echo '<span style="color: #10b981;">🟢 Sangat Tinggi</span>';
                                elseif ($avg >= 3.5) echo '<span style="color: #3b82f6;">🔵 Tinggi</span>';
                                elseif ($avg >= 2.5) echo '<span style="color: #f59e0b;">🟡 Sedang</span>';
                                elseif ($avg >= 1.5) echo '<span style="color: #f97316;">🟠 Rendah</span>';
                                else echo '<span style="color: #ef4444;">🔴 Sangat Rendah</span>';
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Radar Chart -->
            <div class="card" style="margin-top: 30px; background-color: var(--gray-50);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    🎯 Profil Minat Keseluruhan
                </h3>
                <div class="chart-container">
                    <canvas id="radarChart"></canvas>
                </div>
            </div>
            
            <!-- Key Insights -->
            <div class="card" style="margin-top: 30px; background: linear-gradient(135deg, var(--lightest-blue) 0%, var(--white) 100%);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    💡 Temuan Utama
                </h3>
                
                <?php
                // Find highest and lowest interest
                $max_category = null;
                $min_category = null;
                $max_avg = 0;
                $min_avg = 6;
                
                foreach ($category_stats as $stat) {
                    if ($stat['avg_response'] > $max_avg) {
                        $max_avg = $stat['avg_response'];
                        $max_category = $stat['category_name'];
                    }
                    if ($stat['avg_response'] < $min_avg) {
                        $min_avg = $stat['avg_response'];
                        $min_category = $stat['category_name'];
                    }
                }
                ?>
                
                <div style="background: var(--white); padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid var(--success);">
                    <h4 style="color: var(--success); margin-bottom: 10px;">🔝 Minat Tertinggi</h4>
                    <p style="margin: 0; font-size: 1.1rem;">
                        <strong><?php echo htmlspecialchars($max_category); ?></strong> dengan rata-rata 
                        <strong style="color: var(--secondary-blue);"><?php echo number_format($max_avg, 2); ?></strong>
                    </p>
                </div>
                
                <div style="background: var(--white); padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 4px solid var(--warning);">
                    <h4 style="color: var(--warning); margin-bottom: 10px;">📉 Minat Terendah</h4>
                    <p style="margin: 0; font-size: 1.1rem;">
                        <strong><?php echo htmlspecialchars($min_category); ?></strong> dengan rata-rata 
                        <strong style="color: var(--secondary-blue);"><?php echo number_format($min_avg, 2); ?></strong>
                    </p>
                </div>
                
                <div style="background: var(--white); padding: 20px; border-radius: 10px; border-left: 4px solid var(--secondary-blue);">
                    <h4 style="color: var(--secondary-blue); margin-bottom: 10px;">📊 Tingkat Partisipasi</h4>
                    <p style="margin: 0; font-size: 1.1rem;">
                        <?php 
                        $participation_rate = $total_students > 0 ? ($students_participated / $total_students) * 100 : 0;
                        ?>
                        <strong><?php echo round($participation_rate); ?>%</strong> siswa telah berpartisipasi dalam survei
                        <?php if ($participation_rate >= 80): ?>
                            - tingkat partisipasi sangat baik! 🎉
                        <?php elseif ($participation_rate >= 60): ?>
                            - tingkat partisipasi baik.
                        <?php elseif ($participation_rate >= 40): ?>
                            - tingkat partisipasi cukup baik.
                        <?php else: ?>
                            - perlu meningkatkan partisipasi siswa.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            
            <!-- Recommendations -->
            <div class="card" style="margin-top: 30px;">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    📝 Rekomendasi
                </h3>
                
                <ul style="margin-left: 20px; line-height: 1.8;">
                    <?php if ($max_avg >= 4.0): ?>
                    <li>Manfaatkan minat tinggi siswa pada <strong><?php echo htmlspecialchars($max_category); ?></strong> dengan program khusus dan kegiatan terkait.</li>
                    <?php endif; ?>
                    
                    <?php if ($min_avg < 3.0): ?>
                    <li>Tingkatkan awareness dan promosi terkait <strong><?php echo htmlspecialchars($min_category); ?></strong> melalui workshop atau seminar.</li>
                    <?php endif; ?>
                    
                    <?php if ($participation_rate < 80): ?>
                    <li>Tingkatkan partisipasi siswa dalam survei untuk mendapatkan data yang lebih representatif.</li>
                    <?php endif; ?>
                    
                    <li>Pertimbangkan kerjasama dengan institusi Jepang untuk program pertukaran atau magang.</li>
                    <li>Kembangkan kurikulum yang mengintegrasikan aspek-aspek budaya dan bahasa Jepang.</li>
                    <li>Sediakan pelatihan bahasa Jepang dan persiapan JLPT untuk siswa yang berminat.</li>
                </ul>
            </div>
        <?php else: ?>
            <div class="alert alert-info" style="margin-top: 20px;">
                <strong>Info:</strong> Belum ada data yang tersedia. Data akan muncul setelah siswa mulai mengisi kuesioner.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($category_stats)): ?>
<script>
// Bar Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($category_stats, 'category_name')); ?>,
        datasets: [{
            label: 'Rata-rata Minat',
            data: <?php echo json_encode(array_column($category_stats, 'avg_response')); ?>,
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(96, 165, 250, 0.8)',
                'rgba(147, 197, 253, 0.8)',
                'rgba(30, 58, 138, 0.8)'
            ],
            borderColor: [
                'rgba(59, 130, 246, 1)',
                'rgba(96, 165, 250, 1)',
                'rgba(147, 197, 253, 1)',
                'rgba(30, 58, 138, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 5,
                ticks: {
                    stepSize: 1
                },
                title: {
                    display: true,
                    text: 'Skala Likert (1-5)'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Minat Siswa SMK Yos Sudarso Kawunganten Terhadap Jepang',
                font: {
                    size: 16
                }
            }
        }
    }
});

// Radar Chart
const radarCtx = document.getElementById('radarChart').getContext('2d');
const radarChart = new Chart(radarCtx, {
    type: 'radar',
    data: {
        labels: <?php echo json_encode(array_column($category_stats, 'category_name')); ?>,
        datasets: [{
            label: 'Minat Siswa',
            data: <?php echo json_encode(array_column($category_stats, 'avg_response')); ?>,
            backgroundColor: 'rgba(59, 130, 246, 0.2)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 2,
            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgba(59, 130, 246, 1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                beginAtZero: true,
                max: 5,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Profil Minat Keseluruhan',
                font: {
                    size: 16
                }
            }
        }
    }
});
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
