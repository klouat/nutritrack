# Playwright E2E

Suite ini mengotomasi test case SQA berikut:

- `TC-LOG-01` Login dengan kredensial valid
- `TC-LOG-04` Brute force protection pada login
- `TC-DASH-01` Akurasi total gula harian di dashboard
- `TC-CA-01` Input asupan valid
- `TC-ADM-05` User biasa tidak dapat mengakses panel admin

## Kredensial default

Secara default suite memakai:

- `E2E_EMAIL=guje2341@gmail.com`
- `E2E_PASSWORD=test123456`

Kamu bisa override saat run:

```powershell
$env:E2E_EMAIL="user@example.com"
$env:E2E_PASSWORD="secret"
```

## Cara menjalankan

1. Install dependency JavaScript tambahan:

```powershell
npm install
npx playwright install chromium
```

2. Pastikan database dan akun test sudah siap.

3. Jalankan test:

```powershell
npm run test:e2e
```

Untuk mode headed:

```powershell
npm run test:e2e:headed
```

## Output hasil

Setelah run selesai:

- HTML report: `playwright-report/index.html`
- Ringkasan detail markdown: `playwright-results/sqa-summary.md`
- Ringkasan detail HTML: `playwright-results/sqa-summary.html`

## Catatan

- Test `TC-DASH-01` dan `TC-CA-01` membersihkan data asupan hari ini milik akun test sebelum menyiapkan data baru, agar hasil total gula konsisten.
- Test `TC-LOG-04` ditempatkan di akhir suite karena mengaktifkan rate limiter login.
