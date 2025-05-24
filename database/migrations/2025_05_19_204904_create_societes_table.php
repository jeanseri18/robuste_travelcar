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
        Schema::create('societes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_commercial');
            $table->string('description')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->string('siege_social')->nullable();
            $table->date('date_creation')->nullable();
            $table->decimal('capital', 15, 2)->nullable();
            $table->string('rccm')->nullable();
            $table->string('compte_contribuable')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('responsable_marketing')->nullable();
            $table->string('logo')->nullable();
            $table->string('regime_imposition')->nullable();
            $table->string('centre_impots')->nullable();
            $table->string('compte_bancaire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('societes');
    }
};