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
            $table->string('serial_number', 40)->nullable()->unique()->after('slug');
        });

        // Backfill unique serials for existing rows (AD-0001 style); masters script can overwrite known works.
        $rows = DB::table('artworks')->orderBy('id')->get(['id']);
        foreach ($rows as $i => $row) {
            DB::table('artworks')->where('id', $row->id)->update([
                'serial_number' => 'AD-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('artworks', function (Blueprint $table) {
            $table->dropUnique(['serial_number']);
            $table->dropColumn('serial_number');
        });
    }
};
