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
        Schema::create('documentos_renglons', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->increments('IDDOCUMENTO');
            
            //Establecemos las llaves foraneas
            //documentos
            $table->unsignedInteger('IDCODIGO');
            //productos
            $table->string('IDMATERIAL');
            

            //Demas campos
            $table->string ('UNIDAD_MEDIDA', 10);
            $table->decimal ('CANTIDAD',13,3);
            $table->decimal ('PRECIO1',13,3);
            
            $table->timestamps();


            //Hacemos una referencia al IDCODIGO de la tabla de documentos
            $table->foreign('IDCODIGO')->references('IDCODIGO')->on('documentos')->onDelete('cascade')->onUpdate('cascade');
            //Hacemos una referencia al IDMATERIAL de la tabla de productos
            $table->foreign('IDMATERIAL')->references('IDMATERIAL')->on('productos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_renglons');
    }
};
