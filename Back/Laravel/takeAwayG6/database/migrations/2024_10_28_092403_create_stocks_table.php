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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->integer('Nstock');
            $table->enum('Color',['Rojo','Azul','Verde','Negro','Blanco','Naranja','Rosa','Gris','Violeta','Amarillo','Beige'])->nullable();
            $table->enum('TallaCamisa',['XS','S','M','L','XL'])->nullable();
            $table->enum('TallaZapato',['37','38','39','40','41','42','43','44'])->nullable();
            $table->foreign('idProducto')->references('id')->on('productos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
