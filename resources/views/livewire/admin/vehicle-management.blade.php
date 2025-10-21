<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestione Veicoli</h1>
                <p class="mt-2 text-sm text-gray-600">Gestisci tutti i veicoli del tuo centro auto</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('admin.vehicles.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gold-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gold-600 active:bg-elegant-900 focus:outline-none focus:border-gold-700 focus:ring focus:ring-gold-300 disabled:opacity-25 transition ease-in-out duration-150"
                   wire:navigate>
                    <i class="fas fa-plus mr-2"></i>
                    Aggiungi Veicolo
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cerca</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Cerca per marca, modello o titolo..."
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
            </div>

            <!-- Brand Filter -->
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                <select wire:model.live="selectedBrand" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <option value="">Tutte le marche</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Condition Filter -->
            <div>
                <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condizione</label>
                <select wire:model.live="selectedCondition" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <option value="">Tutte</option>
                    <option value="new">Nuovo</option>
                    <option value="used">Usato</option>
                </select>
            </div>

            <!-- Active Only -->
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" 
                           wire:model.live="showActiveOnly" 
                           class="rounded border-gray-300 text-gold-600 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <span class="ml-2 text-sm text-gray-700">Solo attivi</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Vehicles Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Veicolo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prezzo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anno/Km</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condizione</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Azioni</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-car text-gray-500"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $vehicle->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $vehicle->brand->name }} {{ $vehicle->carModel->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $vehicle->formatted_price }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $vehicle->year }}</div>
                                <div class="text-sm text-gray-500">{{ number_format($vehicle->mileage) }} km</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $vehicle->condition === 'new' ? 'bg-green-100 text-green-800' : 'bg-gold-100 text-elegant-800' }}">
                                    {{ $vehicle->condition === 'new' ? 'Nuovo' : 'Usato' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $vehicle->is_active ? 'Attivo' : 'Inattivo' }}
                                </span>
                                @if($vehicle->is_featured)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 ml-1">
                                        In evidenza
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                   class="text-gold-600 hover:text-elegant-900 transition-colors duration-150"
                                   wire:navigate>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="toggleVehicleStatus({{ $vehicle->id }})" 
                                        class="text-yellow-600 hover:text-yellow-900 transition-colors duration-150">
                                    <i class="fas fa-{{ $vehicle->is_active ? 'eye-slash' : 'eye' }}"></i>
                                </button>
                                <button wire:click="deleteVehicle({{ $vehicle->id }})" 
                                        onclick="return confirm('Sei sicuro di voler eliminare questo veicolo?')"
                                        class="text-red-600 hover:text-red-900 transition-colors duration-150">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <i class="fas fa-car text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg">Nessun veicolo trovato</p>
                                    <p class="text-sm">Inizia aggiungendo il tuo primo veicolo</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($vehicles->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>
</div>


