<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->string('evaluation_type', 20);
            $table->decimal('score', 5, 2)->nullable();
            $table->unsignedInteger('cycle');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['student_id', 'school_class_id', 'evaluation_type', 'cycle'], 'grades_student_class_type_cycle_unique');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->index('student_id');
            $table->index('school_class_id');
            $table->index(['school_class_id', 'cycle']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
