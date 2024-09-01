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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');

            $table->unsignedBigInteger('inventarios_id');
            $table->foreign('inventarios_id')->references('id')->on('inventarios');            
            
            $table->unsignedBigInteger('unidad_medida_id');
            $table->foreign('unidad_medida_id')->references('id')->on('unidades_medidas');

            $table->unsignedBigInteger('colores_id')->nullable();
            $table->foreign('colores_id')->references('id')->on('colores');
            
            $table->unsignedBigInteger('medidas_id')->nullable();
            $table->foreign('medidas_id')->references('id')->on('medidas');

            $table->string('referencia');
            $table->integer('cantidad');
            $table->integer('precio');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(array('referencia', 'deleted_at'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
