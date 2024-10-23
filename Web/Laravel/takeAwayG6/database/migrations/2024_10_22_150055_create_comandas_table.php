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
        Schema::create('comandas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idComandaArt');
            $table->enum('estat', ['Preparando', 'En Almacen', 'En Reparto', 'Finalizado']);
            $table->double('total');
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idComandaArt')->references('id')->on('comanda_articulos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comandas');
    }
};
