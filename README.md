# 🛍️ Toko Online - CodeIgniter 4

**Toko Online** adalah sebuah platform e-commerce sederhana yang dibangun menggunakan [CodeIgniter 4](https://codeigniter.com/). Aplikasi ini mendukung manajemen produk, sistem keranjang belanja, transaksi pembelian, hingga panel admin yang powerful dan modern menggunakan template **NiceAdmin**.

---

## 📑 Daftar Isi

- [✨ Fitur](#-fitur)
- [🧰 Persyaratan Sistem](#-persyaratan-sistem)
- [⚙️ Instalasi](#️-instalasi)
- [📁 Struktur Proyek](#-struktur-proyek)
- [📷 Tampilan](#tampilan-opsional)

---

## ✨ Fitur

### 👤 Autentikasi

- Login dan logout pengguna
- Role-based access (Admin dan User)
- Validasi form menggunakan helper bawaan CI4

### 🛒 Sistem Belanja

- **Katalog Produk**
  - Daftar produk lengkap dengan foto, harga, dan tombol beli
  - Pencarian produk (fitur dasar)
- **Keranjang Belanja**
  - Tambah produk ke keranjang (dengan diskon aktif)
  - Update kuantitas produk
  - Hapus produk dari keranjang
  - Total harga otomatis dihitung

### 📦 Sistem Transaksi

- Checkout form (alamat, kelurahan, jasa kirim, ongkir)
- Hitung ongkir otomatis via dropdown layanan
- Transaksi disimpan ke database
- Diskon harian diterapkan dari `session`
- Riwayat transaksi tersimpan

### 🧾 Panel Admin

- CRUD Produk dan Kategori Produk
- Manajemen diskon berdasarkan tanggal
- Validasi tanggal diskon tidak boleh ganda
- Fitur Export Data ke PDF
- Statistik dan Dashboard API transaksi

### 📱 Tampilan Responsive

- Menggunakan [NiceAdmin](https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/) (Bootstrap 5)
- Sidebar dinamis berdasarkan role
- UI bersih, modern, dan mobile-friendly

---

## 🧰 Persyaratan Sistem

- PHP **>= 8.2**
- Composer
- MySQL (melalui XAMPP / Laragon / LAMP)
- Apache / Nginx Web Server
- Ekstensi PHP: `intl`, `curl`, `mbstring`, `json`, dll.

---

## ⚙️ Instalasi

1. **Clone Repository**

   ```bash
   git clone https://github.com/Yayan45/belajar-ci-tugas
   cd belajar-ci-tugas
   ```

2. **Install Dependency via Composer**

   ```bash
   composer install
   ```

3. **Konfigurasi Database**

   - Buat database bernama `db_ci4` di **phpMyAdmin**
   - Salin dan rename file `.env.example` menjadi `.env`
   - Sesuaikan bagian berikut:
     ```env
     database.default.hostname = localhost
     database.default.database = db_ci4
     database.default.username = root
     database.default.password =
     database.default.DBDriver = MySQLi
     ```

4. **Lakukan Migrasi Database**

   ```bash
   php spark migrate
   ```

5. **Seed Data Awal**

   ```bash
   php spark db:seed UserSeeder
   php spark db:seed ProductSeeder
   php spark db:seed DiskonSeeder
   ```

6. **Jalankan Server**

   ```bash
   php spark serve
   ```

7. **Akses Aplikasi**
   - Kunjungi `http://localhost:8080` di browser
   - Login sebagai admin:
     ```
     Username: admin123
     Password: 1234567
     ```

---

## 📁 Struktur Proyek

```plaintext
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php         # Login/Logout
│   │   ├── ProductController.php      # Produk
│   │   ├── TransactionController.php  # Checkout & transaksi
│   │   ├── DiskonController.php       # Diskon per hari
│   │   └── ApiController.php          # Web service transaksi
│   ├── Models/
│   │   ├── ProductModel.php
│   │   ├── TransactionModel.php
│   │   ├── TransactionDetailModel.php
│   │   ├── UserModel.php
│   │   └── DiskonModel.php
│   ├── Views/
│   │   ├── v_login.php
│   │   ├── v_produk.php
│   │   ├── v_keranjang.php
│   │   ├── v_checkout.php
│   │   └── v_diskon.php
│   └── Helpers/
│       └── custom_helper.php
├── public/
│   ├── index.php
│   ├── img/                           # Gambar produk
│   └── NiceAdmin/                     # Template Admin
├── writable/                          # Cache, session, logs
├── .env                               # Konfigurasi lokal
├── composer.json                      # Konfigurasi dependency
└── README.md                          # File dokumentasi ini
```

---

## 💡 Catatan Tambahan

- Data diskon diterapkan otomatis berdasarkan tanggal hari ini (disimpan di session)
- API WebService tersedia di endpoint: `http://localhost:8080/api`  
  Dengan headers:
  ```
  key: random123678abcghi
  ```

---

## ❤️ Kontribusi

Feel free untuk fork repo ini dan kembangkan fitur-fitur lainnya seperti integrasi Midtrans, payment gateway, atau integrasi dengan frontend seperti React atau Vue.js.

---

## 📜 Lisensi

MIT License © 2025 - [@Yayan45](https://github.com/Yayan45)
