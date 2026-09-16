<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quotation QUO-2026-014</title>
    <style>
      :root {
        --navy: #0e223b;
        --navy-soft: #16324f;
        --teal: #0e7ba0;
        --teal-light: #eaf6f9;
        --gray: #6b7280;
        --gray-light: #f4f5f7;
        --border: #e3e6ea;
        --danger: #c0392b;
      }

      @page {
        size: A4;
        margin: 16mm 16mm 20mm 16mm;
      }

      * {
        box-sizing: border-box;
      }

      body {
        font-family:
          -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #1c1c1c;
        font-size: 10.5pt;
        line-height: 1.55;
        margin: 0;
        padding: 20px;
        background-color: #f9fafb;
      }

      .document-container {
        max-width: 800px;
        margin: 0 auto;
        background: #ffffff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      }

      /* ───────── Optima Sync branding strip ───────── */
      .powered-strip {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 7px;
        margin-bottom: 10px;
        opacity: 0.85;
      }
      .powered-strip img {
        height: 100px;
        width: auto;
        object-fit: contain;
      }
      .powered-strip span {
        font-size: 12px;
        color: var(--gray);
        letter-spacing: 0.2px;
      }

      /* ───────── Header ───────── */
      .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 16px;
        border-bottom: 3px solid;
        border-image: linear-gradient(90deg, var(--navy), var(--teal)) 1;
      }
      .org-block {
        display: flex;
        align-items: center;
        gap: 12px;
      }
      .org-block img.org-logo {
        height: 46px;
        width: auto;
        max-width: 160px;
        object-fit: contain;
      }
      .org-name {
        font-size: 13pt;
        font-weight: 700;
        color: var(--navy);
        margin: 0;
      }
      .org-meta {
        font-size: 8.5pt;
        color: var(--gray);
        margin-top: 2px;
      }

      .doc-title-block {
        text-align: right;
      }
      .doc-title {
        font-size: 17pt;
        font-weight: 800;
        color: var(--navy);
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }
      .doc-ref {
        font-size: 9.5pt;
        color: var(--teal);
        font-weight: 700;
      }

      /* ───────── Meta strip ───────── */
      .meta-strip {
        display: flex;
        margin: 16px 0 20px 0;
        background: var(--gray-light);
        border-radius: 8px;
        overflow: hidden;
      }
      .meta-item {
        flex: 1;
        padding: 10px 14px;
        border-right: 1px solid var(--border);
      }
      .meta-item:last-child {
        border-right: none;
      }
      .meta-label {
        font-size: 7.5pt;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        margin-bottom: 3px;
      }
      .meta-value {
        font-size: 9.5pt;
        font-weight: 700;
        color: var(--navy);
      }

      /* ───────── Prepared-for card ───────── */
      .prepared-for {
        display: flex;
        align-items: center;
        gap: 14px;
        background: linear-gradient(135deg, var(--teal-light) 0%, #ffffff 100%);
        border: 1px solid var(--border);
        border-right: 4px solid var(--teal);
        border-radius: 10px;
        border-color: #020202;
        padding: 14px 18px;
        margin-bottom: 20px;
      }
      .client-logo-box {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        background: var(--navy);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18pt;
        font-weight: 800;
        flex-shrink: 0;
        overflow: hidden;
      }
      .client-logo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #fff;
      }
      .prepared-eyebrow {
        font-size: 8pt;
        color: var(--teal);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        font-weight: 700;
        margin-bottom: 2px;
      }
      .prepared-name {
        font-size: 13pt;
        font-weight: 800;
        color: var(--navy);
      }
      .prepared-contact {
        font-size: 9pt;
        color: var(--gray);
        margin-top: 1px;
      }

      /* ───────── Project section ───────── */
      .project-title {
        font-size: 13.5pt;
        font-weight: 700;
        color: var(--navy);
        margin: 0 0 6px 0;
      }
      .project-description {
        font-size: 9.8pt;
        color: #333;
        text-align: justify;
        margin-bottom: 20px;
      }

      /* ───────── Section heading ───────── */
      .section-heading {
        font-size: 10.5pt;
        font-weight: 700;
        color: var(--navy);
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding-bottom: 5px;
        margin: 0 0 10px 0;
        border-bottom: 1.5px solid var(--navy);
      }

      /* ───────── Features list ───────── */
      .features-list {
        list-style: none;
        margin: 0 0 22px 0;
        padding: 0;
      }
      .features-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        padding: 5px 0;
        font-size: 9.8pt;
        page-break-inside: avoid;
      }
      .check-icon {
        color: #377491;
        font-size: 13pt;
        font-weight: bold;
        line-height: 1;
        margin-top: -1px;
      }

      /* ───────── Costs table ───────── */
      .costs-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 22px;
        font-size: 9.3pt;
      }
      .costs-table th {
        color: var(--navy);
        text-align: left;
        padding: 7px 10px;
        font-weight: 700;
        font-size: 8.5pt;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border-bottom: 2px solid var(--navy);
      }
      .costs-table th.num,
      .costs-table td.num {
        text-align: right;
      }
      .costs-table td {
        padding: 7px 10px;
        border-bottom: 1px solid var(--border);
      }
      .costs-table tr:nth-child(even) td {
        background: var(--gray-light);
      }

      /* ───────── Pricing summary ───────── */
      .pricing-section {
        page-break-inside: avoid;
      }
      .pricing-wrap {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 22px;
      }
      .pricing-box {
        width: 100%;
        min-width: 280px;
      }
      .pricing-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 4px;
        font-size: 9.8pt;
        color: #333;
      }
      .pricing-row.discount-row {
        color: var(--danger);
      }
      .pricing-row.subtotal-row {
        border-top: 1px solid var(--border);
        margin-top: 4px;
        padding-top: 8px;
        font-weight: 700;
      }

      .pricing-row.total-row {
        color: #060606;
        border-bottom: 1px solid #060606;
        border-top: 1px solid #060606;
        padding: 12px 14px;
        margin-top: 8px;
        font-size: 12pt;
        font-weight: 800;
      }

      /* ───────── Payment terms ───────── */
      .payment-terms {
        background: var(--gray-light);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 10px;
        page-break-inside: avoid;
      }
      .payment-terms p {
        margin: 0;
        font-size: 9.5pt;
        color: #333;
        white-space: pre-line;
      }

      /* ───────── Footer ───────── */
      .doc-footer {
        margin-top: 24px;
        padding-top: 10px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 7.8pt;
        color: var(--gray);
        flex-wrap: nowrap;
        white-space: nowrap;
      }
      .doc-footer .footer-brand {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
      }
      .doc-footer img {
        height: 42px;
        width: auto;
        object-fit: contain;
      }

      .footer-link-row {
        text-align: center;
        margin-top: 8px;
        font-size: 7.5pt;
        color: var(--gray);
      }
      .footer-link-row a {
        color: var(--teal);
        text-decoration: none;
        font-weight: 600;
      }

      /* ───────── Signatures ───────── */
      .signature-section {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        margin: 26px 0 14px 0;
        page-break-inside: avoid;
      }
      .signature-block {
        flex: 1;
      }
      .signature-space {
        height: 50px;
        border-bottom: 1.5px solid var(--navy);
        margin-bottom: 8px;
      }
      .signature-label {
        font-size: 9pt;
        font-weight: 700;
        color: var(--navy);
      }
      .signature-meta {
        font-size: 8.5pt;
        color: var(--gray);
        margin-top: 7px;
        border-bottom: 1px dotted var(--border);
        padding-bottom: 3px;
        width: 80%;
      }

      .validity-note {
        font-size: 8pt;
        color: var(--gray);
        margin-top: 2px;
        font-style: italic;
      }
    </style>
  </head>
  
  </head>
