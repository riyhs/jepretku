<x-guest-layout>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="flex-col">
            <p class="text-center font-bold text-3xl">Hello Admin!</p>
            <p class="text-center mt-4 text-sm mb-5">Yuk Cek Daftar User dan Lihat Kunjungan</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-col items-end space-y-2 mt-4 sm:flex-row sm:items-center sm:justify-end sm:space-y-0">
            <x-primary-button
                class="w-full sm:w-auto bg-red-800 justify-center py-3 text-white hover:bg-orange-600 sm:ms-4">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>