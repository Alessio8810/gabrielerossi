<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-tags mr-2 text-gold-500"></i>
                    Gestione Marchi
                </h1>
                <p class="mt-2 text-gray-600">Visualizza e gestisci tutti i marchi di veicoli</p>
            </div>
            <a href="{{ route('admin.brands.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gold-500 text-white rounded-md hover:bg-gold-600 transition-colors duration-200"
               wire:navigate>
                <i class="fas fa-plus mr-2"></i>
                Nuovo Marchio
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Cerca per nome o slug..."
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                <div class="absolute left-3 top-3.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tags text-3xl text-gold-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Totale Marchi</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $brands->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Marchi Attivi</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\Brand::active()->count() }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-car text-3xl text-blue-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Veicoli Totali</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\Vehicle::count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Brands Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($brands as $brand)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <!-- Header with Logo -->
                    <div class="p-6 bg-gradient-to-r from-elegant-800 to-elegant-900">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($brand->logo)
                                    <img src="{{ Storage::url($brand->logo) }}" 
                                         alt="{{ $brand->name }}" 
                                         class="h-12 w-12 object-contain bg-white rounded-lg p-2">
                                @else
                                    <div class="h-12 w-12 bg-gold-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-car text-white text-xl"></i>
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-white">{{ $brand->name }}</h3>
                                    <p class="text-sm text-elegant-300">{{ $brand->slug }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="p-6">
                        @if($brand->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $brand->description }}
                            </p>
                        @else
                            <p class="text-gray-400 text-sm mb-4 italic">Nessuna descrizione</p>
                        @endif

                        <!-- Stats -->
                        <div class="flex items-center justify-between mb-4 pb-4 border-b">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-car text-gray-400 mr-2"></i>
                                <span class="text-gray-600">
                                    {{ $brand->vehicles_count }} 
                                    {{ $brand->vehicles_count === 1 ? 'veicolo' : 'veicoli' }}
                                </span>
                            </div>
                            
                            <div>
                                @if($brand->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Attivo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Disattivo
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between">
                            <button wire:click="toggleStatus({{ $brand->id }})" 
                                    class="text-sm px-3 py-1 rounded {{ $brand->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition-colors duration-200">
                                <i class="fas fa-power-off mr-1"></i>
                                {{ $brand->is_active ? 'Disattiva' : 'Attiva' }}
                            </button>

                            <div class="flex space-x-2">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" 
                                   class="text-gold-600 hover:text-gold-900 px-3 py-1 rounded hover:bg-gold-50 transition-colors duration-200"
                                   wire:navigate>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $brand->id }})" 
                                        class="text-red-600 hover:text-red-900 px-3 py-1 rounded hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-tags text-6xl mb-4"></i>
                            <p class="text-xl">Nessun marchio trovato</p>
                            <p class="text-sm mt-2">Inizia creando il tuo primo marchio</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $brands->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingBrandDeletion)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50" wire:click="cancelDelete"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $deleteError ? 'bg-yellow-100' : 'bg-red-100' }} sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas {{ $deleteError ? 'fa-exclamation-triangle text-yellow-600' : 'fa-exclamation-triangle text-red-600' }}"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900">
                                    {{ $deleteError ? 'Impossibile Eliminare' : 'Elimina Marchio' }}
                                </h3>
                                <div class="mt-2">
                                    @if($deleteError)
                                        <p class="text-sm text-gray-600">{{ $deleteError }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">
                                            Sei sicuro di voler eliminare questo marchio? Questa azione non può essere annullata.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        @if(!$deleteError)
                            <button type="button" 
                                    wire:click="deleteBrand" 
                                    class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                Elimina
                            </button>
                        @endif
                        <button type="button" 
                                wire:click="cancelDelete" 
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            {{ $deleteError ? 'Chiudi' : 'Annulla' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
