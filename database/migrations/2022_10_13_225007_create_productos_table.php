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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 100);
            $table->decimal('stock')->default(0);
            $table->decimal('precio_unitario', 8, 2);
            $table->boolean('estado')->default(true);
            $table->foreignId('sub_categoria_id')->constrained();
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
};
