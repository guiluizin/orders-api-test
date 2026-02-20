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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->unsignedInteger('number')->unique();
            $table->unsignedInteger('total_paid');
            $table->unsignedTinyInteger('payment_status');
            $table->string('payment_brand', 20);
            $table->string('fulfillment_status', 20);
            $table->string('address_street');
            $table->char('address_zip', 5);
            $table->string('address_province');
            $table->string('address_country');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
