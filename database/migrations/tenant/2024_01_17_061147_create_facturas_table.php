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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
            
            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('medio_pago_id');
            $table->foreign('medio_pago_id')->references('id')->on('medios_pagos');

            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('formas_pagos');

            $table->bigInteger('valor');
            
            $table->char('estado', 1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
