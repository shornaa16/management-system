# Supplier, Product & Purchase Management System

A complete production-ready Laravel web application for managing suppliers, products, and purchase orders. Built with Laravel 13, PHP 8.4, MySQL, Bootstrap 5, DataTables, and Laravel Blade.

## Features

### 1. Authentication
- Secure login with email + password
- "Remember me" functionality
- "Forgot your password?" link
- Session-based authentication with proper logout
- Auth middleware protects all admin pages

### 2. Supplier Management
- Full CRUD (Create / Read / Update / Delete) operations
- Fields: name, mobile_no, email, address, status (Active/Inactive)
- Soft deletes — deleted records are retained in the database
- Prevents deletion of suppliers that have related purchase orders
- Searchable, sortable, paginated DataTable with:
  - Copy, CSV export, Excel export, Print, Column visibility
  - Page length selector (10/25/50/100/All)
  - Server-side validation with preserved old input

### 3. Product Management
- Full CRUD operations
- Fields: name, status (Active/Inactive)
- Prevents duplicate product names
- Prevents deletion of products referenced by purchase items
- DataTable with all export features

### 4. Purchase Management
- Two-column create page:
  - **Left:** Product Information (searchable dropdown, quantity, unit price, add button)
  - **Right:** Other Information (date picker, supplier dropdown, notes, payment, status)
- Dynamic JavaScript calculation of line totals, total quantity, total amount
- Multiple products per purchase order
- Auto-generated order numbers: PO-0001, PO-0002, ... (database-safe, no duplicates)
- Database transaction wraps purchase + items creation
- Validation: supplier required, date required, at least one product required, quantity > 0, unit price >= 0

### 5. Purchase Order List
- Filterable by supplier, start date, end date, search term
- Sortable columns with DataTables
- Totals footer showing total amount, paid, due across all orders
- Export (CSV/Excel/Print/Copy) and column visibility

### 6. Purchase Order Details
- Professional invoice-style details page
- Item table with columns: S/L, Brand, Category, Product, Code, Unit, Purchase Unit Price, Quantity, Total Price
- Shows: Total, Payment, Due
- Shows: Warehouse, Created By, Checked By
- Print button opens a print-friendly view that auto-opens the browser print dialog

### 7. Print View
- Standalone print-friendly page with proper print CSS
- Auto-opens browser print dialog on page load
- Hides navigation, buttons, and unnecessary UI elements when printing
- Looks like an official purchase invoice/order

## Tech Stack

- **Backend:** Laravel 13.x, PHP 8.4+
- **Database:** MySQL (default) — also supports SQLite for local testing
- **Frontend:** Blade templates, Bootstrap 5.3, Bootstrap Icons, DataTables 2.x
- **Asset bundling:** Vite 8.x
- **Authentication:** Laravel's built-in auth with custom views

## Installation

### Prerequisites

- PHP 8.2+ (8.4 recommended)
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8+ (or use SQLite for quick testing)

### Steps

```bash
# 1. Clone / copy the project and enter its directory
cd supplier-purchase-app

# 2. Install PHP dependencies
composer install

# 3. Install frontend dependencies
npm install

# 4. Copy environment file and configure database
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env
#    Option A — MySQL (recommended, per project requirements):
#       DB_CONNECTION=mysql
#       DB_HOST=127.0.0.1
#       DB_PORT=3306
#       DB_DATABASE=supplier_purchase_management
#       DB_USERNAME=root
#       DB_PASSWORD=
#    (Create the database first: mysql -u root -p -e "CREATE DATABASE supplier_purchase_management;")
#
#    Option B — SQLite (for quick local testing without MySQL):
#       DB_CONNECTION=sqlite
#       DB_DATABASE=/absolute/path/to/database/database.sqlite
#       (The SQLite file will be created automatically on first migrate)

# 6. Build frontend assets
npm run build

# 7. Run migrations + seeders (creates tables, admin user, and sample data)
php artisan migrate --seed

# 8. Start the development server
php artisan serve
```

Then visit http://localhost:8000/login in your browser.

## Demo Credentials

After running the seeders:

- **Email:** `admin@example.com`
- **Password:** `password`

## Sample Data

The seeders create:

- **1 admin user** (admin@example.com)
- **5 suppliers:** ABC Supplier, XYZ Trading Co., Global Textiles Ltd., City Hardware Store, Pacific Importers
- **10 products:** Button, Zipper, Cotton Yarn, Polyester Thread, Sewing Needle, Fabric Roll, Elastic Band, Snap Button, Velcro Tape, Packing Box
- **4 purchase orders** with multiple line items each (PO-0001 through PO-0004)

