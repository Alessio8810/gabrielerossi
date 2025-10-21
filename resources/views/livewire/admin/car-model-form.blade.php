<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.models') }}" 
                   class="text-gray-600 hover:text-gray-900 mr-4"
                   wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-car-side mr-2 text-gold-500"></i>
                    {{ $isEditing ? 'Modifica Modello' : 'Nuovo Modello' }}
                </h1>
            </div>
            <p class="text-gray-600">
                {{ $isEditing ? 'Aggiorna le informazioni del modello' : 'Crea un nuovo modello di veicolo' }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form wire:submit.prevent="save">
                <!-- Marchio -->
                <div class="mb-6">
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Marchio <span class="text-red-500">*</span>
                    </label>
                    <select id="brand_id"
                            wire:model="brand_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('brand_id') border-red-500 @enderror">
                        <option value="">-- Seleziona un marchio --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Se il marchio non esiste, 
                        <a href="{{ route('admin.brands.create') }}" 
                           class="text-gold-600 hover:text-gold-800 underline"
                           wire:navigate>
                            crealo prima qui
                        </a>
                    </p>
                </div>

                <!-- Nome Modello -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome Modello <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           wire:model="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Es. Serie 3, Classe C, Golf">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Il nome del modello deve essere univoco per il marchio selezionato
                    </p>
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informazioni Importanti</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ogni modello deve essere associato a un marchio</li>
                                    <li>Lo stesso nome può esistere per marchi diversi (es. "Golf" per VW e "Golf" per... nessun altro)</li>
                                    <li>Il nome del modello è case-sensitive</li>
                                    @if($isEditing)
                                        <li class="text-red-600">Non è possibile eliminare modelli con veicoli associati</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Example Preview -->
                @if($brand_id && $name)
                    <div class="mb-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-eye text-gray-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-600 mb-1">Anteprima:</p>
                                <p class="text-lg font-bold text-gray-900">
                                    {{ $brands->firstWhere('id', $brand_id)?->name ?? '' }} {{ $name }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.models') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                       wire:navigate>
                        <i class="fas fa-times mr-2"></i>
                        Annulla
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isEditing ? 'Aggiorna Modello' : 'Crea Modello' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Brand Creation (Optional) -->
        @if(!$isEditing && count($brands) === 0)
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Nessun Marchio Disponibile</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Non ci sono marchi attivi nel sistema. Devi prima creare un marchio per poter aggiungere modelli.</p>
                            <a href="{{ route('admin.brands.create') }}" 
                               class="mt-2 inline-flex items-center text-yellow-800 hover:text-yellow-900 font-medium"
                               wire:navigate>
                                <i class="fas fa-plus mr-2"></i>
                                Crea il primo marchio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
