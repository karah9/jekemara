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
        Schema::create('infrastructures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->float('longueur')->nullable();
            $table->float('largeur')->nullable();
            $table->float('diametre')->nullable();
            $table->float('profondeur')->default(1);
            $table->float('niveau')->default(100);
            $table->float('superficie')->nullable();
            $table->float('volume')->nullable();
            $table->foreignId('ferme_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('type_infrastructure_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructures');
    }
};
