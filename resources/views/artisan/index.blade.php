<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artisan Commands - Rossi Auto Center</title>
    @if(app()->environment('production'))
        <link rel="stylesheet" href="{{ asset('build/assets/app-Uu-qpNxC.css') }}">
        <script src="{{ asset('build/assets/app-kG8uzeeg.js') }}" defer></script>
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-elegant-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-elegant-900">
                        <i class="fas fa-terminal text-gold-500"></i>
                        Artisan Commands
                    </h1>
                    <a href="{{ route('admin.dashboard') }}" class="text-gold-600 hover:text-gold-700">
                        <i class="fas fa-arrow-left mr-2"></i>Torna al Dashboard
                    </a>
                </div>
                <p class="text-elegant-600 mt-2">
                    Esegui comandi artisan direttamente dal browser
                </p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-elegant-900 mb-4">Azioni Rapide</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Clear All Caches -->
                    <a href="{{ route('artisan.clear-all') }}?token={{ $token }}" 
                       class="block p-4 bg-gold-50 hover:bg-gold-100 rounded-lg border-2 border-gold-200 hover:border-gold-400 transition">
                        <div class="flex items-center">
                            <i class="fas fa-broom text-gold-600 text-2xl mr-3"></i>
                            <div>
                                <h3 class="font-bold text-elegant-900">Pulisci Tutte le Cache</h3>
                                <p class="text-sm text-elegant-600">config, cache, route, view, optimize</p>
                            </div>
                        </div>
                    </a>

                    <!-- Storage Link -->
                    <a href="{{ route('artisan.index') }}?command=storage:link&token={{ $token }}" 
                       class="block p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border-2 border-blue-200 hover:border-blue-400 transition">
                        <div class="flex items-center">
                            <i class="fas fa-link text-blue-600 text-2xl mr-3"></i>
                            <div>
                                <h3 class="font-bold text-elegant-900">Storage Link</h3>
                                <p class="text-sm text-elegant-600">Crea link simbolico storage</p>
                            </div>
                        </div>
                    </a>

                    <!-- NPM Build -->
                    <a href="{{ route('artisan.index') }}?command=npm-build&token={{ $token }}" 
                       class="block p-4 bg-green-50 hover:bg-green-100 rounded-lg border-2 border-green-200 hover:border-green-400 transition">
                        <div class="flex items-center">
                            <i class="fas fa-hammer text-green-600 text-2xl mr-3"></i>
                            <div>
                                <h3 class="font-bold text-elegant-900">NPM Build</h3>
                                <p class="text-sm text-elegant-600">Compila asset per produzione</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Command Executor -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-elegant-900 mb-4">Esegui Comando</h2>
                
                <form method="GET" action="{{ route('artisan.index') }}" class="space-y-4">
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div>
                        <label for="command" class="block text-sm font-medium text-elegant-700 mb-2">
                            Seleziona Comando
                        </label>
                        <select name="command" id="command" 
                                class="w-full px-4 py-2 border border-elegant-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-gold-500">
                            <option value="">-- Seleziona un comando --</option>
                            <option value="config:clear" {{ $command === 'config:clear' ? 'selected' : '' }}>config:clear</option>
                            <option value="cache:clear" {{ $command === 'cache:clear' ? 'selected' : '' }}>cache:clear</option>
                            <option value="route:clear" {{ $command === 'route:clear' ? 'selected' : '' }}>route:clear</option>
                            <option value="view:clear" {{ $command === 'view:clear' ? 'selected' : '' }}>view:clear</option>
                            <option value="optimize" {{ $command === 'optimize' ? 'selected' : '' }}>optimize</option>
                            <option value="optimize:clear" {{ $command === 'optimize:clear' ? 'selected' : '' }}>optimize:clear</option>
                            <option value="storage:link" {{ $command === 'storage:link' ? 'selected' : '' }}>storage:link</option>
                            <option value="migrate" {{ $command === 'migrate' ? 'selected' : '' }}>migrate</option>
                            <option value="db:seed" {{ $command === 'db:seed' ? 'selected' : '' }}>db:seed</option>
                            <option value="npm-build" {{ $command === 'npm-build' ? 'selected' : '' }}>npm run build</option>
                        </select>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gold-500 hover:bg-gold-600 text-white font-bold py-3 px-6 rounded-lg transition">
                        <i class="fas fa-play mr-2"></i>Esegui Comando
                    </button>
                </form>
            </div>

            <!-- Output -->
            @if($output)
            <div class="bg-elegant-900 rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white">
                        <i class="fas fa-terminal text-gold-400 mr-2"></i>Output
                    </h2>
                    <span class="text-gold-400 text-sm">{{ $command }}</span>
                </div>
                
                <div class="bg-black rounded-lg p-4 overflow-x-auto">
                    <pre class="text-green-400 text-sm font-mono">{{ $output }}</pre>
                </div>
            </div>
            @endif

            <!-- Warning -->
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                    <div>
                        <h3 class="text-sm font-bold text-yellow-800">Attenzione</h3>
                        <p class="text-sm text-yellow-700 mt-1">
                            Questa pagina permette di eseguire comandi artisan. Usa con cautela e solo se sai cosa stai facendo.
                            L'accesso è limitato solo all'admin e protetto da token.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Security Info -->
            <div class="mt-4 text-center text-sm text-elegant-600">
                <p>
                    <i class="fas fa-shield-alt text-gold-500 mr-1"></i>
                    Pagina protetta - Solo admin autorizzato
                </p>
                <p class="mt-1 text-xs">
                    Token: <code class="bg-elegant-100 px-2 py-1 rounded">{{ substr($token, 0, 10) }}...</code>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
