<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            background: #ffffff;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px 40px;
            background: white;
        }

        /* Header Section */
        .header {
            margin-bottom: 50px;
            border-bottom: 3px solid #0066ff;
            padding-bottom: 30px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .header-info h1 {
            font-size: 42px;
            font-weight: 700;
            color: #0066ff;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .invoice-number {
            font-size: 18px;
            color: #666;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .invoice-meta {
            display: flex;
            gap: 30px;
            align-items: center;
            margin-top: 15px;
        }

        .status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-paid {
            background: #d4edda;
            color: #155724;
        }

        .status-partial {
            background: #fff3cd;
            color: #856404;
        }

        .status-unpaid {
            background: #f8d7da;
            color: #721c24;
        }

        .dates {
            font-size: 13px;
            line-height: 1.8;
        }

        .dates strong {
            color: #333;
            font-weight: 600;
        }

        /* Logo Section */
        .logo-container {
            text-align: right;
        }

        .company-logo {
            max-width: 160px;
            max-height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .logo-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .logo-placeholder span {
            color: white;
            font-size: 28px;
            font-weight: 700;
        }

        .company-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 8px;
        }

        /* Parties Section */
        .parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 45px;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .party h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0066ff;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .party strong {
            font-size: 16px;
            color: #1a1a1a;
            display: block;
            margin-bottom: 8px;
        }

        .party p {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin: 3px 0;
        }

        /* Table Section */
        .table-container {
            margin-bottom: 40px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .items thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .items thead th {
            padding: 16px 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .items tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .items tbody tr:hover {
            background: #f9fafb;
        }

        .items tbody tr:last-child {
            border-bottom: none;
        }

        .items tbody td {
            padding: 18px 15px;
            font-size: 14px;
            color: #374151;
        }

        .items tbody td strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .items tbody td small {
            color: #6b7280;
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Totals Section */
        .totals-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }

        .totals {
            min-width: 400px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-row span:first-child {
            color: #666;
        }

        .totals-row span:last-child {
            color: #1a1a1a;
            font-weight: 600;
        }

        .totals-vat {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #e5e7eb;
        }

        .totals-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 15px -25px -25px -25px;
            padding: 20px 25px;
            border-radius: 0 0 12px 12px;
        }

        .totals-total .totals-row {
            border: none;
        }

        .totals-total .totals-row span {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        .paid-amount {
            background: #d4edda;
            margin: 15px -25px 0 -25px;
            padding: 15px 25px;
        }

        .paid-amount .totals-row span {
            color: #155724;
            font-weight: 600;
        }

        .due-amount {
            background: #fff3cd;
            margin: 0 -25px -25px -25px;
            padding: 15px 25px;
            border-radius: 0 0 12px 12px;
        }

        .due-amount .totals-row span {
            color: #856404;
            font-weight: 700;
            font-size: 16px;
        }

        /* Notes Section */
        .notes-container {
            margin-bottom: 40px;
        }

        .notes {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            border-radius: 8px;
        }

        .notes strong {
            color: #92400e;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }

        .notes p {
            color: #78350f;
            font-size: 13px;
            line-height: 1.7;
        }

        /* Footer Section */
        .footer {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 2px solid #e5e7eb;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-text {
            flex: 1;
        }

        .footer-text p {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.7;
            margin: 4px 0;
        }

        .footer-text p:first-child {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .footer-logo-container {
            margin-left: 30px;
        }

        .footer-logo {
            max-width: 100px;
            max-height: 50px;
            object-fit: contain;
            opacity: 0.6;
        }

        .footer-logo-placeholder {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.6;
        }

        .footer-logo-placeholder span {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }

        /* Print Optimization */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .invoice-container {
                padding: 30px;
                max-width: 100%;
            }
        }

        /* PDF Rendering Optimization */
        @page {
            margin: 15mm;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header with Logo -->
        <div class="header">
            <div class="header-content">
                <div class="header-info">
                    <h1>INVOICE</h1>
                    <div class="invoice-number">#INV-2024-001</div>

                    <div class="invoice-meta">
                        <span class="status status-paid">PAID</span>
                        <div class="dates">
                            <div><strong>Issue Date:</strong> Jan 15, 2024</div>
                            <div><strong>Due Date:</strong> Feb 15, 2024</div>
                        </div>
                    </div>
                </div>

                <div class="logo-container">
                    <div class="logo-placeholder">
                        <span>AC</span>
                    </div>
                    <div class="company-name">Acme Corporation</div>
                </div>
            </div>
        </div>

        <!-- Parties -->
        <div class="parties">
            <div class="party">
                <h3>Bill To</h3>
                <strong>John Doe Enterprise</strong>
                <p>john.doe@example.com</p>
                <p>+234 803 123 4567</p>
                <p>123 Business Street, Victoria Island, Lagos, Nigeria</p>
            </div>
            <div class="party">
                <h3>From</h3>
                <strong>Acme Corporation</strong>
                <p>hello@acmecorp.com</p>
                <p>+234 901 234 5678</p>
                <p>456 Corporate Avenue, Lekki Phase 1, Lagos, Nigeria</p>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-container">
            <table class="items">
                <thead>
                    <tr>
                        <th>Product/Service</th>
                        <th class="text-center">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Premium Web Design Package</strong>
                            <small>Unit: Service</small>
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-right">₦ 500,000.00</td>
                        <td class="text-right">₦ 50,000.00</td>
                        <td class="text-right"><strong>₦ 450,000.00</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>SEO Optimization</strong>
                            <small>Unit: Monthly</small>
                        </td>
                        <td class="text-center">3</td>
                        <td class="text-right">₦ 75,000.00</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>₦ 225,000.00</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Content Management System</strong>
                            <small>Unit: License</small>
                        </td>
                        <td class="text-center">1</td>
                        <td class="text-right">₦ 150,000.00</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>₦ 150,000.00</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="totals-container">
            <div class="totals">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span><strong>₦ 825,000.00</strong></span>
                </div>

                <div class="totals-row">
                    <span>Discount:</span>
                    <span>-₦ 50,000.00</span>
                </div>

                <div class="totals-row">
                    <span>After Discount:</span>
                    <span><strong>₦ 775,000.00</strong></span>
                </div>

                <div class="totals-vat">
                    <div class="totals-row">
                        <span>VAT (7.5%):</span>
                        <span><strong>₦ 58,125.00</strong></span>
                    </div>
                </div>

                <div class="totals-total">
                    <div class="totals-row">
                        <span>Total Amount:</span>
                        <span>₦ 833,125.00</span>
                    </div>
                </div>

                <div class="paid-amount">
                    <div class="totals-row">
                        <span>Amount Paid:</span>
                        <span><strong>₦ 833,125.00</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="notes-container">
            <div class="notes">
                <strong>Notes:</strong>
                <p>Payment received via bank transfer on January 20, 2024. Thank you for choosing our services. We appreciate your prompt payment and look forward to continuing our partnership.</p>
            </div>
        </div>

        <!-- Footer with Logo -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-text">
                    <p>Thank you for your business!</p>
                    <p>This is a computer-generated invoice. No signature is required.</p>
                    <p>If you have any questions, please contact us at hello@acmecorp.com</p>
                </div>

                <div class="footer-logo-container">
                    <div class="footer-logo-placeholder">
                        <span>AC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
