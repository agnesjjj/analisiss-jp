<?php
$title = 'Laporan & Analisis';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>📈 Laporan & Analisis Minat Terhadap Jepang</h2>
        </div>
        
        <div style="margin-bottom: 20px;">
            <a href="/admin/reports?export=csv" class="btn btn-success">📥 Ekspor Laporan (CSV)</a>
            <a href="/admin/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        
        <?php if (empty($category_averages)): ?>
            <div class="alert alert-info">
                Belum ada data untuk ditampilkan. Tunggu hingga siswa mulai mengisi kuesioner.
            </div>
        <?php else: ?>
            <!-- Category Average Chart -->
            <div class="card" style="background-color: var(--gray-50);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    📊 Rata-rata Minat per Kategori
                </h3>
                <div class="chart-container">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
            
            <!-- Detailed Statistics by Category -->
            <?php foreach ($data_by_category as $category): ?>
                <div class="card" style="margin-top: 30px;">
                    <div class="category-badge" style="font-size: 1.1rem;">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 45%;">Pertanyaan</th>
                                <th style="width: 10%;">Rata-rata</th>
                                <th style="width: 10%;">Respon</th>
                                <th style="width: 30%;">Distribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category['questions'] as $index => $stat): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($stat['question_text']); ?></td>
                                <td>
                                    <strong style="color: var(--secondary-blue); font-size: 1.2rem;">
                                        <?php echo number_format($stat['avg_response'], 2); ?>
                                    </strong>
                                </td>
                                <td><?php echo $stat['total_responses']; ?></td>
                                <td>
                                    <div style="display: flex; gap: 5px; font-size: 0.85rem;">
                                        <span title="Sangat Tidak Setuju">1: <?php echo $stat['count_1']; ?></span>
                                        <span title="Tidak Setuju">2: <?php echo $stat['count_2']; ?></span>
                                        <span title="Netral">3: <?php echo $stat['count_3']; ?></span>
                                        <span title="Setuju">4: <?php echo $stat['count_4']; ?></span>
                                        <span title="Sangat Setuju">5: <?php echo $stat['count_5']; ?></span>
                                    </div>
                                    <?php if ($stat['total_responses'] > 0): ?>
                                    <div class="progress-bar" style="height: 20px; margin-top: 5px;">
                                        <?php
                                        $percentage = ($stat['avg_response'] / 5) * 100;
                                        ?>
                                        <div class="progress-fill" style="width: <?php echo $percentage; ?>%;"></div>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- Bar chart for this category -->
                    <div style="margin-top: 20px;">
                        <h4 style="color: var(--primary-blue); margin-bottom: 15px;">
                            Grafik Detail: <?php echo htmlspecialchars($category['name']); ?>
                        </h4>
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="chart_<?php echo $category['questions'][0]['category_id']; ?>"></canvas>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <!-- Summary Statistics -->
            <div class="card" style="margin-top: 30px; background: linear-gradient(135deg, var(--lightest-blue) 0%, var(--white) 100%);">
                <h3 style="color: var(--primary-blue); margin-bottom: 20px;">
                    📋 Ringkasan Analisis
                </h3>
                
                <div class="dashboard-grid">
                    <?php foreach ($category_averages as $cat_avg): ?>
                        <div style="background: var(--white); padding: 20px; border-radius: 10px; border-left: 4px solid var(--secondary-blue);">
                            <h4 style="color: var(--primary-blue); margin-bottom: 10px;">
                                <?php echo htmlspecialchars($cat_avg['category_name']); ?>
                            </h4>
                            <div style="font-size: 2rem; font-weight: 700; color: var(--secondary-blue);">
                                <?php echo number_format($cat_avg['avg_response'], 2); ?>
                            </div>
                            <div style="color: var(--gray-600); margin-top: 5px;">
                                <?php
                                $avg = $cat_avg['avg_response'];
                                if ($avg >= 4.5) echo '🟢 Sangat Tinggi';
                                elseif ($avg >= 3.5) echo '🔵 Tinggi';
                                elseif ($avg >= 2.5) echo '🟡 Sedang';
                                elseif ($avg >= 1.5) echo '🟠 Rendah';
                                else echo '🔴 Sangat Rendah';
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="alert alert-info" style="margin-top: 20px;">
                    <strong>Interpretasi Skala:</strong><br>
                    4.5 - 5.0 = Sangat Tinggi | 
                    3.5 - 4.4 = Tinggi | 
                    2.5 - 3.4 = Sedang | 
                    1.5 - 2.4 = Rendah | 
                    1.0 - 1.4 = Sangat Rendah
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($category_averages)): ?>
<script>
// Category Average Bar Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
const categoryChart = new Chart(categoryCtx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_column($category_averages, 'category_name')); ?>,
        datasets: [{
            label: 'Rata-rata Minat',
            data: <?php echo json_encode(array_column($category_averages, 'avg_response')); ?>,
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
            },
            x: {
                title: {
                    display: true,
                    text: 'Kategori'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: 'Rata-rata Minat Siswa per Kategori',
                font: {
                    size: 16
                }
            }
        }
    }
});

// Detail charts for each category
<?php foreach ($data_by_category as $category): ?>
{
    const ctx_<?php echo $category['questions'][0]['category_id']; ?> = document.getElementById('chart_<?php echo $category['questions'][0]['category_id']; ?>').getContext('2d');
    const chart_<?php echo $category['questions'][0]['category_id']; ?> = new Chart(ctx_<?php echo $category['questions'][0]['category_id']; ?>, {
        type: 'horizontalBar',
        data: {
            labels: <?php echo json_encode(array_map(function($q) { 
                return substr($q['question_text'], 0, 50) . (strlen($q['question_text']) > 50 ? '...' : '');
            }, $category['questions'])); ?>,
            datasets: [{
                label: 'Rata-rata',
                data: <?php echo json_encode(array_column($category['questions'], 'avg_response')); ?>,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
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
                }
            }
        }
    });
}
<?php endforeach; ?>
</script>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
