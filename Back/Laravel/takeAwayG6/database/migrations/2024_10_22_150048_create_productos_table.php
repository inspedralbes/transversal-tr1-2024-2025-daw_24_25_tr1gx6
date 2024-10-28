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
            $table->string('nom');
            $table->string('desc');
            $table->float('preu');
            $table->string('img');
            $table->tinyInteger('valoracion');
            $table->unsignedBigInteger('idCategory');
            $table->unsignedBigInteger('idMarca');
            $table->foreign('idCategory')->references('id')->on('categorias');
            $table->foreign('idMarca')->references('id')->on( 'marcas');
            $table->timestamps();
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
