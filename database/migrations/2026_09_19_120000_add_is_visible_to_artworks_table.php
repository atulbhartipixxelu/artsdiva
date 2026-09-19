<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->boolean('is_visible')->default(false)->after('is_published');
        });

        // Launch rule: nothing public until manually switched on.
        DB::table('artworks')->update(['is_visible' => false]);
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropColumn('is_visible');
        });
    }
};
