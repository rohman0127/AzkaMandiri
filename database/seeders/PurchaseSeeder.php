<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $supAlu = Supplier::where('company_name', 'like', '%Duta Aluminium%')->first();
        $supKaca = Supplier::where('company_name', 'like', '%Asahi Prima%')->first();

        $prodAluHitam = Product::where('sku', 'ALU-KS3-BLK')->first();
        $prodAluPutih = Product::where('sku', 'ALU-KS3-WHT')->first();
        $prodKacaClear = Product::where('sku', 'KAC-CLR-5MM')->first();

        if ($supAlu && $prodAluHitam && $prodAluPutih) {
            $purchase1 = Purchase::firstOrCreate(
                ['invoice_number' => 'PO-202611-0001'],
                [
                    'supplier_id' => $supAlu->id,
                    'purchase_date' => Carbon::now()->subDays(5)->toDateString(),
                    'total_amount' => (20 * 125000) + (15 * 135000),
                    'payment_status' => 'paid',
                    'notes' => 'Restock mingguan profil kusen aluminium 3 inch Alexindo.',
                ]
            );

            PurchaseItem::firstOrCreate(
                ['purchase_id' => $purchase1->id, 'product_id' => $prodAluHitam->id],
                [
                    'quantity' => 20,
                    'unit_cost' => 125000,
                    'subtotal' => 20 * 125000,
                ]
            );

            PurchaseItem::firstOrCreate(
                ['purchase_id' => $purchase1->id, 'product_id' => $prodAluPutih->id],
                [
                    'quantity' => 15,
                    'unit_cost' => 135000,
                    'subtotal' => 15 * 135000,
                ]
            );
        }

        if ($supKaca && $prodKacaClear) {
            $purchase2 = Purchase::firstOrCreate(
                ['invoice_number' => 'PO-202611-0002'],
                [
                    'supplier_id' => $supKaca->id,
                    'purchase_date' => Carbon::now()->subDays(3)->toDateString(),
                    'total_amount' => 10 * 195000,
                    'payment_status' => 'paid',
                    'notes' => 'Pembelian bahan kaca lembaran bening 5mm.',
                ]
            );

            PurchaseItem::firstOrCreate(
                ['purchase_id' => $purchase2->id, 'product_id' => $prodKacaClear->id],
                [
                    'quantity' => 10,
                    'unit_cost' => 195000,
                    'subtotal' => 10 * 195000,
                ]
            );
        }
    }
}

