<x-guest-layout>
    <div class="relative">
        <!-- Éléments graphiques technologiques en arrière-plan -->
        <div class="absolute right-4 top-4 w-20 h-20 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full filter blur-xl opacity-40"></div>
        <div class="absolute -left-10 bottom-20 w-28 h-28 bg-gradient-to-tr from-blue-400 to-cyan-500 rounded-full filter blur-xl opacity-30"></div>
        
        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}" class="relative z-10">
            @csrf

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                {{ __('Connexion') }}
            </h2>

            <!-- Circuit design element -->
            <div class="absolute right-0 top-0 h-16 w-20 opacity-20">
                <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" class="text-gray-500">
                    <circle cx="50" cy="50" r="3" fill="currentColor"/>
                    <circle cx="70" cy="30" r="3" fill="currentColor"/>
                    <circle cx="30" cy="70" r="3" fill="currentColor"/>
                    <path d="M50 50 L70 30" stroke="currentColor" stroke-width="1"/>
                    <path d="M50 50 L30 70" stroke="currentColor" stroke-width="1"/>
                    <path d="M50 50 L70 70" stroke="currentColor" stroke-width="1"/>
                    <circle cx="70" cy="70" r="3" fill="currentColor"/>
                </svg>
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700">
                    {{ __('Connexion') }}
                </x-primary-button>
            </div>
            
            <!-- Lien d'inscription -->
            <div class="text-center mt-6">
                <span class="text-sm text-gray-600">{{ __('Vous n\'avez pas de compte?') }}</span>
                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:text-blue-800 ml-1 font-semibold">
                    {{ __('Créer un compte') }}
                </a>
            </div>
        </form>

        <!-- Wave decoration at bottom -->
        <div class="mt-8 opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="text-gray-200">
                <path fill="currentColor" fill-opacity="1" d="M0,160L40,154.7C80,149,160,139,240,154.7C320,171,400,213,480,213.3C560,213,640,171,720,165.3C800,160,880,192,960,197.3C1040,203,1120,181,1200,154.7C1280,128,1360,96,1400,80L1440,64L1440,320L1400,320C1360,320,1280,320,1200,320C1120,320,1040,320,960,320C880,320,800,320,720,320C640,320,560,320,480,320C400,320,320,320,240,320C160,320,80,320,40,320L0,320Z"></path>
            </svg>
        </div>
    </div>
</x-guest-layout>