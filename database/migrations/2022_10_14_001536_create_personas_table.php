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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('paterno', 50);
            $table->string('materno', 50)->nullable();
            $table->enum('tipo_documento', ['NIT', 'CI', 'PASAPORTE', 'RUA']);
            $table->string('nro_documento', 15)->unique();
            $table->string('complemento', 10)->nullable();
            $table->string('empresa', 150);
            $table->string('email', 60);
            $table->string('celular', 8);
            $table->enum('tipo_persona', ['CLIENTE', 'PROVEEDOR']);
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('personas');
    }
};
