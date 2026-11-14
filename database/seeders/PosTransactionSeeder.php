<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PosTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $custHendra = Customer::where('phone', '081288991122')->first();
        $custSiti = Customer::where('phone', '081377889900')->first();

        $prodAluHitam = Product::where('sku', 'ALU-KS3-BLK')->first();
        $prodHandle = Product::where('sku', 'AKS-HDL-DKK')->first();
        $prodSealant = Product::where('sku', 'SLN-DOW-BLK')->first();
        $prodCustomPintu = Product::where('sku', 'CST-PNT-SPK')->first();

        // 1. Retail Transaction Lunas (Cash)
        if ($prodAluHitam && $prodSealant) {
            $trans1 = Transaction::firstOrCreate(
                ['invoice_code' => 'INV-202611-0001'],
                [
                    'customer_id' => $custHendra ? $custHendra->id : null,
                    'user_id' => $admin ? $admin->id : null,
                    'transaction_date' => Carbon::now()->subDays(2)->setTime(10, 30),
                    'order_type' => 'retail',
                    'subtotal' => (2 * 175000) + (3 * 60000), // 350.000 + 180.000 = 530.000
                    'discount_amount' => 30000,
                    'tax_amount' => 0,
                    'total_amount' => 500000,
                    'paid_amount' => 500000,
                    'change_amount' => 0,
                    'payment_type' => 'cash',
                    'payment_status' => 'paid',
                    'notes' => 'Pembelian eceran bahan aluminium kusen dan sealant.',
                ]
            );

            TransactionItem::firstOrCreate(
                ['transaction_id' => $trans1->id, 'product_id' => $prodAluHitam->id],
                [
                    'quantity' => 2,
                    'unit_price' => 175000,
                    'cost_price' => 125000,
                    'subtotal' => 350000,
                    'specification' => 'Panjang utuh 6m',
                ]
            );

            TransactionItem::firstOrCreate(
                ['transaction_id' => $trans1->id, 'product_id' => $prodSealant->id],
                [
                    'quantity' => 3,
                    'unit_price' => 60000,
                    'cost_price' => 42000,
                    'subtotal' => 180000,
                    'specification' => 'Warna hitam',
                ]
            );

            Payment::firstOrCreate(
                ['transaction_id' => $trans1->id, 'reference_number' => 'CASH-0001'],
                [
                    'payment_date' => Carbon::now()->subDays(2)->setTime(10, 30),
                    'amount' => 500000,
                    'payment_type' => 'cash',
                    'notes' => 'Pembayaran lunas kasir tunai',
                ]
            );
        }

        // 2. Project Custom Transaction dengan DP (Piutang)
        if ($custSiti && $prodCustomPintu && $prodHandle) {
            $totalProject = (2 * 1650000) + (2 * 260000); // 3.300.000 + 520.000 = 3.820.000
            $dpAmount = 2000000;

            $trans2 = Transaction::firstOrCreate(
                ['invoice_code' => 'INV-202611-0002'],
                [
                    'customer_id' => $custSiti->id,
                    'user_id' => $admin ? $admin->id : null,
                    'transaction_date' => Carbon::now()->subDays(1)->setTime(14, 15),
                    'order_type' => 'project_custom',
                    'subtotal' => $totalProject,
                    'discount_amount' => 20000,
                    'tax_amount' => 0,
                    'total_amount' => 3800000,
                    'paid_amount' => $dpAmount,
                    'change_amount' => 0,
                    'payment_type' => 'transfer',
                    'payment_status' => 'partial',
                    'due_date' => Carbon::now()->addDays(7)->toDateString(),
                    'notes' => 'Pesanan 2 unit pintu swing aluminium klinik estetika Bintaro. DP 2 juta via Transfer BCA, sisa 1.8 juta dilunasi saat serah terima.',
                ]
            );

            TransactionItem::firstOrCreate(
                ['transaction_id' => $trans2->id, 'product_id' => $prodCustomPintu->id],
                [
                    'quantity' => 2,
                    'unit_price' => 1650000,
                    'cost_price' => 950000,
                    'subtotal' => 3300000,
                    'specification' => 'Ukuran 210 x 90 cm, aluminium putih coating, kaca es 5mm',
                ]
            );

            TransactionItem::firstOrCreate(
                ['transaction_id' => $trans2->id, 'product_id' => $prodHandle->id],
                [
                    'quantity' => 2,
                    'unit_price' => 260000,
                    'cost_price' => 180000,
                    'subtotal' => 520000,
                    'specification' => 'Handle Dekkson SUS 304',
                ]
            );

            Payment::firstOrCreate(
                ['transaction_id' => $trans2->id, 'reference_number' => 'TRF-BCA-98124'],
                [
                    'payment_date' => Carbon::now()->subDays(1)->setTime(14, 15),
                    'amount' => $dpAmount,
                    'payment_type' => 'transfer',
                    'notes' => 'Uang Muka (DP) 50% via Transfer Bank BCA',
                ]
            );
        }

        // 3. Stock Adjustment Opname (Barang pecah / terpotong)
        if ($prodSealant) {
            StockAdjustment::firstOrCreate(
                ['adjustment_code' => 'ADJ-202611-0001'],
                [
                    'product_id' => $prodSealant->id,
                    'user_id' => $admin ? $admin->id : null,
                    'date' => Carbon::now()->subDays(4)->toDateString(),
                    'type' => 'out',
                    'quantity' => 1,
                    'reason' => 'damaged',
                    'notes' => 'Satu tube sealant bocor kemasan saat bongkar muat.',
                ]
            );
        }
    }
}

