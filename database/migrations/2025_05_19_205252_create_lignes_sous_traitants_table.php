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
        Schema::create('lignes_sous_traitants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sous_traitant_id')->constrained()->onDelete('cascade');
            $table->enum('type_destination', ['national', 'sousregion']);
            $table->unsignedBigInteger('destination_id');
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->enum('type_ligne', ['aller_simple', 'retour_simple', 'aller_retour']);
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lignes_sous_traitants');
    }
};