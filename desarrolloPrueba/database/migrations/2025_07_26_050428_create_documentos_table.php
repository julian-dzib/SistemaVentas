<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migratio
     */
    public function up(): void
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->increments('IDCODIGO');

            //Establecemos una llave foranea
            $table->unsignedInteger('IDCLIENTE');

            //rzon social y rfc, es posible obtenerlo a partir de la llave foranea, porque no cambia con el paso del tiempo si no se mantiene
            //Solo si, no deseas mantener datos antiguos si no, actualizados
            //$table->string ('RAZON_SOCIAL', 60); -ELIMINADO
            //$table->string('RFC', 15); -ELIMINADO

            //Demas campos
            $table->decimal('SUBTOTAL', 13,3);
            $table->decimal('IVA',13,3);
            $table->decimal('TOTAL',13,3);
            $table->timestamps();

            //Hacemos una referencia al IDCLIENTE de la tabla de clientes
            $table->foreign('IDCLIENTE')->references('IDCLIENTE')->on('clientes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
