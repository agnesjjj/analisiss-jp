# Panduan Instalasi dan Setup
# Sistem Informasi Minat Generasi Muda Terhadap Jepang
# SMK Yos Sudarso Kawunganten

## LANGKAH 1: Setup Database

1. Buka MySQL/phpMyAdmin
2. Jalankan perintah berikut:

```sql
CREATE DATABASE analisiss_jp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Import database schema:
```bash
mysql -u root -p analisiss_jp < config/init.sql
```

Atau melalui phpMyAdmin:
- Pilih database `analisiss_jp`
- Klik tab "Import"
- Pilih file `config/init.sql`
- Klik "Go"

## LANGKAH 2: Konfigurasi Database

Edit file `index.php` baris 5-8, sesuaikan dengan konfigurasi database Anda:

```php
define('DB_HOST', 'localhost');     // Host database
define('DB_NAME', 'analisiss_jp');  // Nama database
define('DB_USER', 'root');          // Username MySQL
define('DB_PASS', '');              // Password MySQL
```

## LANGKAH 3: Konfigurasi Web Server

### Menggunakan Apache:
1. Pastikan mod_rewrite sudah aktif
2. File `.htaccess` sudah tersedia (tidak perlu diubah)
3. Pastikan AllowOverride diset ke All di konfigurasi Apache

### Menggunakan Nginx:
Tambahkan konfigurasi berikut di server block:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```

### Menggunakan PHP Built-in Server (untuk development):
```bash
php -S localhost:8000
```
Akses di: http://localhost:8000

## LANGKAH 4: Set Permissions

```bash
chmod -R 755 /path/to/analisiss-jp
```

## LANGKAH 5: Akses Aplikasi

1. Buka browser
2. Akses URL sesuai konfigurasi web server Anda, misalnya:
   - http://localhost/analisiss-jp
   - http://localhost:8000 (jika menggunakan PHP built-in server)

## LANGKAH 6: Login Pertama Kali

### Akun Admin Default:
- **Username:** admin
- **Password:** admin123

**PENTING:** Segera ganti password admin setelah login pertama!

## LANGKAH 7: Penggunaan Sistem

### Untuk Siswa:
1. Klik "Daftar Siswa" di halaman utama
2. Isi form registrasi
3. Login dengan username dan password yang dibuat
4. Isi biodata
5. Lengkapi kuesioner

### Untuk Admin:
1. Login dengan akun admin
2. Kelola pertanyaan di menu "Kelola Pertanyaan"
3. Lihat laporan dan grafik di menu "Laporan"
4. Ekspor data ke CSV jika diperlukan

### Untuk Stakeholder:
1. Minta admin untuk membuatkan akun stakeholder
2. Login dengan akun yang diberikan
3. Lihat dashboard analisis dan rekomendasi

## TROUBLESHOOTING

### Error: "Database connection failed"
- Pastikan MySQL service running
- Cek kredensial database di `index.php`
- Pastikan database `analisiss_jp` sudah dibuat

### Error: "404 Not Found"
- Pastikan mod_rewrite aktif (Apache)
- Cek file `.htaccess` ada dan readable
- Verifikasi DocumentRoot mengarah ke folder yang benar

### Halaman Blank/White Screen
- Enable error reporting di PHP: `error_reporting(E_ALL);`
- Cek PHP error log
- Pastikan semua file PHP tidak ada syntax error

### Chart tidak muncul
- Pastikan koneksi internet aktif (Chart.js dimuat dari CDN)
- Buka browser console (F12) untuk cek error JavaScript

### Data tidak tersimpan
- Cek koneksi database
- Pastikan tabel sudah dibuat dengan benar
- Verifikasi user memiliki permission yang tepat

## FITUR TAMBAHAN

### Membuat Akun Stakeholder:
Jalankan query SQL berikut di MySQL:

```sql
INSERT INTO users (username, password, name, role) 
VALUES ('stakeholder1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nama Stakeholder', 'stakeholder');
```

Password default: `admin123` (segera ganti setelah login)

### Backup Database:
```bash
mysqldump -u root -p analisiss_jp > backup_analisiss_jp_$(date +%Y%m%d).sql
```

### Restore Database:
```bash
mysql -u root -p analisiss_jp < backup_analisiss_jp_YYYYMMDD.sql
```

## KONTAK SUPPORT

Jika mengalami masalah dalam instalasi atau penggunaan sistem, silakan hubungi:
- Email: support@example.com
- GitHub Issues: https://github.com/agnesjjj/analisiss-jp/issues

---

Terima kasih telah menggunakan Sistem Informasi Minat Generasi Muda Terhadap Jepang!
