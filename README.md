# TECHNEWS — Portal Berita Teknologi & Cybersecurity

Website portal berita teknologi dan keamanan siber berbasis **CodeIgniter 3 (MVC)** dengan **MySQL**, didesain dengan tema **Cyberpunk Dark** — neon merah/cyan, font Orbitron + JetBrains Mono, efek glitch, dan scanline overlay.

---

## 📁 Daftar Isi

1. [Tech Stack & Plugin](#1-tech-stack--plugin)
2. [Cara Menyalakan Website](#2-cara-menyalakan-website)
3. [Struktur Folder](#3-struktur-folder)
4. [Fitur & Navigasi](#4-fitur--navigasi)
5. [Validasi Form Artikel](#5-validasi-form-artikel)
6. [Kredensial Login](#6-kredensial-login)
7. [Database](#7-database)

---

## 1. Tech Stack & Plugin

### Framework / Bahasa Pemrograman
| Komponen | Teknologi | Versi |
|---|---|---|
| Backend Framework | **CodeIgniter 3** (MVC) | 3.1.13 |
| Bahasa Pemrograman | **PHP** | 8.2.12 (XAMPP) |
| Database | **MySQL / MariaDB** | via XAMPP |
| Web Server | **PHP Built-in Server** (`php -S`) | — |

### Library & Helper CodeIgniter yang Dipakai
| Library | Fungsi |
|---|---|
| `database` | Koneksi & query MySQL (Query Builder) |
| `session` | Login admin & flash message |
| `form_validation` | Validasi form artikel & login |
| `pagination` | Pagination artikel (beranda, kategori, pencarian) |
| `upload` | Upload gambar artikel |
| `url`, `form`, `text`, `date`, `html` | Helper untuk link, form, truncate teks, format tanggal |

### Frontend (CSS/JS)
| Plugin | Fungsi |
|---|---|
| **Quill.js 1.3.7** (CDN) | Rich Text Editor di form artikel admin (Heading, Bold, Italic, Bullet List, Hyperlink, dsb.) |
| **Google Fonts** | Orbitron (judul) + JetBrains Mono (body) |
| **CSS Custom** | `assets/css/style.css` (pengunjung) & `assets/css/admin.css` (admin) — tema cyberpunk |
| **SVG** | Favicon + placeholder gambar artikel |

> Catatan: Quill.js dimuat dari CDN (`cdn.quilljs.com`). Pastikan ada koneksi internet saat mengakses halaman **Tambah/Edit Artikel** di admin agar editor muncul.

---

## 2. Cara Menyalakan Website

> ⚠️ **PENTING untuk 2 langkah pertama**: setelah laptop dimatikan, server PHP dan MySQL **berhenti**. Setiap kali menyalakan laptop, wajib menjalankan kedua langkah ini.

### Langkah 1 — Nyalakan MySQL (Database)

```
Start-Process "c:\Users\user2\xampp\mysql\bin\mysqld.exe" -ArgumentList "--defaults-file=c:\Users\user2\xampp\mysql\bin\my.ini" -WindowStyle Hidden
```

Cek apakah MySQL sudah berjalan:

```
Get-Process | Where-Object { $_.ProcessName -like "*mysql*" }
```

Jika muncul proses `mysqld`, MySQL sudah aktif.

> Alternatif: buka **XAMPP Control Panel** → klik **Start** pada baris **MySQL**.

### Langkah 2 — Nyalakan Website (PHP Server)

Buka **PowerShell**, lalu jalankan:

```
Start-Process php -ArgumentList "-S","localhost:8080","c:\Users\user2\TechNews\router.php" -WorkingDirectory "c:\Users\user2\TechNews" -WindowStyle Hidden
```

### Langkah 3 — Buka di Browser

| Halaman | URL |
|---|---|
| Beranda pengunjung | http://localhost:8080/ |
| Login admin | http://localhost:8080/auth | admin / admin123

### Jika Database Belum Pernah Di-Import (misal pindah komputer)

```powershell
& "c:\Users\user2\xampp\mysql\bin\mysql.exe" -u root --execute="source c:/Users/user2/TechNews/database/technews.sql"
```

### Cara Mematikan Server

```powershell
Get-Process php | Stop-Process
Get-Process mysqld | Stop-Process
```

---

## 3. Struktur Folder

```
TechNews/
├── application/
│   ├── config/          → config.php, database.php, routes.php, autoload.php
│   ├── controllers/     → Home.php (pengunjung), Auth.php (login), Admin.php (CRUD)
│   ├── models/          → Article_model.php, Category_model.php, User_model.php
│   ├── views/
│   │   ├── admin/       → login, header, footer, dashboard, articles, article_form
│   │   └── visitor/     → header, footer, home, detail, category, search
│   └── uploads/         → folder gambar artikel yang di-upload admin
├── assets/
│   ├── css/             → style.css (pengunjung), admin.css (admin)
│   └── img/             → favicon.svg
├── database/
│   └── technews.sql     → skema database + data contoh (12 artikel)
├── system/              → folder inti CodeIgniter (jangan diubah)
├── .htaccess            → routing bersih (untuk Apache/XAMPP)
├── router.php           → router untuk PHP built-in server
└── index.php            → front controller CodeIgniter
```

---

## 4. Fitur & Navigasi

### A. Halaman Pengunjung

#### 🏠 Beranda (`/`)
- **Ticker berita** berjalan di paling atas (breaking news).
- **Header**: logo `>_ TECHNEWS` + **search bar**.
- **Navigasi menu**: Beranda + 8 kategori (AI, Cybersecurity, Gadget, Software, Cloud, Blockchain, IoT, Game).
- **Hero section**: artikel terbaru tampil besar dengan efek glitch pada judul + 3 artikel unggulan di samping.
- **Grid Berita Terbaru**: 6 artikel per halaman.
- **Pagination**: navigasi halaman (`1 2 >`) untuk melihat artikel berikutnya.

#### 📄 Detail Artikel (`/home/detail/{id}`)
- Judul dengan efek glitch.
- Meta: penulis, kategori, tanggal publikasi.
- Konten artikel render penuh dari Quill (heading, bold, italic, list, link, dll).
- Sidebar: daftar **kategori + jumlah artikel** dan **artikel terkait**.

#### 🗂️ Halaman Kategori (`/home/category/{slug}`)
- Menampilkan artikel milik satu kategori (contoh: `/home/category/cybersecurity`).
- Punya pagination sendiri.

#### 🔍 Pencarian (`/home/search?q=kata`)
- Mencari berdasarkan **judul, penulis, dan isi artikel**.
- Menampilkan hasil + pagination.

#### 🦶 Footer
- Tentang website, daftar kategori, dan akses cepat (Beranda, Pencarian, Login Admin).

### B. Halaman Admin (wajib login)

#### 🔐 Login Admin (`/auth`)
- Form username + password.
- Cek kredensial dengan bcrypt.
- Arahkan ke dashboard setelah berhasil; redirect balik jika salah.

#### 📊 Dashboard (`/admin/dashboard`)
- Statistik: **Total Artikel** & **Total Kategori**.
- Tabel **5 artikel terbaru**.

#### 📝 Manage Artikel (`/admin/articles`)
- Tabel semua artikel: gambar thumbnail, judul, kategori, penulis, tanggal.
- Tombol aksi: **Lihat** (buka di halaman publik), **Edit**, **Hapus** (dengan konfirmasi).

#### ➕ Tambah / ✏️ Edit Artikel (`/admin/create` & `/admin/edit/{id}`)
- Form dengan field: **Judul, Kategori (dropdown), Penulis, Tanggal Publikasi (datetime-local), Isi Artikel (Quill.js editor), Gambar (upload)**.
- Editor **Quill.js**: Heading H1–H6, Bold, Italic, Underline, Strike, Blockquote, Code Block, Ordered/Bullet List, Link, Warna teks, dll.
- Gambar opsional — jika kosong, otomatis pakai `placeholder-default.svg`.
- Tombol **SIMPAN** → kembali ke daftar artikel dengan pesan sukses.

#### 🚪 Logout
- Klik **LOGOUT** di sidebar atau kanan atas → kembali ke halaman login.

---

## 5. Validasi Form Artikel

Semua pesan error ditampilkan **di bawah field** masing-masing dalam Bahasa Indonesia.

| Aturan | Pesan |
|---|---|
| Semua field wajib diisi | `Judul wajib diisi.` / `Isi Artikel wajib diisi.` / `Tanggal Publikasi wajib diisi.` |
| Judul minimal 10 karakter | `Judul minimal 10 karakter.` |
| Judul maksimal 200 karakter | `Judul maksimal 200 karakter.` |
| Penulis minimal 3 karakter | `Penulis minimal 3 karakter.` |
| Penulis maksimal 100 karakter | `Penulis maksimal 100 karakter.` |
| Kategori wajib dipilih | `Kategori wajib dipilih.` (atau `Kategori wajib diisi.`) |
| Gambar (jika di-upload) | Hanya **JPG, JPEG, PNG, WebP, GIF**, maks **2MB**. Jika tidak sesuai muncul pesan error upload. |

> Uji validasi: judul pendek (misal "A") atau kategori kosong akan ditolak — form kembali ke halaman yang sama dengan pesan error.

---

## 6. Kredensial Login

| Username | Password | Role |
|---|---|---|
| `admin` | `admin123` | Administrator |

Password disimpan sebagai **hash bcrypt** di tabel `users` (bukan plain text).

---

## 7. Database

Nama database: **`technews`** — file: `database/technews.sql`

| Tabel | Isi |
|---|---|
| `users` | 1 akun admin |
| `categories` | 8 kategori |
| `articles` | 12 artikel seed bertema cybersecurity/teknologi |

Relasi: `articles.category_id` → `categories.id` (foreign key).

Struktur tabel `articles`:

| Field | Tipe |
|---|---|
| id | INT (auto increment) |
| title | VARCHAR(200) |
| category_id | INT (FK → categories) |
| author | VARCHAR(100) |
| content | LONGTEXT (HTML dari Quill) |
| image | VARCHAR(255) |
| publish_date | DATETIME |
| created_at / updated_at | TIMESTAMP |

---

Dibuat dengan ❤️ menggunakan CodeIgniter 3 — desain cyberpunk dari *ui-ux-pro-max design system* (Orbitron + JetBrains Mono, neon #FF2A3C / #22D3EE / #39FF88, scanlines, glitch effect).
