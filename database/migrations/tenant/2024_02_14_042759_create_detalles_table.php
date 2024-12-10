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
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('facturas_id')->nullable();
            $table->foreign('facturas_id')->references('id')->on('facturas');

            $table->unsignedBigInteger('gastos_id')->nullable();
            $table->foreign('gastos_id')->references('id')->on('gastos');

            $table->unsignedBigInteger('productos_id')->nullable();
            $table->foreign('productos_id')->references('id')->on('productos');

            $table->bigInteger('cantidad');
            $table->bigInteger('precio_venta');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles');
    }
};
