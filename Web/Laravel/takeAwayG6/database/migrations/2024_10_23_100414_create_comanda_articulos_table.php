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
        Schema::create('comanda_articulos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->unsignedBigInteger('idComanda');
            $table->string('talla');
            $table->string('color');
            $table->integer('quantitat');
            $table->float('preu');
            $table->foreign('idProducto')->references('id')->on('productos');
            $table->foreign('idComanda')->references('id')->on('comandas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comanda_articulos');
    }
};
