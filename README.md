# NutriTrack 🍽️

**NutriTrack** adalah aplikasi pelacak asupan makanan harian yang membantu pengguna mengelola konsumsi gula dan kalori.

---

## ✨ Fitur Utama

* 🔍 **Cari Makanan**: Menampilkan data kalori dan gula berdasarkan pencarian makanan dari API USDA.
* 🧾 **Catat Konsumsi Harian**: Formulir untuk mencatat makanan yang dikonsumsi per hari.
* 📊 **Ringkasan Gizi Harian**: Menampilkan total gula dan kalori yang telah dikonsumsi.

---
Anggota Kelompok Wong Liyo Ngerti Opo :

| **Nama**                        | **Role**                                | **Tugas**                                                                                                                                             |
|--------------------------------|------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Rozy Setia Irmawan**         | Product Manager                         | Mengelola visi dan arah produk, menyusun roadmap pengembangan, menjembatani tim teknis dan non-teknis, serta mencari ide dan inovasi produk.         |
| **Sazkia Sabrina Aura Zahira** | System Analyst & Content Writer         | Menganalisis kebutuhan sistem dari sisi pengguna, menyusun dokumentasi teknis, serta membuat konten halaman web seperti teks deskriptif. |
| **Muhammad Fachri Afrizal**    | UI/UX Designer & Backend Developer      | Mendesain tampilan antarmuka website di figma secara menyeluruh serta merancang alur interaksi pengguna (user flow) agar mudah digunakan, sekaligus membantu pengembangan sisi backend yaitu autentikasi. |
| **Muhammad Raysa Rafii'udin**  | Web Developer Utama               | Mengelola keseluruhan proses pengembangan website, menangani pengembangan website secara end-to-end, mencakup pembuatan tampilan frontend, pengelolaan logika backend |

---
Link Video Presentasi Final Project Youtube : https://youtu.be/bG7SyxmlYqI?si=-Jq6jlAk-xgwDpZe
---
## 🛠️ Teknologi yang Digunakan

| Teknologi | Deskripsi |
| :--------- | :---------- |
| ![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D) | Kerangka Kerja Frontend |
| ![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white) | Kerangka Kerja Backend |
| ![USDA API](https://img.shields.io/badge/USDA%20API-FFD700?style=for-the-badge&logo=data&logoColor=black) | API untuk data nutrisi (FoodData Central) |

---

## 🚀 Cara Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan NutriTrack di perangkat Anda:

1.  **Pengaturan Database**:
    * Buat database baru dengan nama **`nutri`**.
    * Import file **`nutri.sql`** yang tersedia ke database yang baru Anda buat.

2.  **Konfigurasi Env**:
    * Ganti nama file **`.env.example`** menjadi **`.env`**.

3.  **Instal Dependensi**:
    * Buka terminal atau command prompt Anda di direktori utama proyek.
    * Jalankan **`composer install`** untuk menginstal dependensi PHP.
    * Jalankan **`npm install`** untuk menginstal dependensi JavaScript.

4.  **Jalankan Aplikasi**:
    Bisa dengan klik file **`start.bat`**
	* Atau
       **`php artisan serve`**
       **`npm run dev`**

---

## 📁 Struktur Project
```
nutritrack/
├── 📁 app/                          # Main Directory Laravel
│   ├── 📁 Console/                  # Command line commands
│   ├── 📁 Exceptions/               # Exception handlers
│   ├── 📁 Http/                     # Controllers, Middleware, Requests
│   ├── 📁 Models/                   # Eloquent models
│   ├── 📁 Notifications/            # Notification classes
│   ├── 📁 Providers/                # Service providers
│   └── 📁 View/                     # View composers
├── 📁 bootstrap/                    # Framework bootstrap files
├── 📁 config/                       # Config aplikasi
├── 📁 database/                     # Database Files
│   ├── 📁 factories/                # Model factories
│   ├── 📁 migrations/               # Database migrations
│   └── 📁 seeders/                  # Database seeders
├── 📁 public/                       # Public assets
├── 📁 resources/                    # Frontend resources
│   ├── 📁 css/                      # Stylesheet files
│   ├── 📁 js/                       # JavaScript files
│   │   ├── 📁 components/           # Vue.js components
│   │   ├── app.js                   # Home
│   │   ├── bootstrap.js             # Bootstrap 
│   │   ├── dashboard.js             # Dashboard
│   │   ├── login.js                 # Login 
│   │   ├── register.js              # Register
│   │   ├── asupan.js                # Asupan
│   │   ├── laporan.js               # Laporan
│   │   ├── profile.js               # Profile
│   │   └── pilihansehat.js          # Pilihan Sehat
│   └── 📁 views/                    # Blade template files
├── 📁 routes/                       # Route
│   ├── api.php                      # API routes
│   └── web.php                      # Web routes
├── 📁 storage/                      # File storage
├── 📁 tests/                        # Test files
├── 📁 vendor/                       # Composer dependencies
├── 📁 node_modules/                 # NPM dependencies
├── 📄 .env.example                  # Environment variables template
├── 📄 .gitignore                    # Git ignore rules
├── 📄 .vercelignore                 # Vercel ignore rules
├── 📄 artisan                       # Laravel command line tool
├── 📄 composer.json                 # PHP dependencies
├── 📄 composer.lock                 # PHP dependencies lock
├── 📄 package.json                  # Node.js dependencies
├── 📄 package-lock.json             # Node.js dependencies lock
├── 📄 phpunit.xml                   # PHPUnit configuration
├── 📄 postcss.config.js             # PostCSS configuration
├── 📄 start.bat                     # Windows startup script
├── 📄 tailwind.config.js            # Tailwind CSS configuration
└── 📄 vite.config.js                # Vite build configuration
```
