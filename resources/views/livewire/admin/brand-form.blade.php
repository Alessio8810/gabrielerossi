<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.brands') }}" 
                   class="text-gray-600 hover:text-gray-900 mr-4"
                   wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-tag mr-2 text-gold-500"></i>
                    {{ $isEditing ? 'Modifica Marchio' : 'Nuovo Marchio' }}
                </h1>
            </div>
            <p class="text-gray-600">
                {{ $isEditing ? 'Aggiorna le informazioni del marchio' : 'Crea un nuovo marchio di veicoli' }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form wire:submit.prevent="save">
                <!-- Nome -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome Marchio <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           wire:model.live="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Es. BMW, Mercedes-Benz, Audi">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Lo slug verrà generato automaticamente dal nome
                    </p>
                </div>

                <!-- Slug -->
                <div class="mb-6">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="slug"
                           wire:model="slug"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                           placeholder="es. bmw, mercedes-benz">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Solo lettere minuscole, numeri e trattini. Deve essere unico.
                    </p>
                </div>

                <!-- Descrizione -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrizione
                    </label>
                    <textarea id="description"
                              wire:model="description"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Descrizione del marchio (opzionale)"></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Massimo 1000 caratteri</p>
                </div>

                <!-- Logo Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Logo Marchio
                    </label>
                    
                    <!-- Preview Logo Esistente o Nuovo -->
                    <div class="mb-4">
                        @if($logo)
                            <div class="relative inline-block">
                                <img src="{{ $logo->temporaryUrl() }}" 
                                     alt="Anteprima logo" 
                                     class="h-24 w-24 object-contain border-2 border-gold-500 rounded-lg p-2 bg-white">
                                <button type="button" 
                                        wire:click="$set('logo', null)"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full h-6 w-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        @elseif($existingLogo)
                            <div class="relative inline-block">
                                <img src="{{ Storage::url($existingLogo) }}" 
                                     alt="Logo attuale" 
                                     class="h-24 w-24 object-contain border-2 border-gray-300 rounded-lg p-2 bg-white">
                                <p class="text-xs text-gray-500 mt-2">Logo attuale</p>
                            </div>
                        @else
                            <div class="h-24 w-24 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- File Input -->
                    <div class="flex items-center">
                        <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            {{ $logo || $existingLogo ? 'Cambia Logo' : 'Carica Logo' }}
                        </label>
                        <input type="file" 
                               id="logo" 
                               wire:model="logo" 
                               accept="image/*"
                               class="hidden">
                        
                        @if($logo || $existingLogo)
                            <button type="button"
                                    wire:click="$set('logo', null); $set('existingLogo', null)"
                                    class="ml-3 text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-trash mr-1"></i>
                                Rimuovi
                            </button>
                        @endif
                    </div>
                    
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Formati supportati: JPG, PNG. Dimensione massima: 2MB.
                    </p>
                    
                    <div wire:loading wire:target="logo" class="mt-2">
                        <div class="flex items-center text-gold-600">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            <span class="text-sm">Caricamento in corso...</span>
                        </div>
                    </div>
                </div>

                <!-- Stato Attivo -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               wire:model="is_active"
                               class="w-5 h-5 text-gold-500 border-gray-300 rounded focus:ring-gold-500">
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            Marchio attivo
                        </span>
                    </label>
                    <p class="ml-8 text-xs text-gray-500">
                        I marchi disattivati non saranno visibili nelle selezioni pubbliche
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
                                    <li>Il nome del marchio deve essere univoco</li>
                                    <li>Lo slug viene generato automaticamente ma può essere modificato</li>
                                    <li>Il logo è opzionale ma consigliato per una migliore presentazione</li>
                                    @if($isEditing)
                                        <li class="text-red-600">Non è possibile eliminare marchi con veicoli associati</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.brands') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                       wire:navigate>
                        <i class="fas fa-times mr-2"></i>
                        Annulla
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                            wire:target="save, logo">
                        <i class="fas fa-save mr-2"></i>
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditing ? 'Aggiorna Marchio' : 'Crea Marchio' }}
                        </span>
                        <span wire:loading wire:target="save">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Salvataggio...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
