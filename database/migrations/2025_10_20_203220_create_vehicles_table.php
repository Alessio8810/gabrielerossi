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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('car_model_id')->constrained('car_models');
            $table->string('title');
            $table->text('description')->nullable();
            $table->year('year');
            $table->integer('mileage'); // chilometri
            $table->decimal('price', 10, 2);
            $table->enum('condition', ['new', 'used']); // nuovo/usato
            $table->enum('fuel_type', ['gasoline', 'diesel', 'electric', 'hybrid'])->nullable();
            $table->string('transmission')->nullable(); // cambio
            $table->string('body_type')->nullable(); // tipo carrozzeria
            $table->string('color')->nullable();
            $table->json('images')->nullable(); // array di percorsi immagini
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
