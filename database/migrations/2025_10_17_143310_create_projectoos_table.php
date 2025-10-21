<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projectoos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipografia')->nullable();
            $table->string('area')->nullable();
            $table->string('nome_cliente');
            $table->string('cor')->nullable();
            $table->json('imagens')->nullable();
            $table->foreignId('categoria_id')->constrained('fontes')->onDelete('cascade');
            $table->foreignId('localizacao_id')->constrained('gestaos')->onDelete('cascade');
            $table->foreignId('ano_id')->constrained('gerencias')->onDelete('cascade');
            $table->enum('estado', ['CONCLUIDO', 'EM_CURSO'])->default('CONCLUIDO');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projectoos');
    }
};