<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Rossi Auto Center</title>

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
    
    <style>
        /* Transizioni SPA */
        .page-transition {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.3s ease-in-out;
        }
        
        .page-transition.loading {
            opacity: 0.7;
            transform: translateY(-10px);
        }
        
        /* Animazioni per le card */
        .vehicle-card {
            transition: all 0.3s ease;
        }
        
        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-elegant-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-elegant-900 shadow-lg sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="text-2xl font-bold text-gold-500" wire:navigate>
                                <i class="fas fa-car mr-2"></i>
                                Rossi Auto Center
                            </a>
                        </div>
                        <div class="hidden sm:ml-10 sm:flex sm:space-x-8">
                            <a href="{{ route('home') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200"
                               wire:navigate>
                                <i class="fas fa-home mr-1"></i>
                                Home
                            </a>
                            <a href="{{ route('vehicles') }}" 
                               class="border-transparent text-elegant-300 hover:text-gold-400 hover:border-gold-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200"
                               wire:navigate>
                                <i class="fas fa-cars mr-1"></i>
                                Veicoli
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('admin.vehicles') }}" 
                               class="text-elegant-300 hover:text-gold-400 text-sm transition-colors duration-200"
                               wire:navigate>
                                <i class="fas fa-cog mr-1"></i>
                                Admin
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-gold-500 hover:bg-gold-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-1"></i>
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="page-transition">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} Rossi Auto Center. Tutti i diritti riservati.</p>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
    
    @if(app()->environment('production'))
        <script src="{{ asset('build/assets/app-kG8uzeeg.js') }}" defer></script>
    @endif
    
    <script>
        // Gestione transizioni SPA
        document.addEventListener('livewire:load', function () {
            // Livewire navigation animations
            Livewire.hook('message.sent', () => {
                document.querySelector('main').classList.add('loading');
            });
            
            Livewire.hook('message.processed', () => {
                document.querySelector('main').classList.remove('loading');
            });
        });
    </script>
</body>
</html>