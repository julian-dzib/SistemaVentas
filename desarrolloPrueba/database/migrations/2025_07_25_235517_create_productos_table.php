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
        Schema::create('productos', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->string('IDMATERIAL',20)->primary();
            $table->string('DESCRIPCION', 60);
            $table->string('UNIDADMEDIDA', 10);
            //Definir el campo como decimal, para tener una precision
            $table->decimal('PRECIO1', 13, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
