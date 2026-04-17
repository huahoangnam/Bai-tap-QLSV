<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('full_name', 100);
            $table->date('date_of_birth')->nullable();
            $table->string('email', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('class_id')
                  ->constrained('classrooms', 'class_id')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
