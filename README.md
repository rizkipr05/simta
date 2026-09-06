# SIMTA - Sistem Informasi Manajemen Tugas Akhir & Yudisium

**SIMTA (Sistem Informasi Manajemen Tugas Akhir)** adalah platform berbasis web yang dirancang khusus untuk mengelola dan mengotomatiskan seluruh siklus administrasi Tugas Akhir (Skripsi) dan Yudisium bagi perguruan tinggi (Studi Kasus: Fakultas Teknik Universitas Muhammadiyah Maluku Utara - FT UMMU).

Aplikasi ini mengintegrasikan seluruh pemangku kepentingan (*stakeholders*) — mulai dari Mahasiswa, Dosen Pembimbing, Dosen Penguji, Ketua Program Studi (Kaprodi), Dekan, hingga Pengelola Skripsi / Super Admin — dalam satu alur kerja digital yang transparan dan efisien.

---

## 🚀 Deskripsi & Fitur Utama

SIMTA mempermudah tata kelola akademis dari tahap pengajuan skripsi hingga pelaksanaan yudisium melalui fitur-fitur unggulan berikut:

### 📄 Alur Kerja Terintegrasi
1. **Pengajuan Judul & Skripsi**: Mahasiswa mengajukan draft proposal/judul skripsi secara online.
2. **Penetapan Pembimbing & Penerbitan SK**: Pengelola mengalokasikan Dosen Pembimbing I & II, lalu merilis **SK Pembimbing PDF** yang disetujui oleh Dekan secara sistem.
3. **Bimbingan Skripsi Online**: Proses bimbingan (Bab I hingga Bab V) secara interaktif dengan catatan dosen, status approval, dan fitur riwayat bimbingan.
4. **Penjadwalan & Pelaksanaan Ujian Sidang**:
   - Penjadwalan ujian sidang proposal/skripsi oleh Kaprodi/Pengelola.
   - Penunjukan tim Penguji (Ketua & Anggota) dan penerbitan **SK Penguji PDF** serta **Surat Undangan Sidang PDF**.
   - **Penilaian Online**: Dosen Penguji menginput komponen nilai secara langsung.
   - **Berita Acara Ujian PDF**: Otomatisasi kalkulasi nilai akhir, predikat lulus, dan cetak dokumen resmi Berita Acara.
5. **Lembar Pengesahan**: Mahasiswa mengunggah scan lembar pengesahan yang telah ditandatangani untuk diverifikasi oleh pengelola.
6. **Pendaftaran Yudisium**: Mahasiswa mendaftar periode yudisium aktif dan mengunggah berkas syarat yudisium untuk diverifikasi hingga dinyatakan *eligible*.

### 👥 Fitur Berdasarkan Peran (Multi-Role Support)
- **Super Admin**: Manajemen user, pengaturan master data (Prodi, Dosen, Mahasiswa, Tahun Akademik), audit log, dan setting aplikasi.
- **Pengelola Skripsi**: Verifikasi berkas, pembuatan SK Pembimbing/Penguji, pengelolaan jadwal ujian, dan rekapitulasi laporan.
- **Kaprodi (Ketua Program Studi)**: Monitoring statistik tugas akhir, penjadwalan ujian sidang, dan rekomendasi status mahasiswa.
- **Dekan**: Panel approval digital untuk penetapan SK Pembimbing dan SK Penguji.
- **Dosen**: Dashboard bimbingan skripsi, verifikasi bab, input nilai ujian sidang, dan repositori evidence.
- **Mahasiswa**: Tracking progress tugas akhir, pengajuan judul, pengajuan bimbingan online, pendaftaran yudisium, serta sistem notifikasi internal.

---

## 🛠️ Tech Stack (Teknologi yang Digunakan)

