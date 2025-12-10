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
            if (!Schema::hasColumn('staff', 'name')) {
                $table->string('name')->after('farm_id');
            }
            if (!Schema::hasColumn('staff', 'position')) {
                $table->string('position')->nullable()->after('name');
            }
            if (!Schema::hasColumn('staff', 'contact_number')) {
                $table->string('contact_number')->nullable()->after('position');
            }
            if (!Schema::hasColumn('staff', 'cnic')) {
                $table->string('cnic')->nullable()->after('contact_number');
            }
            if (!Schema::hasColumn('staff', 'joining_date')) {
                $table->date('joining_date')->nullable()->after('cnic');
            }
            if (!Schema::hasColumn('staff', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('joining_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            if (Schema::hasColumn('staff', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('staff', 'joining_date')) {
                $table->dropColumn('joining_date');
            }
            if (Schema::hasColumn('staff', 'cnic')) {
                $table->dropColumn('cnic');
            }
            if (Schema::hasColumn('staff', 'contact_number')) {
                $table->dropColumn('contact_number');
            }
            if (Schema::hasColumn('staff', 'position')) {
                $table->dropColumn('position');
            }
            if (Schema::hasColumn('staff', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
