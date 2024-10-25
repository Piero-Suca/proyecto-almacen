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
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->string('persona_dni', 100);
            $table->foreign('persona_dni')
                  ->references('dni')
                  ->on('personas')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('articulo_id');
            $table->foreign('articulo_id')
                  ->references('id')
                  ->on('articulos')
                  ->onDelete('cascade');
            $table->integer('cantidad');
            $table->string('condicion');
            $table->date('fecha_salida');
            $table->date('fecha_retorno')->nullable();
            $table->text('destino');
            $table->boolean('devuelto')->default(false);
            $table->string('estado')->default('pending'); // O cualquier estado por defecto que prefieras
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salidas');
    }
    


};
