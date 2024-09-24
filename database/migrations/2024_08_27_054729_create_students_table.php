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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id');
            $table->integer('program_id');
            $table->integer('batch_id');
            $table->string('client_code');
            $table->unsignedBigInteger('student_roll_no');
            $table->string('student_name');
            $table->string('email')->unique()->nullable();
            $table->string('student_city')->nullable();
            $table->text('student_address')->nullable();
            $table->string('student_pincode')->nullable();
            $table->string('exam_cycle');
            $table->date('student_passing_year');
            $table->enum('student_exam_status', ['passed', 'failed', 'pending'])->default('pending');
            $table->string('created_by')->comment('User logged in ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
