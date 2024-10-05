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
        Schema::create('product_outgoings', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name');
            $table->string('marketplace');
            $table->integer('stock_out')->default(0);
            $table->integer('purchase_price');
            $table->integer('selling_price');
            $table->integer('total_price');
            $table->integer('profit');
            $table->dateTime('datetime_transaction');
            $table->unsignedBigInteger('product_id');
            // $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_outgoings');
    }
};