## Database Schema

### `suppliers`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| name | string | Required |
| mobile_no | string | Required |
| email | string | Nullable, validated as email |
| address | text | Nullable |
| status | enum | Active / Inactive |
| deleted_at | timestamp | Soft delete |
| created_at, updated_at | timestamps | |

### `products`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| name | string | Required, unique |
| status | enum | Active / Inactive |
| deleted_at | timestamp | Soft delete |
| created_at, updated_at | timestamps | |

### `purchases`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| order_no | string | Unique, format PO-XXXX |
| supplier_id | foreign key | → suppliers.id |
| purchase_date | date | Required |
| notes | text | Nullable |
| subtotal | decimal(14,2) | Sum of all items |
| paid | decimal(14,2) | Amount paid |
| due | decimal(14,2) | Subtotal − paid |
| status | enum | Pending / Received / Cancelled |
| created_by | foreign key | → users.id |
| created_at, updated_at | timestamps | |

### `purchase_items`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| purchase_id | foreign key | → purchases.id (cascade delete) |
| product_id | foreign key | → products.id (restrict delete) |
| quantity | decimal(14,3) | > 0 |
| unit_price | decimal(14,2) | >= 0 |
| total_price | decimal(14,2) | quantity × unit_price |
| created_at, updated_at | timestamps | |

## Eloquent Relationships

- `Supplier` hasMany `Purchase`
- `Purchase` belongsTo `Supplier`, belongsTo `User` (creator), hasMany `PurchaseItem`
- `PurchaseItem` belongsTo `Purchase`, belongsTo `Product`
- `Product` hasMany `PurchaseItem`
- `User` hasMany `Purchase`

## Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | /login | login | Show login form |
| POST | /login | login.attempt | Authenticate user |
| POST | /logout | logout | Log out user |
| GET | /dashboard | dashboard | Admin dashboard |
| GET | /suppliers | suppliers.index | Supplier list |
| GET | /suppliers/create | suppliers.create | Create supplier form |
| POST | /suppliers | suppliers.store | Save new supplier |
| GET | /suppliers/{supplier}/edit | suppliers.edit | Edit supplier form |
| PUT/PATCH | /suppliers/{supplier} | suppliers.update | Update supplier |
| DELETE | /suppliers/{supplier} | suppliers.destroy | Soft-delete supplier |
| GET | /products | products.index | Product list |
| GET | /products/create | products.create | Create product form |
| POST | /products | products.store | Save new product |
| GET | /products/{product}/edit | products.edit | Edit product form |
| PUT/PATCH | /products/{product} | products.update | Update product |
| DELETE | /products/{product} | products.destroy | Soft-delete product |
| GET | /purchases | purchases.index | Purchase order list |
| GET | /purchases/create | purchases.create | Create purchase form |
| POST | /purchases | purchases.store | Save new purchase order |
| GET | /purchases/{purchase} | purchases.show | Purchase order details |
| GET | /purchases/{purchase}/print | purchases.print | Printable purchase order |
| DELETE | /purchases/{purchase} | purchases.destroy | Delete purchase + items |

## Architecture & Code Quality

The application follows Laravel best practices:

- **MVC architecture** — Controllers handle HTTP, Models represent data, Blade renders views
- **Form Requests** — Separate validation classes: `StoreSupplierRequest`, `UpdateSupplierRequest`, `StoreProductRequest`, `UpdateProductRequest`, `StorePurchaseRequest`
- **Service classes** — `PurchaseOrderNumberGenerator` encapsulates the order-number generation logic with a database transaction + row lock for concurrency safety
- **Eloquent relationships** — Properly defined for all models
- **Database transactions** — Purchase creation is wrapped in `DB::transaction()` so items + purchase are atomic
- **Soft deletes** — Used for suppliers and products to preserve history; purchase deletion cascades to items
- **Mass-assignment protection** — `$fillable` arrays on every model
- **CSRF protection** — `@csrf` in every form
- **XSS-safe output** — Blade's `{{ }}` escapes output by default
- **SQL injection protection** — Eloquent + query builder use parameterized queries
- **Friendly error pages** — Custom 404, 403, 500, and database error pages
- **Reusable layout** — `layouts/app.blade.php` with sidebar + topbar partials
- **Toast notifications** — Success/error flash messages via Bootstrap alerts
- **Confirmation dialogs** — Delete buttons use `confirm()` before submission

