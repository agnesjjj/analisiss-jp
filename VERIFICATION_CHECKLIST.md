# ✅ INSTALLATION VERIFICATION CHECKLIST

Use this checklist to verify your installation is complete and working.

## Pre-Installation Checks

- [ ] PHP 7.4+ installed
- [ ] MySQL 5.7+ installed
- [ ] Apache/Nginx with mod_rewrite enabled
- [ ] Web browser (Chrome, Firefox, Edge, or Safari)
- [ ] Git installed (if cloning from GitHub)

## Installation Steps

### Step 1: Download/Clone Repository
- [ ] Repository cloned or downloaded
- [ ] Files extracted to web directory
- [ ] Directory permissions set (chmod 755)

### Step 2: Database Setup
- [ ] MySQL server is running
- [ ] Database `analisiss_jp` created
- [ ] Schema imported from `config/init.sql`
- [ ] No SQL errors during import
- [ ] 5 tables created (users, biodata, categories, questions, responses)
- [ ] Sample data loaded (4 categories, 20 questions, 1 admin user)

### Step 3: Configuration
- [ ] `index.php` edited with database credentials
- [ ] DB_HOST configured correctly
- [ ] DB_NAME set to 'analisiss_jp'
- [ ] DB_USER set to your MySQL username
- [ ] DB_PASS set to your MySQL password

### Step 4: Web Server Setup
- [ ] `.htaccess` file present (for Apache)
- [ ] mod_rewrite enabled (Apache users)
- [ ] URL rewriting configured (Nginx users)
- [ ] Directory accessible via web browser

## Functional Tests

