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
        Schema::create('destinations_sousregion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->foreignId('gare_depart')->references('id')->on('gares')->onDelete('cascade');
            $table->string('pays_destination');
            $table->string('ville_destination');
            $table->string('adresse_destination')->nullable();
            $table->decimal('tarif_unitaire', 10, 2);
            $table->time('premier_depart');
            $table->time('dernier_depart');
            $table->integer('capacite_bus')->nullable();
            $table->integer('duree_trajet')->nullable()->comment('Durée en heures');
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations_sousregion');
    }
};