import fs from 'node:fs';
import path from 'node:path';

function parseAnnotation(test, type) {
  const found = test.annotations.find((annotation) => annotation.type === type);
  if (!found?.description) {
    return null;
  }

  try {
    return JSON.parse(found.description);
  } catch {
    return found.description;
  }
}

function parseAnnotations(test, type) {
  return test.annotations
    .filter((annotation) => annotation.type === type && annotation.description)
    .map((annotation) => {
      try {
        return JSON.parse(annotation.description);
      } catch {
        return annotation.description;
      }
    });
}

export default class SqaDetailReporter {
  constructor() {
    this.results = [];
  }

  onTestEnd(test, result) {
    const meta = parseAnnotation(test, 'case-meta') || {};
    const actual = parseAnnotation(test, 'actual-result');
    const apiResponses = parseAnnotations(test, 'api-response');
    const uiChecks = parseAnnotations(test, 'ui-check');

    this.results.push({
      no: meta.no ?? null,
      test_case_id: meta.testCaseId ?? test.title,
      feature: meta.feature ?? '',
      description: meta.description ?? test.title,
      precondition: meta.precondition ?? '',
      test_steps: meta.steps ?? [],
      test_data: meta.testData ?? '',
      expected_result: meta.expectedResult ?? '',
      sqa_metric: meta.sqaMetric ?? '',
      test_type: meta.testType ?? '',
      owner: meta.owner ?? '',
      status: result.status,
      duration_ms: result.duration,
      actual_result: actual ?? (result.status === 'passed' ? 'Test berjalan sesuai ekspektasi.' : result.error?.message || 'Test gagal.'),
      api_responses: apiResponses,
      ui_checks: uiChecks,
      error: result.error?.message ?? null,
    });
  }

  async onEnd() {
    const outputDir = path.resolve(process.cwd(), 'playwright-results');
    fs.mkdirSync(outputDir, { recursive: true });

    const lines = [
      '# Playwright SQA Summary',
      '',
      '| No | Test Case ID | Fitur | Status | Actual Result | Durasi (ms) |',
      '| --- | --- | --- | --- | --- | ---: |',
      ...this.results.map((item) => {
        const actual = String(item.actual_result).replace(/\r?\n/g, ' ').replace(/\|/g, '\\|');
        return `| ${item.no ?? ''} | ${item.test_case_id} | ${item.feature} | ${item.status.toUpperCase()} | ${actual} | ${item.duration_ms} |`;
      }),
      '',
      '## Detail',
      '',
      ...this.results.flatMap((item) => [
        `### ${item.test_case_id} - ${item.feature}`,
        `- Deskripsi: ${item.description}`,
        `- Precondition: ${item.precondition}`,
        `- Langkah Uji: ${Array.isArray(item.test_steps) ? item.test_steps.join(' | ') : item.test_steps}`,
        `- Data Uji: ${item.test_data}`,
        `- Expected Result: ${item.expected_result}`,
        `- Actual Result: ${item.actual_result}`,
        ...(item.ui_checks?.length
          ? [`- UI Checks: ${item.ui_checks.map((entry) => JSON.stringify(entry)).join(' | ')}`]
          : []),
        ...(item.api_responses?.length
          ? [`- API Responses: ${item.api_responses.map((entry) => JSON.stringify(entry)).join(' | ')}`]
          : []),
        `- Metrik SQA: ${item.sqa_metric}`,
        `- Jenis Uji: ${item.test_type}`,
        `- PJ Testing: ${item.owner}`,
        `- Status: ${item.status.toUpperCase()}`,
        `- Durasi: ${item.duration_ms} ms`,
        '',
      ]),
    ];

    fs.writeFileSync(path.join(outputDir, 'sqa-summary.md'), lines.join('\n'), 'utf8');

    const rows = this.results.map((item) => `
      <tr>
        <td>${item.no ?? ''}</td>
        <td>${escapeHtml(item.test_case_id)}</td>
        <td>${escapeHtml(item.feature)}</td>
        <td class="status ${item.status}">${escapeHtml(item.status.toUpperCase())}</td>
        <td>${escapeHtml(String(item.actual_result))}</td>
        <td>${item.duration_ms}</td>
      </tr>
    `).join('');

    const details = this.results.map((item) => `
      <section class="card">
        <h2>${escapeHtml(item.test_case_id)} - ${escapeHtml(item.feature)}</h2>
        <table class="detail-table">
          <tbody>
            <tr><th>Deskripsi</th><td>${escapeHtml(item.description)}</td></tr>
            <tr><th>Precondition</th><td>${escapeHtml(item.precondition)}</td></tr>
            <tr><th>Langkah Uji</th><td>${escapeHtml(Array.isArray(item.test_steps) ? item.test_steps.join(' | ') : String(item.test_steps))}</td></tr>
            <tr><th>Data Uji</th><td>${escapeHtml(item.test_data)}</td></tr>
            <tr><th>Expected Result</th><td>${escapeHtml(item.expected_result)}</td></tr>
            <tr><th>Actual Result</th><td>${escapeHtml(String(item.actual_result))}</td></tr>
            <tr><th>Metrik SQA</th><td>${escapeHtml(item.sqa_metric)}</td></tr>
            <tr><th>Jenis Uji</th><td>${escapeHtml(item.test_type)}</td></tr>
            <tr><th>PJ Testing</th><td>${escapeHtml(item.owner)}</td></tr>
            <tr><th>Status</th><td><span class="status ${item.status}">${escapeHtml(item.status.toUpperCase())}</span></td></tr>
            <tr><th>Durasi</th><td>${item.duration_ms} ms</td></tr>
          </tbody>
        </table>
        ${renderUiChecks(item.ui_checks)}
        ${renderApiResponses(item.api_responses)}
      </section>
    `).join('');

    const html = `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Playwright SQA Summary</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 32px; color: #1f2937; background: #f8fafc; }
    h1 { margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; background: white; margin-bottom: 32px; }
    th, td { border: 1px solid #d1d5db; padding: 12px; text-align: left; vertical-align: top; }
    th { background: #e5e7eb; }
    .card { background: white; border: 1px solid #d1d5db; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
    .api-block { margin-top: 12px; padding: 12px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px; }
    .detail-table { margin-bottom: 16px; }
    .detail-table th { width: 180px; background: #f3f4f6; }
    .section-table th { width: 180px; background: #f9fafb; }
    .assertion-table th { background: #f9fafb; }
    .badge { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .badge.passed { background: #dcfce7; color: #166534; }
    .badge.failed { background: #fee2e2; color: #991b1b; }
    .badge.skipped { background: #e5e7eb; color: #374151; }
    .screenshot { margin-top: 12px; max-width: 100%; border: 1px solid #d1d5db; border-radius: 8px; }
    pre { white-space: pre-wrap; word-break: break-word; background: #111827; color: #f9fafb; padding: 12px; border-radius: 8px; overflow-x: auto; }
    .status { font-weight: 700; }
    .status.passed { color: #15803d; }
    .status.failed { color: #b91c1c; }
    .status.timedout { color: #b45309; }
    .status.skipped { color: #6b7280; }
  </style>
</head>
<body>
  <h1>Playwright SQA Summary</h1>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Test Case ID</th>
        <th>Fitur</th>
        <th>Status</th>
        <th>Actual Result</th>
        <th>Durasi (ms)</th>
      </tr>
    </thead>
    <tbody>${rows}</tbody>
  </table>
  ${details}
</body>
</html>`;

    fs.writeFileSync(path.join(outputDir, 'sqa-summary.html'), html, 'utf8');
  }
}