<body>
    <div class="document-container">
      <div class="powered-strip">
        <img src="{{ $data['optimasync_logo'] }}" alt="Optima Sync Logo" />
      </div>

      <div class="doc-header">
        <div class="org-block">
          <div>
            <p class="org-name">{{ $data['organization_name'] }}</p>
            <p class="org-meta">{{ $data['org_location'] }}</p>
          </div>
        </div>

        <div class="doc-title-block">
          <p class="doc-ref">{{ $data['quo_number'] }}</p>
        </div>
      </div>

      <div class="meta-strip">
        <div class="meta-item">
          <div class="meta-label">Issue Date</div>
          <div class="meta-value">{{ $data['issue_date'] }}</div>
        </div>

        <div class="meta-item">
          <div class="meta-label">Directed To</div>
          <div class="meta-value">{{ $data['client_name'] }}</div>
        </div>

        <div class="meta-item">
          <div class="meta-label">Version</div>
          <div class="meta-value">v{{ $data['quotation_based_version_id'] }}</div>
        </div>

        <div class="meta-item">
          <div class="meta-label">Valid Until</div>
          <div class="meta-value">{{ $data['valid_until'] }}</div>
        </div>
      </div>

      <div class="prepared-for">
        <div>
          <div class="prepared-eyebrow">Prepared exclusively for</div>
          <div class="prepared-name">{{ $data['client_name'] }}</div>
        </div>
      </div>

      <p class="project-title">{{ $data['project_title'] }}</p>
      <p class="project-description">{{ $data['project_description'] }}</p>

      <div class="section-heading">Project Scope</div>
      <ul class="features-list">
        @foreach ($data['project_features'] as $feature)
          <li>
            <span class="check-icon">&#10003;</span>
            <span>
              <strong>{{ $feature['name'] }}</strong>
              @if (!empty($feature['description']))
                — {{ $feature['description'] }}
              @endif
            </span>
          </li>
        @endforeach
      </ul>

      <div class="section-heading">Pricing Summary</div>
      <table class="costs-table">
        <thead>
          <tr>
            <th>Description</th>
            <th class="num" style="width: 25%">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Development Fee</td>
            <td class="num">
              {{ number_format((float) $data['development_fee'], 2) }} {{ $data['currency'] }}
            </td>
          </tr>

          @foreach ($data['costs'] as $cost)
            <tr>
              <td>
                <strong>{{ $cost['title'] }}</strong>
                @if (!empty($cost['description']))
                  <br>
                  <span>{{ $cost['description'] }}</span>
                @endif
              </td>
              <td class="num">
                {{ number_format((float) $cost['amount'], 2) }} {{ $data['currency'] }}
              </td>
            </tr>
          @endforeach

          {{-- <tr class="summary-row subtotal-row">
            <td>Subtotal</td>
            <td class="num">
              {{ number_format((float) $data['subtotal'], 2) }} {{ $data['currency'] }}
            </td>
          </tr>

          @if ($data['tax'] !== null)
            <tr class="summary-row">
              <td>Tax</td>
              <td class="num">
                {{ number_format((float) $data['tax'], 2) }} {{ $data['currency'] }}
              </td>
            </tr>
          @endif

          @if ($data['discount'] !== null)
            <tr class="summary-row discount-row">
              <td>Discount</td>
              <td class="num">
                &minus; {{ number_format((float) $data['discount'], 2) }} {{ $data['currency'] }}
              </td>
            </tr>
          @endif --}}
{{--
          <tr class="summary-row total-row">
            <td>Total</td>
            <td class="num">
              {{ number_format((float) $data['total'], 2) }} {{ $data['currency'] }}
            </td>
          </tr> --}}
        </tbody>
      </table>

      <div class="pricing-section">
        <div class="pricing-wrap">
          <div class="pricing-box">
            <div class="pricing-row subtotal-row">
              <span>Subtotal</span>
              <span>{{ number_format((float) $data['subtotal'], 2) }} {{ $data['currency'] }}</span>
            </div>

            @if ($data['tax'] !== null)
              <div class="pricing-row">
                <span>Tax</span>
                <span>{{(int) $data['tax'] }} {{ $data['currency']}}</span>
              </div>
            @endif

            @if ($data['discount'] !== null)
              <div class="pricing-row discount-row">
                <span>Discount</span>
                <span>&minus; {{ (int)$data['discount'] }} {{ $data['currency'] }}</span>
              </div>
            @endif

            <div class="pricing-row total-row">
              <span>Total</span>
              <span>{{ number_format((float) $data['total'], 2) }} {{ $data['currency'] }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="section-heading">Payment Terms</div>
      <div class="payment-terms">
        <p>{{ $data['payment_terms'] }}</p>
      </div>

      <p class="validity-note">
        This quotation is valid until {{ $data['valid_until'] }}.
        Prices and scope are subject to change after this date.
      </p>

      <div class="signature-section">
        <div class="signature-block">
          <div class="signature-space"></div>
          <div class="signature-label">Authorized Signature — {{ $data['organization_name'] }}</div>
          <div class="signature-meta">Name &amp; Title</div>
          <div class="signature-meta">Date</div>
        </div>

        <div class="signature-block">
          <div class="signature-space"></div>
          <div class="signature-label">Authorized Signature — {{ $data['client_name'] }}</div>
          <div class="signature-meta">Name &amp; Title</div>
          <div class="signature-meta">Date</div>
        </div>
      </div>

      <div class="doc-footer">
        <span>{{ $data['organization_name'] }} &middot; {{ $data['quo_number'] }}</span>

        <div class="footer-brand">
          <span>Generated by</span>
          <img src="{{ $data['optimasync_logo'] }}" alt="Optima Sync Logo" />
        </div>
      </div>

      <div class="footer-link-row">
        <a href="https://optimasync.io">www.optimasync.io</a>
      </div>
    </div>
  </body>
</html>
