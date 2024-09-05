<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->unsignedBigInteger('empresas_id')->nullable();
            $table->foreign('empresas_id')->references('id')->on('empresas');

            $table->unsignedBigInteger('clientes_id')->nullable();
            $table->foreign('clientes_id')->references('id')->on('clientes');

            $table->unsignedBigInteger('proveedores_id')->nullable();
            $table->foreign('proveedores_id')->references('id')->on('proveedores');

            $table->string('nombre');
            $table->string('celular');
            $table->string('correo');
            $table->char('principal');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