function escapeHtml(value) {
  return String(value)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;');
}

function renderApiResponses(apiResponses = []) {
  if (!apiResponses.length) {
    return '';
  }

  const blocks = apiResponses.map((entry, index) => `
    <div class="api-block">
      <p><strong>API ${index + 1}${entry.label ? ` - ${escapeHtml(entry.label)}` : ''}</strong></p>
      <table class="section-table">
        <tbody>
          ${entry.request ? `<tr><th>Request</th><td><pre>${escapeHtml(JSON.stringify(entry.request, null, 2))}</pre></td></tr>` : ''}
          ${entry.response ? `<tr><th>Response</th><td><pre>${escapeHtml(JSON.stringify(entry.response, null, 2))}</pre></td></tr>` : ''}
        </tbody>
      </table>
    </div>
  `).join('');

  return `<div><strong>API Responses:</strong>${blocks}</div>`;
}

function renderUiChecks(uiChecks = []) {
  if (!uiChecks.length) {
    return '';
  }

  const blocks = uiChecks.map((entry, index) => `
    <div class="api-block">
      <p><strong>UI Check ${index + 1}${entry.label ? ` - ${escapeHtml(entry.label)}` : ''}</strong></p>
      <table class="section-table">
        <tbody>
          ${entry.page ? `<tr><th>Page</th><td>${escapeHtml(entry.page)}</td></tr>` : ''}
          ${entry.current_url ? `<tr><th>Current URL</th><td>${escapeHtml(entry.current_url)}</td></tr>` : ''}
          ${entry.selector ? `<tr><th>Selector</th><td>${escapeHtml(entry.selector)}</td></tr>` : ''}
          ${entry.expected ? `<tr><th>Expected</th><td>${escapeHtml(entry.expected)}</td></tr>` : ''}
          ${entry.observed ? `<tr><th>Observed</th><td>${escapeHtml(entry.observed)}</td></tr>` : ''}
        </tbody>
      </table>
      ${entry.assertions?.length ? `
        <table class="assertion-table">
          <thead>
            <tr><th>Assertion</th><th>Status</th></tr>
          </thead>
          <tbody>
            ${entry.assertions.map((assertion) => `
              <tr>
                <td>${escapeHtml(assertion.text ?? String(assertion))}</td>
                <td><span class="badge ${(assertion.status || 'passed')}">${escapeHtml((assertion.status || 'passed').toUpperCase())}</span></td>
              </tr>
            `).join('')}
          </tbody>
        </table>
      ` : ''}
      ${entry.captured_text?.length ? `
        <table class="assertion-table">
          <thead><tr><th>Captured Text</th></tr></thead>
          <tbody>${entry.captured_text.map((text) => `<tr><td>${escapeHtml(text)}</td></tr>`).join('')}</tbody>
        </table>
      ` : ''}
      ${entry.notes?.length ? `
        <table class="assertion-table">
          <thead><tr><th>Notes</th></tr></thead>
          <tbody>${entry.notes.map((note) => `<tr><td>${escapeHtml(note)}</td></tr>`).join('')}</tbody>
        </table>
      ` : ''}
      ${entry.screenshot ? `<div><strong>Screenshot:</strong><br><img class="screenshot" src="${escapeHtml(entry.screenshot)}" alt="${escapeHtml(entry.label || `UI Check ${index + 1}`)}"></div>` : ''}
    </div>
  `).join('');

  return `<div><strong>UI Checks:</strong>${blocks}</div>`;
}
