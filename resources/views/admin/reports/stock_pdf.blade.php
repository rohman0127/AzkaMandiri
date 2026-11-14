<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Valuasi Stok - AzkaMandiri</title>
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
            font-size: 8.5pt;
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
            padding: 6px 6px;
            border: 1px solid #334155;
        }
        .data-table td {
            padding: 5px 6px;
            border: 1px solid #cbd5e1;
            font-size: 7.5pt;
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
            font-size: 8pt;
        }

        /* Status Pills */
        .status-badge {
            display: inline-block;
            padding: 2px 5px;
            font-size: 6.5pt;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .badge-safe {
            background-color: #dcfce7;
            color: #166534;
            border: 0.5px solid #86efac;
        }
        .badge-low {
            background-color: #fef3c7;
            color: #92400e;
            border: 0.5px solid #fde68a;
        }
        .badge-out {
            background-color: #ffe4e6;
            color: #9f1239;
            border: 0.5px solid #fecdd3;
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
                <div class="company-title">AZKA<span>MANDIRI</span></div>
                <div class="company-sub">Spesialis Kusen Aluminium, Kaca Tempered, &amp; Proyek Interior</div>
                <div class="company-contact">
                    Workshop &amp; Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur<br>
                    Telepon / WhatsApp: 0812-3456-7890 | Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org
                </div>
            </td>
            <td style="width: 30%; text-align: right;">
                <div style="display: inline-block; border: 1.5px solid #0f172a; padding: 6px 12px; text-align: center; background-color: #f8fafc;">
                    <span style="font-size: 7pt; font-weight: bold; text-transform: uppercase; color: #64748b; display: block;">Dokumen Inventaris</span>
                    <span style="font-size: 9pt; font-weight: bold; color: #0f172a;">VALUASI &amp; POSISI STOK</span>
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
                <div class="doc-title">Laporan Posisi Persediaan &amp; Valuasi Aset Stok Gudang</div>
                <div class="doc-period">
                    Klasifikasi: <strong>Profil Aluminium, Kaca Lembaran, Aksesoris, &amp; Material Proyek</strong>
                </div>
            </td>
            <td class="meta-box">
                <div>Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></div>
                <div>Operator Cetak: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Admin' }})</div>
                <div>Filter Kategori: <strong>{{ request('category_id') ? ($categories->firstWhere('id', request('category_id'))->name ?? 'Kategori Terpilih') : 'Semua Kategori' }}</strong></div>
            </td>
        </tr>
    </table>

    <!-- Ringkasan Eksekutif Valuasi -->
    <table class="kpi-table">
        <tr>
            <td class="kpi-cell">
                <div class="kpi-label">Total Item Barang Aktif</div>
                <div class="kpi-value">{{ number_format($totalItems, 0) }} Item</div>
                <div class="kpi-sub">Katalog Material &amp; Sparepart</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Total Valuasi Modal (HPP)</div>
                <div class="kpi-value" style="color: #166534;">Rp {{ number_format($totalCostValue, 0, ',', '.') }}</div>
                <div class="kpi-sub">Nilai Aset Modal Fisik Gudang</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Potensi Nilai Jual Retail</div>
                <div class="kpi-value" style="color: #0f172a;">Rp {{ number_format($totalRetailValue, 0, ',', '.') }}</div>
                <div class="kpi-sub">Estimasi Omzet Jika Seluruh Stok Terjual</div>
            </td>
            <td class="kpi-cell">
                <div class="kpi-label">Status Stok Kritis / Menipis</div>
                <div class="kpi-value" style="color: {{ $lowStockCount > 0 ? '#9f1239' : '#166534' }};">
                    {{ $lowStockCount }} Item
                </div>
                <div class="kpi-sub">Mencapai / Di Bawah Batas Minimum</div>
            </td>
        </tr>
    </table>

    <!-- Tabel Data Stok -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;" class="text-center">No</th>
                <th style="width: 80px;">SKU</th>
                <th>Nama Barang / Material</th>
                <th style="width: 85px;">Kategori</th>
                <th style="width: 45px;" class="text-center">Satuan</th>
                <th style="width: 55px;" class="text-center">Stok</th>
                <th style="width: 50px;" class="text-center">Min.</th>
                <th style="width: 60px;" class="text-center">Rak</th>
                <th style="width: 75px;" class="text-right">Harga Modal</th>
                <th style="width: 75px;" class="text-right">Harga Jual</th>
                <th style="width: 85px;" class="text-right">Total Nilai HPP</th>
                <th style="width: 65px;" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $p)
            @php
                $itemValuation = (float)$p->cost_price * (float)$p->stock;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="font-bold" style="font-family: monospace;">{{ $p->sku }}</td>
                <td>
                    <strong>{{ $p->name }}</strong>
                    @if($p->barcode)
                        <span style="font-size: 6.5pt; color: #64748b; font-family: monospace; display: block;">Barcode: {{ $p->barcode }}</span>
                    @endif
                </td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td class="text-center">{{ $p->unit->symbol ?? 'pcs' }}</td>
                <td class="text-center font-bold" style="font-family: monospace;">{{ $p->stock }}</td>
                <td class="text-center" style="font-family: monospace; color: #64748b;">{{ $p->min_stock }}</td>
                <td class="text-center">{{ $p->rack_location ?: '-' }}</td>
                <td class="text-right" style="font-family: monospace;">{{ number_format($p->cost_price, 0, ',', '.') }}</td>
                <td class="text-right" style="font-family: monospace;">{{ number_format($p->price, 0, ',', '.') }}</td>
                <td class="text-right font-bold" style="font-family: monospace; color: #166534;">
                    {{ number_format($itemValuation, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @if((float)$p->stock <= 0)
                        <span class="status-badge badge-out">Habis</span>
                    @elseif((float)$p->stock <= (float)$p->min_stock)
                        <span class="status-badge badge-low">Kritis</span>
                    @else
                        <span class="status-badge badge-safe">Aman</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="text-center" style="padding: 20px; color: #64748b;">
                    Tidak ada produk atau material yang sesuai dengan filter.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($products->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right font-bold">TOTAL KESELURUHAN:</td>
                <td class="text-center font-bold">{{ $products->sum('stock') }}</td>
                <td colspan="4" class="text-right font-bold">TOTAL VALUASI MODAL FISIK:</td>
                <td class="text-right font-bold" style="font-family: monospace; color: #166534;">
                    Rp {{ number_format($totalCostValue, 0, ',', '.') }}
                </td>
                <td class="text-center font-bold">{{ $totalItems }} Item</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Lembar Pengesahan Resmi -->
    <table class="sign-table">
        <tr>
            <td class="text-center">
                <div class="sign-title">Dibuat &amp; Diverifikasi Fisik:</div>
                <div class="sign-role">Kepala Gudang / Logistik</div>
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
        Dokumen ini dibuat otomatis oleh Sistem Terintegrasi AzkaMandiri POS &amp; Inventory. Berlaku sebagai arsip inventaris resmi internal perusahaan.
    </div>

</body>
</html>

