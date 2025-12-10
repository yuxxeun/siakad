<x-app-layout>
    <x-slot name="header">
        Data Mahasiswa
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-sm text-siakad-secondary">Kelola data mahasiswa dalam sistem</p>
        </div>
        <form method="GET" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." class="input-saas px-4 py-2 text-sm w-64">
            <select name="prodi" class="input-saas px-4 py-2 text-sm">
                <option value="">Semua Prodi</option>
                @foreach($prodiList as $p)
                <option value="{{ $p->id }}" {{ request('prodi') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary-saas px-4 py-2 rounded-lg text-sm font-medium">Filter</button>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card-saas overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-saas">
                <thead>
                    <tr class="bg-siakad-light/30">
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider w-16">#</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Mahasiswa</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">NIM</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Prodi</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Angkatan</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">IPK</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Status</th>
                        <th class="text-right py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswa as $index => $m)
                    <tr class="border-b border-siakad-light/50">
                        <td class="py-4 px-5 text-sm text-siakad-secondary">{{ $mahasiswa->firstItem() + $index }}</td>
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-siakad-primary flex items-center justify-center text-white text-sm font-semibold">
                                    {{ strtoupper(substr($m->user->name ?? '-', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-siakad-dark">{{ $m->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-sm font-mono text-siakad-secondary">{{ $m->nim }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-sm text-siakad-secondary">{{ $m->prodi->nama ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-siakad-secondary/10 text-siakad-secondary rounded-full">{{ $m->angkatan }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-sm font-semibold text-siakad-primary">{{ number_format($m->ipk ?? 0, 2) }}</span>
                        </td>
                        <td class="py-4 px-5">
                            @if($m->status === 'aktif')
                            <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold bg-emerald-100 text-emerald-700 rounded-full">Aktif</span>
                            @elseif($m->status === 'cuti')
                            <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold bg-amber-100 text-amber-700 rounded-full">Cuti</span>
                            @else
                            <span class="inline-flex px-2 py-0.5 text-[10px] font-semibold bg-slate-100 text-slate-600 rounded-full">{{ ucfirst($m->status ?? 'Aktif') }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-5 text-right">
                            <a href="{{ route('admin.mahasiswa.show', $m) }}" class="inline-flex p-2 text-siakad-secondary hover:text-siakad-primary hover:bg-siakad-primary/10 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-siakad-light/50 rounded-xl flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-siakad-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-siakad-secondary text-sm">Tidak ada data mahasiswa</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mahasiswa->hasPages())
        <div class="px-5 py-4 border-t border-siakad-light">
            {{ $mahasiswa->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
