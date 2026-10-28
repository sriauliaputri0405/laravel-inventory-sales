# Laravel Inventory Sales

## 1. Project Overview

**Laravel Inventory Sales** adalah aplikasi berbasis web yang digunakan untuk membantu pengelolaan persediaan barang dan transaksi penjualan. Aplikasi ini dikembangkan menggunakan Laravel dan MySQL.

Tujuan pengembangan aplikasi ini adalah mempermudah pengelolaan data produk, pemantauan stok, pencatatan transaksi penjualan, dan penyusunan laporan penjualan melalui satu sistem terintegrasi.

### Tujuan Proyek
- Mempermudah pengelolaan data produk.
- Membantu memantau jumlah stok barang.
- Mencatat transaksi barang masuk dan keluar.
- Memproses transaksi penjualan secara terstruktur.
- Mengurangi kesalahan pencatatan dan perhitungan manual.
- Membantu admin memantau persediaan dan laporan penjualan.

## 2. Requirements

Perangkat lunak dan teknologi yang dibutuhkan:

- PHP dengan versi yang sesuai dengan konfigurasi proyek.
- Composer.
- Laravel sesuai versi pada proyek.
- MySQL atau MariaDB.
- XAMPP untuk menjalankan server lokal.
- Web browser.
- Visual Studio Code atau editor kode lainnya.
- Git untuk pengelolaan source code.

## 3. Installation

Ikuti langkah-langkah berikut untuk menjalankan aplikasi secara lokal.

### Langkah 1 — Clone Repository

Buka terminal, kemudian jalankan:

```bash
git clone [URL_REPOSITORY_GITHUB]
```

Masuk ke folder proyek:

```bash
cd [NAMA_FOLDER_PROYEK]
```

### Langkah 2 — Install Dependencies

Jalankan perintah berikut:

```bash
composer install
```

### Langkah 3 — Konfigurasi Environment

Salin file `.env.example` menjadi `.env`. Pada Windows, dapat menggunakan:

```bash
copy .env.example .env
```

Buka file `.env`, kemudian sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3308
DB_DATABASE=[NAMA_DATABASE]
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Port `3308` digunakan apabila MySQL pada komputer memang berjalan di port tersebut. Sesuaikan nama database, username, dan password dengan konfigurasi lokal.

### Langkah 4 — Generate Application Key

```bash
php artisan key:generate
```

### Langkah 5 — Membuat Database

1. Jalankan Apache dan MySQL melalui XAMPP.
2. Buka phpMyAdmin.
3. Buat database sesuai nama pada file `.env`.
4. Pastikan konfigurasi koneksi database sudah benar.

### Langkah 6 — Menjalankan Migration dan Seeder

Untuk membuat tabel database, jalankan:

```bash
php artisan migrate
```

Jika proyek memiliki seeder untuk data awal, jalankan:

```bash
php artisan db:seed
```

Jalankan seeder hanya jika memang tersedia dan sesuai dengan konfigurasi proyek. Hindari `migrate:fresh` pada database yang berisi data penting karena perintah tersebut dapat menghapus tabel dan datanya.

### Langkah 7 — Menjalankan Aplikasi

```bash
php artisan serve
```

Buka alamat berikut pada browser:

```text
http://127.0.0.1:8000
```

## 4. Environment Setup

Konfigurasi utama aplikasi dilakukan melalui file `.env`.

| Konfigurasi | Keterangan |
|---|---|
| `APP_NAME` | Nama aplikasi |
| `APP_ENV` | Environment aplikasi |
| `APP_DEBUG` | Pengaturan debug |
| `APP_URL` | URL aplikasi lokal |
| `DB_CONNECTION` | Driver database |
| `DB_HOST` | Alamat server database |
| `DB_PORT` | Port MySQL |
| `DB_DATABASE` | Nama database |
| `DB_USERNAME` | Username database |
| `DB_PASSWORD` | Password database |

File `.env` berisi konfigurasi lokal dan tidak boleh diunggah ke repository publik jika mengandung informasi rahasia. Gunakan `.env.example` sebagai contoh konfigurasi.

## 5. Migration & Seeding

Migration digunakan untuk membuat dan mengelola struktur tabel database melalui kode Laravel.

Tabel utama yang berkaitan dengan fungsi aplikasi meliputi:

- **users** — menyimpan data pengguna dan role.
- **products** — menyimpan data produk, harga, dan stok.
- **categories** — mengelompokkan produk berdasarkan kategori.
- **sales** — menyimpan informasi utama transaksi penjualan.
- **sale_items** — menyimpan rincian produk dalam transaksi penjualan.
- **carts** — menyimpan barang yang dimasukkan ke keranjang belanja.
- **stock_movements** — mencatat pergerakan stok jika tabel ini tersedia pada migration proyek.

Seeder dapat digunakan untuk memasukkan data awal, seperti kategori, produk, atau akun demo, apabila implementasinya tersedia.

Perintah database yang digunakan:

```bash
php artisan migrate
php artisan db:seed
```

### Relasi Database

- Satu kategori dapat memiliki banyak produk.
- Satu transaksi penjualan dapat memiliki banyak detail barang.
- Setiap detail penjualan berhubungan dengan satu produk.
- Transaksi penjualan berhubungan dengan pengguna yang melakukan transaksi.
- Keranjang menghubungkan pengguna dengan produk yang dipilih.

