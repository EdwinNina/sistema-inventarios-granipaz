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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('tipo', 5)->default('VENTA');
            $table->string('tipo_comprobante', 7)->default('Factura');
            $table->string('nro_comprobante', 30)->nullable();
            $table->decimal('cantidad')->default(0);
            $table->decimal('total')->default(0);
            $table->date('fecha');
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('personas');
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('ventas');
    }
};
