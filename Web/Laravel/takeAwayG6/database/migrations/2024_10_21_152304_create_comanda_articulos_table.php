<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComandaArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comanda_articulos');
    }
}
