import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-icons/font/bootstrap-icons.css';

// DataTables + Buttons (Excel/CSV/Print)
import DataTable from 'datatables.net-bs5';
import ButtonsHtmlData from 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-buttons/js/buttons.colVis.mjs';

// Make DataTables + JSZip available globally so existing pages can use `window.DataTable`
import JSZip from 'jszip';
window.JSZip = JSZip;
window.DataTable = DataTable;

// Reusable DataTable helper. Same options applied everywhere for consistency.
window.initDataTable = function (selector, options = {}) {
    const defaults = {
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        order: [[0, 'asc']],
        autoWidth: false,
        responsive: true,
        dom: '<"row align-items-center mb-3"<"col-md-6"B><"col-md-6 text-md-end"lf>>' +
             'rtip' +
             '<"row mt-3"<"col-md-5"i><"col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                text: '<i class="bi bi-clipboard"></i> Copy',
                className: 'btn btn-sm btn-outline-secondary',
                exportOptions: { columns: ':visible:not(.action-col)' }
            },
            {
                extend: 'csv',
                text: '<i class="bi bi-filetype-csv"></i> CSV',
                className: 'btn btn-sm btn-outline-secondary',
                exportOptions: { columns: ':visible:not(.action-col)' }
            },
            {
                extend: 'excelHtml5',
                text: '<i class="bi bi-filetype-xlsx"></i> Excel',
                className: 'btn btn-sm btn-outline-secondary',
                exportOptions: { columns: ':visible:not(.action-col)' }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-sm btn-outline-secondary',
                exportOptions: { columns: ':visible:not(.action-col)' }
            },
            {
                extend: 'colvis',
                text: '<i class="bi bi-layout-three-columns"></i> Columns',
                className: 'btn btn-sm btn-outline-secondary',
                columns: ':not(.action-col)'
            }
        ],
        language: {
            search: '',
            searchPlaceholder: 'Search...',
            lengthMenu: 'Show _MENU_ entries',
            paginate: {
                previous: '<i class="bi bi-chevron-left"></i>',
                next: '<i class="bi bi-chevron-right"></i>'
            },
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'No records available',
            infoFiltered: '(filtered from _MAX_ total entries)',
            zeroRecords: 'No matching records found'
        }
    };

    const config = Object.assign({}, defaults, options);
    return new DataTable(selector, config);
};

// Bootstrap toast helper - shows a quick success/error message
window.showToast = function (message, type = 'success') {
    const container = document.getElementById('toast-container') || (() => {
        const c = document.createElement('div');
        c.id = 'toast-container';
        c.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(c);
        return c;
    })();

    const bgClass = type === 'success' ? 'text-bg-success'
        : type === 'error' ? 'text-bg-danger'
        : type === 'warning' ? 'text-bg-warning'
        : 'text-bg-primary';

    const icon = type === 'success' ? 'bi-check-circle-fill'
        : type === 'error' ? 'bi-x-circle-fill'
        : type === 'warning' ? 'bi-exclamation-triangle-fill'
        : 'bi-info-circle-fill';

    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center ${bgClass} border-0`;
    toastEl.role = 'alert';
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi ${icon} me-2"></i>${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    container.appendChild(toastEl);
    const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
    toast.show();
    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
};

// Confirmation dialog helper for delete buttons
window.confirmDelete = function (formId, message) {
    if (confirm(message || 'Are you sure you want to delete this record? This action cannot be undone.')) {
        document.getElementById(formId).submit();
    }
    return false;
};

// Initialize sidebar toggle on mobile
document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.querySelector('[data-bs-toggle="sidebar"]');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            const backdrop = document.querySelector('.sidebar-backdrop');
            if (sidebar && backdrop) {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            }
        });
    }

    const backdrop = document.querySelector('.sidebar-backdrop');
    if (backdrop) {
        backdrop.addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
            }
        });
    }

    // Auto-dismiss old validation error list boxes after 6s
    document.querySelectorAll('[data-auto-dismiss]').forEach(function (el) {
        setTimeout(() => {
            const alert = bootstrap.Alert.getOrCreateInstance(el);
            alert.close();
        }, 6000);
    });
});
