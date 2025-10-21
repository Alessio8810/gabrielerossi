<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gold-600 hover:text-elegant-800" wire:navigate>Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('vehicles') }}" class="text-gold-600 hover:text-elegant-800" wire:navigate>Veicoli</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-600">{{ $vehicle->title }}</span>
            </nav>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Galleria Immagini -->
                <div class="p-6">
                    <!-- Immagine Principale -->
                    <div class="mb-4">
                        @if($vehicle->images && count($vehicle->images) > 0)
                            <img src="{{ $vehicle->images[$selectedImage] }}" 
                                 alt="{{ $vehicle->title }}" 
                                 class="w-full h-96 object-cover rounded-lg shadow-md">
                        @else
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-car text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if($vehicle->images && count($vehicle->images) > 1)
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($vehicle->images as $index => $image)
                                <button wire:click="selectImage({{ $index }})" 
                                        class="focus:outline-none {{ $selectedImage === $index ? 'ring-2 ring-gold-600' : '' }}">
                                    <img src="{{ $image }}" 
                                         alt="Thumbnail {{ $index + 1 }}" 
                                         class="w-full h-20 object-cover rounded-md hover:opacity-75 transition-opacity">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Badges -->
                    <div class="flex flex-wrap gap-2 mt-6">
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $vehicle->condition === 'new' ? 'bg-green-100 text-green-800' : 'bg-gold-100 text-elegant-800' }}">
                            <i class="fas fa-{{ $vehicle->condition === 'new' ? 'star' : 'certificate' }} mr-2"></i>
                            {{ $vehicle->condition === 'new' ? 'Nuovo' : 'Usato' }}
                        </span>
                        @if($vehicle->is_featured)
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-star mr-2"></i>
                                In Evidenza
                            </span>
                        @endif
                        @if($vehicle->is_active)
                            <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Disponibile
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Informazioni Veicolo -->
                <div class="p-6">
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $vehicle->title }}</h1>
                    <p class="text-xl text-gray-600 mb-6">
                        {{ $vehicle->brand->name }} {{ $vehicle->carModel->name }}
                    </p>

                    <!-- Prezzo -->
                    <div class="mb-8 p-6 bg-gold-50 rounded-lg">
                        <div class="text-sm text-gray-600 mb-1">Prezzo</div>
                        <div class="text-5xl font-bold text-gold-600">{{ $vehicle->formatted_price }}</div>
                    </div>

                    <!-- Specifiche Principali -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-calendar text-2xl text-gold-600 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-600">Anno</div>
                                <div class="text-lg font-semibold">{{ $vehicle->year }}</div>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-road text-2xl text-gold-600 mr-3"></i>
                            <div>
                                <div class="text-sm text-gray-600">Chilometraggio</div>
                                <div class="text-lg font-semibold">{{ number_format($vehicle->mileage) }} km</div>
                            </div>
                        </div>

                        @if($vehicle->fuel_type)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-gas-pump text-2xl text-gold-600 mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Carburante</div>
                                    <div class="text-lg font-semibold">{{ ucfirst($vehicle->fuel_type) }}</div>
                                </div>
                            </div>
                        @endif

                        @if($vehicle->transmission)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-cogs text-2xl text-gold-600 mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Cambio</div>
                                    <div class="text-lg font-semibold">{{ $vehicle->transmission }}</div>
                                </div>
                            </div>
                        @endif

                        @if($vehicle->body_type)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-car-side text-2xl text-gold-600 mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Carrozzeria</div>
                                    <div class="text-lg font-semibold">{{ $vehicle->body_type }}</div>
                                </div>
                            </div>
                        @endif

                        @if($vehicle->color)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <i class="fas fa-palette text-2xl text-gold-600 mr-3"></i>
                                <div>
                                    <div class="text-sm text-gray-600">Colore</div>
                                    <div class="text-lg font-semibold">{{ $vehicle->color }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pulsanti Azione -->
                    <div class="space-y-3">
                        <button class="w-full bg-gold-500 text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-gold-600 transition-colors duration-200 flex items-center justify-center">
                            <i class="fas fa-phone mr-2"></i>
                            Contattaci per Info
                        </button>
                        <button class="w-full bg-green-600 text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Chatta su WhatsApp
                        </button>
                    </div>
                </div>
            </div>

            <!-- Descrizione -->
            @if($vehicle->description)
                <div class="p-6 border-t">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-info-circle text-gold-600 mr-2"></i>
                        Descrizione
                    </h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $vehicle->description }}</p>
                </div>
            @endif

            <!-- Caratteristiche Aggiuntive -->
            <div class="p-6 border-t bg-gray-50">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <i class="fas fa-list-check text-gold-600 mr-2"></i>
                    Caratteristiche
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span>Marca: {{ $vehicle->brand->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span>Modello: {{ $vehicle->carModel->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span>Anno: {{ $vehicle->year }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        <span>Km: {{ number_format($vehicle->mileage) }}</span>
                    </div>
                    @if($vehicle->fuel_type)
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span>Alimentazione: {{ ucfirst($vehicle->fuel_type) }}</span>
                        </div>
                    @endif
                    @if($vehicle->transmission)
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span>Cambio: {{ $vehicle->transmission }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pulsante Torna alla Lista -->
            <div class="p-6 border-t">
                <a href="{{ route('vehicles') }}" 
                   class="inline-flex items-center text-gold-600 hover:text-elegant-800 font-medium"
                   wire:navigate>
                    <i class="fas fa-arrow-left mr-2"></i>
                    Torna alla lista veicoli
                </a>
            </div>
        </div>
    </div>
</div>


