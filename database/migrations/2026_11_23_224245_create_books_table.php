<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wp_id')->nullable()->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('isbn', 20)->nullable()->index();
            $table->string('sku', 100)->nullable()->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('price_cents');
            $table->unsignedInteger('sale_price_cents')->nullable();
            $table->char('currency', 3)->default('CAD');
            $table->integer('stock')->nullable(); // null = not tracked
            $table->boolean('is_active')->default(true);
            $table->string('publisher')->nullable();
            $table->string('language', 50)->nullable();
            $table->string('format', 50)->nullable();
            $table->unsignedSmallInteger('pages')->nullable();
            $table->unsignedInteger('weight_grams')->nullable();
            $table->unsignedSmallInteger('length_mm')->nullable();
            $table->unsignedSmallInteger('width_mm')->nullable();
            $table->unsignedSmallInteger('height_mm')->nullable();
            $table->date('published_at')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};