<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'supplier_id',
        'purchase_date',
        'notes',
        'subtotal',
        'paid',
        'due',
        'status',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'subtotal' => 'decimal:2',
        'paid' => 'decimal:2',
        'due' => 'decimal:2',
    ];

    /**
     * The supplier that this purchase order was issued to.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * The user who created this purchase order.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Line items belonging to this purchase order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Total quantity across all line items.
     */
    public function getTotalQuantityAttribute(): float
    {
        return (float) $this->items->sum('quantity');
    }

    /**
     * Scope to filter purchases by date range.
     */
    public function scopeDateBetween($query, $start = null, $end = null)
    {
        if ($start) {
            $query->where('purchase_date', '>=', $start);
        }
        if ($end) {
            $query->where('purchase_date', '<=', $end);
        }

        return $query;
    }

    /**
     * Scope to filter by a specific supplier.
     */
    public function scopeForSupplier($query, $supplierId = null)
    {
        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        return $query;
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, $status = null)
    {
        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }
}
