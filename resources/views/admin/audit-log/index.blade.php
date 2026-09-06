@extends("layouts.app")
@section("title", "Audit Log System")
@section("breadcrumb", "Audit Log")

@section("content")
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Audit Log Aktivitas Sistem</h1>
            <p class="text-xs text-slate-500 mt-1">Catatan histori aktivitas user, perubahan data, dan timestamp akses SIMTA</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.audit-log.index') }}" class="flex items-center gap-3 w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas, user, atau modul..." class="px-4 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none w-full md:w-64">
            <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-700 transition-all">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Waktu</th>
                        <th class="px-6 py-3.5">User</th>
                        <th class="px-6 py-3.5">Aktivitas</th>
                        <th class="px-6 py-3.5">Modul</th>
                        <th class="px-6 py-3.5">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $l)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-mono text-slate-500 text-[11px]">
                            {{ $l->created_at ? $l->created_at->format('Y-m-d H:i:s') : '-' }}
                        </td>
                        <td class="px-6 py-4 font-extrabold text-slate-900">
                            {{ $l->user->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            {{ $l->action }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border bg-slate-100 text-slate-700 border-slate-200">
                                {{ class_basename($l->model_type ?? 'System') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-500 text-[11px]">
                            {{ $l->ip_address ?? '127.0.0.1' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-semibold">Belum ada log aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
