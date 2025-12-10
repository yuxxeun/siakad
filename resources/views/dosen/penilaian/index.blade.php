<x-app-layout>
    <x-slot name="header">
        Input Nilai Mahasiswa
    </x-slot>

    @if($kelasAjar->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
        <div class="w-20 h-20 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Kelas</h3>
        <p class="text-slate-500">Anda belum memiliki kelas yang diampu untuk semester ini.</p>
    </div>
    @else
    <div class="space-y-8">
        @foreach($kelasAjar as $kelas)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold">{{ $kelas->mataKuliah->nama_mk }}</h3>
                        <p class="text-sm opacity-80 mt-1">{{ $kelas->mataKuliah->kode_mk }} • {{ $kelas->mataKuliah->sks }} SKS</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-white/20 flex items-center justify-center text-2xl font-bold">
                            {{ $kelas->nama_kelas }}
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold">{{ $kelas->krsDetail->count() }}</p>
                            <p class="text-sm opacity-80">Mahasiswa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Mahasiswa</th>
                            <th class="text-center px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai Angka</th>
                            <th class="text-center px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai Huruf</th>
                            <th class="text-center px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kelas->krsDetail as $detail)
                            @php
                                $nilai = $kelas->nilai->where('mahasiswa_id', $detail->krs->mahasiswa_id)->first();
                            @endphp
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm bg-slate-100 px-2 py-1 rounded">{{ $detail->krs->mahasiswa->nim }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($detail->krs->mahasiswa->user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-medium text-slate-800">{{ $detail->krs->mahasiswa->user->name }}</span>
                                </div>
                            </td>
                            <form action="{{ url('dosen/penilaian') }}" method="POST">
                                @csrf
                                <input type="hidden" name="mahasiswa_id" value="{{ $detail->krs->mahasiswa_id }}">
                                <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                                <td class="px-6 py-4 text-center">
                                    <input type="number" step="0.01" min="0" max="100" name="nilai_angka" value="{{ $nilai?->nilai_angka }}" 
                                        class="w-20 px-3 py-2 text-center rounded-lg border border-slate-200 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 transition">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($nilai?->nilai_huruf)
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl font-bold text-lg
                                        {{ in_array($nilai->nilai_huruf, ['A', 'B+']) ? 'bg-emerald-100 text-emerald-700' : 
                                           (in_array($nilai->nilai_huruf, ['B', 'C+']) ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $nilai->nilai_huruf }}
                                    </span>
                                    @else
                                    <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="submit" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg font-medium text-sm hover:bg-indigo-100 transition">
                                        Simpan
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                Belum ada mahasiswa yang mengambil kelas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>
