<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('key', 32)->unique(); // free, pro, pro_annual
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2)->default(0);
            $table->decimal('price_yearly', 10, 2)->nullable();
            $table->string('interval', 16)->default('month'); // month, year
            $table->json('features')->nullable(); // list of feature strings
            $table->json('limits')->nullable();   // max_schools, max_classes, etc.
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_price_yearly_id')->nullable();
            $table->string('mercadopago_plan_id')->nullable();
            $table->unsignedSmallInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
