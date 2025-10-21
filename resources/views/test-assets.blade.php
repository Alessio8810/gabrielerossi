<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Asset Path</title>
</head>
<body>
    <h1>Test Percorsi Asset</h1>
    
    <h2>Informazioni Ambiente</h2>
    <ul>
        <li><strong>APP_ENV:</strong> {{ config('app.env') }}</li>
        <li><strong>APP_URL:</strong> {{ config('app.url') }}</li>
        <li><strong>ASSET_URL:</strong> {{ config('app.asset_url') }}</li>
        <li><strong>Base Path:</strong> {{ base_path() }}</li>
        <li><strong>Public Path:</strong> {{ public_path() }}</li>
    </ul>
    
    <h2>Percorsi Generati</h2>
    <ul>
        <li><strong>asset('build/manifest.json'):</strong> {{ asset('build/manifest.json') }}</li>
        <li><strong>asset('build/assets/app-Uu-qpNxC.css'):</strong> {{ asset('build/assets/app-Uu-qpNxC.css') }}</li>
        <li><strong>asset('build/assets/app-kG8uzeeg.js'):</strong> {{ asset('build/assets/app-kG8uzeeg.js') }}</li>
    </ul>
    
    <h2>File Esistono?</h2>
    <ul>
        <li><strong>manifest.json:</strong> {{ file_exists(public_path('build/manifest.json')) ? '✅ SI' : '❌ NO' }}</li>
        <li><strong>app.css:</strong> {{ file_exists(public_path('build/assets/app-Uu-qpNxC.css')) ? '✅ SI' : '❌ NO' }}</li>
        <li><strong>app.js:</strong> {{ file_exists(public_path('build/assets/app-kG8uzeeg.js')) ? '✅ SI' : '❌ NO' }}</li>
    </ul>
    
    <h2>Contenuto Directory public/build/</h2>
    <pre>
@php
    $buildPath = public_path('build');
    if (is_dir($buildPath)) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($buildPath),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($files as $file) {
            if ($file->isFile()) {
                echo str_replace(public_path(), '', $file->getPathname()) . "\n";
            }
        }
    } else {
        echo "❌ Directory build/ non esiste!";
    }
@endphp
    </pre>
    
    <h2>Test Caricamento Diretto</h2>
    <p>Clicca sui link per testare:</p>
    <ul>
        <li><a href="{{ asset('build/manifest.json') }}" target="_blank">manifest.json</a></li>
        <li><a href="{{ asset('build/assets/app-Uu-qpNxC.css') }}" target="_blank">app.css</a></li>
        <li><a href="{{ asset('build/assets/app-kG8uzeeg.js') }}" target="_blank">app.js</a></li>
    </ul>
</body>
</html>
