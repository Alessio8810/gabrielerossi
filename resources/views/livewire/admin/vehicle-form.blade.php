<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $vehicleId ? 'Modifica Veicolo' : 'Nuovo Veicolo' }}
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $vehicleId ? 'Modifica i dettagli del veicolo' : 'Aggiungi un nuovo veicolo al tuo centro auto' }}
                </p>
            </div>
            <a href="{{ route('admin.vehicles') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
               wire:navigate>
                <i class="fas fa-arrow-left mr-2"></i>
                Torna alla Lista
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Informazioni Generali</h3>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titolo *</label>
                    <input type="text" 
                           wire:model="title" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500"
                           placeholder="Es. BMW Serie 3 2020">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Marca *</label>
                    <select wire:model.live="brand_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="">Seleziona marca</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Model -->
                <div>
                    <label for="car_model_id" class="block text-sm font-medium text-gray-700 mb-1">Modello *</label>
                    <select wire:model="car_model_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500"
                            {{ !$brand_id ? 'disabled' : '' }}>
                        <option value="">Seleziona modello</option>
                        @foreach($carModels as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                        @endforeach
                    </select>
                    @error('car_model_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Anno *</label>
                    <input type="number" 
                           wire:model="year" 
                           min="1990" 
                           max="2030"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('year') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Mileage -->
                <div>
                    <label for="mileage" class="block text-sm font-medium text-gray-700 mb-1">Chilometraggio *</label>
                    <input type="number" 
                           wire:model="mileage" 
                           min="0"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('mileage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Prezzo (€) *</label>
                    <input type="number" 
                           wire:model="price" 
                           min="0" 
                           step="0.01"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condizione *</label>
                    <select wire:model="condition" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="new">Nuovo</option>
                        <option value="used">Usato</option>
                    </select>
                    @error('condition') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrizione</label>
                    <textarea wire:model="description" 
                              rows="4"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500"
                              placeholder="Descrizione dettagliata del veicolo..."></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Dettagli Tecnici</h3>
            </div>
            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fuel Type -->
                <div>
                    <label for="fuel_type" class="block text-sm font-medium text-gray-700 mb-1">Carburante *</label>
                    <select wire:model="fuel_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="gasoline">Benzina</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Elettrico</option>
                        <option value="hybrid">Ibrido</option>
                    </select>
                    @error('fuel_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Transmission -->
                <div>
                    <label for="transmission" class="block text-sm font-medium text-gray-700 mb-1">Cambio *</label>
                    <select wire:model="transmission" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="Manuale">Manuale</option>
                        <option value="Automatico">Automatico</option>
                        <option value="Semiautomatico">Semiautomatico</option>
                    </select>
                    @error('transmission') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Body Type -->
                <div>
                    <label for="body_type" class="block text-sm font-medium text-gray-700 mb-1">Tipo Carrozzeria</label>
                    <select wire:model="body_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                        <option value="">Seleziona tipo</option>
                        <option value="Berlina">Berlina</option>
                        <option value="Station Wagon">Station Wagon</option>
                        <option value="SUV">SUV</option>
                        <option value="Coupé">Coupé</option>
                        <option value="Cabriolet">Cabriolet</option>
                        <option value="Hatchback">Hatchback</option>
                    </select>
                    @error('body_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Colore</label>
                    <input type="text" 
                           wire:model="color"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500"
                           placeholder="Es. Bianco">
                    @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Immagini</h3>
            </div>
            <div class="px-6 py-4">
                <!-- Existing Images -->
                @if(count($images) > 0)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Immagini Attuali</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($this->formatted_images as $index => $image)
                                <div class="relative">
                                    <img src="{{ $image }}" alt="Vehicle Image" class="w-full h-24 object-cover rounded-lg">
                                    <button type="button" 
                                            wire:click="removeImage({{ $index }})"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- New Images -->
                <div>
                    <label for="newImages" class="block text-sm font-medium text-gray-700 mb-1">Nuove Immagini</label>
                    <input type="file" 
                           wire:model="newImages" 
                           multiple 
                           accept="image/*"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    @error('newImages.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    
                    <!-- Preview New Images -->
                    @if($newImages)
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($newImages as $index => $image)
                                <div class="relative">
                                    <img src="{{ $image->temporaryUrl() }}" alt="New Image" class="w-full h-24 object-cover rounded-lg">
                                    <button type="button" 
                                            wire:click="removeNewImage({{ $index }})"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Impostazioni</h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" 
                           wire:model="is_active" 
                           class="rounded border-gray-300 text-gold-600 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <label class="ml-2 text-sm text-gray-700">Veicolo attivo (visibile sul sito)</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           wire:model="is_featured" 
                           class="rounded border-gray-300 text-gold-600 shadow-sm focus:border-gold-500 focus:ring-gold-500">
                    <label class="ml-2 text-sm text-gray-700">In evidenza (mostrato in homepage)</label>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.vehicles') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 transition ease-in-out duration-150"
               wire:navigate>
                Annulla
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gold-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gold-600 active:bg-elegant-900 focus:outline-none focus:border-gold-700 focus:ring focus:ring-gold-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-save mr-2"></i>
                {{ $vehicleId ? 'Aggiorna' : 'Salva' }}
            </button>
        </div>
    </form>
</div>

