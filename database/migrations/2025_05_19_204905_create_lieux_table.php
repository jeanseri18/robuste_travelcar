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
            $table->string('ville');
            $table->string('commune')->nullable();
            $table->string('region')->nullable();
            $table->string('departement')->nullable();
            $table->string('sous_prefecture')->nullable();
            $table->enum('type', ['depart', 'arrive', 'les_deux'])->default('les_deux');
            $table->boolean('est_actif')->default(true);
            $table->timestamps();
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