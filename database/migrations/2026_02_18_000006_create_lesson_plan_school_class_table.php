<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_plan_school_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->timestamp('applied_at')->nullable();
            $table->string('status', 30)->default('applied');
            $table->text('additional_notes')->nullable();
            $table->timestamps();

            $table->unique(['lesson_plan_id', 'school_class_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_plan_school_class');
    }
};
