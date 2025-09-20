<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // VIEW (semua data, karena tidak ada soft delete)
        DB::unprepared('DROP VIEW IF EXISTS vw_active_products;');
        DB::unprepared(<<<SQL
CREATE VIEW vw_active_products AS
SELECT product_id, product_code, product_name, price, stock_quantity, is_active, created_at, updated_at
FROM master_products;
SQL);

        // SP: CREATE
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_create_product;');
        DB::unprepared(<<<SQL
CREATE PROCEDURE sp_create_product(
    IN p_code VARCHAR(20),
    IN p_name VARCHAR(200),
    IN p_price DECIMAL(15,2),
    IN p_qty INT,
    IN p_active TINYINT(1)
)
BEGIN
    INSERT INTO master_products (product_code, product_name, price, stock_quantity, is_active)
    VALUES (p_code, p_name, p_price, p_qty, p_active);
END;
SQL);

        // SP: UPDATE
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_update_product;');
        DB::unprepared(<<<SQL
CREATE PROCEDURE sp_update_product(
    IN p_id INT,
    IN p_code VARCHAR(20),
    IN p_name VARCHAR(200),
    IN p_price DECIMAL(15,2),
    IN p_qty INT,
    IN p_active TINYINT(1)
)
BEGIN
    UPDATE master_products
    SET product_code = p_code,
        product_name = p_name,
        price = p_price,
        stock_quantity = p_qty,
        is_active = p_active
    WHERE product_id = p_id;
END;
SQL);

        // SP: HARD DELETE (sesuai tabel tanpa deleted_at)
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_product;');
        DB::unprepared(<<<SQL
CREATE PROCEDURE sp_delete_product(IN p_id INT)
BEGIN
    DELETE FROM master_products
    WHERE product_id = p_id;
END;
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP VIEW IF EXISTS vw_active_products;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_create_product;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_update_product;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_product;');
    }
};
