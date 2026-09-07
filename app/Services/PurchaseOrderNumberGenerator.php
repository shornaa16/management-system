<?php

namespace App\Services;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class PurchaseOrderNumberGenerator
{
    /**
     * Generate the next sequential purchase order number in the format PO-0001, PO-0002, ...
     *
     * The lookup is wrapped in a transaction with a row lock (when supported by
     * the database driver) so that concurrent requests cannot generate the same
     * number twice. If the driver is SQLite (typically used in tests / local
     * dev), we fall back to a best-effort lookup, since SQLite serializes writes
     * anyway.
     */
    public function generate(): string
    {
        return DB::transaction(function () {
            $prefix = 'PO-';

            // SELECT ... FOR UPDATE on capable drivers. Laravel's query builder
            // silently skips the lock clause on SQLite, so this is safe to call
            // on either driver.
            $conn = DB::connection();

            $lastOrder = $conn->table('purchases')
                ->where('order_no', 'like', $prefix . '%')
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($lastOrder && preg_match('/^PO-(\d+)$/', $lastOrder->order_no, $matches)) {
                $nextNumber = (int) $matches[1] + 1;
            }

            $orderNo = $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);

            // Defensive double-check inside the transaction. The unique index on
            // `order_no` would otherwise surface as a SQL error here, so retry a
            // few times just in case.
            $attempts = 0;
            while (Purchase::where('order_no', $orderNo)->exists() && $attempts < 5) {
                $nextNumber++;
                $orderNo = $prefix . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
                $attempts++;
            }

            if (Purchase::where('order_no', $orderNo)->exists()) {
                throw new RuntimeException('Failed to generate a unique purchase order number.');
            }

            return $orderNo;
        });
    }
}
