# Postman Guide

Dokumen ini dipakai untuk mengetes endpoint utama NutriTrack secara manual di Postman atau API client sejenis.

## Catatan Penting

- Project ini memakai verifikasi manual untuk API.
- Jangan jalankan automated test seperti `php artisan test`, `phpunit`, atau test runner lain untuk repo ini.

## Base URL

Ganti sesuai server lokal kamu:

```text
http://127.0.0.1:8000
```

Kalau menjalankan Laravel dengan host atau port lain, sesuaikan `base_url`.

## Sebelum Mulai

Pastikan:

1. Database sudah aktif.
2. Migrasi sudah dijalankan.
3. Aplikasi Laravel sudah running.

Contoh:

```powershell
php artisan migrate
php artisan serve
```

## Auth yang Dipakai

Semua endpoint protected memakai Bearer Token.

Ambil token dari:

- `POST /api/register`, atau
- `POST /api/login`

Lalu pakai token itu pada request berikutnya di Postman:

```text
Authorization: Bearer <token>
```

## Header Umum

Untuk request JSON, pakai header:

```text
Accept: application/json
Content-Type: application/json
```

Untuk endpoint yang butuh login, tambahkan:

```text
Authorization: Bearer <token>
```

## Urutan Test yang Disarankan

1. `POST /api/register`
2. `POST /api/login`
3. Simpan `token`
4. `POST /api/asupan`
5. `GET /api/dashboard`
6. `GET /api/dashboard/daily-totals`
7. `POST /api/laporan`
8. `GET /api/sehat`
9. `GET /api/sehat/buah`
10. `GET /api/profile`
11. `PUT /api/profile`
12. `POST /api/profile/password`
13. `GET /api/admin/pilihan-sehat`
14. `POST /api/admin/pilihan-sehat`
15. `PUT /api/admin/pilihan-sehat/{id}`
16. `DELETE /api/admin/pilihan-sehat/{id}`
17. `POST /api/konsultasi`
18. `POST /api/logout`

## 1. Register Akun

Endpoint:

```text
POST /api/register
```

Full URL:

```text
{{base_url}}/api/register
```

Body:

```json
{
  "name": "Budi Santoso",
  "email": "budi@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

Expected response:

```json
{
  "message": "User successfully registered!",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com"
  },
  "token": "1|...",
  "token_type": "Bearer"
}
```

Catatan:

- Simpan nilai `token` kalau mau langsung dipakai.
- Kalau email sudah terdaftar, response akan `422`.

## 2. Login Akun

Endpoint:

```text
POST /api/login
```

Full URL:

```text
{{base_url}}/api/login
```

Body:

```json
{
  "email": "budi@example.com",
  "password": "password123"
}
```

Expected response:

```json
{
  "success": true,
  "message": "Login successful.",
  "token": "2|...",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com"
  }
}
```

Catatan:

- Pakai token dari response ini untuk endpoint protected.
- Kalau email/password salah, response akan `422`.

## 3. Input Asupan

Endpoint:

```text
POST /api/asupan
```

Full URL:

```text
{{base_url}}/api/asupan
```

Headers:

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

Body:

```json
{
  "nama": "Teh Manis",
  "kadar_gula": 12.5,
  "kadar_kalori": 95,
  "tanggal_konsumsi": "2026-05-07",
  "waktu_konsumsi": "Pagi",
  "catatan": "Minum setelah sarapan"
}
```

Expected response:

```json
{
  "message": "Asupan berhasil disimpan",
  "asupan": {
    "id": 1,
    "user_id": 1,
    "nama": "Teh Manis",
    "kadar_gula": "12.50",
    "kadar_kalori": "95.00",
    "tanggal_konsumsi": "2026-05-07",
    "waktu_konsumsi": "Pagi",
    "catatan": "Minum setelah sarapan"
  }
}
```

Catatan:

- Kalau tidak kirim bearer token, response akan `401`.

## 4. Ambil Data Dashboard

Endpoint:

```text
GET /api/dashboard
```

Full URL:

```text
{{base_url}}/api/dashboard
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

Expected response:

```json
{
  "message": "Dashboard data fetched successfully.",
  "user": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com"
  },
  "summary": {
    "tanggal": "2026-05-07",
    "total_gula": 12.5,
    "total_kalori": 95,
    "gula_percentage": 25,
    "kalori_percentage": 4,
    "max_gula": 50,
    "max_kalori": 2400
  },
  "today_asupan": []
}
```

Catatan:

- Nilai `today_asupan` akan berisi catatan asupan user untuk tanggal hari ini.

## 5. Ambil Total Harian Dashboard

Endpoint:

```text
GET /api/dashboard/daily-totals
```

Full URL:

