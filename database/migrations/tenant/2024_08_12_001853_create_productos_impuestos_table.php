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
        Schema::create('productos_impuestos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('productos_id');
            $table->foreign('productos_id')->references('id')->on('productos');

            $table->unsignedBigInteger('impuestos_id');
            $table->foreign('impuestos_id')->references('id')->on('impuestos');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_impuestos');
    }
};
