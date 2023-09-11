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
        Schema::create('alimentations', function (Blueprint $table) {
            $table->id();
            $table->integer('jour')->default(0);
            $table->decimal('ration', 20, 2)->default(0);
            $table->decimal('quantite', 20, 2)->nullable();
            $table->integer('prix')->nullable();
            $table->decimal('produit', 20, 2)->virtualAs('quantite * jour');
            $table->decimal('montant', 20, 2)->virtualAs('produit * prix');
            $table->foreignId('pdc_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('aliment_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentations');
    }
};
