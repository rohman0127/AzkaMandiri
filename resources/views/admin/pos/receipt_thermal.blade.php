<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk POS - {{ $transaction->invoice_code }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.35;
            color: #000;
            background-color: #f1f5f9;
            padding: 20px 0;
        }
        .receipt-container {
            width: 78mm;
            margin: 0 auto;
            background: #fff;
            padding: 12px 10px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .receipt-container.w-58 {
            width: 58mm;
            padding: 8px 6px;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .divider-double {
            border-top: 1px double #000;
            margin: 8px 0;
        }

        .header h1 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 2px;
            letter-spacing: 0.5px;
        }
        .header p {
            font-size: 9.5px;
            color: #222;
        }

        .meta-table, .items-table, .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 1px 0;
            font-size: 10px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding-bottom: 4px;
            font-size: 10px;
        }
        .items-table td {
            padding: 3px 0 1px 0;
            vertical-align: top;
        }
        .item-spec {
            font-size: 9px;
            font-style: italic;
            color: #333;
            padding-left: 6px;
        }

        .summary-table td {
            padding: 1.5px 0;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
            line-height: 1.3;
        }

        /* Screen Action Bar */
        .toolbar {
            width: 78mm;
            margin: 0 auto 12px auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #334155;
        }
        .btn-primary {
            background: #0284c7;
            color: #fff;
            border-color: #0284c7;
        }
        .btn:hover { opacity: 0.9; }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .toolbar { display: none !important; }
            .receipt-container {
                box-shadow: none;
                padding: 4px 2px;
                width: 100% !important;
            }
            @page {
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <!-- On-screen Action Toolbar -->
    <div class="toolbar" id="toolbar">
        <button class="btn btn-primary" onclick="window.print()">
            🖨️ Cetak Struk
        </button>
        <button class="btn" onclick="togglePaperWidth()">
            📐 <span id="widthLabel">Format: 80mm</span>
        </button>
        <button class="btn" onclick="window.close()">
            ✕ Tutup
        </button>
    </div>

    <!-- Thermal Receipt Body -->
    <div class="receipt-container" id="receipt">
        <!-- Store Header -->
        <div class="header text-center">
            <h1>AZKA MANDIRI</h1>
            <p class="font-bold">SPESIALIS ALUMINIUM & KACA</p>
            <p>Jl. Pondok Serut, Paku Jaya, Serpong Utara</p>
            <p>Tangerang Selatan, Banten 15220</p>
            <p>Telp / WhatsApp: 0819-3273-5383</p>
        </div>

        <div class="divider"></div>

        <!-- Meta Info -->
        <table class="meta-table">
            <tr>
                <td style="width: 45%;">No. Nota</td>
                <td class="font-bold">: {{ $transaction->invoice_code }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: {{ $transaction->user->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td class="font-bold">: {{ $transaction->customer->name ?? 'Umum (Walk-in)' }}</td>
            </tr>
            @if($transaction->customer && $transaction->customer->phone)
            <tr>
                <td>No. Telp</td>
                <td>: {{ $transaction->customer->phone }}</td>
            </tr>
            @endif
            <tr>
                <td>Tipe Pesanan</td>
                <td class="uppercase">: {{ $transaction->order_type === 'project_custom' ? 'Proyek Custom' : 'Penjualan Ritel' }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk/Item</th>
                    <th class="text-right" style="width: 20%;">Qty</th>
                    <th class="text-right" style="width: 30%;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $item)
                <tr>
                    <td colspan="3" class="font-bold">
                        {{ $item->product->name ?? 'Item Kustom' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding-left: 6px; font-size: 9.5px; color: #444;">
                        @ {{ number_format($item->unit_price, 0, ',', '.') }}
                    </td>
                    <td class="text-right" style="font-size: 10px;">
                        {{ (float)$item->quantity == (int)$item->quantity ? number_format($item->quantity, 0) : number_format($item->quantity, 2) }} {{ $item->product->unit->symbol ?? '' }}
                    </td>
                    <td class="text-right font-bold">
                        {{ number_format($item->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @if($item->specification)
                <tr>
                    <td colspan="3" class="item-spec">
                        * {{ $item->specification }}
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

        <div class="divider"></div>

        <!-- Summary -->
        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
            </tr>
            @if($transaction->discount_amount > 0)
            <tr>
                <td>Diskon</td>
                <td class="text-right">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="font-bold" style="font-size: 12px;">
                <td>TOTAL</td>
                <td class="text-right">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><div class="divider"></div></td>
            </tr>
            <tr>
                <td>Bayar ({{ strtoupper($transaction->payment_type) }})</td>
                <td class="text-right font-bold">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td>
            </tr>

            @if($transaction->change_amount > 0)
            <tr>
                <td>Kembalian</td>
                <td class="text-right">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</td>
            </tr>
            @endif

            @if($transaction->remaining_debt > 0)
            <tr class="font-bold">
                <td>SISA PIUTANG</td>
                <td class="text-right">Rp {{ number_format($transaction->remaining_debt, 0, ',', '.') }}</td>
            </tr>
            @if($transaction->due_date)
            <tr style="font-size: 9.5px;">
                <td>Jatuh Tempo</td>
                <td class="text-right">{{ \Carbon\Carbon::parse($transaction->due_date)->format('d/m/Y') }}</td>
            </tr>
            @endif
            @endif

            <tr>
                <td>Status</td>
                <td class="text-right font-bold uppercase">
                    @if($transaction->payment_status === 'paid')
                        *** LUNAS ***
                    @elseif($transaction->payment_status === 'partial')
                        * DP / BERTAHAP *
                    @else
                        * BELUM BAYAR *
                    @endif
                </td>
            </tr>
        </table>

        <div class="divider-double"></div>

        <!-- Footer -->
        <div class="footer">
            <p class="font-bold">TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
            <p>Kepuasan Anda Prioritas Kami</p>
            <p style="margin-top: 4px;">Pintu - Jendela - Kusen - Kaca Tempered - Partisi</p>
            <p style="margin-top: 6px; font-size: 8px;">Simpan struk ini sebagai bukti pembayaran resmi.</p>
        </div>
    </div>

    <script>
        function togglePaperWidth() {
            var receipt = document.getElementById('receipt');
            var toolbar = document.getElementById('toolbar');
            var label = document.getElementById('widthLabel');
            if (receipt.classList.contains('w-58')) {
                receipt.classList.remove('w-58');
                toolbar.style.width = '78mm';
                label.innerText = 'Format: 80mm';
            } else {
                receipt.classList.add('w-58');
                toolbar.style.width = '58mm';
                label.innerText = 'Format: 58mm';
            }
        }

        // Auto print trigger on opening
        window.onload = function() {
            // Optional: Uncomment below if auto print popup is preferred
            // window.print();
        };
    </script>
</body>
</html>

