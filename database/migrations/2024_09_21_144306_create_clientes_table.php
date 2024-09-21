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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('cliente_id');
            $table->string('cli_cpf')->unique();
            $table->string('cli_nome');
            $table->date('cli_nascimento');
            $table->enum('cli_sexo', ['M', 'F']);
            $table->string('cli_endereco');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('estado_id');
            $table->foreign('cidade_id')->references('cidade_id')->on('cidades')->onDelete('cascade');
            $table->foreign('estado_id')->references('estado_id')->on('estados')->onDelete('cascade');
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
