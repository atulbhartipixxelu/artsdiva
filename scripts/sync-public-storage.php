<?php

/**
 * Copy storage/app/public → public/storage (Hostinger-safe, no symlink).
 * Usage: php scripts/sync-public-storage.php
 */
$root = dirname(__DIR__);
$from = $root.'/storage/app/public';
$to = $root.'/public/storage';

if (! is_dir($from)) {
    fwrite(STDERR, "Missing source: {$from}\n");
    exit(1);
}

if (is_link($to)) {
    unlink($to);
    echo "Removed broken/old symlink public/storage\n";
}

if (! is_dir($to)) {
    mkdir($to, 0755, true);
    echo "Created public/storage\n";
}

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$copied = 0;
foreach ($iterator as $item) {
    $target = $to.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
    if ($item->isDir()) {
        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }
        continue;
    }
    $dir = dirname($target);
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    if (! file_exists($target) || filemtime($item->getPathname()) > filemtime($target)) {
        copy($item->getPathname(), $target);
        $copied++;
    }
}

echo "Synced. Files copied/updated: {$copied}\n";
echo "Publications check: ".(is_dir($to.'/publications') ? 'OK' : 'missing')."\n";
