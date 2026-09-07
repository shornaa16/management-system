<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile_no',
        'email',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * All purchases that belong to this supplier.
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Returns true if the supplier has any related purchases.
     * Used to prevent unsafe deletions.
     */
    public function hasPurchases(): bool
    {
        return $this->purchases()->exists();
    }

    /**
     * Scope to filter only active suppliers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
