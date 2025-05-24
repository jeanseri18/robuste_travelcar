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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['orange_money', 'mtn_money', 'moov_money', 'wave', 'cheque', 'virement','en espece', 'cinetpay']);
            $table->string('numero_transaction')->nullable();
            $table->string('reference_transaction')->nullable();
            $table->enum('statut', ['en_attente', 'complete', 'echoue', 'remboursement'])->default('en_attente');
            $table->dateTime('date_paiement')->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};