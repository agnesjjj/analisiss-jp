<?php
$title = 'Biodata Siswa';
ob_start();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>📝 Biodata Siswa</h2>
        </div>
        
        <form method="POST" action="/student/biodata">
            <div class="form-group">
                <label for="nis">NIS (Nomor Induk Siswa) *</label>
                <input type="text" id="nis" name="nis" class="form-control" 
                       value="<?php echo htmlspecialchars($biodata['nis'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="kelas">Kelas *</label>
                <select id="kelas" name="kelas" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    <option value="X" <?php echo ($biodata['kelas'] ?? '') === 'X' ? 'selected' : ''; ?>>X</option>
                    <option value="XI" <?php echo ($biodata['kelas'] ?? '') === 'XI' ? 'selected' : ''; ?>>XI</option>
                    <option value="XII" <?php echo ($biodata['kelas'] ?? '') === 'XII' ? 'selected' : ''; ?>>XII</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="jurusan">Jurusan *</label>
                <input type="text" id="jurusan" name="jurusan" class="form-control" 
                       value="<?php echo htmlspecialchars($biodata['jurusan'] ?? ''); ?>" 
                       placeholder="Contoh: Teknik Komputer dan Jaringan" required>
            </div>
            
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin *</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" <?php echo ($biodata['jenis_kelamin'] ?? '') === 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($biodata['jenis_kelamin'] ?? '') === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir *</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" 
                       value="<?php echo htmlspecialchars($biodata['tanggal_lahir'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat Lengkap *</label>
                <textarea id="alamat" name="alamat" class="form-control" required><?php echo htmlspecialchars($biodata['alamat'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="no_telepon">Nomor Telepon/HP *</label>
                <input type="tel" id="no_telepon" name="no_telepon" class="form-control" 
                       value="<?php echo htmlspecialchars($biodata['no_telepon'] ?? ''); ?>" 
                       placeholder="Contoh: 081234567890" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="<?php echo htmlspecialchars($biodata['email'] ?? ''); ?>" 
                       placeholder="Contoh: nama@email.com">
            </div>
            
            <div style="display: flex; gap: 15px; margin-top: 25px;">
                <button type="submit" class="btn btn-primary">Simpan Biodata</button>
                <a href="/student/dashboard" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/main.php';
?>
