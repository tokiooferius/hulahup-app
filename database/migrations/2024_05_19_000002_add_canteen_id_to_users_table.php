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
        Schema::table('users', function (Blueprint $table) {
            // Add canteen_id (nullable, hanya untuk ibu_kantin)
            $table->foreignId('canteen_id')->nullable()->constrained('canteens')->onDelete('set null');
            
            // Update role column dengan enum baru
            $table->string('role')->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn('canteen_id');
        });
    }
};
