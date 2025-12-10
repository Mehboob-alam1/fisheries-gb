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
            if (!Schema::hasColumn('entries', 'shifting_in')) {
                $table->integer('shifting_in')->default(0);
            }
            if (!Schema::hasColumn('entries', 'shifting_out')) {
                $table->integer('shifting_out')->default(0);
            }
            if (!Schema::hasColumn('entries', 'sale')) {
                $table->integer('sale')->default(0);
            }
            if (!Schema::hasColumn('entries', 'feed_in_stock')) {
                $table->decimal('feed_in_stock', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('entries', 'feed_consumption')) {
                $table->decimal('feed_consumption', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('entries', 'medication')) {
                $table->text('medication')->nullable();
            }
            if (!Schema::hasColumn('entries', 'water_ph')) {
                $table->decimal('water_ph', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('entries', 'water_do')) {
                $table->decimal('water_do', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('entries', 'offence_cases')) {
                $table->integer('offence_cases')->default(0);
            }
            if (!Schema::hasColumn('entries', 'additional_notes')) {
                $table->text('additional_notes')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            if (Schema::hasColumn('entries', 'additional_notes')) {
                $table->dropColumn('additional_notes');
            }
            if (Schema::hasColumn('entries', 'offence_cases')) {
                $table->dropColumn('offence_cases');
            }
            if (Schema::hasColumn('entries', 'water_do')) {
                $table->dropColumn('water_do');
            }
            if (Schema::hasColumn('entries', 'water_ph')) {
                $table->dropColumn('water_ph');
            }
            if (Schema::hasColumn('entries', 'medication')) {
                $table->dropColumn('medication');
            }
            if (Schema::hasColumn('entries', 'feed_consumption')) {
                $table->dropColumn('feed_consumption');
            }
            if (Schema::hasColumn('entries', 'feed_in_stock')) {
                $table->dropColumn('feed_in_stock');
            }
            if (Schema::hasColumn('entries', 'sale')) {
                $table->dropColumn('sale');
            }
            if (Schema::hasColumn('entries', 'shifting_out')) {
                $table->dropColumn('shifting_out');
            }
            if (Schema::hasColumn('entries', 'shifting_in')) {
                $table->dropColumn('shifting_in');
            }
        });
    }
};
