<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('purchased_art_before', 10)->nullable()->after('address');
            $table->text('admired_artists')->nullable()->after('purchased_art_before');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['purchased_art_before', 'admired_artists']);
        });
    }
};
