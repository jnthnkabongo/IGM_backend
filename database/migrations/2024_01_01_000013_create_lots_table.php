<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_id')->constrained('productions')->onDelete('cascade');
            $table->string('numero', 100)->unique();
            $table->string('qr_code', 255)->nullable();
            $table->string('verification_token', 255)->unique()->nullable();
            $table->string('hash_signature', 255)->nullable();
            $table->decimal('quantite', 18, 2);
            $table->decimal('quantite_restante', 18, 2);
            $table->enum('statut', ['en_attente', 'en_stock', 'reserve', 'vendu', 'expedie', 'livre', 'bloque'])->default('en_stock');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
