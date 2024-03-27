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
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->string('direccion');
            $table->unsignedBigInteger('especie_id');
            $table->foreign('especie_id')->references('id')->on('especies');
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->integer('plazos');
            $table->unsignedBigInteger('cuadrilla_id');
            $table->foreign('cuadrilla_id')->references('id')->on('cuadrillas');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->enum('estados', ['CREADA', 'EN PROCESO', 'RECHAZADA', 'REALIZADA'])->default('CREADA');
            $table->enum('estpago', ['POR PAGAR', 'PAGADO'])->default('POR PAGAR');
            $table->longText('observacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
