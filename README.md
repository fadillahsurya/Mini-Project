Mini Project – Laravel CRUD: Master Product

A simple, professional CRUD app for Master Product built with Laravel.
It fulfills these requirements:

Must use Stored Procedures & a Database View

Delete = Soft Delete (uses is_active, not deleted_at)

Responsive UI (Bootstrap 5 + Tailwind CSS v4 via Vite)

Product Code Auto-Generation (PRD-YYYYMMDD-0001, increments per day)

Runs with one terminal (php artisan serve) after a one-time asset build

✨ Features

Create / Read / Update / Delete products

Soft Delete via is_active = 0 (record remains in DB)

View vw_active_products shows only is_active = 1

Stored Procedures (MySQL/MariaDB):

sp_create_product(code, name, price, qty, is_active)

sp_update_product(id, code, name, price, qty, is_active)

sp_soft_delete_product(id) → sets is_active = 0

sp_restore_product(id) → sets is_active = 1 (optional)

Search (by code/name), Bootstrap pagination, flash messages

Auto Product Code on create (readonly in form; server enforces uniqueness)

🧱 Table Schema

Table: master_products

product_id (INT, PK, AUTO_INCREMENT)

product_code (VARCHAR(20), UNIQUE)

product_name (VARCHAR(200))

price (DECIMAL(15,2), default 0)

stock_quantity (INT, default 0)

is_active (TINYINT(1)/BOOLEAN, default 1)

created_at (timestamp, DEFAULT CURRENT_TIMESTAMP)

updated_at (timestamp, DEFAULT CURRENT_TIMESTAMP ON UPDATE)

No deleted_at. Soft delete uses is_active.

🧠 Data Architecture: View & Stored Procedures

View vw_active_products: lists only active products (is_active = 1).

Stored Procedures (MySQL/MariaDB):

sp_create_product

sp_update_product

sp_soft_delete_product

sp_restore_product (optional)

🧰 Tech Stack

Laravel (Vite)

MySQL/MariaDB (required for SP & View)

Bootstrap 5 + Tailwind CSS v4

Blade templates & components

Bootstrap 5 pagination
