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
        Schema::create('pdcs', function (Blueprint $table) {
            $table->id();
            $table->integer('echant')->default(1);
            $table->string('achat')->nullable();
            $table->decimal('poids_moyen');
            $table->string('type')->default('pdc');
            $table->integer('nombre');
            $table->integer('mortalite')->nullable();
            $table->integer('remplacement')->nullable();
            $table->integer('survivant')->virtualAs('nombre - mortalite + remplacement');
            $table->float('biomasse')->virtualAs('(nombre - mortalite + remplacement)*(poids_moyen/1000)');
            $table->decimal('poids_total', 20)->virtualAs('survivant * poids_moyen');
            $table->decimal('prise_poids')->default(0);
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
        Schema::dropIfExists('pdcs');
    }
};
