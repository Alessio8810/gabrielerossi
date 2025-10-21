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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->text('description')->nullable()->after('logo');
        });
        
        // Popola gli slug per i brand esistenti
        $brands = \App\Models\Brand::all();
        foreach ($brands as $brand) {
            $brand->slug = \Illuminate\Support\Str::slug($brand->name);
            $brand->save();
        }
        
        // Ora rendi lo slug unique
        Schema::table('brands', function (Blueprint $table) {
            $table->string('slug')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['slug', 'description']);
        });
    }
};
