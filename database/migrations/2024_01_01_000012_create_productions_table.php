<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites_miniers')->onDelete('cascade');
            $table->foreignId('zone_id')->nullable()->constrained('zones_extraction')->onDelete('set null');
            $table->foreignId('minerai_id')->constrained('minerais')->onDelete('cascade');
            $table->date('date_production')->nullable();
            $table->decimal('quantite', 18, 2)->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
