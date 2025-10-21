<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-car-side mr-2 text-gold-500"></i>
                    Gestione Modelli
                </h1>
                <p class="mt-2 text-gray-600">Visualizza e gestisci tutti i modelli di veicoli</p>
            </div>
            <a href="{{ route('admin.models.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gold-500 text-white rounded-md hover:bg-gold-600 transition-colors duration-200"
               wire:navigate>
                <i class="fas fa-plus mr-2"></i>
                Nuovo Modello
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Search and Filter Bar -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Search -->
            <div class="relative">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Cerca per nome modello o marchio..."
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                <div class="absolute left-3 top-3.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>

            <!-- Filter by Brand -->
            <div>
                <select wire:model.live="filterBrand"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent">
                    <option value="">Tutti i marchi</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-car-side text-3xl text-gold-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Totale Modelli</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $models->total() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-tags text-3xl text-blue-500"></i>
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
                        <i class="fas fa-car text-3xl text-green-500"></i>
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

        <!-- Models Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-elegant-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Marchio
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Modello
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Veicoli Associati
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                            Creato il
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">
                            Azioni
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($models as $model)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($model->brand->logo)
                                        <img src="{{ Storage::url($model->brand->logo) }}" 
                                             alt="{{ $model->brand->name }}" 
                                             class="h-8 w-8 object-contain rounded mr-3">
                                    @else
                                        <div class="h-8 w-8 bg-gold-100 rounded flex items-center justify-center mr-3">
                                            <i class="fas fa-car text-gold-600 text-sm"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $model->brand->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $model->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $model->vehicles_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    <i class="fas fa-car mr-1"></i>
                                    {{ $model->vehicles_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $model->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $model->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.models.edit', $model->id) }}" 
                                   class="text-gold-600 hover:text-gold-900 mr-3"
                                   wire:navigate>
                                    <i class="fas fa-edit"></i>
                                    Modifica
                                </a>
                                <button wire:click="confirmDelete({{ $model->id }})" 
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                    Elimina
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-car-side text-4xl mb-4"></i>
                                    <p class="text-lg">Nessun modello trovato</p>
                                    @if($search || $filterBrand)
                                        <p class="text-sm mt-2">Prova a modificare i filtri di ricerca</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $models->links() }}
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingModelDeletion)
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
                                    {{ $deleteError ? 'Impossibile Eliminare' : 'Elimina Modello' }}
                                </h3>
                                <div class="mt-2">
                                    @if($deleteError)
                                        <p class="text-sm text-gray-600">{{ $deleteError }}</p>
                                    @else
                                        <p class="text-sm text-gray-500">
                                            Sei sicuro di voler eliminare questo modello? Questa azione non può essere annullata.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        @if(!$deleteError)
                            <button type="button" 
                                    wire:click="deleteModel" 
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
