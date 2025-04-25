<x-guest-layout>
    <div class="relative">
        <!-- Éléments graphiques technologiques en arrière-plan -->
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-gradient-to-br from-blue-400 to-cyan-300 rounded-full filter blur-xl opacity-50"></div>
        <div class="absolute -left-8 bottom-10 w-32 h-32 bg-gradient-to-tr from-purple-400 to-blue-300 rounded-full filter blur-xl opacity-40"></div>
        
        <!-- Formulaire d'inscription -->
        <form method="POST" action="{{ route('register') }}" class="relative z-10">
            @csrf

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ __('Créer un compte') }}
            </h2>

            <!-- Nom -->
            <div>
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Éléments de sécurité graphiques -->
            <div class="relative mt-6 mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">{{ __('Sécurité') }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Déjà inscrit?') }}
                </a>
            
                <x-primary-button class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Motif technologique décoratif en bas -->
        <div class="mt-8 opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="text-gray-200">
                <path fill="currentColor" fill-opacity="1" d="M0,256L48,240C96,224,192,192,288,181.3C384,171,480,181,576,186.7C672,192,768,192,864,170.7C960,149,1056,107,1152,117.3C1248,128,1344,192,1392,224L1440,256L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </div>
</x-guest-layout>