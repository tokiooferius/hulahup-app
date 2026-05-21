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
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('canteen_id')->after('id')->nullable()->constrained('canteens')->onDelete('cascade');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreignId('canteen_id')->after('id')->nullable()->constrained('canteens')->onDelete('cascade');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('canteen_id')->after('user_id')->nullable()->constrained('canteens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn('canteen_id');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn('canteen_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeignKeyConstraints();
            $table->dropColumn('canteen_id');
        });
    }
};
