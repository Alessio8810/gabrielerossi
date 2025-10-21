<div>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-elegant-800 to-elegant-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">
                Trova la Tua Auto Perfetta
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-elegant-200">
                Scopri la nostra selezione di veicoli nuovi e usati
            </p>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white border-b border-gray-200 sticky top-16 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cerca marca, modello..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                </div>

                <!-- Brand -->
                <div>
                    <select wire:model.live="selectedBrand" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="">Tutte le marche</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Model -->
                <div>
                    <select wire:model.live="selectedModel" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500"
                            {{ !$selectedBrand ? 'disabled' : '' }}>
                        <option value="">Tutti i modelli</option>
                        @foreach($carModels as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Condition -->
                <div>
                    <select wire:model.live="selectedCondition" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="">Tutte</option>
                        <option value="new">Nuovo</option>
                        <option value="used">Usato</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="flex items-end">
                    <button wire:click="clearFilters" 
                            class="w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                        <i class="fas fa-times mr-1"></i>
                        Pulisci
                    </button>
                </div>
            </div>

            <!-- Advanced Filters (Collapsible) -->
            <div x-data="{ showAdvanced: false }" class="mt-4">
                <button @click="showAdvanced = !showAdvanced" 
                        class="text-gold-600 hover:text-elegant-800 text-sm font-medium">
                    <i class="fas fa-sliders-h mr-1"></i>
                    Filtri Avanzati
                    <i class="fas fa-chevron-down ml-1 transition-transform" 
                       :class="{ 'rotate-180': showAdvanced }"></i>
                </button>

                <div x-show="showAdvanced" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                    
                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prezzo Min (€)</label>
                        <input type="number" 
                               wire:model.live.debounce.500ms="minPrice" 
                               placeholder="Da..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prezzo Max (€)</label>
                        <input type="number" 
                               wire:model.live.debounce.500ms="maxPrice" 
                               placeholder="A..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    </div>

                    <!-- Year Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anno Min</label>
                        <input type="number" 
                               wire:model.live.debounce.500ms="minYear" 
                               placeholder="Da..."
                               min="1990"
                               max="{{ date('Y') + 1 }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anno Max</label>
                        <input type="number" 
                               wire:model.live.debounce.500ms="maxYear" 
                               placeholder="A..."
                               min="1990"
                               max="{{ date('Y') + 1 }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Veicoli Disponibili
                </h2>
                <p class="text-gray-600">
                    {{ $vehicles->total() }} veicoli trovati
                </p>
            </div>

            <!-- Sort Options -->
            <div class="mt-4 sm:mt-0 flex items-center space-x-4">
                <label class="text-sm text-gray-700">Ordina per:</label>
                <select wire:model.live="sortBy" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <option value="created_at">Più recenti</option>
                    <option value="price">Prezzo</option>
                    <option value="year">Anno</option>
                    <option value="mileage">Chilometraggio</option>
                </select>
                <button wire:click="sortBy('{{ $sortBy }}')" 
                        class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                </button>
            </div>
        </div>

        <!-- Vehicles Grid -->
        @if($vehicles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($vehicles as $vehicle)
                    <div class="vehicle-card bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Vehicle Image -->
                        <div class="relative">
                            <img src="{{ $vehicle->main_image }}" 
                                 alt="{{ $vehicle->title }}" 
                                 class="w-full h-48 object-cover">
                            
                            <!-- Condition Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $vehicle->condition === 'new' ? 'bg-green-100 text-green-800' : 'bg-gold-100 text-elegant-800' }}">
                                    {{ $vehicle->condition === 'new' ? 'Nuovo' : 'Usato' }}
                                </span>
                            </div>

                            @if($vehicle->is_featured)
                                <div class="absolute top-2 right-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-star mr-1"></i>
                                        In Evidenza
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Vehicle Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $vehicle->title }}
                            </h3>
                            
                            <div class="text-sm text-gray-600 mb-3 space-y-1">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar w-4 text-gray-400 mr-2"></i>
                                    {{ $vehicle->year }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-road w-4 text-gray-400 mr-2"></i>
                                    {{ number_format($vehicle->mileage) }} km
                                </div>
                                @if($vehicle->fuel_type)
                                    <div class="flex items-center">
                                        <i class="fas fa-gas-pump w-4 text-gray-400 mr-2"></i>
                                        {{ ucfirst($vehicle->fuel_type) }}
                                    </div>
                                @endif
                                @if($vehicle->transmission)
                                    <div class="flex items-center">
                                        <i class="fas fa-cogs w-4 text-gray-400 mr-2"></i>
                                        {{ $vehicle->transmission }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold text-gold-600">
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

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $vehicles->links() }}
            </div>
        @else
            <!-- No Results -->
            <div class="text-center py-16">
                <div class="mb-4">
                    <i class="fas fa-search text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    Nessun veicolo trovato
                </h3>
                <p class="text-gray-600 mb-4">
                    Prova a modificare i filtri di ricerca
                </p>
                <button wire:click="clearFilters" 
                        class="inline-flex items-center px-4 py-2 bg-gold-500 text-white rounded-md hover:bg-gold-600 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Pulisci Filtri
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Alpine.js for interactive elements -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