## Security

- Passwords hashed with Laravel's bcrypt hasher (configurable rounds)
- CSRF tokens on every state-changing form
- Auth middleware on all admin routes
- Session regeneration on login / logout
- SQL injection protected via Eloquent ORM parameterized queries
- XSS protected via Blade's auto-escaping
- Mass-assignment protected via `$fillable`
- Raw database exceptions are never exposed to end users (custom error page in production)
- Foreign key constraints prevent orphaned purchase items

## Testing the App

After setup, you can verify everything works by walking through this checklist:

1. Visit `/login` — should see the login page with the company logo
2. Log in with `admin@example.com` / `password` — should redirect to dashboard
3. Dashboard shows stat cards (suppliers, products, purchase orders, total)
4. Suppliers page — DataTable loads with 5 sample suppliers
5. Click "Create Supplier" — fill form, save — should redirect back to list
6. Click "Edit" on a supplier — form should be pre-filled
7. Click "Delete" on a supplier without purchases — confirmation dialog, then soft-deletes
8. Try to delete a supplier with purchases — should show an error message
9. Products page — DataTable loads with 10 sample products
10. Create a new product — should appear in list
11. Try to create a duplicate product — should show validation error
12. Purchases page — DataTable loads with 4 sample purchase orders, totals at bottom
13. Filter by supplier or date range — list should update
14. Click "Create Purchase" — two-column layout with product section + other info
15. Select a product, enter quantity + unit price, click "Add" — row appears in items table
16. Add multiple products — totals update dynamically
17. Submit the form — should redirect to the new purchase order details page
18. Verify the order number is the next sequential PO-XXXX
19. Click "Print" — opens print-friendly page that auto-opens the print dialog
20. Click "Logout" — should redirect to login page; dashboard becomes inaccessible

## Project Structure

```
supplier-purchase-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SupplierController.php
│   │   │   ├── ProductController.php
│   │   │   └── PurchaseController.php
│   │   └── Requests/
│   │       ├── Supplier/{StoreSupplierRequest, UpdateSupplierRequest}.php
│   │       ├── Product/{StoreProductRequest, UpdateProductRequest}.php
│   │       └── Purchase/StorePurchaseRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Supplier.php
│   │   ├── Product.php
│   │   ├── Purchase.php
│   │   └── PurchaseItem.php
│   └── Services/
│       └── PurchaseOrderNumberGenerator.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_01_01_000001_create_suppliers_table.php
│   │   ├── 2025_01_01_000002_create_products_table.php
│   │   ├── 2025_01_01_000003_create_purchases_table.php
│   │   └── 2025_01_01_000004_create_purchase_items_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── AdminUserSeeder.php
│       ├── SupplierSeeder.php
│       ├── ProductSeeder.php
│       └── PurchaseSeeder.php
├── resources/
│   ├── views/
│   │   ├── auth/login.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── layouts/{app, print}.blade.php
│   │   ├── partials/{sidebar, topbar, toasts}.blade.php
│   │   ├── suppliers/{index, create, edit}.blade.php
│   │   ├── products/{index, create, edit}.blade.php
│   │   ├── purchases/{index, create, show, print}.blade.php
│   │   └── errors/{404, 403, 500, db}.blade.php
│   ├── css/app.css
│   └── js/app.js
├── routes/web.php
└── bootstrap/app.php
```

## Color Scheme

The application uses a purple/white color scheme:
- Primary: `#6c5ce7` (purple)
- Primary dark: `#5b4bc4`
- Sidebar: gradient from `#2d2b55` to `#1f1d3d`
- Background: `#f4f3ff` (very light purple tint)

## Troubleshooting

**Database connection error:**
- Verify DB credentials in `.env`
- For MySQL: ensure the database exists and the user has privileges
- For SQLite: ensure the path in `DB_DATABASE` is absolute and the directory is writable

**Assets not loading (404 on /build/*):**
- Run `npm run build` to compile the assets
- Check that `public/build/manifest.json` exists

**CSRF token mismatch on form submission:**
- Clear browser cookies and try again
- Verify `APP_KEY` is set in `.env` (run `php artisan key:generate`)

**`php artisan serve` child process can't load shared libraries:**
- This happens when PHP was installed via custom paths. Set `LD_LIBRARY_PATH` before running artisan serve.
- Or use `php -S 0.0.0.0:8000 -t public server.php` directly.

## License

This project is provided as-is for educational/demonstration purposes.
