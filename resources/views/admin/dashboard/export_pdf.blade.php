<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ringkasan Eksekutif & Analitik Bisnis {{ $selectedYear }} - AzkaMandiri</title>
    <style>
        @page {
            margin: 25px 30px 25px 30px;
            size: A4 landscape;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 8.5pt;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.35;
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

        .kpi-card {
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 10px;
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 6.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 0.5px solid #fca5a5;
        }
        .badge-warning {
            background-color: #fef3c7;
            color: #b45309;
            border: 0.5px solid #fde68a;
        }
        .badge-success {
            background-color: #dcfce7;
            color: #15803d;
            border: 0.5px solid #86efac;
        }

        .data-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 7.5pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 5px 6px;
            border: 0.5px solid #334155;
        }
        .data-table td {
            font-size: 7.5pt;
            padding: 4.5px 6px;
            border: 0.5px solid #cbd5e1;
        }
        .data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .doc-footer {
            margin-top: 15px;
            border-top: 0.5px solid #cbd5e1;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <!-- KOP PERUSAHAAN & HEADER DOKUMEN -->
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: top; width: 70%;">
                <div style="font-size: 18pt; font-weight: bold; color: #0f172a; letter-spacing: -0.5px;">AZKA<span style="color: #b45309;">MANDIRI</span></div>
                <div style="font-size: 8pt; font-weight: bold; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px;">SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, &amp; PROYEK INTERIOR</div>
                <div style="font-size: 7.5pt; color: #475569; margin-top: 2px;">Workshop &amp; Kantor: Jl. Raya Mandiri Blok A No. 12, Jawa Timur | Telp/WA: 0812-3456-7890</div>
                <div style="font-size: 7.5pt; color: #475569; margin-top: 1px;">Email: contact@azkamandiri.com | Website: azkamandiri.nichesite.org</div>
            </td>
            <td style="vertical-align: top; width: 30%; text-align: right;">
                <div style="display: inline-block; border: 1.5px solid #0f172a; border-radius: 6px; padding: 6px 14px; text-align: center; background-color: #ffffff;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">DOKUMEN EKSEKUTIF RESMI</div>
                    <div style="font-size: 10pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-top: 1px;">RINGKASAN BISNIS {{ $selectedYear }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div style="border-bottom: 2px solid #0f172a; margin-top: 8px; margin-bottom: 8px;"></div>

    <!-- DOCUMENT META -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="vertical-align: middle; width: 60%;">
                <div style="font-size: 11pt; font-weight: bold; color: #0f172a; text-transform: uppercase;">LAPORAN ANALITIK KINERJA USAHA, LABA RUGI &amp; VALUASI ASET</div>
                <div style="font-size: 8pt; color: #334155; margin-top: 2px;">
                    Tahun Analisis: <strong>{{ $selectedYear }}</strong> | Cakupan: <strong>Penjualan POS, Estimasi Laba, Pengadaan Material &amp; Persediaan</strong>
                </div>
            </td>
            <td style="vertical-align: middle; width: 40%; text-align: right; font-size: 7.5pt; color: #475569; line-height: 1.4;">
                <div>Waktu Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></div>
                <div>Dicetak Oleh: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Super Admin' }})</div>
                <div>Status Database: <strong>Real-Time Terkini</strong></div>
            </td>
        </tr>
    </table>

    <!-- RINGKASAN KPI EKSEKUTIF -->
    <table style="width: 100%; margin-bottom: 12px;">
        <tr>
            <!-- KPI 1: PENJUALAN -->
            <td style="width: 25%; padding-right: 5px; vertical-align: top;">
                <div class="kpi-card" style="border-left: 4px solid #16a34a;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">Total Penjualan {{ $selectedYear }}</div>
                    <div style="font-size: 11pt; font-weight: bold; color: #15803d; margin-top: 2px;">Rp {{ number_format($stats['annual_sales'], 0, ',', '.') }}</div>
                    <div style="font-size: 6.8pt; color: #475569; margin-top: 3px; border-top: 0.5px dashed #cbd5e1; padding-top: 3px;">
                        Hari Ini: <strong>Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</strong><br>
                        Bulan Ini: <strong>Rp {{ number_format($stats['month_sales'], 0, ',', '.') }}</strong><br>
                        Piutang Aktif: <strong style="color: #b91c1c;">Rp {{ number_format($stats['total_receivables'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            </td>

            <!-- KPI 2: LABA RUGI -->
            <td style="width: 25%; padding-right: 5px; padding-left: 5px; vertical-align: top;">
                <div class="kpi-card" style="border-left: 4px solid #d97706;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">Laba Kotor (Gross Profit)</div>
                    <div style="font-size: 11pt; font-weight: bold; color: #b45309; margin-top: 2px;">Rp {{ number_format($stats['annual_profit'], 0, ',', '.') }}</div>
                    <div style="font-size: 6.8pt; color: #475569; margin-top: 3px; border-top: 0.5px dashed #cbd5e1; padding-top: 3px;">
                        Profit Margin: <strong>{{ number_format($stats['annual_profit_margin'], 1) }}%</strong><br>
                        Total Transaksi: <strong>{{ number_format($stats['annual_trx_count'], 0, ',', '.') }} order</strong><br>
                        Rata-rata/Bulan: <strong>Rp {{ number_format($stats['avg_monthly_sales'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            </td>

            <!-- KPI 3: VALUASI STOK -->
            <td style="width: 25%; padding-right: 5px; padding-left: 5px; vertical-align: top;">
                <div class="kpi-card" style="border-left: 4px solid #2563eb;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">Valuasi Persediaan (HPP)</div>
                    <div style="font-size: 11pt; font-weight: bold; color: #1d4ed8; margin-top: 2px;">Rp {{ number_format($stats['stock_cost_value'], 0, ',', '.') }}</div>
                    <div style="font-size: 6.8pt; color: #475569; margin-top: 3px; border-top: 0.5px dashed #cbd5e1; padding-top: 3px;">
                        Nilai Jual Retail: <strong>Rp {{ number_format($stats['stock_retail_value'], 0, ',', '.') }}</strong><br>
                        Potensi Margin Stok: <strong>{{ number_format($stats['potential_stock_margin'], 1) }}%</strong><br>
                        Fisik Barang: <strong>{{ number_format($stats['total_stock_units'], 0, ',', '.') }} unit</strong>
                    </div>
                </div>
            </td>

            <!-- KPI 4: BELANJA PENGADAAN -->
            <td style="width: 25%; padding-left: 5px; vertical-align: top;">
                <div class="kpi-card" style="border-left: 4px solid #7c3aed;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">Pengadaan Barang / Restock</div>
                    <div style="font-size: 11pt; font-weight: bold; color: #6d28d9; margin-top: 2px;">Rp {{ number_format($stats['annual_purchases'], 0, ',', '.') }}</div>
                    <div style="font-size: 6.8pt; color: #475569; margin-top: 3px; border-top: 0.5px dashed #cbd5e1; padding-top: 3px;">
                        Total Faktur PO: <strong>{{ $stats['annual_purchases_count'] }} transaksi</strong><br>
                        Bulan Ini: <strong>Rp {{ number_format($stats['month_purchases'], 0, ',', '.') }}</strong><br>
                        Hutang Dagang Belum Lunas: <strong style="color: #b91c1c;">Rp {{ number_format($stats['unpaid_purchases'], 0, ',', '.') }}</strong>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- SECTION 1: TABEL KINERJA BULANAN -->
    <div style="margin-bottom: 12px;">
        <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 4px;">
            1. Tabel Rincian Kinerja Bulanan Tahun {{ $selectedYear }}
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 15%;" class="text-left">Bulan</th>
                    <th style="width: 18%;" class="text-right">Penjualan (Kas Masuk)</th>
                    <th style="width: 18%;" class="text-right">Laba Kotor (Gross Profit)</th>
                    <th style="width: 18%;" class="text-right">Pengadaan Stok (Belanja)</th>
                    <th style="width: 16%;" class="text-right">Selisih Kas Bersih</th>
                    <th style="width: 10%;" class="text-center">Jml Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sumSales = 0;
                    $sumProfit = 0;
                    $sumPurchases = 0;
                    $sumTrx = 0;
                @endphp
                @foreach($chartCategories as $idx => $monthName)
                    @php
                        $s = $chartSales[$idx] ?? 0;
                        $p = $chartProfit[$idx] ?? 0;
                        $b = $chartPurchases[$idx] ?? 0;
                        $net = $s - $b;
                        $t = $chartTrxCount[$idx] ?? 0;

                        $sumSales += $s;
                        $sumProfit += $p;
                        $sumPurchases += $b;
                        $sumTrx += $t;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $idx + 1 }}</td>
                        <td class="font-bold">{{ $monthName }} {{ $selectedYear }}</td>
                        <td class="text-right font-bold" style="color: #15803d;">Rp {{ number_format($s, 0, ',', '.') }}</td>
                        <td class="text-right" style="color: #b45309;">Rp {{ number_format($p, 0, ',', '.') }}</td>
                        <td class="text-right" style="color: #6d28d9;">Rp {{ number_format($b, 0, ',', '.') }}</td>
                        <td class="text-right font-bold" style="color: {{ $net >= 0 ? '#15803d' : '#b91c1c' }};">
                            Rp {{ number_format($net, 0, ',', '.') }}
                        </td>
                        <td class="text-center">{{ $t }} order</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">
                    <td colspan="2" class="text-center" style="padding: 6px; border: 0.5px solid #334155; color: #ffffff;">TOTAL TAHUNAN {{ $selectedYear }}</td>
                    <td class="text-right" style="border: 0.5px solid #334155; color: #4ade80;">Rp {{ number_format($sumSales, 0, ',', '.') }}</td>
                    <td class="text-right" style="border: 0.5px solid #334155; color: #fde047;">Rp {{ number_format($sumProfit, 0, ',', '.') }}</td>
                    <td class="text-right" style="border: 0.5px solid #334155; color: #c4b5fd;">Rp {{ number_format($sumPurchases, 0, ',', '.') }}</td>
                    <td class="text-right" style="border: 0.5px solid #334155; color: {{ ($sumSales - $sumPurchases) >= 0 ? '#4ade80' : '#f87171' }};">
                        Rp {{ number_format($sumSales - $sumPurchases, 0, ',', '.') }}
                    </td>
                    <td class="text-center" style="border: 0.5px solid #334155; color: #ffffff;">{{ $sumTrx }} order</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- SECTION 2: DUA KOLOM - VALUASI KATEGORI & STATUS STOK KRITIS -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 14px;">
        <tr>
            <!-- KOLOM KIRI: VALUASI PER KATEGORI -->
            <td style="width: 50%; vertical-align: top; padding-right: 8px;">
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 4px;">
                    2. Valuasi Nilai Persediaan per Kategori Produk
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 35%;" class="text-left">Kategori Produk</th>
                            <th style="width: 15%;" class="text-center">Jml Varian</th>
                            <th style="width: 25%;" class="text-right">Aset HPP Modal</th>
                            <th style="width: 25%;" class="text-right">Nilai Jual Retail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categoryBreakdown as $cat)
                            <tr>
                                <td class="font-bold">{{ $cat['name'] }}</td>
                                <td class="text-center">{{ $cat['count'] }} item</td>
                                <td class="text-right font-bold">Rp {{ number_format($cat['asset_value'], 0, ',', '.') }}</td>
                                <td class="text-right" style="color: #15803d;">Rp {{ number_format($cat['retail_value'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="color: #64748b;">Belum ada data kategori persediaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>

            <!-- KOLOM KANAN: STATUS KESEHATAN STOK & ITEM KRITIS -->
            <td style="width: 50%; vertical-align: top; padding-left: 8px;">
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 4px;">
                    3. Peringatan Stok Kritis &amp; Rekomendasi Restock
                </div>
                <div style="margin-bottom: 4px; font-size: 7pt; color: #475569;">
                    Status Gudang: <span class="badge badge-success">Aman: {{ $stats['safe_stock_count'] }}</span>
                    <span class="badge badge-warning">Menipis: {{ $stats['low_stock_count'] }}</span>
                    <span class="badge badge-danger">Habis: {{ $stats['out_of_stock_count'] }}</span>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 25%;" class="text-left">Kode / Barcode</th>
                            <th style="width: 40%;" class="text-left">Nama Produk</th>
                            <th style="width: 15%;" class="text-center">Sisa Stok</th>
                            <th style="width: 20%;" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criticalProducts as $prod)
                            <tr>
                                <td style="font-family: monospace; font-size: 7pt;">{{ $prod->code }}</td>
                                <td class="font-bold">{{ $prod->name }}</td>
                                <td class="text-center font-bold" style="color: {{ $prod->stock <= 0 ? '#b91c1c' : '#b45309' }};">
                                    {{ $prod->stock }} {{ $prod->unit->symbol ?? 'pcs' }}
                                </td>
                                <td class="text-center">
                                    @if($prod->stock <= 0)
                                        <span class="badge badge-danger">HABIS</span>
                                    @else
                                        <span class="badge badge-warning">MENIPIS (Min: {{ $prod->min_stock }})</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="color: #15803d;">Semua persediaan dalam batas stok aman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <!-- LEMBAR PENGESAHAN DOKUMEN -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="width: 65%; vertical-align: bottom; font-size: 7pt; color: #64748b; line-height: 1.4;">
                <div>Catatan Resmi:</div>
                <div>1. Seluruh data kalkulasi diambil langsung dari basis data operasional POS dan sistem inventaris AzkaMandiri.</div>
                <div>2. Estimasi laba kotor dihitung berdasarkan selisih harga jual faktur terhadap HPP (Cost Price) barang terkait.</div>
                <div>3. Dokumen ini sah dan dapat digunakan untuk evaluasi internal bulanan maupun laporan pertanggungjawaban manajemen.</div>
            </td>
            <td style="width: 35%; vertical-align: top; text-align: center;">
                <div style="font-size: 7.5pt; color: #334155; margin-bottom: 45px;">
                    Jawa Timur, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    <strong>Disahkan Oleh,</strong>
                </div>
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-decoration: underline;">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </div>
                <div style="font-size: 7pt; color: #475569; margin-top: 1px;">
                    Manajemen &amp; Pimpinan AzkaMandiri
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="doc-footer">
        <table style="width: 100%;">
            <tr>
                <td style="font-size: 6.5pt; color: #94a3b8; width: 50%;">
                    AzkaMandiri Enterprise ERP &amp; POS &copy; {{ date('Y') }} &bull; Sistem Pelaporan Eksekutif Otomatis
                </td>
                <td style="font-size: 6.5pt; color: #94a3b8; text-align: right; width: 50%;">
                    Dokumen Rahasia Internal Usaha &bull; Halaman 1 dari 1
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

