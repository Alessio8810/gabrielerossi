<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.users') }}" 
                   class="text-gray-600 hover:text-gray-900 mr-4"
                   wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">
                    <i class="fas fa-user mr-2 text-gold-500"></i>
                    {{ $isEditing ? 'Modifica Utente' : 'Nuovo Utente' }}
                </h1>
            </div>
            <p class="text-gray-600">
                {{ $isEditing ? 'Aggiorna le informazioni dell\'utente' : 'Crea un nuovo account utente' }}
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form wire:submit.prevent="save">
                <!-- Nome -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome Completo <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name"
                           wire:model="name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Es. Mario Rossi">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email"
                           wire:model="email"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('email') border-red-500 @enderror"
                           placeholder="utente@esempio.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password 
                        @if(!$isEditing)
                            <span class="text-red-500">*</span>
                        @else
                            <span class="text-gray-500 text-xs">(Lascia vuoto per non modificarla)</span>
                        @endif
                    </label>
                    <input type="password" 
                           id="password"
                           wire:model="password"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent @error('password') border-red-500 @enderror"
                           placeholder="Minimo 8 caratteri">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Conferma Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Conferma Password
                        @if(!$isEditing)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <input type="password" 
                           id="password_confirmation"
                           wire:model="password_confirmation"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold-500 focus:border-transparent"
                           placeholder="Ripeti la password">
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informazioni</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>L'utente riceverà un'email con le credenziali di accesso</li>
                                    <li>La password deve contenere almeno 8 caratteri</li>
                                    <li>L'email deve essere univoca nel sistema</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.users') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200"
                       wire:navigate>
                        <i class="fas fa-times mr-2"></i>
                        Annulla
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gold-500 text-white rounded-lg hover:bg-gold-600 transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isEditing ? 'Aggiorna Utente' : 'Crea Utente' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