### Backend
- **PHP**: `>= 8.3`
- **Framework**: [Laravel 13.x](https://laravel.com)
- **Authentication**: [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
- **Authorization & RBAC**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) (`^8.3`)
- **PDF Generator**: [Laravel DomPDF](https://github.com/barryvdh/laravel-dompdf) (`^3.1`)

### Frontend
- **Templating**: Laravel Blade Engine
- **Styling / CSS**: [Tailwind CSS](https://tailwindcss.com) (`^3.1` & `@tailwindcss/vite ^4.0`)
- **Interaktivitas JS**: [Alpine.js](https://alpinejs.dev) (`^3.4`)
- **Icons & UI Accents**: Heroicons & SVG modern

### Database & Storage
- **Database**: SQLite (Default untuk lokal) / MySQL / MariaDB / PostgreSQL
- **Storage**: Local Disk with Laravel Public Storage Link

### Build Tools & Code Quality
- **Bundler**: [Vite 8](https://vitejs.dev) & `laravel-vite-plugin`
- **Code Formatter**: [Laravel Pint](https://laravel.com/docs/pint)
- **Dev Tools**: Laravel Boost, Laravel Pail, Concurrently

---

## 📋 Persyaratan Sistem (Prerequisites)

Sebelum menginstall projek ini, pastikan perangkat Anda telah memenuhi persyaratan berikut:

- **PHP**: `^8.3` dengan ekstensi aktif:
  - `pdo`, `pdo_sqlite` (atau `pdo_mysql`), `mbstring`, `openssl`, `xml`, `ctype`, `json`, `tokenizer`, `gd`, `fileinfo`
- **Composer**: `^2.x`
- **Node.js**: `^18.x` atau `^20.x`
- **NPM**: `^9.x` atau lebih baru
- **Git**

---

## 📥 Tutorial Cara Install Project

Ikuti langkah-langkah di bawah ini untuk menjalankan SIMTA di lingkungan lokal (*development*):

### 1. Clone Repository & Masuk ke Direktori
```bash
git clone https://github.com/rizkipr05/simta.git
cd simta
```

### 2. Salin File Environment
Buat file `.env` dari file konfigurasi sampel `.env.example`:
```bash
cp .env.example .env
```

### 3. Install Dependensi PHP via Composer
```bash
composer install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database

#### Menggunakan SQLite (Default / Paling Mudah):
Buat file `database.sqlite` di dalam folder `database/`:
```bash
touch database/database.sqlite
```
*Pastikan di file `.env` pengaturan database diset ke `DB_CONNECTION=sqlite`.*

#### Menggunakan MySQL / MariaDB (Opsional):
Jika ingin menggunakan MySQL, buka file `.env` dan sesuaikan nilainya:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simta_db
DB_USERNAME=root
DB_PASSWORD=
```
*Buat database `simta_db` di phpMyAdmin / MySQL CLI sebelum menjalankan langkah berikutnya.*

### 6. Jalankan Migrasi Database & Seeder Data Awal
Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data awal (termasuk akun uji coba untuk semua role):
```bash
php artisan migrate --seed
```

### 7. Buat Symbolic Link Storage
Gunakan perintah ini agar file dokumen / PDF yang diunggah dapat diakses oleh sistem:
```bash
php artisan storage:link
```

### 8. Install Dependensi Node.js & Compile Assets Frontend
```bash
npm install
npm run build
```

### 9. Jalankan Aplikasi
Anda dapat menjalankan server lokal dengan dua cara:

#### Cara 1: Standard Artisan Serve
```bash
php artisan serve
```
Buka browser dan akses: `http://127.0.0.1:8000`

#### Cara 2: Mode Pengembang (Vite Hot Reload + Artisan)
```bash
npm run dev
```
atau
```bash
composer run dev
```

---

## 🔑 Akun Uji Coba Default (Seeder Data)

Setelah menjalankan `php artisan migrate --seed`, Anda dapat menguji aplikasi menggunakan akun default berikut (Semua kata sandi adalah: `password`):

| Peran (Role) | Email | Password | Keterangan Status Data |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@simta.ac.id` | `password` | Akses penuh ke seluruh fitur & master data |
| **Pengelola Skripsi** | `pengelola@simta.ac.id` | `password` | Manajemen pengajuan skripsi, SK, & ujian |
| **Kaprodi (TI)** | `kaprodi@simta.ac.id` | `password` | Dr. Ahmad Fauzi, M.Kom. (Monitoring & Ujian) |
| **Dekan (FT UMMU)** | `dekan@simta.ac.id` | `password` | Dr. Ir. H. Syahrul Ramadhan, M.T. (Approval SK) |
| **Dosen 1** | `dosen1@simta.ac.id` | `password` | Dr. Budi Santoso, M.T. (Pembimbing & Penguji) |
| **Dosen 2** | `dosen2@simta.ac.id` | `password` | Ir. Citra Lestari, M.Kom. (Pembimbing & Penguji) |
| **Dosen 3** | `dosen3@simta.ac.id` | `password` | Prof. Dr. Hendra Wijaya (Penguji Utama) |
| **Mahasiswa 1** | `mahasiswa@simta.ac.id` | `password` | Ahmad Rizky Maulana (Status: Bimbingan / Siap Ujian) |
| **Mahasiswa 2** | `mahasiswa2@simta.ac.id` | `password` | Siti Nur Aisyah (Status: Selesai / Yudisium) |
| **Mahasiswa 3** | `mahasiswa3@simta.ac.id` | `password` | Dimas Anggara (Status: Belum Daftar Skripsi) |

---

## 📁 Struktur Direktori Utama Projek

```text
simta/
├── app/
│   ├── Http/Controllers/    # Controller dipisah berdasar role (Admin, Dekan, Kaprodi, Dosen, Mahasiswa)
│   ├── Models/              # Eloquent Models (Skripsi, Bimbingan, Ujian, BeritaAcara, Yudisium, dll.)
│   └── Providers/           # Service Providers Laravel
├── config/                  # File Konfigurasi Aplikasi
├── database/
│   ├── migrations/          # Schema Migrasi Database
│   └── seeders/             # Data awal untuk Pengujian & Produksi
├── public/                  # File Statis & Assets Publik (Storage link, favicon, logo)
├── resources/
│   ├── css/                 # Stylings Tailwind CSS
│   ├── js/                  # JavaScript & Alpine.js Entrypoint
│   └── views/               # Blade Views (Layouts, Admin, Dosen, Mahasiswa, pdf templates)
├── routes/
│   ├── auth.php             # Route Autentikasi Breeze
│   ├── console.php          # Route Command Artisan
│   └── web.php              # Route Utama Aplikasi dengan Proteksi Middleware Role
└── storage/                 # Tempat Penyimpanan Dokumen Upload & Log
```

---

## 🧪 Pengujian (Testing)

Untuk menjalankan suite pengujian otomatis pada aplikasi ini:
```bash
php artisan test
```

---

## 📄 Lisensi

Projek ini dikembangkan untuk kepentingan manajemen akademik Fakultas Teknik Universitas Muhammadiyah Maluku Utara (FT UMMU) di bawah lisensi [MIT License](LICENSE).
