<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_number',
        'customer_id',
        'customer_name',
        'customer_phone',
        'customer_company',
        'customer_address',
        'date',
        'valid_until',
        'status',
        'order_type',
        'subtotal',
        'discount',
        'tax',
        'grand_total',
        'notes',
        'terms_conditions',
        'created_by',
        'converted_transaction_id',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function convertedTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'converted_transaction_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    /**
     * Generate sequential unique quotation number: AM/QTN/YYYY/MM/001
     */
    public static function generateNextNumber(): string
    {
        $year = date('Y');
        $month = date('m');
        $prefix = "AM/QTN/{$year}/{$month}/";

        $latest = self::where('quotation_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        $seq = 1;
        if ($latest) {
            $parts = explode('/', $latest->quotation_number);
            $lastSeq = end($parts);
            $seq = intval($lastSeq) + 1;
        }

        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }

    public function getEffectiveCustomerNameAttribute(): string
    {
        return $this->customer->name ?? $this->customer_name ?? 'Pelanggan Umum';
    }

    public function getEffectiveCustomerPhoneAttribute(): string
    {
        return $this->customer->phone ?? $this->customer_phone ?? '-';
    }

    public function getEffectiveCustomerCompanyAttribute(): ?string
    {
        return $this->customer->company_name ?? $this->customer_company;
    }

    public function getEffectiveCustomerAddressAttribute(): ?string
    {
        return $this->customer->address ?? $this->customer_address;
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'draft' => [
                'label' => 'Draft',
                'bg' => 'bg-slate-100',
                'text' => 'text-slate-700',
                'border' => 'border-slate-300',
                'dot' => 'bg-slate-500',
            ],
            'sent' => [
                'label' => 'Terkirim',
                'bg' => 'bg-sky-50',
                'text' => 'text-sky-700',
                'border' => 'border-sky-300',
                'dot' => 'bg-sky-500',
            ],
            'accepted' => [
                'label' => 'Diterima',
                'bg' => 'bg-emerald-50',
                'text' => 'text-emerald-700',
                'border' => 'border-emerald-300',
                'dot' => 'bg-emerald-500',
            ],
            'rejected' => [
                'label' => 'Ditolak',
                'bg' => 'bg-rose-50',
                'text' => 'text-rose-700',
                'border' => 'border-rose-300',
                'dot' => 'bg-rose-500',
            ],
            'converted' => [
                'label' => 'Dikonversi ke Invoice',
                'bg' => 'bg-purple-50',
                'text' => 'text-purple-700',
                'border' => 'border-purple-300',
                'dot' => 'bg-purple-500',
            ],
            default => [
                'label' => ucfirst($this->status),
                'bg' => 'bg-gray-100',
                'text' => 'text-gray-700',
                'border' => 'border-gray-300',
                'dot' => 'bg-gray-500',
            ],
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status_badge['label'] ?? ucfirst($this->status);
    }

    public function getFormattedGrandTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->grand_total ?? 0, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal ?? 0, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount ?? 0, 0, ',', '.');
    }

    public function getFormattedTaxAttribute(): string
    {
        return 'Rp ' . number_format($this->tax ?? 0, 0, ',', '.');
    }

    public function getIsExpiredAttribute(): bool
    {
        if (in_array($this->status, ['accepted', 'converted'])) {
            return false;
        }

        return $this->valid_until && $this->valid_until->isPast() && !$this->valid_until->isToday();
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $query->where(function ($sub) use ($q) {
                $sub->where('quotation_number', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_company', 'like', "%{$q}%")
                    ->orWhereHas('customer', function ($c) use ($q) {
                        $c->where('name', 'like', "%{$q}%")
                            ->orWhere('company_name', 'like', "%{$q}%")
                            ->orWhere('phone', 'like', "%{$q}%");
                    });
            });
        }

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('date', '<=', $filters['end_date']);
        }

        return $query;
    }
}
