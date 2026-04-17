<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_subject', function (Blueprint $table) {
            $table->foreignId('student_id')
                  ->constrained('students', 'student_id')
                  ->cascadeOnDelete();
            $table->foreignId('subject_id')
                  ->constrained('subjects', 'subject_id')
                  ->cascadeOnDelete();
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamp('registered_at')->useCurrent();

            $table->primary(['student_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_subject');
    }
};
