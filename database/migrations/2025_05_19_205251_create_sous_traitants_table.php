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
        Schema::create('sous_traitants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['personne_physique', 'personne_morale']);
            $table->string('nom_commercial')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->decimal('capital', 15, 2)->nullable();
            $table->string('rccm')->nullable();
            $table->string('compte_contribuable')->nullable();
            $table->string('adresse_geographique')->nullable();
            $table->string('adresse_postale')->nullable();
            $table->string('telephone_fixe')->nullable();
            $table->string('telephone_mobile')->nullable();
            $table->decimal('taux_commission', 5, 2)->default(1.00);
            $table->string('commune_activite');
            $table->decimal('montant_cautionnement', 10, 2)->nullable();
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sous_traitants');
    }
};