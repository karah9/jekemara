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
        Schema::create('recoltes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('poids_total')->default(0);
            $table->decimal('prixkg')->default(0);
            $table->double('montant')->virtualAs('poids_total * prixkg');
            $table->foreignId('cycle_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recoltes');
    }
};
