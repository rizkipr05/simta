<section class="space-y-4">
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun Ini') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-white space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-base font-extrabold text-slate-900">
                {{ __('Konfirmasi Penghapusan Akun') }}
            </h2>

            <p class="text-xs text-slate-500">
                {{ __('Apakah Anda yakin ingin menghapus akun Anda? Masukkan kata sandi Anda untuk mengonfirmasi.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Kata Sandi') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Kata Sandi') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-xs text-rose-600" />
            </div>

            <div class="flex justify-end gap-3 pt-3 border-t border-slate-100">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Ya, Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
