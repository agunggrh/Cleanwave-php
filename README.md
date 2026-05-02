# CleanWave POS - Laundry Management System

CleanWave POS adalah aplikasi Point of Sale (POS) dan manajemen sistem laundry yang dirancang dengan antarmuka yang modern, bersih, dan profesional. Aplikasi ini dibangun menggunakan PHP asli (Native PHP) dan MySQL, dirancang agar mudah digunakan serta memiliki fitur lengkap untuk mengelola operasional laundry harian Anda.

## Fitur Utama

- **Antarmuka Modern (UI/UX)**: Desain minimalis dan responsif untuk kemudahan navigasi.
- **Manajemen Transaksi**: Mencatat pesanan pelanggan, jenis layanan, serta berat cucian dengan mudah.
- **Pelacakan Status**: Memantau status pesanan mulai dari proses penerimaan, pencucian, hingga selesai dan diambil.
- **Pembuatan Laporan & Cetak**: Dapat menghasilkan laporan transaksi dan struk penerimaan yang siap dicetak menggunakan library FPDF.
- **Sistem Autentikasi**: Login aman untuk mengamankan data transaksi laundry.

## Teknologi yang Digunakan

- **Backend**: PHP 8.x (Native)
- **Database**: MySQL / MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Library Tambahan**: FPDF (untuk cetak laporan)

## Panduan Instalasi (Lokal)

1. **Clone repositori ini**:
   ```bash
   git clone https://github.com/agunggrh/cleanwave-pos-java.git
   ```
2. **Pindahkan ke server lokal**:
   Pindahkan folder proyek ke dalam direktori `htdocs` (jika menggunakan XAMPP) atau direktori publik server web Anda.

3. **Konfigurasi Database**:
   - Buat database baru di phpMyAdmin (misal: `laundry_db`).
   - Impor file `laundry_db.sql` yang tersedia di dalam proyek ke database tersebut.
   - Buka file `config/database.php` (atau file konfigurasi Anda) dan sesuaikan detail koneksi database (username, password, dan nama database).

4. **Akses Aplikasi**:
   Buka browser dan akses aplikasi melalui `http://localhost/cleanwave-pos-java/` (atau sesuai nama folder lokal Anda).

## Lisensi

Proyek ini dibuat untuk tujuan pembelajaran dan pengembangan profesional. Silakan gunakan atau modifikasi sesuai kebutuhan!
