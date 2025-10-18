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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            // Data lokasi dari RajaOngkir
            $table->string('origin_city_id');
            $table->string('origin_city_name');
            $table->string('destination_city_id');
            $table->string('destination_city_name');

            // Integrasi API
            $table->decimal('cost', 12, 2)->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            $table->string('duration')->nullable();

            // Data armada
            $table->string('driver_name')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('contact_number')->nullable();

            // Tracking & Status
            $table->enum('status', ['waiting', 'on_route', 'delivered', 'cancelled'])->default('waiting');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
