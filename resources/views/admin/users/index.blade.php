@extends("layouts.app")
@section("title", "Manajemen User & Role")
@section("breadcrumb", "Manajemen User")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Manajemen User &amp; Role</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data pengguna, penetapan role, dan reset password sistem SIMTA</p>
        </div>
        <button onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md shadow-emerald-600/20 transition-all flex items-center justify-center gap-2 w-full md:w-auto mt-2 md:mt-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User Baru
        </button>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row w-full items-center gap-3 md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email..." class="px-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none w-full md:w-64">
            <div class="flex w-full md:w-auto gap-3">
                <select name="role" class="px-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none flex-1 md:flex-none">
                    <option value="">Semua Role</option>
                    <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="kaprodi" {{ request('role') == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="dekan" {{ request('role') == 'dekan' ? 'selected' : '' }}>Dekan</option>
                    <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-700 transition-all">Filter</button>
            </div>
        </form>
    </div>

    {{-- Data User --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        
        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Nama &amp; Email</th>
                        <th class="px-6 py-3.5">Role</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-extrabold text-slate-900 text-sm">{{ $u->name }}</p>
                            <p class="text-slate-500 text-[11px]">{{ $u->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border bg-emerald-50 text-emerald-700 border-emerald-200">
                                {{ str_replace('_', ' ', $u->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button type="button" onclick="document.getElementById('modalEditUser-{{ $u->id }}').classList.remove('hidden')" class="px-3 py-1.5 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-lg transition-all">Edit</button>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded-lg transition-all">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-slate-400 font-semibold">Tidak ada data user ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile List --}}
        <div class="block md:hidden divide-y divide-slate-100">
            @forelse($users as $u)
            <div class="p-4 space-y-3 hover:bg-slate-50 transition-colors">
                <div class="flex justify-between items-start gap-4">
                    <div class="truncate">
                        <p class="font-extrabold text-slate-900 text-sm truncate">{{ $u->name }}</p>
                        <p class="text-slate-500 text-[11px] truncate">{{ $u->email }}</p>
                    </div>
                    <span class="shrink-0 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border bg-emerald-50 text-emerald-700 border-emerald-200">
                        {{ str_replace('_', ' ', $u->role) }}
                    </span>
                </div>
                
                <div class="flex justify-end gap-2 pt-2 border-t border-slate-50">
                    <button type="button" onclick="document.getElementById('modalEditUser-{{ $u->id }}').classList.remove('hidden')" class="px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold rounded-xl transition-all flex-1 md:flex-none">Edit</button>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline flex-1 md:flex-none" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-bold rounded-xl transition-all">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-400 font-semibold text-xs">
                Tidak ada data user ditemukan.
            </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    </div>
</div>

{{-- Modals Container --}}
@foreach($users as $u)
{{-- Modal Edit User --}}
<div id="modalEditUser-{{ $u->id }}" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4 text-left">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-extrabold text-slate-900 text-base">Edit User</h3>
            <button type="button" onclick="document.getElementById('modalEditUser-{{ $u->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.users.update', $u) }}" class="space-y-3 text-xs">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Lengkap *</label>
                <input type="text" name="name" value="{{ $u->name }}" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Email *</label>
                <input type="email" name="email" value="{{ $u->email }}" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Role *</label>
                <select name="role" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="super_admin" {{ $u->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="pengelola_skripsi" {{ $u->role === 'pengelola_skripsi' ? 'selected' : '' }}>Pengelola Skripsi</option>
                    <option value="kaprodi" {{ $u->role === 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                    <option value="dekan" {{ $u->role === 'dekan' ? 'selected' : '' }}>Dekan</option>
                    <option value="dosen" {{ $u->role === 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ $u->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modalEditUser-{{ $u->id }}').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl shadow-md">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- Modal Tambah User --}}
<div id="modalTambahUser" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b pb-3">
            <h3 class="font-extrabold text-slate-900 text-base">Tambah User Baru</h3>
            <button onclick="document.getElementById('modalTambahUser').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-3 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Nama Lengkap *</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Email *</label>
                <input type="email" name="email" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Password *</label>
                <input type="password" name="password" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>
            <div>
                <label class="block font-bold text-slate-700 uppercase mb-1">Role *</label>
                <select name="role" required class="w-full px-3.5 py-2 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="super_admin">Super Admin</option>
                    <option value="pengelola_skripsi">Pengelola Skripsi</option>
                    <option value="kaprodi">Kaprodi</option>
                    <option value="dekan">Dekan</option>
                    <option value="dosen">Dosen</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('modalTambahUser').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold rounded-xl">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white font-bold rounded-xl shadow-md">Simpan User</button>
            </div>
        </form>
    </div>
</div>
@endsection
