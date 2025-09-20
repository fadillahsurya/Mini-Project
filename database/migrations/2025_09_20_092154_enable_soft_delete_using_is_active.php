<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // VIEW: hanya produk aktif (is_active = 1)
        DB::unprepared('DROP VIEW IF EXISTS vw_active_products;');
        DB::unprepared(<<<'SQL'
CREATE VIEW vw_active_products AS
SELECT
    product_id,
    product_code,
    product_name,
    price,
    stock_quantity,
    is_active,
    created_at,
    updated_at
FROM master_products
WHERE is_active = 1
SQL);

        // SP: SOFT DELETE (set is_active = 0)
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_soft_delete_product;');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_soft_delete_product(IN p_id INT)
BEGIN
    UPDATE master_products
    SET is_active = 0,
        updated_at = CURRENT_TIMESTAMP
    WHERE product_id = p_id AND is_active = 1;
END
SQL);

        // (Opsional) SP: RESTORE (balikkan ke aktif)
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_restore_product;');
        DB::unprepared(<<<'SQL'
CREATE PROCEDURE sp_restore_product(IN p_id INT)
BEGIN
    UPDATE master_products
    SET is_active = 1,
        updated_at = CURRENT_TIMESTAMP
    WHERE product_id = p_id AND is_active = 0;
END
SQL);
    }

    public function down(): void
    {
        // Hapus SP soft delete & restore
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_soft_delete_product;');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_restore_product;');

        // Kembalikan VIEW ke semua data (tanpa filter)
        DB::unprepared('DROP VIEW IF EXISTS vw_active_products;');
        DB::unprepared(<<<'SQL'
CREATE VIEW vw_active_products AS
SELECT
    product_id,
    product_code,
    product_name,
    price,
    stock_quantity,
    is_active,
    created_at,
    updated_at
FROM master_products
SQL);
    }
};
