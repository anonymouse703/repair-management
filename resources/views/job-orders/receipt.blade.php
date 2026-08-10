<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>
        {{ $jobOrder->reference_number }}
    </title>

    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .receipt-copy {
            width: 100%;
            min-height: 277mm;
            position: relative;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGE BREAK
        |--------------------------------------------------------------------------
        */

        .page-break {
            page-break-before: always;
        }

        /*
        |--------------------------------------------------------------------------
        | HEADER
        |--------------------------------------------------------------------------
        */

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .header-table td {
            vertical-align: top;
        }

        .shop-info {
            width: 70%;
        }

        .shop-name {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .shop-details {
            font-size: 8px;
            line-height: 1.4;
        }

        .copy-label {
            width: 30%;
            text-align: right;
        }

        .copy-label-box {
            display: inline-block;
            border: 1px solid #222;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .jo-number {
            font-size: 12px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | SECTION TITLES
        |--------------------------------------------------------------------------
        */

        .section-title {
            font-size: 9px;
            font-weight: bold;
            border-bottom: 1px solid #222;
            padding-bottom: 2px;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER / DEVICE INFORMATION
        |--------------------------------------------------------------------------
        */

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .info-table td {
            padding: 3px 4px;
            vertical-align: top;
        }

        .info-table .label {
            width: 12%;
            font-weight: bold;
            white-space: nowrap;
        }

        .info-table .value {
            width: 38%;
            border-bottom: 1px solid #ddd;
        }

        /*
        |--------------------------------------------------------------------------
        | NOTES
        |--------------------------------------------------------------------------
        */

        .notes {
            border: 1px solid #ddd;
            padding: 5px;
            min-height: 25px;
            white-space: pre-line;
            margin-bottom: 5px;
        }

        /*
        |--------------------------------------------------------------------------
        | ITEMS TABLE
        |--------------------------------------------------------------------------
        */

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .items-table th {
            background: #f2f2f2;
            border-top: 1px solid #222;
            border-bottom: 1px solid #222;
            padding: 4px;
            font-size: 8px;
        }

        .items-table td {
            padding: 3px 4px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        /*
        |--------------------------------------------------------------------------
        | TOTALS
        |--------------------------------------------------------------------------
        */

        .totals-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .totals-table td {
            padding: 3px 4px;
            border-bottom: 1px solid #eeeeee;
        }

        .totals-table .total {
            font-size: 10px;
            font-weight: bold;
            border-top: 1px solid #222;
            border-bottom: 2px solid #222;
        }

        /*
        |--------------------------------------------------------------------------
        | SIGNATURES
        |--------------------------------------------------------------------------
        */

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            padding: 0 20px;
        }

        .signature-space {
            height: 30px;
        }

        .signature-line {
            border-top: 1px solid #222;
            padding-top: 4px;
            font-size: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        .receipt-footer {
            margin-top: 12px;
            text-align: center;
            font-size: 7px;
            color: #666;
            line-height: 1.4;
        }

        .small {
            font-size: 7px;
        }

        .muted {
            color: #777;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /*
        |--------------------------------------------------------------------------
        | PRINT / PDF
        |--------------------------------------------------------------------------
        */

        .copy-separator {
            display: none;
        }
    </style>
</head>

<body>

    {{-- ============================================================
        PAGE 1 - SHOP COPY
    ============================================================= --}}

    @include('job-orders.receipt-copy', [
        'jobOrder' => $jobOrder,
        'copyType' => 'SHOP COPY',
        'settings' => $settings,
    ])


    {{-- ============================================================
        PAGE 2 - CUSTOMER COPY
    ============================================================= --}}

    <div class="page-break"></div>

    @include('job-orders.receipt-copy', [
        'jobOrder' => $jobOrder,
        'copyType' => 'CUSTOMER COPY',
        'settings' => $settings,
    ])

</body>

</html>