<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('desc');
            $table->integer('stock');
            $table->float('preu');
            $table->string('img');
            $table->enum('talla', ['XS', 'S', 'M', 'L', 'XL', 'XXL']);
            $table->enum('color', ['Negro', 'Amarillo', 'Rosa', 'Morado', 'Azul', 'Verde', 'Naranja', 'Blanco']);
            $table->unsignedBigInteger('idCategory');
            $table->foreign('idCategory')->references('id')->on('categorias');
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
        Schema::dropIfExists('productos');
    }
}
