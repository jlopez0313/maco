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
        Schema::create('autorizaciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->unsignedBigInteger('empresas_id');
            $table->foreign('empresas_id')->references('id')->on('empresas');

            $table->string('autorizacion');
            $table->string('prefijo');
            $table->integer('consecutivo_inicial');
            $table->integer('consecutivo_final');
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->char('estado');
            $table->unique(['autorizacion']);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autorizaciones');
    }
};
