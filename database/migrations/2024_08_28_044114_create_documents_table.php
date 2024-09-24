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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->string('document_type');
            $table->string('document_path')->nullable();
            $table->string('document_name');
            $table->enum('is_document_generated',['yes','no'])->default('no');
            $table->enum('delivery_status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->timestamp('document_generated_at')->nullable();
            $table->timestamp('document_dispatched_at')->nullable();
            $table->timestamp('document_delivered_at')->nullable();
            $table->enum('is_deleted', ['yes','no'])->default('no');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('shipment_id')->references('id')->on('shipments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
