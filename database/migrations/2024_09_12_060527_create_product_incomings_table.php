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
        Schema::create('product_incomings', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_in')->default(0);
            $table->integer('price');
            $table->integer('total_price');
            $table->integer('dp');
            $table->integer('paid_off');
            $table->boolean('payment_status');
            $table->dateTime('datetime_incoming');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_incomings');
    }
};
