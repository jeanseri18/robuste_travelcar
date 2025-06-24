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
        Schema::create('lieux', function (Blueprint $table) {
            $table->id();
            $table->string('pays')->nullable();
            $table->string('ville');
            $table->string('commune')->nullable();
            $table->string('region')->nullable();
            $table->string('departement')->nullable();
            $table->string('sous_prefecture')->nullable();
            $table->enum('type', ['depart', 'arrive', 'les_deux']);
            $table->enum('typedestination', ['national', 'sousregion']);
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
            
            // Index pour optimiser les performances des requêtes
            $table->index(['typedestination', 'type', 'est_actif'], 'idx_lieux_type_destination_actif');
            $table->index(['type', 'est_actif'], 'idx_lieux_type_actif');
            $table->index(['typedestination', 'est_actif'], 'idx_lieux_destination_actif');
            $table->index('ville', 'idx_lieux_ville');
            $table->index('est_actif', 'idx_lieux_actif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lieux');
    }
};