**ERD (Entity Relationship Diagram)**

Simpan gambar ERD pada folder `docs`, misalnya dengan nama `erd.png`, kemudian tampilkan menggunakan:

```markdown
![Entity Relationship Diagram](docs/erd.png)
```

ERD harus sesuai dengan struktur tabel dan foreign key yang benar-benar ada pada proyek.

## 6. Demo Account

Aplikasi menyediakan akses berdasarkan role pengguna apabila akun dan pembatasan role tersebut sudah dikonfigurasi.

| Role | Hak akses |
|---|---|
| Admin | Mengelola data dan mengakses fungsi administratif sesuai implementasi aplikasi. |
| Staff | Mengakses fungsi operasional sesuai pembatasan role pada aplikasi. |

### Akun Demo

| Role | Username | Password |
|---|---|---|
| Admin | [USERNAME_ADMIN] | [PASSWORD_DEMO_ADMIN] |
| Staff | [USERNAME_STAFF] | [PASSWORD_DEMO_STAFF] |

Isi tabel menggunakan akun demo yang benar-benar dapat digunakan. Jangan mencantumkan password pribadi atau kredensial database.

## 7. Features

### 7.1 Authentication & Authorization
- Login pengguna.
- Pengelolaan akses berdasarkan role.
- Pembatasan fungsi tertentu berdasarkan hak akses pengguna.

### 7.2 Product Management
- Menampilkan daftar produk.
- Menambahkan produk.
- Mengubah informasi produk.
- Menampilkan informasi harga dan stok.
- Pencarian dan penyaringan produk jika tersedia.

### 7.3 Inventory Management
- Memantau stok barang.
- Mencatat stok masuk.
- Mencatat stok keluar.
- Memeriksa kecukupan stok sebelum barang dikeluarkan.
- Menampilkan informasi stok rendah jika tersedia.

### 7.4 Sales Management
- Memproses transaksi penjualan.
- Menghitung subtotal dan total transaksi.
- Menyimpan rincian produk yang terjual.
- Mengurangi stok berdasarkan jumlah barang yang dijual.
- Menyediakan riwayat dan detail transaksi.

### 7.5 Reports
- Menampilkan riwayat transaksi.
- Menyediakan informasi total transaksi dan pendapatan.
- Menampilkan laporan penjualan sesuai fungsi yang tersedia pada aplikasi.

## 8. Known Limitations

Bagian ini perlu disesuaikan dengan hasil pengujian aplikasi yang sebenarnya.

Contoh keterbatasan yang dapat dicantumkan jika memang sesuai:

- Aplikasi masih dijalankan pada lingkungan lokal.
- Integrasi pembayaran dengan payment gateway belum tersedia.
- Notifikasi stok rendah otomatis belum tersedia.
- Laporan masih terbatas pada data yang disediakan aplikasi.
- Pengujian dilakukan menggunakan data dan akun demo.

Keterbatasan di atas merupakan contoh, bukan pernyataan bahwa seluruhnya pasti berlaku pada proyek ini.

## 9. Screenshots

Tambahkan screenshot hasil implementasi aplikasi agar fitur dapat diverifikasi.

Simpan gambar pada folder `docs/screenshots/`, lalu tampilkan menggunakan format berikut:

```markdown
![Dashboard](docs/screenshots/dashboard.png)
```

Screenshot yang disarankan:

1. Halaman login.
2. Dashboard utama.
3. Daftar produk.
4. ERD Database
   <img width="1158" height="719" alt="ERD Web" src="https://github.com/user-attachments/assets/ffa03056-919f-4ed4-a2dd-45c2d276ac7c" />






   


Pilih screenshot yang menunjukkan fungsi aplikasi secara jelas dan gunakan data demo, bukan data sensitif.

## 10. Testing

Pengujian dilakukan untuk memeriksa apakah fungsi utama aplikasi berjalan sesuai kebutuhan.

| No. | Skenario Pengujian | Hasil yang Diharapkan |
|---|---|---|
| 1 | Login menggunakan akun valid | Pengguna dapat masuk ke aplikasi. |
| 2 | Login menggunakan akun tidak valid | Sistem menolak login. |
| 3 | Menambahkan produk | Produk tersimpan di database. |
| 4 | Mengubah data produk | Perubahan tersimpan dengan benar. |
| 5 | Menambahkan stok masuk | Jumlah stok bertambah. |
| 6 | Memproses stok keluar | Jumlah stok berkurang sesuai jumlah yang dikeluarkan. |
| 7 | Checkout dengan stok mencukupi | Transaksi tercatat dan stok diperbarui. |
| 8 | Checkout dengan stok tidak mencukupi | Sistem menolak transaksi yang tidak memenuhi ketentuan stok. |
| 9 | Staff mencoba mengakses fitur Admin | Sistem menolak akses jika fitur tersebut dibatasi untuk Admin. |
| 10 | Membuka laporan penjualan | Data transaksi ditampilkan sesuai data database. |

Hasil akhir pengujian harus diisi berdasarkan pengujian yang benar-benar dilakukan.

## 11. Repository

Source code proyek dapat diakses melalui:

**GitHub Repository:** [URL_REPOSITORY_GITHUB]

Repository mencakup source code aplikasi, migration, seeder yang tersedia, serta dokumentasi instalasi yang diperlukan untuk menjalankan proyek.
