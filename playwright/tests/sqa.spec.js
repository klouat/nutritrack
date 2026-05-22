import { test, expect } from '@playwright/test';
import {
  addApiResponse,
  addUiCheck,
  annotateCase,
  captureUiCheckScreenshot,
  clearTodayAsupan,
  createAsupanViaApi,
  defaultCredentials,
  expectDashboardSugarTotal,
  loginThroughUi,
  setActualResult,
  snapshotResponse,
  todayDateString,
} from '../utils/sqa-helpers.js';

test.describe.serial('NutriTrack SQA automated test cases', () => {
  test('TC-LOG-01 Login dengan kredensial valid', async ({ page }, testInfo) => {
    annotateCase(testInfo, {
      no: 1,
      testCaseId: 'TC-LOG-01',
      feature: 'Register & Login',
      description: 'Login dengan kredensial valid',
      precondition: `${defaultCredentials.email} sudah terdaftar dan aktif`,
      steps: [
        'Buka halaman Login',
        'Isi email dan password yang benar',
        'Klik tombol Masuk',
      ],
      testData: `Email: ${defaultCredentials.email}, Password: ${defaultCredentials.password}`,
      expectedResult: 'Login berhasil, user diarahkan ke Dashboard, muncul teks “Selamat datang”.',
      sqaMetric: 'Pass Rate',
      testType: 'Manual & Automated (Playwright)',
      owner: 'Fachri',
    });

    const loginResponsePromise = page.waitForResponse('**/api/login');
    await loginThroughUi(page);
    const loginResponse = await loginResponsePromise;
    addApiResponse(testInfo, {
      label: 'POST /api/login',
      request: {
        email: defaultCredentials.email,
        password: '[REDACTED]',
      },
      response: await snapshotResponse(loginResponse),
    });
    await expect(page).toHaveURL(/\/dashboard$/);
    await expect(page.getByTestId('dashboard-welcome')).toContainText('Selamat datang');

    setActualResult(testInfo, 'Login berhasil menggunakan kredensial valid, user diarahkan ke /dashboard, dan teks sambutan "Selamat datang" tampil.');
  });

  test('TC-DASH-01 Dashboard menampilkan total gula harian yang akurat', async ({ page }, testInfo) => {
    annotateCase(testInfo, {
      no: 3,
      testCaseId: 'TC-DASH-01',
      feature: 'Dashboard',
      description: 'Dashboard menampilkan total gula harian yang akurat',
      precondition: 'User sudah login dan sudah ada data asupan hari ini',
      steps: [
        'Login ke sistem',
        'Siapkan data asupan hari ini sebesar 30g dan 20g',
        'Buka Dashboard',
        'Periksa widget total konsumsi gula harian',
      ],
      testData: '30g gula pagi + 20g gula siang = 50g',
      expectedResult: 'Dashboard menampilkan total gula harian = 50g sesuai input.',
      sqaMetric: 'Pass Rate, API Performance',
      testType: 'Manual & Automated (Playwright)',
      owner: 'Raysa',
    });

    await loginThroughUi(page);
    await clearTodayAsupan(page);

    const firstPayload = {
      nama: 'Teh Manis Pagi',
      porsi: 1,
      kadar_gula: 30,
      kadar_kalori: 120,
      tanggal_konsumsi: todayDateString(),
      waktu_konsumsi: 'Pagi',
      catatan: 'Setup TC-DASH-01 pagi',
    };
    const firstResponse = await createAsupanViaApi(page, firstPayload);
    addApiResponse(testInfo, {
      label: 'POST /api/asupan (setup pagi)',
      request: firstPayload,
      response: firstResponse,
    });

    const secondPayload = {
      nama: 'Teh Manis Siang',
      porsi: 1,
      kadar_gula: 20,
      kadar_kalori: 80,
      tanggal_konsumsi: todayDateString(),
      waktu_konsumsi: 'Siang',
      catatan: 'Setup TC-DASH-01 siang',
    };
    const secondResponse = await createAsupanViaApi(page, secondPayload);
    addApiResponse(testInfo, {
      label: 'POST /api/asupan (setup siang)',
      request: secondPayload,
      response: secondResponse,
    });

    await expectDashboardSugarTotal(page, 50);
    await expect(page.getByTestId('dashboard-entry-count')).toContainText('2 catatan');
    const sugarTotalText = (await page.getByTestId('dashboard-sugar-total').innerText()).trim();
    const entryCountText = (await page.getByTestId('dashboard-entry-count').innerText()).trim();
    const dashUiScreenshot = await captureUiCheckScreenshot(
      page,
      testInfo,
      'tc-dash-01-dashboard-widget.png'
    );
    addUiCheck(testInfo, {
      label: 'Periksa widget total konsumsi gula harian',
      page: '/dashboard',
      current_url: page.url(),
      selector: '[data-testid="dashboard-sugar-total"]',
      expected: 'Widget menampilkan "Total: 50 dari 50 gram".',
      observed: 'Dashboard widget kadar gula harian dan ringkasan jumlah catatan berhasil diverifikasi di halaman dashboard.',
      assertions: [
        {
          text: 'Assert [data-testid="dashboard-sugar-total"] contains "Total: 50".',
          status: 'passed',
        },
        {
          text: 'Assert [data-testid="dashboard-entry-count"] contains "2 catatan".',
          status: 'passed',
        },
      ],
      captured_text: [
        `dashboard-sugar-total => ${sugarTotalText}`,
        `dashboard-entry-count => ${entryCountText}`,
      ],
      notes: [
        'Data dashboard diverifikasi setelah dua data asupan setup dibuat: 30g pagi dan 20g siang.',
        'Verifikasi ini membuktikan langkah "Periksa widget total konsumsi gula harian" benar-benar dilakukan di UI, bukan hanya lewat API setup.',
      ],
      screenshot: dashUiScreenshot,
    });

    setActualResult(testInfo, 'Data setup 30g + 20g berhasil dibuat dan dashboard menampilkan total gula harian 50 gram dengan 2 catatan asupan.');
  });

  test('TC-CA-01 Input asupan makanan/minuman dengan data valid', async ({ page }, testInfo) => {
    annotateCase(testInfo, {
      no: 4,
      testCaseId: 'TC-CA-01',
      feature: 'Catat Asupan',
      description: 'Input asupan makanan/minuman dengan data valid',
      precondition: 'User sudah login',
      steps: [
        'Buka menu Catat Asupan',
        'Isi data makanan/minuman',
        'Klik Simpan',
        'Periksa Dashboard',
      ],
      testData: 'Makanan: Teh Manis, Porsi: 1, Kadar gula: 15g, Kadar kalori: 60 kcal',
      expectedResult: 'Asupan berhasil disimpan, total gula Dashboard terupdate (+15g).',
      sqaMetric: 'Pass Rate, API Performance',
      testType: 'Manual & Automated (Playwright)',
      owner: 'Fachri',
    });

    await loginThroughUi(page);
    await clearTodayAsupan(page);

    await page.goto('/asupan');
    const submitResponsePromise = page.waitForResponse('**/asupan');
    await page.getByTestId('asupan-porsi').fill('1');
    await page.getByTestId('asupan-nama').fill('Teh Manis');
    await page.getByTestId('asupan-gula').fill('15');
    await page.getByTestId('asupan-kalori').fill('60');
    await page.getByTestId('asupan-tanggal').fill(todayDateString());
    await page.getByTestId('asupan-waktu').fill('Pagi');
    await page.getByTestId('asupan-catatan').fill('Playwright TC-CA-01');
    await page.getByTestId('asupan-submit').click();
    const submitResponse = await submitResponsePromise;

    await expect(page.getByText('Asupan berhasil disimpan')).toBeVisible();
    addApiResponse(testInfo, {
      label: 'POST /asupan',
      request: {
        nama: 'Teh Manis',
        porsi: '1',
        kadar_gula: '15',
        kadar_kalori: '60',
        tanggal_konsumsi: todayDateString(),
        waktu_konsumsi: 'Pagi',
        catatan: 'Playwright TC-CA-01',
      },
      response: {
        status: submitResponse.status(),
        url: submitResponse.url(),
      },
    });

    await expectDashboardSugarTotal(page, 15);
    await expect(page.getByText('Teh Manis')).toBeVisible();
    const dashboardSugarText = (await page.getByTestId('dashboard-sugar-total').innerText()).trim();
    const tehManisText = (await page.getByText('Teh Manis').first().innerText()).trim();
    const asupanUiScreenshot = await captureUiCheckScreenshot(
      page,
      testInfo,
      'tc-ca-01-dashboard-verification.png'
    );
    addUiCheck(testInfo, {
      label: 'Periksa Dashboard',
      page: '/dashboard',
      current_url: page.url(),
      selector: '[data-testid="dashboard-sugar-total"] and text=Teh Manis',
      expected: 'Dashboard menampilkan total gula 15 gram dan riwayat asupan Teh Manis.',
      observed: 'Setelah submit asupan dari halaman Catat Asupan, dashboard dibuka kembali dan hasilnya diverifikasi langsung di UI.',
      assertions: [
        {
          text: 'Assert [data-testid="dashboard-sugar-total"] contains "Total: 15".',
          status: 'passed',
        },
        {
          text: 'Assert text "Teh Manis" is visible in riwayat asupan hari ini.',
          status: 'passed',
        },
      ],
      captured_text: [
        `dashboard-sugar-total => ${dashboardSugarText}`,
        `riwayat-item => ${tehManisText}`,
      ],
      notes: [
        'UI verification dilakukan setelah form submit berhasil dan toast sukses muncul.',
        'Verifikasi ini mencakup total gula harian serta kemunculan item riwayat asupan yang baru dibuat.',
      ],
      screenshot: asupanUiScreenshot,
    });

    setActualResult(testInfo, 'Input asupan valid berhasil disimpan dari halaman Catat Asupan dan dashboard menampilkan total gula harian 15 gram serta riwayat Teh Manis.');
  });

  test('TC-ADM-05 User biasa tidak dapat mengakses panel admin', async ({ page }, testInfo) => {
    annotateCase(testInfo, {
      no: 5,
      testCaseId: 'TC-ADM-05',
      feature: 'Admin: Manajemen Konten Sehat',
      description: 'User biasa tidak dapat mengakses panel admin',
      precondition: 'Login sebagai user biasa (bukan admin)',
      steps: [
        'Login sebagai user biasa',
        'Akses URL panel admin secara langsung',
      ],
      testData: 'URL: /admin/dashboard',
      expectedResult: 'Akses ditolak, diarahkan ke halaman 403/404 atau redirect ke halaman user.',
      sqaMetric: 'Pass Rate, Bug Severity (Critical)',
      testType: 'Automated (Playwright)',
      owner: 'Fachri',
    });

    await loginThroughUi(page);
    await page.goto('/admin/dashboard');

    await expect(page).toHaveURL(/\/dashboard$/);
    await expect(page.getByTestId('dashboard-welcome')).toContainText('Selamat datang');

    setActualResult(testInfo, 'Akses /admin/dashboard sebagai user biasa ditolak oleh middleware dan browser diarahkan kembali ke halaman /dashboard.');
  });

  test('TC-LOG-04 Uji keamanan login brute force protection', async ({ page }, testInfo) => {
    annotateCase(testInfo, {
      no: 2,
      testCaseId: 'TC-LOG-04',
      feature: 'Register & Login',
      description: 'Uji keamanan login brute force protection',
      precondition: 'Akun sudah terdaftar',
      steps: [
        'Buka halaman Login',
        'Coba login dengan password salah sebanyak 5x berturut-turut',
        'Lakukan percobaan tambahan untuk memastikan rate limit aktif',
        'Observasi respons sistem',
      ],
      testData: `Email: ${defaultCredentials.email}, Password salah berulang`,
      expectedResult: 'Sistem memberi notifikasi peringatan atau membatasi percobaan login.',
      sqaMetric: 'Bug Severity (Critical)',
      testType: 'Automated (Playwright)',
      owner: 'Fachri',
    });

    await page.goto('/login');
    const observedStatuses = [];
    const observedResponses = [];

    for (let attempt = 1; attempt <= 5; attempt += 1) {
      const responsePromise = page.waitForResponse('**/api/login');
      await page.getByTestId('login-email').fill(defaultCredentials.email);
      await page.getByTestId('login-password').fill(`wrong-password-${attempt}`);
      await page.getByTestId('login-submit').click();
      const response = await responsePromise;
      observedStatuses.push(response.status());
      observedResponses.push({
        attempt,
        response: await snapshotResponse(response, { includeBody: true }),
      });
      await expect(
        page.getByRole('listitem').filter({ hasText: 'Email atau password salah.' }).first()
      ).toBeVisible();
    }

    const blockedResponsePromise = page.waitForResponse('**/api/login');
    await page.getByTestId('login-email').fill(defaultCredentials.email);
    await page.getByTestId('login-password').fill('wrong-password-6');
    await page.getByTestId('login-submit').click();
    const blockedResponse = await blockedResponsePromise;
    observedStatuses.push(blockedResponse.status());
    observedResponses.push({
      attempt: 6,
      response: await snapshotResponse(blockedResponse, { includeBody: true }),
    });

    addApiResponse(testInfo, {
      label: 'POST /api/login brute force attempts',
      request: {
        email: defaultCredentials.email,
        password: '[WRONG_PASSWORD_REPEATED]',
      },
      response: observedResponses,
    });

    setActualResult(
      testInfo,
      `Observed status sequence for wrong-password attempts: ${observedStatuses.join(', ')}. Expected the final attempt to return 429 rate-limited response.`
    );
    expect(blockedResponse.status(), 'Final repeated login attempt should be rate-limited').toBe(429);
  });
});
