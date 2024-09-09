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
        Schema::create('pessoas_eventos', function (Blueprint $table) {
            $table->primary(['pessoa_id', 'evento_id']);
            $table->unsignedBigInteger('pessoa_id');
            $table->unsignedBigInteger('evento_id');
            $table->timestamps();
    
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('restrict');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('restrict');
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas_eventos');
    }
};
