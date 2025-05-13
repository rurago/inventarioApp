<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('productos');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::create('productos', function (Blueprint $table) {
            // Define la estructura original aquí (por si necesitas revertir)
        });
    }
};
