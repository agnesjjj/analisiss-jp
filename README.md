# Sistem Informasi Minat Generasi Muda Terhadap Jepang

Sistem informasi berbasis web untuk menganalisis minat siswa SMK Yos Sudarso Kawunganten terhadap Jepang, meliputi budaya, pendidikan, pekerjaan, dan bahasa Jepang.

## 🌟 Fitur Utama

### Untuk Siswa
- ✅ Registrasi dan login
- 📝 Pengisian biodata lengkap
- 📊 Kuesioner dengan skala Likert (1-5)
- 📈 Tracking progress pengisian

### Untuk Admin
- 🎛️ Dashboard statistik
- 📋 Manajemen pertanyaan (CRUD)
- 📊 Visualisasi data dengan grafik (Chart.js)
- 📥 Ekspor laporan ke CSV
- 📈 Analisis hasil per kategori

### Untuk Stakeholder
- 👔 Dashboard analisis komprehensif
- 📊 Grafik dan visualisasi interaktif
- 💡 Temuan dan rekomendasi otomatis
- 📈 Radar chart profil minat

## 🎯 Kategori Kuesioner

1. **Budaya Jepang** - Anime, manga, tradisi, makanan, festival
2. **Pendidikan di Jepang** - Universitas, beasiswa, sistem pendidikan
3. **Bekerja di Jepang** - Magang, karir, budaya kerja
4. **Bahasa Jepang** - Pembelajaran, praktik, ujian JLPT

## 🚀 Instalasi

### Persyaratan Sistem
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx dengan mod_rewrite
- Browser modern (Chrome, Firefox, Edge, Safari)

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/agnesjjj/analisiss-jp.git
   cd analisiss-jp
   ```

2. **Konfigurasi Database**
   - Buat database MySQL:
     ```sql
     CREATE DATABASE analisiss_jp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
     ```
   
   - Import schema database:
     ```bash
     mysql -u root -p analisiss_jp < config/init.sql
     ```
   
   - Edit konfigurasi database di `index.php` (baris 5-8):
     ```php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'analisiss_jp');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     ```

3. **Konfigurasi Web Server**
   
   **Apache:**
   - Pastikan mod_rewrite aktif
   - File `.htaccess` sudah disediakan
   
   **Nginx:**
   ```nginx
   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }
   ```

4. **Set Permissions**
   ```bash
   chmod -R 755 .
   ```

5. **Akses Aplikasi**
   - Buka browser dan akses: `http://localhost/analisiss-jp`

## 👤 Login Akun Default

### Admin
- **Username:** `admin`
- **Password:** `admin123`

**Catatan:** Segera ganti password default setelah login pertama kali!

## 📱 Fitur Responsif

Website ini menggunakan desain responsif yang mendukung:
- 💻 Desktop
- 📱 Tablet
- 📱 Mobile

## 🎨 Tema Design

- **Warna Utama:** Biru-Putih (edukatif)
- **Font:** Segoe UI, sistem default
- **Framework CSS:** Custom CSS dengan variabel CSS
- **Chart Library:** Chart.js v3

## 📊 Skala Likert

Sistem menggunakan skala Likert 5 poin:

1. ⭐ Sangat Tidak Setuju
2. ⭐⭐ Tidak Setuju
3. ⭐⭐⭐ Netral
4. ⭐⭐⭐⭐ Setuju
5. ⭐⭐⭐⭐⭐ Sangat Setuju

## 📂 Struktur Direktori

```
analisiss-jp/
├── config/
│   ├── database.php      # Konfigurasi database
│   └── init.sql          # Schema database
├── controllers/
│   ├── AuthController.php
│   ├── StudentController.php
│   ├── AdminController.php
│   └── StakeholderController.php
├── views/
│   ├── layouts/
│   │   └── main.php
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── questions.php
│   │   └── reports.php
│   ├── student/
│   │   ├── dashboard.php
│   │   ├── biodata.php
│   │   └── questionnaire.php
│   ├── stakeholder/
│   │   └── dashboard.php
│   ├── home.php
│   ├── login.php
│   ├── register.php
│   └── 404.php
├── public/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   └── images/
├── index.php             # Router utama
├── .htaccess            # Apache rewrite rules
└── README.md
```

## 🔒 Keamanan

- ✅ Password di-hash menggunakan `password_hash()`
- ✅ Prepared statements untuk mencegah SQL injection
- ✅ Session-based authentication
- ✅ HTML escaping untuk mencegah XSS
- ✅ Role-based access control

## 📈 Fitur Analisis

### Grafik yang Tersedia:
1. **Bar Chart** - Rata-rata per kategori
2. **Horizontal Bar Chart** - Detail per pertanyaan
3. **Radar Chart** - Profil minat keseluruhan
4. **Progress Bar** - Visualisasi persentase

### Laporan CSV:
- Header: Kategori, Pertanyaan, Rata-rata, Total Respon, Distribusi (1-5)
- Encoding: UTF-8 dengan BOM (kompatibel Excel)
- Format: CSV standar

## 🛠️ Troubleshooting

### Database Connection Error
- Periksa kredensial database di `index.php`
- Pastikan MySQL service running
- Cek apakah database sudah dibuat

### 404 Error
- Pastikan mod_rewrite aktif (Apache)
- Cek `.htaccess` file ada
- Verifikasi URL rewrite configuration

### Blank Page
- Enable error reporting di PHP
- Cek PHP error log
- Pastikan semua file ada

## 📞 Support

Untuk pertanyaan atau masalah, silakan buka issue di repository GitHub.

## 📄 Lisensi

Project ini dibuat untuk SMK Yos Sudarso Kawunganten sebagai sistem informasi analisis minat siswa terhadap Jepang.

## 👨‍💻 Pengembangan

Sistem ini dikembangkan menggunakan:
- **Backend:** PHP Native (OOP)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Chart Library:** Chart.js
- **Design Pattern:** MVC (Model-View-Controller)

---

Made with ❤️ for SMK Yos Sudarso Kawunganten