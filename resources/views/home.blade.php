<x-layouts.public>
    <div>
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-elegant-800 to-elegant-900 text-white py-24 overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in">
                    <i class="fas fa-car mr-4 text-gold-500"></i>
                    Benvenuto in Rossi Auto Center
                </h1>
                <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">
                    Il tuo partner di fiducia per l'acquisto di auto nuove e usate. 
                    Trova il veicolo perfetto per te tra la nostra vasta selezione.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('vehicles') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gold-500 text-elegant-900 rounded-lg font-bold text-lg hover:bg-gold-600 transition-all duration-200 transform hover:scale-105 shadow-lg"
                       wire:navigate>
                        <i class="fas fa-search mr-2"></i>
                        Esplora i Veicoli
                    </a>
                    @auth
                        <a href="{{ route('admin.vehicles') }}" 
                           class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-gold-500 text-gold-500 rounded-lg font-bold text-lg hover:bg-gold-500 hover:text-elegant-900 transition-all duration-200 transform hover:scale-105"
                           wire:navigate>
                            <i class="fas fa-cog mr-2"></i>
                            Pannello Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white py-12 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="p-6">
                        <div class="text-5xl font-bold text-gold-600 mb-2">
                            {{ \App\Models\Vehicle::active()->count() }}+
                        </div>
                        <div class="text-gray-600 text-lg">Veicoli Disponibili</div>
                    </div>
                    <div class="p-6">
                        <div class="text-5xl font-bold text-gold-600 mb-2">
                            {{ \App\Models\Brand::active()->count() }}+
                        </div>
                        <div class="text-gray-600 text-lg">Marche Prestigiose</div>
                    </div>
                    <div class="p-6">
                        <div class="text-5xl font-bold text-gold-600 mb-2">100%</div>
                        <div class="text-gray-600 text-lg">Soddisfazione Cliente</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Vehicles Section -->
        @php
            $featuredVehicles = \App\Models\Vehicle::with(['brand', 'carModel'])
                ->active()
                ->featured()
                ->limit(6)
                ->get();
        @endphp

        @if($featuredVehicles->count() > 0)
            <div class="py-16 bg-gray-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-900 mb-4">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            Veicoli in Evidenza
                        </h2>
                        <p class="text-xl text-gray-600">
                            Scopri i nostri veicoli selezionati
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($featuredVehicles as $vehicle)
                            <div class="vehicle-card bg-white rounded-lg shadow-md overflow-hidden">
                                <!-- Vehicle Image -->
                                <div class="relative">
                                    <img src="{{ $vehicle->main_image }}" 
                                         alt="{{ $vehicle->title }}" 
                                         class="w-full h-56 object-cover">
                                    
                                    <!-- Condition Badge -->
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $vehicle->condition === 'new' ? 'bg-green-100 text-green-800' : 'bg-gold-100 text-elegant-800' }}">
                                            {{ $vehicle->condition === 'new' ? 'Nuovo' : 'Usato' }}
                                        </span>
                                    </div>

                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>
                                            In Evidenza
                                        </span>
                                    </div>
                                </div>

                                <!-- Vehicle Info -->
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">
                                        {{ $vehicle->title }}
                                    </h3>
                                    
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar w-5 mr-2"></i>
                                            {{ $vehicle->year }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-road w-5 mr-2"></i>
                                            {{ number_format($vehicle->mileage) }} km
                                        </div>
                                        @if($vehicle->fuel_type)
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-gas-pump w-5 mr-2"></i>
                                                {{ ucfirst($vehicle->fuel_type) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex items-center justify-between pt-4 border-t">
                                        <div class="text-3xl font-bold text-gold-600">
                                            {{ $vehicle->formatted_price }}
                                        </div>
                                        <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                                           class="bg-gold-500 text-white px-4 py-2 rounded-md hover:bg-gold-600 transition-colors duration-200"
                                           wire:navigate>
                                            <i class="fas fa-eye mr-1"></i>
                                            Dettagli
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-12">
                        <a href="{{ route('vehicles') }}" 
                           class="inline-flex items-center px-8 py-4 bg-gold-500 text-white rounded-lg font-bold text-lg hover:bg-gold-600 transition-all duration-200"
                           wire:navigate>
                            Vedi Tutti i Veicoli
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Why Choose Us Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Perché Scegliere Noi
                    </h2>
                    <p class="text-xl text-gray-600">
                        I nostri punti di forza
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow duration-200">
                        <div class="text-5xl text-gold-600 mb-4">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Veicoli Certificati</h3>
                        <p class="text-gray-600">
                            Tutti i nostri veicoli sono accuratamente selezionati e certificati per garantire la massima qualità.
                        </p>
                    </div>

                    <div class="text-center p-8 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow duration-200">
                        <div class="text-5xl text-gold-600 mb-4">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Prezzi Competitivi</h3>
                        <p class="text-gray-600">
                            Offriamo i migliori prezzi sul mercato con possibilità di finanziamento personalizzato.
                        </p>
                    </div>

                    <div class="text-center p-8 rounded-lg bg-gray-50 hover:shadow-lg transition-shadow duration-200">
                        <div class="text-5xl text-gold-600 mb-4">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Assistenza Dedicata</h3>
                        <p class="text-gray-600">
                            Il nostro team è sempre a tua disposizione per aiutarti a trovare l'auto perfetta.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-elegant-800 to-elegant-900 text-white py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-bold mb-6">
                    Pronto a Trovare la Tua Auto Perfetta?
                </h2>
                <p class="text-xl mb-8">
                    Esplora la nostra collezione completa di veicoli nuovi e usati
                </p>
                <a href="{{ route('vehicles') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gold-500 text-elegant-900 rounded-lg font-bold text-lg hover:bg-gold-600 transition-all duration-200 transform hover:scale-105 shadow-lg"
                   wire:navigate>
                    <i class="fas fa-search mr-2"></i>
                    Inizia la Ricerca
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
    </style>
</x-layouts.public>


