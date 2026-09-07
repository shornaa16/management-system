<?php $__env->startSection('title', 'Dashboard - ' . config('app.name')); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Suppliers</div>
                    <div class="stat-value"><?php echo e($supplierCount); ?></div>
                </div>
                <i class="bi bi-people-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Products</div>
                    <div class="stat-value"><?php echo e($productCount); ?></div>
                </div>
                <i class="bi bi-box-seam-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Purchase Orders</div>
                    <div class="stat-value"><?php echo e($purchaseCount); ?></div>
                </div>
                <i class="bi bi-cart-check-fill text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-label">Total Purchases</div>
                    <div class="stat-value">৳<?php echo e(number_format($totalPurchaseAmount, 2)); ?></div>
                </div>
                <i class="bi bi-cash-stack text-brand" style="font-size:2.4rem;opacity:.35;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up-arrow me-1"></i> Payment Summary</span>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Paid</span>
                    <span class="fw-semibold text-success">৳<?php echo e(number_format($totalPaid, 2)); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">Total Due</span>
                    <span class="fw-semibold text-danger">৳<?php echo e(number_format($totalDue, 2)); ?></span>
                </div>
                <div class="d-flex justify-content-between border-top pt-2 mt-2">
                    <span class="text-muted small">Total Purchase Value</span>
                    <span class="fw-bold text-brand">৳<?php echo e(number_format($totalPurchaseAmount, 2)); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-1"></i> Recent Purchase Orders</span>
                <a href="<?php echo e(route('purchases.index')); ?>" class="btn btn-sm btn-outline-brand">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="bg-brand-light">
                        <tr>
                            <th class="ps-3">Order #</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th class="text-end pe-3">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentPurchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="ps-3 fw-semibold text-brand">
                                    <a href="<?php echo e(route('purchases.show', $purchase)); ?>" class="text-decoration-none"><?php echo e($purchase->order_no); ?></a>
                                </td>
                                <td><?php echo e($purchase->supplier->name ?? '—'); ?></td>
                                <td><?php echo e($purchase->purchase_date->format('d M, Y')); ?></td>
                                <td class="text-end pe-3">৳<?php echo e(number_format($purchase->subtotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No purchases yet</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="<?php echo e(route('suppliers.create')); ?>" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-person-plus-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Add New Supplier</div>
                <small class="text-muted">Register a new supplier</small>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="<?php echo e(route('products.create')); ?>" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-plus-square-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Add New Product</div>
                <small class="text-muted">Create a product entry</small>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-decoration-none text-reset h-100">
            <a href="<?php echo e(route('purchases.create')); ?>" class="text-decoration-none text-reset d-block p-3 text-center">
                <i class="bi bi-bag-plus-fill text-brand" style="font-size:2rem;"></i>
                <div class="fw-semibold mt-2">Create Purchase Order</div>
                <small class="text-muted">Issue a new purchase order</small>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\supplier-purchase-app\supplier-purchase-app\resources\views/dashboard.blade.php ENDPATH**/ ?>