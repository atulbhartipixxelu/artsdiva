<?php

/**
 * Set strong admin passwords from environment (do not hardcode secrets in git).
 *
 * Usage:
 *   SUPERADMIN_NEW_PASSWORD='...' ADMIN_NEW_PASSWORD='...' php scripts/set-admin-passwords.php
 */
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$superPass = getenv('SUPERADMIN_NEW_PASSWORD') ?: null;
$adminPass = getenv('ADMIN_NEW_PASSWORD') ?: null;

if (! $superPass || ! $adminPass) {
    fwrite(STDERR, "Set SUPERADMIN_NEW_PASSWORD and ADMIN_NEW_PASSWORD env vars.\n");
    exit(1);
}

if (strlen($superPass) < 12 || strlen($adminPass) < 12) {
    fwrite(STDERR, "Passwords must be at least 12 characters.\n");
    exit(1);
}

$super = User::query()->where('email', 'superadmin@artsdiva.com')->first();
$admin = User::query()->where('email', 'admin@artsdiva.com')->first();

if (! $super || ! $admin) {
    fwrite(STDERR, "Admin users not found.\n");
    exit(1);
}

$super->password = Hash::make($superPass);
$super->save();

$admin->password = Hash::make($adminPass);
$admin->save();

echo "Updated passwords for:\n";
echo "- {$super->email}\n";
echo "- {$admin->email}\n";
echo "Done. Share credentials privately only.\n";
