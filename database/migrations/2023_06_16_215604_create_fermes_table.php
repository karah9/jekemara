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
        Schema::create('fermes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('fullname')->virtualAs('concat(firstname, \' \', lastname)');
            $table->string('phone');
            $table->string('zone');
            $table->string('email')->nullable();
            $table->string('pays')->default('Mali');
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('cercle')->nullable();
            $table->string('communecercle')->nullable();
            $table->string('communedistrict')->nullable();
            $table->string('quartier')->nullable();
            $table->string('village')->nullable();
            $table->float('latitude', 20, 20)->nullable();
            $table->float('longitude', 20, 20)->nullable();
            $table->string('cooperative')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fermes');
    }
};
