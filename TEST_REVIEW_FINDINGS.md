# Test Review Findings

Dokumen ini merangkum gap antara test case yang direncanakan dengan implementasi aplikasi saat ini.

## Ringkasan

Ada 1 temuan utama yang membuat beberapa test case belum sepenuhnya sesuai dengan behavior aplikasi saat ini:

1. `ASP-02` belum menolak input negatif.

## Findings

### 1. Input asupan negatif masih lolos validasi

Test case terkait:

- `ASP-02`

File:

- [app/Http/Controllers/AsupanController.php](D:/b/nutri/nutritrack/app/Http/Controllers/AsupanController.php:56)

Masalah:

- Validasi `kadar_gula` dan `kadar_kalori` hanya memakai rule `numeric`.
- Tidak ada rule `min:0` atau `gte:0`.

Dampak:

- Test case `ASP-02` dengan expected result `Validation error` belum akan lulus, karena input negatif masih diterima.

Saran:

- Tambahkan validasi non-negatif pada field angka.

## Rekomendasi Revisi Test Case

### Tetap valid tanpa perubahan besar

- `REG-01`
- `REG-02`
- `REG-03`
- `REG-04`
- `LOG-02`
- `LOG-03`
- `LOG-04`
- `DASH-01`
- `DASH-02`
- `DASH-03`
- `ASP-01`
- `ASP-03`
- `ASP-04`
- `PROF-01`
- `PROF-02`
- `KONS-01`
- `KONS-02`
- `PASS-01`
- `PASS-02`

### Perlu penyesuaian test case atau implementasi

- `ASP-02`

## Kesimpulan

Secara umum, mayoritas test case sudah bisa dijalankan. Namun ada beberapa test case yang masih tidak sepenuhnya sinkron dengan implementasi saat ini, terutama karena:

- validasi angka negatif pada asupan belum diterapkan,
- dan input negatif masih belum diblok oleh validasi backend.