```text
{{base_url}}/api/dashboard/daily-totals
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

Expected response:

```json
{
  "total_gula": 12.5,
  "total_kalori": 95,
  "gula_percentage": 25,
  "kalori_percentage": 4,
  "max_gula": 50,
  "max_kalori": 2400
}
```

## 6. Buat Laporan

Endpoint:

```text
POST /api/laporan
```

Full URL:

```text
{{base_url}}/api/laporan
```

Headers:

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

Body:

```json
{
  "judul": "Laporan Harian",
  "isi_laporan": "Isi laporan lengkap di sini."
}
```

Expected response:

```json
{
  "message": "Laporan berhasil dibuat.",
  "laporan": {
    "id": 1,
    "judul": "Laporan Harian",
    "isi_laporan": "Isi laporan lengkap di sini."
  }
}
```

## 7. Ambil Semua Pilihan Sehat

Endpoint:

```text
GET /api/sehat
```

Full URL:

```text
{{base_url}}/api/sehat
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

Expected response:

```json
{
  "message": "Data pilihan sehat berhasil diambil.",
  "kategori": null,
  "items": []
}
```

## 8. Ambil Pilihan Sehat Per Kategori

Contoh endpoint:

```text
GET /api/sehat/buah
GET /api/sehat/sayur
GET /api/sehat/protein
GET /api/sehat/minuman
GET /api/sehat/karbohidrat
```

Contoh full URL:

```text
{{base_url}}/api/sehat/buah
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

Expected response:

```json
{
  "message": "Data pilihan sehat berhasil diambil.",
  "kategori": "buah",
  "items": [
    {
      "id": 1,
      "judul": "Buah Sehat",
      "kategori": "buah",
      "nama": "Apel",
      "deskripsi": "Contoh data",
      "gambar_path": "images/contoh.jpg",
      "urutan": 1,
      "aktif": 1
    }
  ]
}
```

## 9. Ambil Profil

Endpoint:

```text
GET /api/profile
```

Full URL:

```text
{{base_url}}/api/profile
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

## 10. Update Profil

Endpoint:

```text
PUT /api/profile
```

Full URL:

```text
{{base_url}}/api/profile
```

Headers:

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

Body:

```json
{
  "name": "Budi Santoso Update",
  "email": "budi.updated@example.com",
  "nomor_telepon": "081234567890",
  "umur": 25,
  "pekerjaan": "Mahasiswa",
  "riwayat_kesehatan": "Tidak ada",
  "alergi": "Seafood"
}
```

Expected response:

```json
{
  "message": "Profil berhasil diperbarui.",
  "user": {
    "id": 1,
    "name": "Budi Santoso Update",
    "email": "budi.updated@example.com",
    "nomor_telepon": "081234567890",
    "umur": 25,
    "pekerjaan": "Mahasiswa",
    "riwayat_kesehatan": "Tidak ada",
    "alergi": "Seafood"
  }
}
```

## 11. Ganti Password

Endpoint:

```text
POST /api/profile/password
```

Full URL:

```text
{{base_url}}/api/profile/password
```

Headers:

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

Body:

```json
{
  "old_password": "password123",
  "new_password": "passwordBaru123",
  "new_password_confirmation": "passwordBaru123"
}
```

Expected response:

```json
{
  "message": "Password berhasil diperbarui."
}
```

Catatan:

- `new_password` minimal 8 karakter.
- `new_password_confirmation` harus sama dengan `new_password`.
- Kalau `old_password` salah, response akan `422`.

## 12. Ambil Data Admin Pilihan Sehat

Endpoint:

```text
GET /api/admin/pilihan-sehat
```

Full URL:

```text
{{base_url}}/api/admin/pilihan-sehat
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token_admin>
```

Optional query:

```text
{{base_url}}/api/admin/pilihan-sehat?kategori=buah
```

Expected response:

```json
{
  "message": "Data admin pilihan sehat berhasil diambil.",
  "items": []
}
```

Catatan:

- Endpoint ini untuk admin, dokter pencegahan, atau dokter pengobatan.
- User biasa akan mendapat `403`.

## 13. Tambah Data Admin Pilihan Sehat

Endpoint:

```text
POST /api/admin/pilihan-sehat
```

Full URL:

```text
{{base_url}}/api/admin/pilihan-sehat
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token_admin>
```

Body:

- Gunakan `form-data`, bukan raw JSON.
- Isi field berikut:

```text
judul = Anggur
kategori = buah
gambar_path = [pilih file gambar, opsional]
nama = Anggur Merah Globe
deskripsi = Buah kaya antioksidan dengan rasa manis alami.
urutan = 1
aktif = 1
```

Expected response:

```json
{
  "message": "Data berhasil ditambahkan.",
  "item": {
    "id": 1,
    "judul": "Anggur",
    "kategori": "buah",
    "gambar_path": "images/1234567890.png",
    "nama": "Anggur Merah Globe",
    "deskripsi": "Buah kaya antioksidan dengan rasa manis alami.",
    "urutan": 1,
    "aktif": true
  }
}
```

Catatan:

- `gambar_path` sekarang opsional.
- Kalau ingin upload gambar, tetap gunakan `form-data`.
- Kalau tanpa gambar, cukup kosongkan field `gambar_path`.

## 14. Edit Data Admin Pilihan Sehat

