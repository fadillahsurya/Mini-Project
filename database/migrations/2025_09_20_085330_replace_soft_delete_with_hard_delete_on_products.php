<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // buang SP lama (soft delete) jika ada
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_soft_delete_product');

        // buat SP baru (HARD DELETE)
        DB::unprepared(<<<SQL
DROP PROCEDURE IF EXISTS sp_delete_product;
CREATE PROCEDURE sp_delete_product(IN p_id INT)
BEGIN
    DELETE FROM master_products
    WHERE product_id = p_id;
END
SQL);
    }

    public function down(): void
    {
        // balik lagi ke soft delete kalau di-rollback
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_product');

        DB::unprepared(<<<SQL
DROP PROCEDURE IF EXISTS sp_soft_delete_product;
CREATE PROCEDURE sp_soft_delete_product(IN p_id INT)
BEGIN
    UPDATE master_products
    SET deleted_at = NOW()
    WHERE product_id = p_id AND deleted_at IS NULL;
END
SQL);
    }
};
