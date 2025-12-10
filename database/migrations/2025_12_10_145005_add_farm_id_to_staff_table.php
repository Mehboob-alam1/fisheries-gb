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
        Schema::table('staff', function (Blueprint $table) {
            if (!Schema::hasColumn('staff', 'farm_id')) {
                $table->unsignedBigInteger('farm_id')->after('id');
                $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
                $table->index('farm_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'farm_id')) {
                $table->dropForeign(['farm_id']);
                $table->dropIndex(['farm_id']);
                $table->dropColumn('farm_id');
            }
        });
    }
};
