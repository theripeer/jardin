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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('r_social');
            $table->string('rut')->unique();
            $table->boolean('is_visible')->default(false);
            $table->longText('descripcion')->nullable();
            $table->timestamps();
        });
    }
    //$table->foreignId('parent_id')->nullable()->constrained('empresas')->cascadeOnDelete();
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
