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
        Schema::create('product_installments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datetime_payment');
            $table->unsignedBigInteger('product_incoming_id');
            $table->foreign('product_incoming_id')->references('id')->on('product_incomings')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_installments');
    }
};
