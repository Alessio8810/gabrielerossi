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
        Schema::table('vehicle_histories', function (Blueprint $table) {
            // Indice per recuperare velocemente la storia di un veicolo specifico
            $table->index(['vehicle_id', 'created_at'], 'vh_vehicle_date_index');
            
            // Indice per recuperare rapidamente per tipo di azione
            $table->index(['vehicle_id', 'action'], 'vh_vehicle_action_index');
            
            // Indice per recuperare per utente che ha fatto la modifica
            $table->index('user_name', 'vh_user_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_histories', function (Blueprint $table) {
            $table->dropIndex('vh_vehicle_date_index');
            $table->dropIndex('vh_vehicle_action_index');
            $table->dropIndex('vh_user_index');
        });
    }
};
