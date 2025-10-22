<?php
// scripts/normalize_images.php
// Usage: php scripts/normalize_images.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Vehicle;
use Illuminate\Support\Str;

echo "Starting normalization of vehicle images...\n";

$counter = 0;
$changed = 0;

Vehicle::chunk(100, function($vehicles) use (&$counter, &$changed) {
    foreach ($vehicles as $v) {
        $counter++;
        $images = $v->images ?? [];
        if (!is_array($images) || empty($images)) {
            continue;
        }

        $normalized = [];
        $modified = false;

        foreach ($images as $img) {
            $orig = $img;
            if (is_array($img)) {
                $img = $img['url'] ?? $img['original'] ?? '';
            }
            $img = trim((string) $img);
            if ($img === '') continue;

            // If contains 'public/storage/', strip everything up to that and keep the rest
            if (strpos($img, 'public/storage/') !== false) {
                $pos = strpos($img, 'public/storage/');
                $rest = substr($img, $pos + strlen('public/storage/'));
                $img = 'vehicles/' . ltrim($rest, '/');
            }
            // If contains '/storage/vehicles/' keep relative path after 'storage/'
            elseif (strpos($img, '/storage/vehicles/') !== false) {
                $pos = strpos($img, '/storage/');
                $rest = substr($img, $pos + strlen('/storage/'));
                $img = $rest;
            }

            // If it's an absolute URL to the same host and contains '/public/storage/',
            // extract the path after '/public/storage/'
            $appUrl = rtrim(config('app.url') ?: '', '/');
            if ($appUrl && Str::startsWith($img, $appUrl)) {
                $p = substr($img, strlen($appUrl));
                if (Str::startsWith($p, '/public/storage/')) {
                    $rest = substr($p, strlen('/public/storage/'));
                    $img = 'vehicles/' . ltrim($rest, '/');
                }
            }

            // Normalize spaces
            $img = str_replace('%20', ' ', $img);
            $img = trim($img);

            if ($img !== $orig) {
                $modified = true;
            }

            $normalized[] = $img;
        }

        // make unique and reindex
        $normalized = array_values(array_unique($normalized));

        if ($modified) {
            $v->images = $normalized;
            $v->save();
            $changed++;
            echo "Updated vehicle {$v->id}: now " . json_encode($normalized) . "\n";
        }
    }
});

echo "Processed: $counter vehicles. Modified: $changed vehicles.\n";

