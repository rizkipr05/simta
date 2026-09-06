<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h1 class="text-xl font-extrabold text-slate-900">Lupa Password?</h1>
            <p class="text-sm text-slate-500 mt-2 mb-4">Tidak masalah — masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset password.</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end">
                    <x-primary-button>
                        KIRIM TAUTAN RESET PASSWORD
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
