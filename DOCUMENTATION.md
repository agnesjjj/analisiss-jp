# Dokumentasi Sistem Informasi Minat Generasi Muda Terhadap Jepang

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Fitur Sistem](#fitur-sistem)
3. [Arsitektur Sistem](#arsitektur-sistem)
4. [Pengguna dan Hak Akses](#pengguna-dan-hak-akses)
5. [Alur Kerja Sistem](#alur-kerja-sistem)
6. [Database Schema](#database-schema)
7. [API & Routing](#api--routing)
8. [Keamanan](#keamanan)
9. [Visualisasi Data](#visualisasi-data)

---

## Pendahuluan

Sistem Informasi Minat Generasi Muda Terhadap Jepang adalah aplikasi web yang dirancang untuk menganalisis minat siswa SMK Yos Sudarso Kawunganten terhadap berbagai aspek Jepang.

### Tujuan
- Mengumpulkan data minat siswa terhadap Jepang
- Menganalisis tren minat berdasarkan kategori
- Menyediakan visualisasi data untuk pengambilan keputusan
- Mendukung perencanaan program pendidikan terkait Jepang

### Kategori Analisis
1. **Budaya Jepang** - Anime, manga, tradisi, kuliner, festival
2. **Pendidikan di Jepang** - Universitas, beasiswa, sistem pendidikan
3. **Bekerja di Jepang** - Magang, karir, budaya kerja
4. **Bahasa Jepang** - Pembelajaran, JLPT, komunikasi

---

## Fitur Sistem

### Fitur Siswa
- **Registrasi & Login**: Sistem autentikasi berbasis session
- **Manajemen Biodata**: Form lengkap untuk profil siswa
- **Kuesioner Interaktif**: Skala Likert 1-5 dengan UI yang intuitif
- **Progress Tracking**: Melihat progres pengisian kuesioner
- **Dashboard Personal**: Ringkasan status biodata dan kuesioner

### Fitur Admin
- **Dashboard Statistik**: Overview jumlah siswa dan partisipasi
- **Manajemen Pertanyaan**: CRUD (Create, Read, Update, Delete) pertanyaan
- **Kategori Management**: Organisasi pertanyaan berdasarkan kategori
- **Toggle Aktif/Nonaktif**: Kontrol pertanyaan yang ditampilkan
- **Laporan Komprehensif**: Analisis detail per kategori dan pertanyaan
- **Visualisasi Grafik**: Bar chart, horizontal bar chart
- **Ekspor CSV**: Download laporan dalam format CSV

### Fitur Stakeholder
- **Dashboard Analisis**: View-only untuk melihat hasil
- **Grafik Interaktif**: Bar chart dan radar chart
- **Temuan Utama**: Insight otomatis dari data
- **Rekomendasi**: Saran berbasis analisis data
- **Statistik Partisipasi**: Tingkat partisipasi siswa

---

## Arsitektur Sistem

### Technology Stack
- **Backend**: PHP 7.4+ (Native, OOP)
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Chart Library**: Chart.js v3
- **Design Pattern**: MVC (Model-View-Controller)

### Struktur Folder
```
analisiss-jp/
├── config/           # Konfigurasi database & schema
├── controllers/      # Business logic
├── views/           # Template & UI
│   ├── layouts/     # Layout template
│   ├── admin/       # Admin pages
│   ├── student/     # Student pages
│   └── stakeholder/ # Stakeholder pages
├── public/          # Assets (CSS, JS, images)
├── index.php        # Router utama
└── .htaccess       # URL rewriting
```

---

## Pengguna dan Hak Akses

### 1. Siswa (Student)
**Hak Akses:**
- Register akun baru
- Login/logout
- View & edit biodata pribadi
- Mengisi & update kuesioner
- View dashboard personal

**Pembatasan:**
- Tidak dapat melihat data siswa lain
- Tidak dapat mengelola pertanyaan
- Tidak dapat melihat laporan agregat

### 2. Admin
**Hak Akses:**
- Login/logout
- View semua data siswa
- CRUD pertanyaan kuesioner
- Toggle aktif/nonaktif pertanyaan
- View laporan & statistik
- Generate grafik
- Ekspor data ke CSV

**Akun Default:**
- Username: `admin`
- Password: `admin123` (harus diganti!)

### 3. Stakeholder
**Hak Akses:**
- Login/logout
- View dashboard analisis
- View grafik & statistik
- View temuan & rekomendasi

**Pembatasan:**
- Read-only access
- Tidak dapat mengelola data
- Tidak dapat ekspor data

---

## Alur Kerja Sistem

### Alur Siswa
1. Registrasi akun → Login
2. Isi biodata lengkap
3. Akses kuesioner
4. Jawab pertanyaan (skala 1-5)
5. Submit jawaban
6. Lihat progress di dashboard

### Alur Admin
1. Login dengan akun admin
2. Tambah/edit pertanyaan (opsional)
3. Monitor partisipasi siswa
4. Akses laporan & grafik
5. Analisis data per kategori
6. Ekspor laporan CSV

### Alur Stakeholder
1. Login dengan akun stakeholder
2. View dashboard analisis
3. Lihat grafik interaktif
4. Review temuan utama
5. Baca rekomendasi sistem

---

## Database Schema

### Tabel: users
```sql
id INT PRIMARY KEY AUTO_INCREMENT
username VARCHAR(50) UNIQUE
password VARCHAR(255) -- bcrypt hash
name VARCHAR(100)
role ENUM('student', 'admin', 'stakeholder')
created_at TIMESTAMP
updated_at TIMESTAMP
```

### Tabel: biodata
```sql
id INT PRIMARY KEY AUTO_INCREMENT
user_id INT FOREIGN KEY → users.id
nis VARCHAR(20)
kelas VARCHAR(20)
jurusan VARCHAR(50)
jenis_kelamin ENUM('Laki-laki', 'Perempuan')
tanggal_lahir DATE
alamat TEXT
no_telepon VARCHAR(20)
email VARCHAR(100)
created_at TIMESTAMP
updated_at TIMESTAMP
```

### Tabel: categories
```sql
id INT PRIMARY KEY AUTO_INCREMENT
name VARCHAR(100)
description TEXT
order_num INT
created_at TIMESTAMP
```

### Tabel: questions
```sql
id INT PRIMARY KEY AUTO_INCREMENT
category_id INT FOREIGN KEY → categories.id
question_text TEXT
order_num INT
is_active TINYINT(1)
created_at TIMESTAMP
updated_at TIMESTAMP
```

### Tabel: responses
```sql
id INT PRIMARY KEY AUTO_INCREMENT
user_id INT FOREIGN KEY → users.id
question_id INT FOREIGN KEY → questions.id
response_value INT CHECK (1-5)
created_at TIMESTAMP
updated_at TIMESTAMP
UNIQUE(user_id, question_id)
```

---

## API & Routing

### Public Routes
- `GET /` - Homepage
- `GET /login` - Login page
- `POST /login` - Process login
- `GET /register` - Registration page
- `POST /register` - Process registration
- `GET /logout` - Logout

### Student Routes (Auth Required)
- `GET /student/dashboard` - Student dashboard
- `GET /student/biodata` - Biodata form
- `POST /student/biodata` - Save biodata
- `GET /student/questionnaire` - Questionnaire
- `POST /student/questionnaire` - Save responses

### Admin Routes (Auth Required)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/questions` - Manage questions
- `POST /admin/questions` - Add/edit/delete question
- `GET /admin/reports` - View reports
- `GET /admin/reports?export=csv` - Export CSV

### Stakeholder Routes (Auth Required)
- `GET /stakeholder/dashboard` - Stakeholder dashboard

---

## Keamanan

### Autentikasi
- **Session-based authentication**
- Password hashing: `password_hash()` dengan bcrypt
- Session timeout management
- Role-based access control (RBAC)

### Proteksi Data
- **SQL Injection Prevention**: PDO prepared statements
- **XSS Prevention**: `htmlspecialchars()` untuk output
- **CSRF Protection**: Session validation
- **Input Validation**: Server-side validation

### Best Practices Implemented
- ✅ Passwords never stored in plain text
- ✅ Prepared statements untuk semua query
- ✅ Role middleware untuk authorization
- ✅ HTML escaping pada user input
- ✅ Session security headers

---

## Visualisasi Data

### Chart.js Implementation

#### 1. Bar Chart (Rata-rata per Kategori)
```javascript
type: 'bar'
data: Rata-rata response per kategori (1-5)
axes: x=Kategori, y=Skala Likert
```

#### 2. Horizontal Bar Chart (Detail Pertanyaan)
```javascript
type: 'horizontalBar'
data: Rata-rata per pertanyaan dalam kategori
axes: x=Skala, y=Pertanyaan
```

#### 3. Radar Chart (Profil Minat)
```javascript
type: 'radar'
data: Profil keseluruhan 4 kategori
scale: 0-5
```

### Interpretasi Skala
- **4.5 - 5.0**: 🟢 Sangat Tinggi
- **3.5 - 4.4**: 🔵 Tinggi
- **2.5 - 3.4**: 🟡 Sedang
- **1.5 - 2.4**: 🟠 Rendah
- **1.0 - 1.4**: 🔴 Sangat Rendah

### Metrik Analisis
- **Rata-rata (Average)**: Mean response value per kategori/pertanyaan
- **Distribusi**: Count untuk setiap nilai (1-5)
- **Partisipasi**: Jumlah siswa yang menjawab
- **Progress**: Persentase completion

---

## Troubleshooting Common Issues

### Database Connection Error
```
Error: Database connection failed
Solution: 
1. Cek MySQL service: sudo service mysql status
2. Verifikasi credentials di index.php
3. Pastikan database exists: SHOW DATABASES;
```

### 404 Not Found
```
Error: Page not found for all routes
Solution:
1. Enable mod_rewrite: sudo a2enmod rewrite
2. Check .htaccess exists and readable
3. Verify AllowOverride All in Apache config
```

### Charts Not Loading
```
Error: Charts don't appear
Solution:
1. Check internet connection (Chart.js from CDN)
2. Open browser console (F12) for JavaScript errors
3. Verify data format in Chart.js configuration
```

### CSV Export Issues
```
Error: CSV not downloading or corrupted
Solution:
1. Check headers sent before export function
2. Verify file permissions
3. Check UTF-8 BOM for Excel compatibility
```

---

## Maintenance & Updates

### Regular Maintenance
- **Backup database** mingguan
- **Monitor disk space** untuk log files
- **Update PHP** security patches
- **Review user accounts** untuk inactive users

### Scaling Considerations
- Pagination untuk large datasets
- Database indexing untuk performance
- Caching untuk frequently accessed data
- CDN untuk static assets

---

## Support & Contact

Untuk bantuan teknis, dokumentasi tambahan, atau pertanyaan:
- **GitHub**: https://github.com/agnesjjj/analisiss-jp
- **Issues**: https://github.com/agnesjjj/analisiss-jp/issues

---

*Dokumentasi ini dibuat untuk SMK Yos Sudarso Kawunganten*
*Last Updated: 2026*
