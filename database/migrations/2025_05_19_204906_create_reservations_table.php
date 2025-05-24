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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type_destination', ['national', 'sousregion']);
            $table->unsignedBigInteger('destination_id');
            $table->foreignId('societe_id')->constrained()->onDelete('cascade');
            $table->foreignId('gare_depart')->references('id')->on('gares')->onDelete('cascade');
            $table->string('lieu_embarquement');
            $table->date('date_depart');
            $table->time('heure_depart');
            $table->decimal('tarif_unitaire', 10, 2);
            $table->integer('nombre_tickets');
            $table->decimal('total', 10, 2);
            $table->boolean('assurance_voyageur')->default(false);
            $table->boolean('assurance_bagages')->default(false);
            $table->decimal('cout_assurance', 10, 2)->default(0);
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])->default('en_attente');
            $table->string('statut_paiement')->unique();
            $table->string('code_reservation')->unique();
            $table->string('nom_voyageur')->nullable();
            $table->string('contact_voyageur')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};