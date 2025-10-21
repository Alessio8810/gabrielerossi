<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Pannello Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @if(app()->environment('production'))
        <link rel="stylesheet" href="{{ asset('build/assets/app-Uu-qpNxC.css') }}">
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>
<body class="font-sans antialiased bg-elegant-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-elegant-900 shadow-lg border-b border-gold-600">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-gold-500">
                                <i class="fas fa-car text-gold-500 mr-2"></i>
                                Rossi Auto Center Admin
                            </h1>
                        </div>
                        <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-chart-line mr-1"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('admin.vehicles') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-cars mr-1"></i>
                                Veicoli
                            </a>
                            <a href="{{ route('admin.brands') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-tags mr-1"></i>
                                Marchi
                            </a>
                            <a href="{{ route('admin.models') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-car-side mr-1"></i>
                                Modelli
                            </a>
                            <a href="{{ route('admin.users') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-users mr-1"></i>
                                Utenti
                            </a>
                            <a href="{{ route('admin.artisan') }}?token=rossi-auto-artisan-2025" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                                <i class="fas fa-terminal mr-1"></i>
                                Artisan
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" 
                           class="text-elegant-300 hover:text-gold-400 text-sm"
                           wire:navigate>
                            <i class="fas fa-eye mr-1"></i>
                            Visualizza Sito
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-gold-500 hover:bg-gold-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                <i class="fas fa-sign-out-alt mr-1"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    
    @if(app()->environment('production'))
        <script src="{{ asset('build/assets/app-kG8uzeeg.js') }}" defer></script>
    @endif
    
    <!-- Flash Messages -->
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('flashMessage', message => {
                // Implementazione per messaggi flash
                console.log(message);
            });
        });
    </script>
</body>
</html>

