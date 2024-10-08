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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipos_personas');

            $table->unsignedBigInteger('tipo_doc_id');
            $table->foreign('tipo_doc_id')->references('id')->on('tipos_documentos');

            $table->unsignedBigInteger('ciudad_id');
            $table->foreign('ciudad_id')->references('id')->on('ciudades');

            $table->unsignedBigInteger('responsabilidad_fiscal_id');
            $table->foreign('responsabilidad_fiscal_id')->references('id')->on('responsabilidades_fiscales');

            $table->bigInteger('documento');
            $table->integer('dv');
            $table->string('nombre');
            $table->string('comercio');
            $table->bigInteger('matricula');
            $table->string('direccion');
            $table->string('celular');
            $table->string('correo')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
