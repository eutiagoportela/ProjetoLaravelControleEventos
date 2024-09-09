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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 50)->required()->unique();
            $table->integer('idade')->required();
            $table->string('cpf', 11)->required();
            $table->string('localnascimento', 80)->required();
            $table->string('endereco', 150)->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('email', 150)->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas');
    }
};
