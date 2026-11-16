<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Laba Rugi - AzkaMandiri</title>
    <style>
        @page {
            margin: 20px 25px 25px 25px;
            size: A4 landscape;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.35;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* Kop Surat */
        .kop-table td {
            vertical-align: middle;
        }
        .company-title {
            font-size: 16pt;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .company-title span {
            color: #b45309;
        }
        .company-sub {
            font-size: 8.5pt;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1px;
        }
        .company-contact {
            font-size: 8pt;
            color: #64748b;
            margin-top: 3px;
            line-height: 1.3;
        }
        .kop-border {
            border-bottom: 2.5px solid #0f172a;
            margin-top: 8px;
            margin-bottom: 2px;
        }
        .kop-border-sub {
            border-bottom: 0.75px solid #0f172a;
            margin-bottom: 12px;
        }

        /* Title & Meta */
        .doc-header td {
            vertical-align: top;
        }
        .doc-title {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .doc-period {
            font-size: 8.5pt;
            color: #334155;
            margin-top: 2px;
        }
        .meta-box {
            font-size: 8pt;
            color: #475569;
            text-align: right;
        }

        /* KPI Cards in Document */
        .kpi-table {
            margin-top: 10px;
            margin-bottom: 14px;
        }
        .kpi-cell {
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            width: 25%;
        }
        .kpi-label {
            font-size: 7.5pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kpi-value {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 3px;
        }
        .kpi-sub {
            font-size: 7pt;
            color: #64748b;
            margin-top: 1px;
        }

        /* Data Table */
        .data-table {
            width: 100%;
            border: 1px solid #94a3b8;
            margin-top: 5px;
        }
        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 6px 8px;
            border: 1px solid #334155;
        }
        .data-table td {
            padding: 5px 8px;
            border: 1px solid #cbd5e1;
            font-size: 8pt;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .data-table tfoot td {
            background-color: #e2e8f0;
            font-weight: bold;
            border-top: 2px solid #0f172a;
            border-bottom: 2px solid #0f172a;
            font-size: 8.5pt;
        }

        /* Signatures */
        .sign-table {
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .sign-table td {
            vertical-align: top;
            width: 33%;
        }
        .sign-title {
            font-size: 8pt;
            color: #64748b;
        }
        .sign-role {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0f172a;
            margin-top: 2px;
        }
        .sign-space {
            height: 48px;
        }
        .sign-name {
            font-size: 8.5pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #334155;
            display: inline-block;
            padding-bottom: 2px;
        }

        .footer-note {
            margin-top: 15px;
            font-size: 7pt;
            color: #94a3b8;
            text-align: center;
            border-top: 0.5px dashed #cbd5e1;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Resmi -->
    <table class="kop-table">
        <tr>
            <td style="width: 70%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 52px; vertical-align: top; padding-right: 10px;">
                            <img src="{{ public_path('assets/brand/azka-logo-icon.png') }}" style="height: 46px; width: auto;" alt="Logo Azka Mandiri">
                        </td>
                        <td style="vertical-align: top;">
                            <div class="company-title" style="color: #1b2e56; font-family: 'Times New Roman', serif;">AZKA MANDIRI</div>
                            <div class="company-sub" style="color: #a81b3e;">Spesialis Kusen Aluminium, Kaca Tempered, &amp; Proyek Interior</div>
                            <div class="company-contact">
                                Workshop &amp; Kantor: Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220<br>
                                Telepon / WhatsApp: +62 819-3273-5383 | Email: kontak@azkamandiri.com | Website: azkamandiri.nichesite.org
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%; text-align: right;">
                <div style="display: inline-block; border: 1.5px solid #0f172a; padding: 6px 12px; text-align: center; background-color: #f8fafc;">
                    <span style="font-size: 7pt; font-weight: bold; text-transform: uppercase; color: #64748b; display: block;">Dokumen Keuangan</span>
                    <span style="font-size: 9pt; font-weight: bold; color: #0f172a;">ANALISIS LABA RUGI</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="kop-border"></div>
    <div class="kop-border-sub"></div>

    <!-- Header Dokumen & Parameter Filter -->
    <table class="doc-header">
        <tr>
            <td>
                <div class="doc-title">Laporan Analisis Laba Kotor (Gross Profit &amp; Loss)</div>
                <div class="doc-period">
                    Periode Analisis: <strong>{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong>{{ $endDate->translatedFormat('d F Y') }}</strong>
                </div>
            </td>
            <td class="meta-box">
                <div>Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></div>
                <div>Operator Cetak: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</div>
                <div>Basis Perhitungan: <strong>Harga Jual Kasir vs Harga Pokok Penjualan (HPP Modal)</strong></div>
            </td>
        </tr>
    </table>

    <!-- Ringkasan Eksekutif Laba Rugi -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-cell">
                <div class="kpi-label">Total Omzet Penjualan</div>
                <div class="kpi-value">Rp {{ number_format($totalSales, 0, ',', '.') }}</div>
                <div class="kpi-sub">Total Nilai Penjualan Kotor</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Beban Pokok Pendapatan (HPP)</div>
                <div class="kpi-value" style="color: #475569;">Rp {{ number_format($totalCost, 0, ',', '.') }}</div>
                <div class="kpi-sub">Total Modal Material/Produk Terjual</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Keuntungan Kotor (Gross Profit)</div>
                <div class="kpi-value" style="color: {{ $grossProfit >= 0 ? '#166534' : '#9f1239' }};">
                    Rp {{ number_format($grossProfit, 0, ',', '.') }}
                </div>
                <div class="kpi-sub">Selisih Penjualan &amp; HPP Modal</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Margin Keuntungan Kotor</div>
                <div class="kpi-value" style="color: #b45309;">
                    {{ number_format($profitMargin, 1, ',', '.') }}%
                </div>
                <div class="kpi-sub">Persentase Laba Terhadap Omzet</div>
            </td>
        </tr>
    </table>

    <!-- Tabel Analisis Laba per Produk/Material -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="text-center">No</th>
                <th style="width: 100px;">SKU / Kode</th>
                <th>Nama Barang / Material / Jasa</th>
                <th style="width: 110px;">Kategori</th>
                <th style="width: 75px;" class="text-center">Qty Terjual</th>
                <th style="width: 110px;" class="text-right">Total Penjualan</th>
                <th style="width: 110px;" class="text-right">Total Modal (HPP)</th>
                <th style="width: 110px;" class="text-right">Laba Kotor</th>
                <th style="width: 70px;" class="text-center">Margin (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productStats as $index => $stat)
            @php
                $itemMargin = $stat['revenue'] > 0 ? ($stat['profit'] / $stat['revenue']) * 100 : 0;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold" style="font-family: monospace;">{{ $stat['sku'] }}</td>
                <td>
                    <strong>{{ $stat['name'] }}</strong>
                </td>
                <td>{{ $stat['category'] ?? '-' }}</td>
                <td class="text-center font-bold" style="font-family: monospace;">
                    {{ number_format($stat['qty'], 0, ',', '.') }} {{ $stat['unit'] ?? '' }}
                </td>
                <td class="text-right" style="font-family: monospace;">Rp {{ number_format($stat['revenue'], 0, ',', '.') }}</td>
                <td class="text-right" style="font-family: monospace;">Rp {{ number_format($stat['cost'], 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="font-family: monospace; color: {{ $stat['profit'] >= 0 ? '#166534' : '#9f1239' }};">
                    Rp {{ number_format($stat['profit'], 0, ',', '.') }}
                </td>
                <td class="text-center font-bold" style="font-family: monospace; color: {{ $itemMargin >= 20 ? '#166534' : ($itemMargin >= 10 ? '#b45309' : '#9f1239') }};">
                    {{ number_format($itemMargin, 1, ',', '.') }}%
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center" style="padding: 20px; color: #64748b;">
                    Tidak ada transaksi penjualan barang pada rentang tanggal filter ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if(count($productStats) > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right font-bold">TOTAL KESELURUHAN:</td>
                <td class="text-right font-bold" style="font-family: monospace;">Rp {{ number_format($totalSales, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="font-family: monospace;">Rp {{ number_format($totalCost, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="font-family: monospace; color: {{ $grossProfit >= 0 ? '#166534' : '#9f1239' }};">
                    Rp {{ number_format($grossProfit, 0, ',', '.') }}
                </td>
                <td class="text-center font-bold" style="font-family: monospace; color: #b45309;">
                    {{ number_format($profitMargin, 1, ',', '.') }}%
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Lembar Pengesahan Resmi -->
    <table class="sign-table">
        <tr>
            <td class="text-center">
                <div class="sign-title">Dibuat &amp; Dianalisis Oleh:</div>
                <div class="sign-role">Bagian Keuangan &amp; Akuntansi</div>
                <div class="sign-space"></div>
                <div class="sign-name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div style="font-size: 7.5pt; color: #64748b; margin-top: 2px;">{{ auth()->user()->role_name ?? 'Staf Admin' }}</div>
            </td>
            <td></td>
            <td class="text-center">
                <div class="sign-title">Mengetahui &amp; Menyetujui:</div>
                <div class="sign-role">Pimpinan / Direksi AzkaMandiri</div>
                <div class="sign-space"></div>
                <div class="sign-name">( .................................................... )</div>
                <div style="font-size: 7.5pt; color: #64748b; margin-top: 2px;">Direksi Perusahaan</div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini dibuat otomatis oleh Sistem Terintegrasi AzkaMandiri POS &amp; Inventory. Berlaku sebagai arsip keuangan resmi internal perusahaan.
    </div>

</body>
</html>