### Test 1: Homepage Access
- [ ] Navigate to homepage (http://localhost/analisiss-jp)
- [ ] Page loads without errors
- [ ] Header displays: "Sistem Informasi Minat Generasi Muda Terhadap Jepang"
- [ ] Blue-white theme visible
- [ ] "Masuk" and "Daftar Siswa" buttons present
- [ ] Footer displays: "SMK Yos Sudarso Kawunganten"

### Test 2: Demo Page
- [ ] Access demo.html directly
- [ ] All sections visible
- [ ] Sample chart displays
- [ ] Likert scale interactive (radio buttons work)
- [ ] Color palette displayed correctly

### Test 3: Admin Login
- [ ] Click "Masuk" button
- [ ] Login page loads
- [ ] Enter username: `admin`
- [ ] Enter password: `admin123`
- [ ] Click "Masuk" button
- [ ] Redirects to admin dashboard
- [ ] No errors displayed
- [ ] Navigation menu shows: Dashboard, Kelola Pertanyaan, Laporan

### Test 4: Admin Dashboard
- [ ] Statistics cards display correctly
- [ ] Shows "Total Siswa" count (should be 0 initially)
- [ ] Shows "Total Pertanyaan" count (should be 20)
- [ ] Menu links work
- [ ] No console errors (press F12)

### Test 5: Question Management
- [ ] Navigate to "Kelola Pertanyaan"
- [ ] Table displays 20 questions
- [ ] Questions grouped by 4 categories
- [ ] "Tambah Pertanyaan Baru" button works
- [ ] Modal opens for adding question
- [ ] Can select category from dropdown
- [ ] Edit button works for existing questions
- [ ] Toggle button changes active status
- [ ] Delete button works (with confirmation)

### Test 6: Student Registration
- [ ] Logout from admin account
- [ ] Click "Daftar Siswa" on homepage
- [ ] Registration form loads
- [ ] Fill in all fields:
  - [ ] Nama Lengkap: "Test Student"
  - [ ] Username: "student1"
  - [ ] Password: "password123"
  - [ ] Konfirmasi Password: "password123"
- [ ] Click "Daftar" button
- [ ] Success message appears
- [ ] Redirects to login page

### Test 7: Student Login & Dashboard
- [ ] Login as student (student1/password123)
- [ ] Student dashboard loads
- [ ] Shows biodata status (Belum diisi)
- [ ] Shows kuesioner progress (0%)
- [ ] Navigation menu shows: Dashboard, Biodata, Kuesioner

### Test 8: Biodata Form
- [ ] Click "Isi Biodata"
- [ ] Form loads with all fields
- [ ] Fill in required fields:
  - [ ] NIS: "12345"
  - [ ] Kelas: Select "X"
  - [ ] Jurusan: "Teknik Komputer"
  - [ ] Jenis Kelamin: Select "Laki-laki"
  - [ ] Tanggal Lahir: Select date
  - [ ] Alamat: "Test Address"
  - [ ] No Telepon: "081234567890"
- [ ] Click "Simpan Biodata"
- [ ] Success message appears
- [ ] Redirects to dashboard
- [ ] Biodata status shows "Sudah diisi"

### Test 9: Questionnaire
- [ ] Click "Mulai Kuesioner"
- [ ] All 4 categories displayed:
  - [ ] Budaya Jepang
  - [ ] Pendidikan di Jepang
  - [ ] Bekerja di Jepang
  - [ ] Bahasa Jepang
- [ ] Each category shows 5 questions
- [ ] Total 20 questions visible
- [ ] Likert scale (1-5) for each question
- [ ] Radio buttons work properly
- [ ] Answer all 20 questions
- [ ] Click "Simpan Jawaban"
- [ ] Success message appears
- [ ] Progress shows 100%

### Test 10: Admin Reports
- [ ] Logout and login as admin
- [ ] Navigate to "Laporan"
- [ ] Statistics table displays
- [ ] Shows data for answered questions
- [ ] Bar chart renders correctly
- [ ] Category averages visible
- [ ] Detail charts for each category
- [ ] All data matches submitted responses

### Test 11: CSV Export
- [ ] On reports page, click "Ekspor Laporan (CSV)"
- [ ] File downloads automatically
- [ ] Open CSV in Excel/Notepad
- [ ] Headers are present and correct
- [ ] Data rows contain survey responses
- [ ] UTF-8 encoding (Indonesian characters display correctly)

### Test 12: Stakeholder Access
- [ ] Create stakeholder account (via MySQL):
  ```sql
  INSERT INTO users (username, password, name, role) 
  VALUES ('stakeholder1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Stakeholder Test', 'stakeholder');
  ```
- [ ] Login as stakeholder1/admin123
- [ ] Stakeholder dashboard loads
- [ ] Statistics cards display
- [ ] Category analysis shown
- [ ] Bar chart renders
- [ ] Radar chart renders
- [ ] Key findings displayed
- [ ] Recommendations shown

### Test 13: Responsive Design
- [ ] Resize browser to tablet width (768px)
- [ ] Layout adjusts properly
- [ ] Navigation remains functional
- [ ] Resize to mobile width (480px)
- [ ] Menu stacks vertically
- [ ] Likert scale stacks vertically
- [ ] All buttons remain clickable
- [ ] Text is readable

### Test 14: Chart.js Functionality
- [ ] All charts load from CDN
- [ ] No console errors for Chart.js
- [ ] Charts are interactive (hover shows values)
- [ ] Charts are responsive (resize with window)
- [ ] Colors match blue theme

### Test 15: Security Tests
- [ ] Try accessing /admin/dashboard without login → Redirects to login
- [ ] Try accessing /student/dashboard as admin → Redirects appropriately
- [ ] Password not visible in page source
- [ ] Sessions expire after logout
- [ ] SQL injection attempts blocked (try: `admin' OR '1'='1`)
- [ ] XSS attempts blocked (try: `<script>alert('XSS')</script>`)

## Performance Checks

- [ ] Homepage loads in < 2 seconds
- [ ] Dashboard loads in < 3 seconds
- [ ] Questionnaire page loads in < 3 seconds
- [ ] Report generation completes in < 5 seconds
- [ ] CSV export downloads immediately
- [ ] No memory errors in browser console
- [ ] No PHP errors in server logs

## Browser Compatibility

Test in multiple browsers:
- [ ] Google Chrome (latest)
- [ ] Mozilla Firefox (latest)
- [ ] Microsoft Edge (latest)
- [ ] Safari (if on Mac)
- [ ] Mobile browsers (Chrome/Safari mobile)

## Final Verification

- [ ] All features work as expected
- [ ] No error messages displayed
- [ ] All navigation links work
- [ ] Data persists after logout/login
- [ ] System is production-ready
- [ ] Documentation files are readable
- [ ] README.md instructions are clear

---

## If Any Test Fails

Refer to troubleshooting sections in:
1. **SETUP.md** - Installation issues
2. **DOCUMENTATION.md** - Technical details
3. **README.md** - General overview

## Support

If issues persist:
1. Check PHP error log: `/var/log/apache2/error.log` (Linux) or `C:\xampp\apache\logs\error.log` (Windows)
2. Check MySQL error log
3. Enable PHP error display: `ini_set('display_errors', 1);`
4. Open GitHub issue with error details

---

## ✅ Verification Complete!

Once all checkboxes are checked, your system is fully operational and ready for production use.

**Congratulations! The system is ready to serve SMK Yos Sudarso Kawunganten students.**

🎉 **SISTEM SIAP DIGUNAKAN!** 🎉
