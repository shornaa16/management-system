@extends('layouts.app')

@section('content')
<h2 class="page-title">Supplier</h2>

<div class="mb-3">
    <a href="{{ route('suppliers.create') }}" class="btn btn-purple">Create Supplier +</a>
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
            @forelse($suppliers as $key => $supplier)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->mobile_no }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->address }}</td>
                <td>
                    @if($supplier->status)
                        <span class="badge-active">Active</span>
                    @else
                        <span class="badge-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="action-btn-edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn-delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
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
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
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
@endpush
@endsection