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
            $table->string('talla');
            $table->string('color');
            $table->unsignedBigInteger('quantitat');
            $table->float('preu');
            $table->foreign('idProducto')->references('id')->on('productos');
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
