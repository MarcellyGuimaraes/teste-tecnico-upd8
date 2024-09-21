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
        Schema::create('representante_cidade', function (Blueprint $table) {
            $table->unsignedBigInteger('representante_id');
            $table->unsignedBigInteger('cidade_id');
            $table->foreign('representante_id')->references('representante_id')->on('representantes')->onDelete('cascade');
            $table->foreign('cidade_id')->references('cidade_id')->on('cidades')->onDelete('cascade');
            $table->primary(['representante_id', 'cidade_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representante_cidade');
    }
};
