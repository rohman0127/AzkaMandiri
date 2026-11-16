<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Penawaran {{ $quotation->quotation_number }} - AzkaMandiri</title>
    <style>
        @page {
            margin: 25px 35px 25px 35px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10.5px;
            line-height: 1.4;
            color: #1e293b;
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
            font-size: 9px;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.4;
        }

        .doc-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            letter-spacing: 0.5px;
            text-align: right;
        }
        .doc-subtitle {
            font-size: 9.5px;
            color: #64748b;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .doc-meta {
            margin-top: 6px;
            font-size: 9.5px;
            color: #334155;
        }
        .doc-meta td {
            padding: 1.5px 0;
        }

        /* Divider Gold & Navy */
        .divider-bar {
            height: 3px;
            background-color: #d97706;
            margin: 14px 0 16px 0;
        }

        /* Info Boxes */
        .info-table td {
            vertical-align: top;
            padding: 0 4px;
        }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            min-height: 75px;
        }
        .info-card-title {
            font-size: 9px;
            font-weight: bold;
            color: #b45309;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }

        /* Items Table */
        .items-table {
            margin-top: 14px;
            border: 1px solid #cbd5e1;
        }
        .items-table th {
            background-color: #1e293b;
            color: #ffffff;
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            border: 1px solid #1e293b;
        }
        .items-table td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            font-size: 9.5px;
            vertical-align: top;
        }
        .items-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Calculation Summary */
        .summary-wrapper {
            margin-top: 10px;
        }
        .summary-table td {
            padding: 4px 8px;
            font-size: 9.5px;
        }
        .summary-table .label {
            color: #475569;
            text-align: right;
            width: 70%;
        }
        .summary-table .value {
            text-align: right;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
            width: 30%;
        }
        .grand-total-row {
            background-color: #0f172a;
            color: #ffffff;
        }
        .grand-total-row td {
            padding: 6px 8px;
            font-size: 11px;
            font-weight: bold;
        }
        .grand-total-row .value {
            color: #fbbf24;
            font-size: 12px;
        }

        /* Terms & Notes */
        .terms-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            padding: 8px 12px;
            margin-top: 12px;
            font-size: 8.5px;
            color: #334155;
            line-height: 1.45;
        }
        .terms-title {
            font-size: 9px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        /* Signatures */
        .signature-table {
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-space {
            height: 55px;
        }
        .signature-name {
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #334155;
            display: inline-block;
            min-width: 170px;
            padding-bottom: 2px;
        }
        .signature-role {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 3px;
        }

        /* Footer */
        .footer {
            margin-top: 25px;
            border-top: 1px solid #e2e8f0;
            padding-top: 6px;
            font-size: 8px;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td style="width: 58%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 56px; vertical-align: top; padding-right: 10px;">
                            <img src="{{ public_path('assets/brand/azka-logo-icon.png') }}" style="height: 50px; width: auto;" alt="Logo Azka Mandiri">
                        </td>
                        <td style="vertical-align: top;">
                            <div class="company-name" style="color: #1b2e56; font-family: 'Times New Roman', serif; font-size: 20px; letter-spacing: 0.8px;">{{ setting('company_name', 'AZKA MANDIRI') }}</div>
                            <div class="company-sub" style="color: #a81b3e; font-weight: bold; font-size: 9.5px; letter-spacing: 0.5px;">SPESIALIS ALUMINIUM, KACA &amp; FABRIKASI INTERIOR</div>
                            <div class="company-contact" style="font-size: 9px; color: #64748b; line-height: 1.35; margin-top: 3px;">
                                {{ setting('company_address', 'Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220') }}<br>
                                Telepon / WhatsApp: {{ setting('company_phone', '0819-3273-5383') }} &bull; Email: {{ setting('company_email', 'kontak@azkamandiri.com') }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 42%;">
                <div class="doc-title" style="color: #1b2e56;">PENAWARAN HARGA</div>
                <div class="doc-subtitle">Price Quotation / Sales Proposal</div>
                <table class="doc-meta" style="margin-left: auto; width: 95%;">
                    <tr>
                        <td class="text-right font-bold" style="width: 45%;">No. Penawaran :</td>
                        <td class="text-right font-bold" style="color: #0f172a;">{{ $quotation->quotation_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: #64748b;">Tanggal :</td>
                        <td class="text-right">{{ $quotation->date ? $quotation->date->translatedFormat('d F Y') : date('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: #64748b;">Berlaku Sampai :</td>
                        <td class="text-right font-bold" style="color: #b45309;">{{ $quotation->valid_until ? $quotation->valid_until->translatedFormat('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="color: #64748b;">Estimator / Petugas :</td>
                        <td class="text-right">{{ $quotation->creator->name ?? 'Tim Estimator' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="divider-bar"></div>

    <!-- Client / Proyek Info -->
    <table class="info-table">
        <tr>
            <td style="width: 50%;">
                <div class="info-card">
                    <div class="info-card-title">Informasi Klien / Pelanggan</div>
                    <div style="font-size: 11px; font-weight: bold; color: #0f172a;">
                        {{ $quotation->effective_customer_name }}
                    </div>
                    @if($quotation->effective_customer_company)
                        <div style="font-size: 9.5px; color: #475569; font-weight: 600;">
                            Perusahaan: {{ $quotation->effective_customer_company }}
                        </div>
                    @endif
                    <div style="font-size: 9px; color: #64748b; margin-top: 2px;">
                        Kontak: {{ $quotation->effective_customer_phone }}
                    </div>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="info-card">
                    <div class="info-card-title">Lokasi Pekerjaan &amp; Proyek</div>
                    <div style="font-size: 9.5px; color: #334155; line-height: 1.4;">
                        {{ $quotation->effective_customer_address ?: 'Lokasi disesuaikan dengan instruksi klien / workshop' }}
                    </div>
                    <div style="font-size: 8.5px; color: #64748b; margin-top: 4px;">
                        Tipe Proyek: <strong>{{ $quotation->order_type === 'retail' ? 'Pengadaan Bahan / Material Ritel' : 'Pekerjaan Fabrikasi &amp; Pemasangan Custom' }}</strong>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Rincian Item Penawaran -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 4%;">No</th>
                <th class="text-left" style="width: 38%;">Deskripsi Barang / Item Pekerjaan</th>
                <th class="text-left" style="width: 22%;">Dimensi &amp; Spesifikasi</th>
                <th class="text-center" style="width: 8%;">Volume</th>
                <th class="text-center" style="width: 6%;">Satuan</th>
                <th class="text-right" style="width: 11%;">Harga Satuan</th>
                <th class="text-right" style="width: 11%;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $idx => $item)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>
                    <strong style="color: #0f172a;">{{ $item->item_name }}</strong>
                    @if($item->product && $item->product->sku)
                        <div style="font-size: 8px; color: #64748b;">SKU: {{ $item->product->sku }}</div>
                    @endif
                </td>
                <td style="color: #475569;">
                    {{ $item->dimensions ?: '-' }}
                </td>
                <td class="text-center font-bold">
                    {{ (float)$item->quantity == (int)$item->quantity ? (int)$item->quantity : number_format($item->quantity, 2, ',', '.') }}
                </td>
                <td class="text-center text-slate-600">
                    {{ $item->unit_name ?: ($item->product->unit->symbol ?? 'unit') }}
                </td>
                <td class="text-right font-mono">
                    {{ number_format($item->unit_price, 0, ',', '.') }}
                </td>
                <td class="text-right font-mono font-bold" style="color: #0f172a;">
                    {{ number_format($item->total_price, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Financial Summary Box -->
    <table class="summary-wrapper">
        <tr>
            <td style="width: 55%; vertical-align: top; padding-right: 15px;">
                @if($quotation->notes)
                    <div class="terms-box" style="margin-top: 0; margin-bottom: 8px;">
                        <div class="terms-title">Catatan Tambahan Pekerjaan:</div>
                        {!! nl2br(e($quotation->notes)) !!}
                    </div>
                @endif
                <div class="terms-box" style="margin-top: 0;">
                    <div class="terms-title">Informasi Rekening Pembayaran Resmi:</div>
                    <strong>Bank Mandiri:</strong> 156-00-1888-9999 a.n. <strong>CV Azka Mandiri Perkasa</strong><br>
                    <strong>Bank BCA:</strong> 842-099-1234 a.n. <strong>Azka Mandiri</strong><br>
                    <span style="font-size: 8px; color: #64748b;">Harap cantumkan No. Penawaran pada berita transfer dan konfirmasikan bukti pembayaran.</span>
                </div>
            </td>
            <td style="width: 45%; vertical-align: top;">
                <table class="summary-table">
                    <tr>
                        <td class="label">Subtotal Nilai Pekerjaan:</td>
                        <td class="value">Rp {{ number_format($quotation->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($quotation->discount > 0)
                    <tr>
                        <td class="label" style="color: #059669;">Potongan Diskon Khusus:</td>
                        <td class="value" style="color: #059669;">- Rp {{ number_format($quotation->discount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($quotation->tax > 0)
                    <tr>
                        <td class="label">PPN / Pajak Terkait:</td>
                        <td class="value">+ Rp {{ number_format($quotation->tax, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td class="label" style="color: #ffffff;">TOTAL KESEPAKATAN:</td>
                        <td class="value">Rp {{ number_format($quotation->grand_total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Terms & Conditions Box -->
    @if($quotation->terms_conditions)
    <div class="terms-box">
        <div class="terms-title">Syarat &amp; Ketentuan Penawaran (Terms &amp; Conditions):</div>
        {!! nl2br(e($quotation->terms_conditions)) !!}
    </div>
    @endif

    <!-- Dual Signatures Box -->
    <table class="signature-table">
        <tr>
            <td class="signature-box">
                <div style="font-size: 9px; color: #64748b;">Diajukan &amp; Diterbitkan Oleh:</div>
                <div style="font-size: 10px; font-weight: bold; color: #0f172a; margin-top: 2px;">{{ setting('company_name', 'AzkaMandiri') }}</div>
                <div class="signature-space"></div>
                <div class="signature-name">{{ $quotation->creator->name ?? 'Estimator Proyek' }}</div>
                <div class="signature-role">Estimator Teknis / Marketing</div>
            </td>
            <td style="width: 10%;"></td>
            <td class="signature-box">
                <div style="font-size: 9px; color: #64748b;">Disetujui &amp; Diterima Oleh:</div>
                <div style="font-size: 10px; font-weight: bold; color: #0f172a; margin-top: 2px;">{{ $quotation->effective_customer_name }}</div>
                <div class="signature-space"></div>
                <div class="signature-name">( .................................................... )</div>
                <div class="signature-role">Tanda Tangan &amp; Cap Perusahaan / Tanggal</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen Surat Penawaran Harga ini digenerate secara resmi melalui Sistem ERP Enterprise AzkaMandiri. &bull; Halaman 1 dari 1
    </div>

</body>
</html>

