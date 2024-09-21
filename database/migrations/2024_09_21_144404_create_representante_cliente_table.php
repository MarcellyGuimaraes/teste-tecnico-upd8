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
        Schema::create('representante_cliente', function (Blueprint $table) {
            $table->unsignedBigInteger('representante_id');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('representante_id')->references('representante_id')->on('representantes')->onDelete('cascade');
            $table->foreign('cliente_id')->references('cliente_id')->on('clientes')->onDelete('cascade');
            $table->primary(['representante_id', 'cliente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representante_cliente');
    }
};
