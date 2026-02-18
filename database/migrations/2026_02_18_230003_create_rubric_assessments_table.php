<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubric_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rubric_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rubric_level_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('cycle');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['student_id', 'school_class_id', 'rubric_id', 'cycle'],
                'rubric_assessments_student_class_rubric_cycle_unique'
            );
        });

        Schema::table('rubric_assessments', function (Blueprint $table) {
            $table->index('student_id');
            $table->index('school_class_id');
            $table->index(['school_class_id', 'cycle']);
            $table->index('rubric_id');
            $table->index('rubric_level_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubric_assessments');
    }
};
