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
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->unsignedBigInteger('proveedores_id');
            $table->foreign('proveedores_id')->references('id')->on('proveedores');

            $table->unsignedBigInteger('medio_pago_id');
            $table->foreign('medio_pago_id')->references('id')->on('medios_pagos');

            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('formas_pagos');
            
            $table->bigInteger('valor');
            
            $table->char('estado', 1);
            $table->string('prefijo')->nullable();
            $table->integer('folio')->nullable();
            $table->string('transaccionID')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
