<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Penjualan POS - AzkaMandiri</title>
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

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 3px;
            font-size: 6.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #15803d;
            border: 0.5px solid #86efac;
        }
        .badge-partial {
            background-color: #fef3c7;
            color: #b45309;
            border: 0.5px solid #fde68a;
        }
        .badge-unpaid {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 0.5px solid #fca5a5;
        }

        /* Fixed page footer */
        .doc-footer {
            margin-top: 18px;
            border-top: 0.5px solid #cbd5e1;
            padding-top: 5px;
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
                <div style="display: inline-block; border: 1px solid #94a3b8; border-radius: 6px; padding: 6px 14px; text-align: center; background-color: #ffffff;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">DOKUMEN KEUANGAN</div>
                    <div style="font-size: 9.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-top: 1px;">LAPORAN PENJUALAN</div>
                </div>
            </td>
        </tr>
    </table>

    <div style="border-bottom: 1.5px solid #0f172a; margin-top: 8px; margin-bottom: 8px;"></div>

    <!-- DOCUMENT META -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
        <tr>
            <td style="vertical-align: middle; width: 55%;">
                <div style="font-size: 11pt; font-weight: bold; color: #0f172a; text-transform: uppercase;">REKAPITULASI PENJUALAN &amp; KAS MASUK (POS)</div>
                <div style="font-size: 8pt; color: #334155; margin-top: 2px;">
                    Periode Transaksi: <strong>{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong>{{ $endDate->translatedFormat('d F Y') }}</strong>
                </div>
            </td>
            <td style="vertical-align: middle; width: 45%; text-align: right; font-size: 7.5pt; color: #475569; line-height: 1.4;">
                <div>Waktu Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></div>
                <div>Operator Cetak: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Super Admin' }})</div>
                <div>Filter Status: <strong>{{ request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status' }}</strong> | Metode: <strong>{{ request('payment_type') ? strtoupper(request('payment_type')) : 'Semua Metode' }}</strong></div>
            </td>
        </tr>
    </table>

    <!-- SECTION 1: RINGKASAN KEUANGAN UTAMA -->
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        RINGKASAN KEUANGAN UTAMA
    </div>
    <table style="width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-left: -8px; margin-right: -8px; margin-bottom: 14px;">
        <tr>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">TOTAL OMZET PENJUALAN</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #0f172a; margin-top: 2px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">{{ $totalCount }} transaksi tercatat</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">KAS MASUK (TERBAYAR)</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #16a34a; margin-top: 2px;">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">Sudah masuk rekening/kas</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">PIUTANG BERJALAN</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #d97706; margin-top: 2px;">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">Sisa tagihan pelanggan</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">TOTAL POTONGAN DISKON</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #dc2626; margin-top: 2px;">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">Kotor: Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <!-- SECTION 2: DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR -->
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1; margin-bottom: 14px;">
        <thead>
            <tr style="background-color: #1e293b; color: #ffffff;">
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: left; text-transform: uppercase; width: 40%; border: 1px solid #1e293b;">METODE BAYAR</th>
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: right; text-transform: uppercase; width: 35%; border: 1px solid #1e293b;">JUMLAH (RP)</th>
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: right; text-transform: uppercase; width: 25%; border: 1px solid #1e293b;">PERSENTASE (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #334155;">Tunai (Cash)</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($cashTotal, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $totalPaid > 0 ? number_format(($cashTotal / $totalPaid) * 100, 1) : 0 }}%</td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #334155;">Transfer Bank</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($transferTotal, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $totalPaid > 0 ? number_format(($transferTotal / $totalPaid) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #334155;">QRIS / E-Wallet</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $totalPaid > 0 ? number_format(($qrisTotal / $totalPaid) * 100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION 3: RINCIAN TRANSAKSI PERIODE TERPILIH -->
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        RINCIAN TRANSAKSI PERIODE TERPILIH ({{ $transactions->count() }} DATA DITEMUKAN)
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1; margin-bottom: 14px;">
        <thead>
            <tr style="background-color: #1e293b; color: #ffffff;">
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e293b; width: 15%;">NO. INVOICE &amp; TANGGAL</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e293b; width: 17%;">PELANGGAN</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: center; text-transform: uppercase; border: 1px solid #1e293b; width: 6%;">TIPE</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: center; text-transform: uppercase; border: 1px solid #1e293b; width: 8%;">METODE</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 9%;">SUBTOTAL</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 8%;">DISKON</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 10%;">TOTAL NET</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 9%;">TERBAYAR</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 9%;">SISA PIUTANG</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: center; text-transform: uppercase; border: 1px solid #1e293b; width: 9%;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            @php
                $debt = max(0, (float)$trx->total_amount - (float)$trx->paid_amount);
            @endphp
            <tr>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; vertical-align: top;">
                    <div style="font-weight: bold; color: #0f172a; font-family: monospace;">{{ $trx->invoice_code }}</div>
                    <div style="font-size: 6.5pt; color: #64748b; margin-top: 1px;">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}</div>
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; vertical-align: top;">
                    <div style="font-weight: bold; color: #0f172a;">{{ $trx->customer->name ?? 'Pelanggan Umum' }}</div>
                    @if($trx->customer && $trx->customer->phone)
                        <div style="font-size: 6.5pt; color: #64748b; margin-top: 1px;">{{ $trx->customer->phone }}</div>
                    @endif
                </td>
                <td style="padding: 4px 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; vertical-align: middle;">
                    {{ $trx->order_type === 'custom' ? 'Custom' : 'Ritel' }}
                </td>
                <td style="padding: 4px 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; vertical-align: middle; text-transform: uppercase; font-family: monospace;">
                    {{ $trx->payment_type }}
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace;">
                    {{ number_format($trx->subtotal, 0, ',', '.') }}
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace; color: {{ $trx->discount_amount > 0 ? '#dc2626' : '#64748b' }};">
                    {{ $trx->discount_amount > 0 ? '-' . number_format($trx->discount_amount, 0, ',', '.') : '-' }}
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace; font-weight: bold; color: #0f172a;">
                    {{ number_format($trx->total_amount, 0, ',', '.') }}
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace; color: #16a34a; font-weight: bold;">
                    {{ number_format($trx->paid_amount, 0, ',', '.') }}
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace; font-weight: bold; color: {{ $debt > 0 ? '#d97706' : '#64748b' }};">
                    {{ number_format($debt, 0, ',', '.') }}
                </td>
                <td style="padding: 4px 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; vertical-align: middle;">
                    @if($trx->payment_status === 'paid')
                        <span class="badge badge-paid">Lunas</span>
                    @elseif($trx->payment_status === 'partial')
                        <span class="badge badge-partial">DP / Sisa</span>
                    @else
                        <span class="badge badge-unpaid">Belum Bayar</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="padding: 15px; text-align: center; color: #94a3b8; font-style: italic;">
                    Tidak ada data transaksi penjualan pada rentang periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot>
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="4" style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; text-transform: uppercase;">
                    TOTAL PERIODE ({{ $totalCount }} Nota)
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">
                    Rp {{ number_format($totalSubtotal, 0, ',', '.') }}
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace; color: {{ $totalDiscount > 0 ? '#dc2626' : '#0f172a' }};">
                    {{ $totalDiscount > 0 ? '-Rp ' . number_format($totalDiscount, 0, ',', '.') : 'Rp 0' }}
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace; color: #0f172a;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace; color: #16a34a;">
                    Rp {{ number_format($totalPaid, 0, ',', '.') }}
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace; color: #d97706;">
                    Rp {{ number_format($totalPiutang, 0, ',', '.') }}
                </td>
                <td style="padding: 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; color: #64748b;">
                    {{ $totalCount }} Nota
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- FOOTER RESMI HALAMAN -->
    <div class="doc-footer">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: left; font-size: 7pt; color: #64748b;">
                    AzkaMandiri Admin Panel - Laporan Penjualan POS
                </td>
                <td style="text-align: right; font-size: 7pt; color: #64748b;">
                    Halaman 1 dari 1
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
