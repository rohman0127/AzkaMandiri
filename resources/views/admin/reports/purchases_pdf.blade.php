<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pembelian &amp; Restock - AzkaMandiri</title>
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
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 52px; vertical-align: top; padding-right: 10px;">
                            <img src="{{ public_path('assets/brand/azka-logo-icon.png') }}" style="height: 46px; width: auto;" alt="Logo Azka Mandiri">
                        </td>
                        <td style="vertical-align: top;">
                            <div style="font-size: 16pt; font-weight: bold; color: #1b2e56; font-family: 'Times New Roman', serif; letter-spacing: 0.5px;">AZKA MANDIRI</div>
                            <div style="font-size: 7.5pt; font-weight: bold; color: #a81b3e; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 1px;">SPESIALIS KUSEN ALUMINIUM, KACA TEMPERED, &amp; PROYEK INTERIOR</div>
                            <div style="font-size: 7.5pt; color: #475569; margin-top: 2px;">Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220 | Telp/WA: +62 819-3273-5383</div>
                            <div style="font-size: 7.5pt; color: #475569; margin-top: 1px;">Email: kontak@azkamandiri.com | Website: azkamandiri.nichesite.org</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top; width: 30%; text-align: right;">
                <div style="display: inline-block; border: 1px solid #94a3b8; border-radius: 6px; padding: 6px 14px; text-align: center; background-color: #ffffff;">
                    <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">DOKUMEN INVENTARIS &amp; LOGISTIK</div>
                    <div style="font-size: 9.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-top: 1px;">LAPORAN PEMBELIAN</div>
                </div>
            </td>
        </tr>
    </table>

    <div style="border-bottom: 1.5px solid #0f172a; margin-top: 8px; margin-bottom: 8px;"></div>

    <!-- DOCUMENT META -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
        <tr>
            <td style="vertical-align: middle; width: 55%;">
                <div style="font-size: 11pt; font-weight: bold; color: #0f172a; text-transform: uppercase;">REKAPITULASI PEMBELIAN &amp; RESTOCK BAHAN BAKU</div>
                <div style="font-size: 8pt; color: #334155; margin-top: 2px;">
                    Periode Transaksi: <strong>{{ $startDate->translatedFormat('d F Y') }}</strong> s/d <strong>{{ $endDate->translatedFormat('d F Y') }}</strong>
                </div>
            </td>
            <td style="vertical-align: middle; width: 45%; text-align: right; font-size: 7.5pt; color: #475569; line-height: 1.4;">
                <div>Waktu Cetak: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y - H:i') }} WIB</strong></div>
                <div>Operator Cetak: <strong>{{ auth()->user()->name ?? 'Administrator' }}</strong> ({{ auth()->user()->role_name ?? 'Super Admin' }})</div>
                <div>Filter Status: <strong>{{ request('payment_status') ? ucfirst(request('payment_status')) : 'Semua Status' }}</strong> | Supplier: <strong>{{ request('supplier_id') ? ($suppliers->firstWhere('id', request('supplier_id'))->company_name ?? 'Supplier Terpilih') : 'Semua Vendor' }}</strong></div>
            </td>
        </tr>
    </table>

    <!-- SECTION 1: RINGKASAN PEMBELIAN & RESTOCK UTAMA -->
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        RINGKASAN PEMBELIAN &amp; RESTOCK UTAMA
    </div>
    <table style="width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-left: -8px; margin-right: -8px; margin-bottom: 14px;">
        <tr>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">TOTAL PENGELUARAN BELANJA</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #0f172a; margin-top: 2px;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">{{ $totalPurchasesCount }} faktur PO tercatat</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">TOTAL MATERIAL MASUK</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #2563eb; margin-top: 2px;">{{ number_format($totalItemsQty, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">Total unit/batang masuk</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">BELANJA LUNAS (TERBAYAR)</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #16a34a; margin-top: 2px;">Rp {{ number_format($paidTotal, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">{{ $paidCount }} faktur terbayar penuh</div>
            </td>
            <td style="width: 25%; border: 1px solid #cbd5e1; border-radius: 4px; padding: 7px 10px; background-color: #ffffff; vertical-align: top;">
                <div style="font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase;">HUTANG BELANJA / TEMPO</div>
                <div style="font-size: 11.5pt; font-weight: bold; color: #dc2626; margin-top: 2px;">Rp {{ number_format($unpaidTotal, 0, ',', '.') }}</div>
                <div style="font-size: 7pt; color: #64748b; margin-top: 2px;">{{ $unpaidCount + $partialCount }} faktur belum selesai</div>
            </td>
        </tr>
    </table>

    <!-- SECTION 2: DISTRIBUSI STATUS PEMBAYARAN FAKTUR -->
    @php
        $totAmt = (float)$totalAmount;
        $pctPaid = $totAmt > 0 ? number_format(($paidTotal / $totAmt) * 100, 1) : 0;
        $pctPartial = $totAmt > 0 ? number_format(($partialTotal / $totAmt) * 100, 1) : 0;
        $pctUnpaid = $totAmt > 0 ? number_format(($unpaidTotalOnly / $totAmt) * 100, 1) : 0;
    @endphp
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        DISTRIBUSI STATUS PEMBAYARAN FAKTUR
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1; margin-bottom: 14px;">
        <thead>
            <tr style="background-color: #1e293b; color: #ffffff;">
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: left; text-transform: uppercase; width: 30%; border: 1px solid #1e293b;">STATUS PEMBAYARAN</th>
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: center; text-transform: uppercase; width: 20%; border: 1px solid #1e293b;">JUMLAH FAKTUR</th>
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: right; text-transform: uppercase; width: 30%; border: 1px solid #1e293b;">TOTAL BELANJA (RP)</th>
                <th style="padding: 5px 8px; font-size: 7.5pt; font-weight: bold; text-align: right; text-transform: uppercase; width: 20%; border: 1px solid #1e293b;">PERSENTASE (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #15803d;">Lunas (Terbayar Penuh)</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: center;">{{ $paidCount }} Faktur</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($paidTotal, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $pctPaid }}%</td>
            </tr>
            <tr style="background-color: #f8fafc;">
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #b45309;">DP / Sebagian (Tempo Aktif)</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: center;">{{ $partialCount }} Faktur</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($partialTotal, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $pctPartial }}%</td>
            </tr>
            <tr>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; font-weight: bold; color: #b91c1c;">Belum Lunas (Hutang Dagang)</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: center;">{{ $unpaidCount }} Faktur</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace;">Rp {{ number_format($unpaidTotalOnly, 0, ',', '.') }}</td>
                <td style="padding: 5px 8px; font-size: 8pt; border: 1px solid #cbd5e1; text-align: right;">{{ $pctUnpaid }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- SECTION 3: RINCIAN FAKTUR PEMBELIAN & RESTOCK PERIODE TERPILIH -->
    <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.3px;">
        <span style="display: inline-block; width: 3.5px; height: 11px; background-color: #2563eb; margin-right: 5px; vertical-align: middle;"></span>
        RINCIAN FAKTUR PEMBELIAN &amp; RESTOCK PERIODE TERPILIH ({{ $purchases->count() }} DATA DITEMUKAN)
    </div>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #cbd5e1; margin-bottom: 14px;">
        <thead>
            <tr style="background-color: #1e293b; color: #ffffff;">
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e293b; width: 15%;">NO. FAKTUR PO &amp; TANGGAL</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e293b; width: 20%;">SUPPLIER VENDOR</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: left; text-transform: uppercase; border: 1px solid #1e293b; width: 38%;">RINCIAN BARANG &amp; MATERIAL MASUK</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: right; text-transform: uppercase; border: 1px solid #1e293b; width: 14%;">TOTAL FAKTUR</th>
                <th style="padding: 5px 6px; font-size: 7pt; font-weight: bold; text-align: center; text-transform: uppercase; border: 1px solid #1e293b; width: 13%;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $p)
            @php
                $supName = $p->supplier ? ($p->supplier->company_name ?: $p->supplier->name) : 'Supplier Umum';
                $supPhone = $p->supplier && $p->supplier->phone ? $p->supplier->phone : null;
            @endphp
            <tr>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; vertical-align: top;">
                    <div style="font-weight: bold; color: #0f172a; font-family: monospace;">{{ $p->invoice_number }}</div>
                    <div style="font-size: 6.5pt; color: #64748b; margin-top: 1px;">{{ $p->purchase_date ? $p->purchase_date->format('d/m/Y') : '-' }}</div>
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; vertical-align: top;">
                    <div style="font-weight: bold; color: #0f172a;">{{ $supName }}</div>
                    @if($supPhone)
                        <div style="font-size: 6.5pt; color: #64748b; margin-top: 1px;">{{ $supPhone }}</div>
                    @endif
                </td>
                <td style="padding: 4px 6px; font-size: 7pt; border: 1px solid #cbd5e1; vertical-align: top;">
                    @forelse($p->items as $it)
                        @php
                            $pName = $it->product ? $it->product->name : 'Item Material';
                            $uSym = $it->product && $it->product->unit ? $it->product->unit->symbol : 'unit';
                        @endphp
                        <div style="margin-bottom: 2px;">
                            &bull; <strong>{{ $pName }}</strong> - <span style="font-family: monospace;">{{ (float)$it->quantity }} {{ $uSym }} @ Rp {{ number_format($it->unit_cost, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <span style="color: #94a3b8; font-style: italic;">- Tidak ada rincian material -</span>
                    @endforelse
                    @if($p->notes)
                        <div style="font-size: 6.5pt; color: #64748b; font-style: italic; margin-top: 2px;">Catatan: {{ $p->notes }}</div>
                    @endif
                </td>
                <td style="padding: 4px 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; vertical-align: middle; font-family: monospace; font-weight: bold; color: #0f172a;">
                    Rp {{ number_format($p->total_amount, 0, ',', '.') }}
                </td>
                <td style="padding: 4px 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; vertical-align: middle;">
                    @if($p->payment_status === 'paid')
                        <span class="badge badge-paid">Lunas</span>
                    @elseif($p->payment_status === 'partial')
                        <span class="badge badge-partial">DP / Tempo</span>
                    @else
                        <span class="badge badge-unpaid">Belum Lunas</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding: 15px; text-align: center; color: #94a3b8; font-style: italic;">
                    Tidak ada data faktur pembelian yang tercatat pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($purchases->count() > 0)
        <tfoot>
            <tr style="background-color: #f8fafc; font-weight: bold;">
                <td colspan="3" style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; text-transform: uppercase;">
                    TOTAL PENGELUARAN PERIODE INI ({{ $totalPurchasesCount }} Faktur)
                </td>
                <td style="padding: 6px; font-size: 7.5pt; border: 1px solid #cbd5e1; text-align: right; font-family: monospace; color: #0f172a;">
                    Rp {{ number_format($totalAmount, 0, ',', '.') }}
                </td>
                <td style="padding: 6px; font-size: 7pt; border: 1px solid #cbd5e1; text-align: center; color: #64748b;">
                    {{ $totalPurchasesCount }} Faktur
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
                    AzkaMandiri Admin Panel - Laporan Pembelian &amp; Restock
                </td>
                <td style="text-align: right; font-size: 7pt; color: #64748b;">
                    Halaman 1 dari 1
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
