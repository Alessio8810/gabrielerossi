<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Rossi Auto Center</h1>
            <p class="mt-2 text-sm text-gray-600">Panoramica completa del tuo inventario veicoli</p>
        </div>

        <!-- Statistiche Principali -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Totale Veicoli -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-gold-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Totale Veicoli</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $totalVehicles }}</p>
                    </div>
                    <div class="bg-gold-100 rounded-full p-4">
                        <i class="fas fa-car text-2xl text-gold-600"></i>
                    </div>
                </div>
            </div>

            <!-- Veicoli Attivi -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Veicoli Attivi</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $activeVehicles }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-4">
                        <i class="fas fa-check-circle text-2xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- In Evidenza -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">In Evidenza</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $featuredVehicles }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-4">
                        <i class="fas fa-star text-2xl text-yellow-600"></i>
                    </div>
                </div>
            </div>

            <!-- Valore Inventario -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Valore Inventario</p>
                        <p class="text-3xl font-bold text-gray-900">€{{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-4">
                        <i class="fas fa-euro-sign text-2xl text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="text-white">
                    <h3 class="text-xl font-bold mb-2">Azioni Rapide</h3>
                    <p class="text-gold-100">Gestisci il tuo centro auto in modo efficiente</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.vehicles.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-white text-gold-600 rounded-lg font-semibold hover:bg-gold-50 transition-colors duration-200"
                       wire:navigate>
                        <i class="fas fa-plus mr-2"></i>
                        Nuovo Veicolo
                    </a>
                    <a href="{{ route('admin.vehicles') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gold-500 text-white rounded-lg font-semibold hover:bg-blue-400 transition-colors duration-200"
                       wire:navigate>
                        <i class="fas fa-list mr-2"></i>
                        Tutti i Veicoli
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

