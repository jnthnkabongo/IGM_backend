<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sites_miniers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('concession_id')->nullable()->constrained('concessions')->onDelete('set null');
            $table->string('code', 50)->unique();
            $table->string('nom', 150)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('territoire', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sites_miniers');
    }
};
