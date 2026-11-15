<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $transaction->invoice_code }} - AzkaMandiri</title>
    <style>
        @page {
            margin: 25px 35px 30px 35px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* Header */
        .header-table td {
            vertical-align: top;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .company-sub {
            font-size: 10px;
            font-weight: bold;
            color: #b45309;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .company-contact {
            font-size: 9.5px;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.4;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: 1px;
            text-align: right;
        }
        .invoice-meta {
            margin-top: 6px;
            font-size: 10px;
            color: #475569;
        }
        .invoice-meta td {
            padding: 1.5px 0;
        }

        /* Status Badge */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 4px;
            letter-spacing: 0.5px;
        }
        .badge-paid {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
        }
        .badge-partial {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .badge-unpaid {
            background-color: #ffe4e6;
            color: #be123c;
            border: 1px solid #fecdd3;
        }

        /* Customer & Order Box */
        .info-box {
            margin-top: 18px;
            margin-bottom: 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .info-box td {
            padding: 10px 14px;
            vertical-align: top;
            width: 50%;
        }
        .info-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            color: #94a3b8;
            margin-bottom: 4px;
        }
        .info-content {
            font-size: 11px;
            color: #1e293b;
        }

        /* Items Table */
        .items-table {
            margin-top: 10px;
            border: 1px solid #cbd5e1;
        }
        .items-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 10px;
        }
        .items-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: top;
        }
        .items-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .item-spec {
            font-size: 9px;
            color: #64748b;
            font-style: italic;
            margin-top: 3px;
        }

        /* Calculation & Totals */
        .calc-table {
            margin-top: 12px;
        }
        .calc-table td {
            vertical-align: top;
        }
        .totals-box {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-box td {
            padding: 4px 8px;
            font-size: 10.5px;
        }
        .grand-total {
            font-size: 13px;
            font-weight: bold;
            background-color: #f1f5f9;
            color: #0f172a;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;
        }

        /* Bank & Terms */
        .terms-box {
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            padding: 8px 10px;
            border-radius: 4px;
            font-size: 9px;
            color: #78350f;
            line-height: 1.4;
        }
        .bank-info {
            font-size: 9.5px;
            color: #334155;
            line-height: 1.4;
            margin-top: 8px;
        }

        /* Signatures */
        .sign-table {
            margin-top: 35px;
        }
        .sign-table td {
            width: 50%;
            text-align: center;
            font-size: 10px;
        }
        .sign-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td style="width: 55%;">
                <div class="company-name">AZKA MANDIRI</div>
                <div class="company-sub">Spesialis Aluminium, Kaca & Interior</div>
                <div class="company-contact">
                    Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara<br>
                    Kota Tangerang Selatan, Banten 15220<br>
                    Telp / WhatsApp: +62 819-3273-5383 | Email: kontak@azkamandiri.com<br>
                    Website: azkamandiri.nichesite.org
                </div>
            </td>
            <td style="width: 45%;">
                <div class="invoice-title">INVOICE</div>
                <table class="invoice-meta" style="margin-left: auto; width: 90%;">
                    <tr>
                        <td class="text-right font-bold" style="width: 45%;">No. Invoice :</td>
                        <td class="text-right font-bold">{{ $transaction->invoice_code }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: #64748b;">Tanggal :</td>
                        <td class="text-right">{{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    @if($transaction->due_date)
                    <tr>
                        <td class="text-right" style="color: #be123c; font-weight: bold;">Jatuh Tempo :</td>
                        <td class="text-right" style="color: #be123c; font-weight: bold;">{{ \Carbon\Carbon::parse($transaction->due_date)->translatedFormat('d F Y') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="text-right" style="color: #64748b;">Status :</td>
                        <td class="text-right">
                            @if($transaction->payment_status === 'paid')
                                <span class="badge badge-paid">LUNAS</span>
                            @elseif($transaction->payment_status === 'partial')
                                <span class="badge badge-partial">DP / BERTAHAP</span>
                            @else
                                <span class="badge badge-unpaid">BELUM LUNAS</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Customer & Order Meta -->
    <div class="info-box">
        <table>
            <tr>
                <td>
                    <div class="info-label">DITUJUKAN KEPADA :</div>
                    <div class="info-content">
                        <strong>{{ $transaction->customer->name ?? 'Pelanggan Umum (Walk-in)' }}</strong><br>
                        @if($transaction->customer && $transaction->customer->phone)
                            Telp / WhatsApp: {{ $transaction->customer->phone }}<br>
                        @endif
                        @if($transaction->customer && $transaction->customer->email)
                            Email: {{ $transaction->customer->email }}<br>
                        @endif
                        @if($transaction->customer && $transaction->customer->address)
                            Alamat: {{ $transaction->customer->address }}
                        @endif
                    </div>
                </td>
                <td style="border-left: 1px solid #e2e8f0;">
                    <div class="info-label">INFORMASI PESANAN :</div>
                    <div class="info-content">
                        Tipe Pesanan: <strong>{{ $transaction->order_type === 'project_custom' ? 'Proyek Custom Aluminium / Kaca' : 'Penjualan Ritel Toko' }}</strong><br>
                        Metode Pembayaran: <span class="uppercase"><strong>{{ $transaction->payment_type }}</strong></span><br>
                        Petugas Kasir: {{ $transaction->user->name ?? 'Admin' }}<br>
                        @if($transaction->notes)
                            Catatan: <em>"{{ $transaction->notes }}"</em>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 48%;">Deskripsi Produk & Spesifikasi Proyek</th>
                <th class="text-center" style="width: 10%;">Satuan</th>
                <th class="text-right" style="width: 17%;">Harga Satuan</th>
                <th class="text-center" style="width: 8%;">Qty</th>
                <th class="text-right" style="width: 17%;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $idx => $item)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>
                    <div class="font-bold">{{ $item->product->name ?? 'Produk Custom' }}</div>
                    @if($item->specification)
                        <div class="item-spec">• Spesifikasi: {{ $item->specification }}</div>
                    @endif
                </td>
                <td class="text-center">{{ $item->product->unit->symbol ?? $item->product->unit->name ?? 'pcs' }}</td>
                <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                <td class="text-center font-bold">
                    {{ (float)$item->quantity == (int)$item->quantity ? number_format($item->quantity, 0) : number_format($item->quantity, 2) }}
                </td>
                <td class="text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Calculation & Payment Info -->
    <table class="calc-table">
        <tr>
            <!-- Left: Bank & Terms -->
            <td style="width: 55%; padding-right: 15px;">
                <div class="bank-info">
                    <strong>INFORMASI REKENING PEMBAYARAN:</strong><br>
                    • Bank BCA: <strong>474-0850-364</strong> a.n. Mikliw Oking<br>
                    <em>Harap cantumkan nomor invoice ({{ $transaction->invoice_code }}) pada berita transfer.</em>
                </div>

                <div class="terms-box" style="margin-top: 10px;">
                    <strong>SYARAT & KETENTUAN GARANSI:</strong><br>
                    1. Garansi kebocoran silikon & kerapian pemasangan berlaku 6 bulan sejak serah terima.<br>
                    2. Pelunasan sisa tagihan wajib diselesaikan sesuai tanggal jatuh tempo yang disepakati.<br>
                    3. Material custom yang sudah dipotong/dipabrikasi tidak dapat dibatalkan secara sepihak.
                </div>
            </td>

            <!-- Right: Totals Box -->
            <td style="width: 45%;">
                <table class="totals-box">
                    <tr>
                        <td class="text-right" style="color: #64748b;">Subtotal :</td>
                        <td class="text-right" style="width: 50%;">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($transaction->discount_amount > 0)
                    <tr>
                        <td class="text-right" style="color: #15803d;">Diskon Khusus :</td>
                        <td class="text-right" style="color: #15803d;">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="grand-total">
                        <td class="text-right">GRAND TOTAL :</td>
                        <td class="text-right">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: #15803d; font-weight: bold; padding-top: 6px;">Total Terbayar :</td>
                        <td class="text-right font-bold" style="color: #15803d; padding-top: 6px;">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($transaction->remaining_debt > 0)
                    <tr style="background-color: #fff1f2; font-weight: bold; color: #be123c;">
                        <td class="text-right" style="border: 1px solid #fecdd3;">SISA PIUTANG :</td>
                        <td class="text-right" style="border: 1px solid #fecdd3;">Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- Signatures -->
    <table class="sign-table">
        <tr>
            <td>
                <div>Penerima / Pemesan,</div>
                <div class="sign-space"></div>
                <div>( <strong>{{ $transaction->customer->name ?? 'Pelanggan' }}</strong> )</div>
            </td>
            <td>
                <div>Tangerang Selatan, {{ \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') }}</div>
                <div>Hormat Kami, <strong>Azka Mandiri</strong></div>
                <div class="sign-space"></div>
                <div>( <strong>{{ $transaction->user->name ?? 'Management / Kasir' }}</strong> )</div>
            </td>
        </tr>
    </table>

</body>
</html>

