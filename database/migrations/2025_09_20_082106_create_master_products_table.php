<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_products', function (Blueprint $table) {
            $table->increments('product_id');                   // INT PRIMARY KEY AUTO_INCREMENT
            $table->string('product_code', 20)->unique();       // UNIQUE NOT NULL
            $table->string('product_name', 200);                // NOT NULL
            $table->decimal('price', 15, 2)->default(0);        // NOT NULL DEFAULT 0
            $table->integer('stock_quantity')->default(0);      // DEFAULT 0
            $table->boolean('is_active')->default(true);        // DEFAULT TRUE
            $table->timestamp('created_at')->useCurrent();      // DEFAULT CURRENT_TIMESTAMP
            $table->timestamp('updated_at')                     // DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                  ->useCurrent()
                  ->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_products');
    }
};

