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
        Schema::table('entries', function (Blueprint $table) {
            // Fish Stock related fields
            $table->integer('shifting_in')->default(0)->after('mortality');
            $table->integer('shifting_out')->default(0)->after('shifting_in');
            $table->integer('sale')->default(0)->after('shifting_out');
            
            // Fish Feed related fields
            $table->decimal('feed_in_stock', 10, 2)->nullable()->after('feed_quantity');
            $table->decimal('feed_consumption', 10, 2)->nullable()->after('feed_in_stock');
            
            // Medication
            $table->text('medication')->nullable()->after('feed_consumption');
            
            // Water Parameters
            $table->decimal('water_ph', 5, 2)->nullable()->after('water_temp');
            $table->decimal('water_do', 5, 2)->nullable()->after('water_ph'); // Dissolved Oxygen
            
            // Offence Cases
            $table->integer('offence_cases')->default(0)->after('water_do');
            
            // Add additional_notes column (keep remarks for backward compatibility)
            $table->text('additional_notes')->nullable()->after('offence_cases');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn([
                'shifting_in',
                'shifting_out',
                'sale',
                'feed_in_stock',
                'feed_consumption',
                'medication',
                'water_ph',
                'water_do',
                'offence_cases',
                'additional_notes',
            ]);
        });
    }
};
