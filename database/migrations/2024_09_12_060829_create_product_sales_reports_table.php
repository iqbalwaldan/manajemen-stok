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
        Schema::create('product_sales_reports', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datetime_report');
            $table->integer('total_stock_out');
            $table->integer('profit');
            $table->integer('ads');
            $table->integer('total_profit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sales_reports');
    }
};
