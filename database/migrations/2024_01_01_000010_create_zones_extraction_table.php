<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('zones_extraction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites_miniers')->onDelete('cascade');
            $table->string('nom', 100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones_extraction');
    }
};
