<x-guest-layout>
<div class="min-h-screen flex flex-col justify-between bg-slate-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="flex-1 flex items-center justify-center">
        <div class="w-full max-w-md space-y-6" x-data="{
            email: '{{ old('email', '') }}',
            password: '',
            showPass: false
        }">
            {{-- BRAND HEADER --}}
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white p-2 shadow-lg ring-4 ring-emerald-100 mx-auto mb-2">
                    <img src="{{ asset('asset/logo.png') }}" class="w-full h-full object-contain" alt="Logo UMMU">
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">SIMTA UMMU</h1>
                <p class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Sistem Informasi Skripsi &amp; Yudisium</p>
                <p class="text-xs text-slate-500">Fakultas Teknik · Universitas Muhammadiyah Maluku Utara</p>
            </div>

            {{-- MAIN LOGIN CARD --}}
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-200/80 space-y-6">
                <div class="border-b border-slate-100 pb-4">
                    <h2 class="text-lg font-bold text-slate-900">Masuk ke Akun Anda</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gunakan akun resmi civitas akademika UMMU</p>
                </div>

                {{-- ERRORS --}}
                @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                    <div class="font-bold text-rose-900">Gagal Masuk:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- LOGIN FORM --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
                        <input id="email" type="text" name="email" x-model="email" required autofocus
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Password</label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-emerald-700 font-bold hover:underline">Lupa Password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password" x-model="password" required
                                   class="w-full px-4 pr-16 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all"
                                   placeholder="••••••••">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-800 text-xs font-bold">
                                <span x-show="!showPass" class="text-emerald-700">Lihat</span>
                                <span x-show="showPass" class="text-slate-500">Sembunyi</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="form-checkbox-row cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="text-xs text-slate-600 font-medium">Ingat Saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/20 transition-all duration-150 flex items-center justify-center gap-2 mt-2">
                        <span>MASUK PORTAL SIMTA</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="text-center text-xs text-slate-500 font-medium py-4">
        &copy; {{ date('Y') }} Universitas Muhammadiyah Maluku Utara · Fakultas Teknik Ternate
    </div>
</div>
</x-guest-layout>
