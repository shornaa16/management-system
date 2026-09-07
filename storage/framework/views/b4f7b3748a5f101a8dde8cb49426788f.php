<?php $__env->startSection('content'); ?>
<h2 class="page-title">Supplier</h2>

<div class="mb-3">
    <a href="<?php echo e(route('suppliers.create')); ?>" class="btn btn-purple">Create Supplier +</a>
</div>

<div class="card card-custom">
    <table id="supplierTable" class="table table-bordered align-middle w-100">
        <thead class="table-light">
            <tr>
                <th style="width: 50px;">S/L</th>
                <th>Name</th>
                <th>Mobile No.</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th style="width: 90px;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($supplier->name); ?></td>
                <td><?php echo e($supplier->mobile_no); ?></td>
                <td><?php echo e($supplier->email); ?></td>
                <td><?php echo e($supplier->address); ?></td>
                <td>
                    <?php if($supplier->status): ?>
                        <span class="badge-active">Active</span>
                    <?php else: ?>
                        <span class="badge-inactive">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="<?php echo e(route('suppliers.edit', $supplier->id)); ?>" class="action-btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="<?php echo e(route('suppliers.destroy', $supplier->id)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="action-btn-delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td>1</td>
                <td>ABC</td>
                <td>12345678901</td>
                <td></td>
                <td></td>
                <td><span class="badge-active">Active</span></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="action-btn-edit"><i class="fa-solid fa-pen-to-square"></i></button>
                        <button class="action-btn-delete"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('#supplierTable').DataTable({
        dom: '<"d-flex justify-content-between align-items-center mb-3"l<"d-flex gap-2"Bf>>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
        buttons: [
            { extend: 'copy', text: '<i class="fa-regular fa-copy"></i> Copy' },
            { extend: 'csv', text: '<i class="fa-solid fa-file-csv"></i> Export to CSV' },
            { extend: 'excel', text: '<i class="fa-solid fa-file-excel"></i> Export to Excel' },
            { extend: 'print', text: '<i class="fa-solid fa-print"></i> Print' },
            { extend: 'colvis', text: '<i class="fa-regular fa-eye"></i> Column visibility' }
        ],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            paginate: {
                first: "First",
                previous: "Previous",
                next: "Next",
                last: "Last"
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Downloads\supplier-purchase-app\supplier-purchase-app\resources\views/suppliers/index.blade.php ENDPATH**/ ?>