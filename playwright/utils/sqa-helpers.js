import { expect } from '@playwright/test';
import fs from 'node:fs';
import path from 'node:path';

const defaultCredentials = {
  email: process.env.E2E_EMAIL || 'guje2341@gmail.com',
  password: process.env.E2E_PASSWORD || 'test123456',
};

export function annotateCase(testInfo, meta) {
  testInfo.annotations.push({
    type: 'case-meta',
    description: JSON.stringify(meta),
  });
}

export function setActualResult(testInfo, actualResult) {
  testInfo.annotations.push({
    type: 'actual-result',
    description: JSON.stringify(actualResult),
  });
}

export function addApiResponse(testInfo, apiResponse) {
  testInfo.annotations.push({
    type: 'api-response',
    description: JSON.stringify(apiResponse),
  });
}

export function addUiCheck(testInfo, uiCheck) {
  testInfo.annotations.push({
    type: 'ui-check',
    description: JSON.stringify(uiCheck),
  });
}

export async function captureUiCheckScreenshot(page, testInfo, fileName) {
  const directory = path.resolve(process.cwd(), 'playwright-results', 'ui-checks');
  fs.mkdirSync(directory, { recursive: true });

  const targetPath = path.join(directory, sanitizeFileName(fileName));
  await page.screenshot({
    path: targetPath,
    fullPage: true,
  });

  return `ui-checks/${path.basename(targetPath)}`;
}

export async function snapshotResponse(response, options = {}) {
  const snapshot = {
    status: response.status(),
    url: response.url(),
    headers: await response.allHeaders(),
  };

  if (options.includeBody) {
    try {
      const text = await response.text();
      snapshot.body = tryParseJson(text);
    } catch {
      snapshot.body = '[response body unavailable]';
    }
  }

  return snapshot;
}

export async function loginThroughUi(page, credentials = defaultCredentials) {
  await page.goto('/login');
  await expect(page.getByTestId('login-page-title')).toBeVisible();
  await page.getByTestId('login-email').fill(credentials.email);
  await page.getByTestId('login-password').fill(credentials.password);
  await page.getByTestId('login-submit').click();
  await page.waitForURL('**/dashboard');
  await expect(page.getByTestId('dashboard-welcome')).toContainText('Selamat datang');
}

export async function logoutIfNeeded(page) {
  await page.goto('/dashboard');

  const loginButton = page.getByTestId('login-submit');
  if (await loginButton.isVisible().catch(() => false)) {
    return;
  }

  page.once('dialog', (dialog) => dialog.dismiss().catch(() => {}));
  await page.evaluate(async () => {
    await fetch('/api/logout', {
      method: 'POST',
      headers: {
        Accept: 'application/json',
      },
    });
  });
}

export async function fetchDashboardData(page) {
  return page.evaluate(async () => {
    const response = await fetch('/api/dashboard', {
      headers: {
        Accept: 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error(`Failed to fetch dashboard data: ${response.status}`);
    }

    return response.json();
  });
}

export async function clearTodayAsupan(page) {
  const dashboard = await fetchDashboardData(page);

  for (const item of dashboard.today_asupan || []) {
    await page.evaluate(async (id) => {
      const response = await fetch(`/api/asupan/${id}`, {
        method: 'DELETE',
        headers: {
          Accept: 'application/json',
        },
      });

      if (!response.ok) {
        throw new Error(`Failed to delete asupan ${id}: ${response.status}`);
      }
    }, item.id);
  }
}

export async function createAsupanViaApi(page, payload) {
  return page.evaluate(async (input) => {
    const response = await fetch('/api/asupan', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(input),
    });

    if (!response.ok) {
      const body = await response.text();
      throw new Error(`Failed to create asupan: ${response.status} ${body}`);
    }

    return response.json();
  }, payload);
}

export async function expectDashboardSugarTotal(page, expectedTotal) {
  await page.goto('/dashboard');
  await expect(page.getByTestId('dashboard-sugar-total')).toContainText(`Total: ${expectedTotal}`);
}

export function todayDateString() {
  const date = new Date();
  const timezoneOffset = date.getTimezoneOffset() * 60_000;
  return new Date(date.getTime() - timezoneOffset).toISOString().split('T')[0];
}

export { defaultCredentials };

function tryParseJson(text) {
  try {
    return JSON.parse(text);
  } catch {
    return text;
  }
}

function sanitizeFileName(value) {
  return value.replace(/[^a-zA-Z0-9._-]/g, '_');
}
