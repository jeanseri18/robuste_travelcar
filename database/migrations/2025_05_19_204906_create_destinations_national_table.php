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
        Schema::create('destinations_national', function (Blueprint $table) {
            $table->id();
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->foreignId('gare_depart')->references('id')->on('gares')->onDelete('cascade');
            $table->foreignId('depart')->references('id')->on('lieux')->onDelete('cascade');
            $table->foreignId('arrive')->references('id')->on('lieux')->onDelete('cascade');
            $table->decimal('tarif_unitaire', 10, 2);
            $table->time('premier_depart');
            $table->time('dernier_depart');
            $table->integer('capacite_bus')->nullable();
            $table->integer('frequence_departs')->nullable()->comment('Fréquence en minutes');
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations_national');
    }
};