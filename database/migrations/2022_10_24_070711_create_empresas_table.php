<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('direccion');
            $table->string('nit', 10);
            $table->string('correo', 60);
            $table->string('celular', 10);
            $table->string('paterno', 50);
            $table->string('materno', 50);
            $table->string('nombre', 50);
            $table->string('logotipo', 60);
            $table->integer('stock_minimo');
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
        Schema::dropIfExists('empresas');
    }
};
