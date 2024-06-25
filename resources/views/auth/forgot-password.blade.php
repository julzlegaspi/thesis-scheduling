<x-guest-layout>
    <h2 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">
        Forgot your password?
    </h2>
    <p class="text-base font-normal text-gray-500 dark:text-gray-400">
        Don't fret! Just type in your email and we will send you a code to reset your password!
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- //TODO TAC --}}
        {{-- <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600" required>
            </div>
            <div class="ml-3 text-sm">
                <label for="remember" class="font-medium text-gray-900 dark:text-white">I accept the <a href="#" class="text-blue-700 hover:underline dark:text-blue-500">Terms and Conditions</a></label>
            </div>
        </div> --}}

        <x-primary-button>
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </form>
</x-guest-layout>
