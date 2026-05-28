import { expect, test } from '@playwright/test';

const PASSWORD = 'Test@12345';
const APP_URL = process.env.PLAYWRIGHT_BASE_URL || 'http://127.0.0.1:8000';

const SQA_CASES = {
  'TC-LOG-01': {
    feature: 'Register & Login',
    actualResult:
      'POST /api/login succeeds from the UI, redirects the user to /dashboard, and shows the welcome message.',
  },
  'TC-LOG-04': {
    feature: 'Register & Login',
    actualResult:
      'Repeated invalid login attempts eventually trigger the login rate limiter and return HTTP 429.',
  },
  'TC-DASH-01': {
    feature: 'Dashboard',
    actualResult:
      'Two asupan setup records are reflected on the dashboard with total gula 50 gram and 2 daily entries.',
  },
  'TC-CA-01': {
    feature: 'Catat Asupan',
    actualResult:
      'Submitting the asupan form stores the record successfully and updates the dashboard sugar total.',
  },
  'TC-ADM-05': {
    feature: 'Admin: Manajemen Konten Sehat',
    actualResult:
      'A regular user attempting to open /admin/dashboard is redirected back to /dashboard.',
  },
};

function uniqueIdentity(prefix) {
  const stamp = `${Date.now()}-${Math.random().toString(36).slice(2, 8)}`;

  return {
    name: `${prefix} ${stamp}`,
    email: `${prefix.toLowerCase().replace(/\s+/g, '.')}.${stamp}@example.com`,
    password: PASSWORD,
  };
}

async function registerUser(request, user) {
  const response = await request.post('/api/register', {
    data: {
      name: user.name,
      email: user.email,
      password: user.password,
      password_confirmation: user.password,
    },
  });

  expect(response.ok()).toBeTruthy();

  const payload = await response.json();

  return {
    ...user,
    token: payload.token,
    id: payload.user?.id,
  };
}

async function seedAsupan(request, token, data) {
  const response = await request.post('/api/asupan', {
    headers: {
      Authorization: `Bearer ${token}`,
      Accept: 'application/json',
    },
    data,
  });

  expect(response.status()).toBe(201);
  return response.json();
}

async function authenticatePage(page, token, baseURL) {
  const cookieUrl = new URL('/', baseURL || APP_URL).toString();

  await page.context().addCookies([
    {
      name: 'nutri_token',
      value: token,
      url: cookieUrl,
    },
  ]);

  await page.addInitScript((value) => {
    window.localStorage.setItem('nutri_access_token', value);
  }, token);
}

async function loginThroughUi(page, user) {
  await page.goto('/login');
  await expect(page.getByTestId('login-page-title')).toBeVisible();

  await page.getByTestId('login-email').fill(user.email);
  await page.getByTestId('login-password').fill(user.password);

  const [response] = await Promise.all([
    page.waitForResponse((candidate) => candidate.url().includes('/api/login') && candidate.request().method() === 'POST'),
    page.getByTestId('login-submit').click(),
  ]);

  return response;
}

function annotateSqa(testInfo, testcaseId) {
  const detail = SQA_CASES[testcaseId];
  testInfo.annotations.push({ type: 'testcase_id', description: testcaseId });
  testInfo.annotations.push({ type: 'feature', description: detail.feature });
  testInfo.annotations.push({ type: 'actual_result', description: detail.actualResult });
}

