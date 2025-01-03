<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();  // Combined short and long descriptions
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('prep_time')->nullable()->comment('Preparation time in minutes');
            $table->string('meta_title', 200)->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('featured')->default(false);
            $table->json('additional_charges')->nullable()->comment('Stores delivery fee, packing charge, etc.');
            $table->json('tax_rules')->nullable()->comment('Stores tax configurations');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
