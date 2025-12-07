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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('farm_id');
            $table->date('date');
            $table->integer('fish_stock');
            $table->decimal('feed_quantity', 10, 2);
            $table->integer('mortality')->default(0);
            $table->decimal('water_temp', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('editable_until');
            $table->timestamps();
            
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->index(['farm_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
