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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('tracking_id')->nullable();
            $table->string('shipping_agent')->nullable();
            $table->string('shipping_address')->nullable();
            $table->date('dispatched_at')->nullable();
            $table->float('amount', 8, 2)->nullable();
            $table->enum('delivery_status',['pending', 'shipped', 'delivered'])->default('pending');
            $table->date('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
