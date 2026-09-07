<?php $__env->startSection('content'); ?>
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Create Product</h3>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card p-4 shadow-sm border-0" style="max-width: 600px;">
        <form action="<?php echo e(route('products.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label font-weight-bold">Product Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required placeholder="e.g. Laptop / Keyboard">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">SKU / Code</label>
                <input type="text" name="sku" class="form-control" placeholder="e.g. PRD-1001">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
            </div>

            <div class="mb-3">
                <label class="form-label font-weight-bold">Initial Stock Quantity <span class="text-danger">*</span></label>
                <input type="number" name="stock_quantity" class="form-control" required value="0">
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #6d28d9; border: none;">Save Product</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\supplier-purchase-app\supplier-purchase-app\resources\views/products/create.blade.php ENDPATH**/ ?>