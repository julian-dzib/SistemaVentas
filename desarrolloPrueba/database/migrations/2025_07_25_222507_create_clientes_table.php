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
        //Definir la base de datos
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->increments('IDCLIENTE');
            $table->string('RAZON_SOCIAL', 60)->unique();
            $table->string('RFC',15)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