test.describe('SQA Playwright coverage', () => {
  test('TC-LOG-01 valid user can log in from the UI', async ({ page, request }, testInfo) => {
    annotateSqa(testInfo, 'TC-LOG-01');

    const user = await registerUser(request, uniqueIdentity('log01'));
    const response = await loginThroughUi(page, user);

    expect(response.status()).toBe(200);
    await expect(page).toHaveURL(/\/dashboard$/);
    await expect(page.getByTestId('dashboard-welcome')).toContainText('Selamat datang');
  });

  test('TC-LOG-04 invalid login is rate limited after repeated attempts', async ({ page, request }, testInfo) => {
    annotateSqa(testInfo, 'TC-LOG-04');

    const user = await registerUser(request, uniqueIdentity('log04'));

    await page.goto('/login');
    await page.getByTestId('login-email').fill(user.email);

    for (let attempt = 1; attempt <= 5; attempt += 1) {
      await page.getByTestId('login-password').fill(`WrongPassword-${attempt}`);

      const [response] = await Promise.all([
        page.waitForResponse((candidate) => candidate.url().includes('/api/login') && candidate.request().method() === 'POST'),
        page.getByTestId('login-submit').click(),
      ]);

      expect(response.status(), `attempt ${attempt} should still be rejected as invalid credentials`).toBe(422);
      await expect(page.getByRole('listitem').filter({ hasText: 'Email atau password salah.' })).toBeVisible();
    }

    await page.getByTestId('login-password').fill('WrongPassword-final');

    const [blockedResponse] = await Promise.all([
      page.waitForResponse((candidate) => candidate.url().includes('/api/login') && candidate.request().method() === 'POST'),
      page.getByTestId('login-submit').click(),
    ]);

    expect(blockedResponse.status()).toBe(429);
    await expect(page.getByRole('alert').filter({ hasText: 'Terlalu banyak percobaan login.' })).toBeVisible();
  });

  test('TC-DASH-01 dashboard shows daily totals from seeded asupan records', async ({ page, request, baseURL }, testInfo) => {
    annotateSqa(testInfo, 'TC-DASH-01');

    const user = await registerUser(request, uniqueIdentity('dash01'));
    const today = new Date().toISOString().split('T')[0];

    await seedAsupan(request, user.token, {
      nama: 'Jus Jeruk',
      porsi: 1,
      kadar_gula: 20,
      kadar_kalori: 90,
      tanggal_konsumsi: today,
      waktu_konsumsi: 'Pagi',
      catatan: 'Setup 1',
    });

    await seedAsupan(request, user.token, {
      nama: 'Teh Manis',
      porsi: 2,
      kadar_gula: 15,
      kadar_kalori: 80,
      tanggal_konsumsi: today,
      waktu_konsumsi: 'Siang',
      catatan: 'Setup 2',
    });

    await authenticatePage(page, user.token, baseURL);
    await page.goto('/dashboard');

    await expect(page.getByTestId('dashboard-sugar-total')).toContainText('Total: 50');
    await expect(page.getByTestId('dashboard-entry-count')).toHaveText('2 catatan');
    await expect(page.getByTestId('dashboard-today-list')).toContainText('Jus Jeruk');
    await expect(page.getByTestId('dashboard-today-list')).toContainText('Teh Manis');
  });

  test('TC-CA-01 user can submit asupan form and see updated dashboard summary', async ({ page, request, baseURL }, testInfo) => {
    annotateSqa(testInfo, 'TC-CA-01');

    const user = await registerUser(request, uniqueIdentity('ca01'));
    const today = new Date().toISOString().split('T')[0];

    await authenticatePage(page, user.token, baseURL);
    await page.goto('/asupan');

    await page.getByTestId('asupan-porsi').fill('2');
    await page.getByTestId('asupan-nama').fill('Smoothie Mangga');
    await page.getByTestId('asupan-gula').fill('12');
    await page.getByTestId('asupan-kalori').fill('100');
    await page.getByTestId('asupan-tanggal').fill(today);
    await page.getByTestId('asupan-waktu').fill('Sore');
    await page.getByTestId('asupan-catatan').fill('Tes input Playwright');

    const [response] = await Promise.all([
      page.waitForResponse((candidate) => candidate.url().endsWith('/asupan') && candidate.request().method() === 'POST'),
      page.getByTestId('asupan-submit').click(),
    ]);

    expect(response.status()).toBe(201);
    await expect(page.getByRole('alert').filter({ hasText: 'Asupan berhasil disimpan' })).toBeVisible();

    await page.goto('/dashboard');
    await expect(page.getByTestId('dashboard-sugar-total')).toContainText('Total: 24');
    await expect(page.getByTestId('dashboard-entry-count')).toHaveText('1 catatan');
    await expect(page.getByTestId('dashboard-today-list')).toContainText('Smoothie Mangga');
  });

  test('TC-ADM-05 regular user is redirected away from admin dashboard', async ({ page, request, baseURL }, testInfo) => {
    annotateSqa(testInfo, 'TC-ADM-05');

    const user = await registerUser(request, uniqueIdentity('adm05'));

    await authenticatePage(page, user.token, baseURL);
    await page.goto('/admin/dashboard');

    await expect(page).toHaveURL(/\/dashboard$/);
    await expect(page.getByTestId('dashboard-welcome')).toContainText('Selamat datang');
  });
});
