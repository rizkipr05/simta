            <!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIMTA') — Sistem Informasi Manajemen Skripsi &amp; Yudisium FT UMMU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link.active { 
            background: linear-gradient(135deg, #059669, #047857) !important; 
            color: #ffffff !important; 
            box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35); 
            border-left: 4px solid #facc15;
            font-weight: 700 !important;
        }
        .sidebar-link:not(.active):hover { 
            background: rgba(255, 255, 255, 0.08) !important; 
            color: #ffffff !important;
        }
        .status-badge { 
            display: inline-flex; 
            align-items: center; 
            gap: 4px; 
            font-size: 0.75rem; 
            font-weight: 700; 
            padding: 4px 12px; 
            border-radius: 999px; 
            letter-spacing: 0.02em; 
        }
        /* Fix form field spacing and prevent text overlap */
        label { display: block; margin-bottom: 0.375rem; }
        input[type="text"], input[type="email"], input[type="password"], input[type="number"], input[type="date"], input[type="datetime-local"], select, textarea {
            box-sizing: border-box;
            line-height: 1.25;
            padding-top: 0.6rem;
            padding-bottom: 0.6rem;
            min-height: 2.5rem;
        }
        input[type="checkbox"], input[type="radio"] {
            min-height: auto !important;
            padding: 0 !important;
        }
        /* Ensure buttons have consistent line-height */
        button, .btn { line-height: 1.2; }
        /* Prevent very long text from overflowing sidebar items */
        .sidebar-nav a { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        /* Checkbox row helper to keep checkbox and label aligned */
        .form-checkbox-row { display:flex; align-items:center; gap:0.5rem; padding-left:1rem; }
        .form-checkbox-row label { margin:0; }
    </style>
</head>
<body class="h-full bg-slate-100 text-slate-800 antialiased" x-data="{ sidebarOpen: true, mobileOpen: false }">

<div class="flex h-screen overflow-hidden">
    {{-- ELEGANT DARK NAVY SIDEBAR --}}
    <div x-show="mobileOpen" @click="mobileOpen = false"
         class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm lg:hidden"
         x-transition:enter="transition duration-200" x-transition:leave="transition duration-200"></div>

    <aside :class="sidebarOpen ? 'w-64' : 'w-[76px]'"
           class="fixed inset-y-0 left-0 z-30 flex-shrink-0 flex flex-col bg-[#0f172a] text-slate-300 transition-all duration-300 ease-in-out lg:relative shadow-2xl border-r border-slate-800">

        {{-- SIDEBAR BRAND HEADER --}}
        <div class="flex h-16 items-center px-4 border-b border-slate-800 bg-[#090d16]">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl bg-white p-1 flex items-center justify-center flex-shrink-0 shadow-md">
                    <img src="{{ asset('asset/logo.png') }}" class="w-full h-full object-contain" alt="Logo UMMU">
                </div>
                <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                    <p class="font-extrabold text-white text-base tracking-wide leading-tight">SIMTA UMMU</p>
                    <p class="text-emerald-400 text-[10px] font-bold tracking-wider uppercase leading-tight">Fakultas Teknik</p>
                </div>
            </div>
        </div>

        {{-- SIDEBAR NAVIGATION LINKS --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
            @include('components.sidebar-nav')
        </nav>

        {{-- USER FOOTER PROFILE --}}
        <div class="p-3.5 border-t border-slate-800 bg-[#090d16]">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ auth()->user()->avatar_url }}" class="w-9 h-9 rounded-full flex-shrink-0 object-cover ring-2 ring-emerald-500" alt="">
                <div x-show="sidebarOpen" x-transition class="overflow-hidden flex-1 min-w-0">
                    <p class="text-white text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-emerald-400 text-xs font-semibold truncate">{{ auth()->user()->getRoleLabel() }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="flex-1 flex flex-col overflow-hidden bg-slate-100">
        {{-- UMMU CAMPUS TOPBAR STRIP --}}
        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white text-xs py-2 px-5 hidden sm:flex items-center justify-between border-b border-emerald-900 shadow-sm">
            <div class="flex items-center gap-5 font-semibold text-emerald-100">
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Kel. Sasa, Ternate Selatan</span>
                <span class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> ummuternate@ummu.ac.id</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-yellow-400 text-slate-950 font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wider shadow">UNIVERSITAS MUHAMMADIYAH MALUKU UTARA</span>
            </div>
        </div>

        {{-- MAIN HEADER --}}
        <header class="h-16 flex-shrink-0 bg-white border-b border-slate-200/80 flex items-center px-6 gap-4 shadow-sm z-10">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-600 hover:text-emerald-700 transition-colors p-2 rounded-xl hover:bg-slate-100 border border-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex-1 font-bold text-slate-800 text-sm">
                @yield('breadcrumb', 'Portal Akademik Skripsi & Yudisium')
            </div>

            {{-- USER DROPDOWN --}}
            <div class="flex items-center gap-3">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-3 px-3.5 py-1.5 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 transition shadow-sm">
                        <img src="{{ auth()->user()->avatar_url }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-emerald-600" alt="">
                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-emerald-700 font-bold leading-tight uppercase tracking-wider">{{ auth()->user()->getRoleLabel() }}</p>
                        </div>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false"
                         x-transition class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100 bg-emerald-50/60">
                            <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                            <span class="inline-block mt-1 text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-700 text-white shadow-sm">{{ auth()->user()->getRoleLabel() }}</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-700 transition">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT CONTAINER --}}
        <main class="flex-1 overflow-y-auto p-6 lg:p-8 bg-slate-100">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-2xl flex items-center gap-3 shadow-sm"
                     x-data="{show:true}" x-show="show" x-transition>
                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold flex-shrink-0">✓</div>
                    <span class="text-sm font-semibold flex-1">{{ session('success') }}</span>
                    <button @click="show=false" class="text-emerald-700 hover:text-emerald-900 font-bold">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-900 rounded-2xl flex items-center gap-3 shadow-sm"
                     x-data="{show:true}" x-show="show" x-transition>
                    <div class="w-8 h-8 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold flex-shrink-0">✕</div>
                    <span class="text-sm font-semibold flex-1">{{ session('error') }}</span>
                    <button @click="show=false" class="text-rose-700 hover:text-rose-900 font-bold">✕</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('modals')
@stack('scripts')
</body>
</html>
