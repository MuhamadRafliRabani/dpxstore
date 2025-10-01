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
        // Table tr_orders
        Schema::create('tr_orders', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PK
            $table->string('order_code', 100)->unique(); // ganti nama biar jelas, FK jangan pakai varchar
            $table->bigInteger('price');
            $table->enum('status', ['Pending', 'Processing', 'Success', 'Canceled'])->default('Pending');
            $table->longText('ket')->nullable();
            $table->dateTime('start_process')->nullable();
            $table->dateTime('end_process')->nullable();
            $table->boolean('isvoucher')->default(false);
            $table->string('creby', 20)->nullable();
            $table->dateTime('cretime')->nullable();
            $table->string('modby', 20)->nullable();
            $table->dateTime('modtime')->nullable();
        });

        // Table tr_order_dt
        Schema::create('tr_order_dt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('tr_orders')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('ms_categories');
            $table->foreignId('product_id')->constrained('ms_product_dt');
            $table->string('user_id')->nullable();
            $table->string('zone_id')->nullable();
            $table->string('username')->nullable();
            $table->string('no_handphone')->nullable();
            $table->string('no_akun')->nullable();
            $table->string('kode_voucher')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('creby')->nullable();
            $table->timestamp('cretime')->nullable();
            $table->string('modby')->nullable();
            $table->timestamp('modtime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