Endpoint:

```text
PUT /api/admin/pilihan-sehat/{id}
```

Contoh full URL:

```text
{{base_url}}/api/admin/pilihan-sehat/37
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token_admin>
```

Body:

- Gunakan `form-data`.
- Isi field berikut:

```text
nama = Semangka Update
deskripsi = Deskripsi baru untuk item ini.
urutan = 2
aktif = 1
gambar_path = [pilih file gambar, opsional]
```

Expected response:

```json
{
  "success": true,
  "message": "Data berhasil diperbarui.",
  "item": {
    "id": 37,
    "nama": "Semangka Update",
    "deskripsi": "Deskripsi baru untuk item ini.",
    "urutan": 2,
    "aktif": true
  }
}
```

Catatan:

- `gambar_path` opsional saat update.
- Endpoint ini mengikuti field edit yang sudah ada di admin page, jadi yang diubah adalah `nama`, `deskripsi`, `urutan`, `aktif`, dan opsional `gambar_path`.

## 15. Hapus Data Admin Pilihan Sehat

Endpoint:

```text
DELETE /api/admin/pilihan-sehat/{id}
```

Contoh full URL:

```text
{{base_url}}/api/admin/pilihan-sehat/37
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token_admin>
```

Expected response:

```json
{
  "success": true,
  "message": "Data berhasil dihapus."
}
```

## 16. Kirim Konsultasi

Endpoint:

```text
POST /api/konsultasi
```

Full URL:

```text
{{base_url}}/api/konsultasi
```

Headers:

```text
Accept: application/json
Content-Type: application/json
Authorization: Bearer <token>
```

Body untuk kirim ke role dokter:

```json
{
  "message": "Halo dok, saya ingin konsultasi soal pola makan.",
  "to_role": "dokter_pencegahan"
}
```

Alternatif body untuk kirim langsung ke user/dokter tertentu:

```json
{
  "message": "Halo, saya kirim pesan langsung.",
  "to_id": 2
}
```

Expected response:

```json
{
  "message": "Konsultasi berhasil dikirim.",
  "data": {
    "id": 1,
    "from_id": 1,
    "to_id": null,
    "to_role": "dokter_pencegahan",
    "message": "Halo dok, saya ingin konsultasi soal pola makan."
  }
}
```

Catatan:

- Minimal isi salah satu: `to_role` atau `to_id`.
- Kalau dua-duanya kosong, response akan `422`.

## 17. Logout

Endpoint:

```text
POST /api/logout
```

Full URL:

```text
{{base_url}}/api/logout
```

Headers:

```text
Accept: application/json
Authorization: Bearer <token>
```

Expected response:

```json
{
  "message": "Logout successful."
}
```

## Postman Environment yang Disarankan

Buat environment variable:

```text
base_url = http://127.0.0.1:8000
token = isi token dari login/register
```

Lalu pakai:

```text
{{base_url}}/api/login
{{token}}
```

## Cara Simpan Token di Postman

Setelah login atau register berhasil:

1. Copy value `token` dari response.
2. Simpan ke environment variable `token`.
3. Untuk endpoint protected, pakai tab `Authorization`.
4. Type: `Bearer Token`
5. Token: `{{token}}`

## Error Umum

`401 Unauthenticated.`

- Bearer token belum dikirim.
- Token salah atau sudah di-logout.

`422 Unprocessable Entity`

- Ada field wajib yang belum diisi.
- Format data tidak sesuai validasi.

`500 Internal Server Error`

- Biasanya database belum aktif.
- Bisa juga migrasi belum dijalankan.

## Ringkasan Endpoint

| Endpoint | Method | Tujuan |
| --- | --- | --- |
| `/api/register` | `POST` | Register akun |
| `/api/login` | `POST` | Login akun |
| `/api/usda-proxy` | `GET` | Proxy data USDA |
| `/api/asupan` | `POST` | Input asupan |
| `/api/laporan` | `POST` | Buat laporan |
| `/api/sehat` | `GET` | Ambil semua pilihan sehat |
| `/api/sehat/{kategori}` | `GET` | Ambil pilihan sehat per kategori |
| `/api/dashboard` | `GET` | Ambil data dashboard |
| `/api/dashboard/daily-totals` | `GET` | Ambil total harian dashboard |
| `/api/profile` | `GET` | Ambil profil user |
| `/api/profile` | `PUT` | Update profil |
| `/api/profile/password` | `POST` | Ganti password user |
| `/api/admin/pilihan-sehat` | `GET` | Ambil data pilihan sehat untuk admin |
| `/api/admin/pilihan-sehat` | `POST` | Tambah data pilihan sehat untuk admin |
| `/api/admin/pilihan-sehat/{id}` | `PUT` | Edit data pilihan sehat untuk admin |
| `/api/admin/pilihan-sehat/{id}` | `DELETE` | Hapus data pilihan sehat untuk admin |
| `/api/konsultasi` | `POST` | Kirim konsultasi |
| `/api/logout` | `POST` | Logout |
