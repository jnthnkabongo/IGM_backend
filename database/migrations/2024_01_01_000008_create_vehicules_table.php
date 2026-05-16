<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('plaque', 50)->nullable();
            $table->string('marque', 100)->nullable();
            $table->string('chauffeur', 100)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
