<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Sistem Informasi Minat Jepang'; ?> - SMK Yos Sudarso</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <header>
        <div class="header-content">
            <div class="logo">
                <h1>🗾 Sistem Informasi Minat Generasi Muda Terhadap Jepang</h1>
                <p>SMK Yos Sudarso Kawunganten</p>
            </div>
            <nav>
                <ul>
                    <?php if ($_SESSION['role'] === 'student'): ?>
                        <li><a href="/student/dashboard">Dashboard</a></li>
                        <li><a href="/student/biodata">Biodata</a></li>
                        <li><a href="/student/questionnaire">Kuesioner</a></li>
                    <?php elseif ($_SESSION['role'] === 'admin'): ?>
                        <li><a href="/admin/dashboard">Dashboard</a></li>
                        <li><a href="/admin/questions">Kelola Pertanyaan</a></li>
                        <li><a href="/admin/reports">Laporan</a></li>
                    <?php elseif ($_SESSION['role'] === 'stakeholder'): ?>
                        <li><a href="/stakeholder/dashboard">Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="/logout">Keluar (<?php echo htmlspecialchars($_SESSION['name']); ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php endif; ?>
    
    <main>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="container">
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="container">
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php echo $content ?? ''; ?>
    </main>
    
    <?php if (!isset($hideFooter) || !$hideFooter): ?>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> SMK Yos Sudarso Kawunganten - Sistem Informasi Minat Generasi Muda Terhadap Jepang</p>
    </footer>
    <?php endif; ?>
</body>
</html>
