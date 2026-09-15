<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 40)->nullable()->after('email');
            $table->string('city', 120)->nullable()->after('phone');
            $table->string('country', 120)->nullable()->after('city');
            $table->text('address')->nullable()->after('country');
        });

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('artwork_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'artwork_id']);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number', 32)->unique();
            $table->string('status', 30)->default('pending');
            $table->string('type', 30)->default('acquisition');
            $table->decimal('total_eur', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('artwork_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('artist_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('thumbnail')->nullable();
            $table->decimal('price_eur', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('wishlists');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city', 'country', 'address']);
        });
    }
};
