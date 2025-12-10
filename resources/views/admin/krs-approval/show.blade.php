<x-app-layout>
    <x-slot name="header">
        Detail KRS - {{ $krs->mahasiswa->user->name ?? 'Unknown' }}
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Student Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                        {{ strtoupper(substr($krs->mahasiswa->user->name ?? 'X', 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $krs->mahasiswa->user->name ?? '-' }}</h3>
                    <p class="text-slate-500">{{ $krs->mahasiswa->nim ?? '-' }}</p>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Prodi</span>
                        <span class="font-medium text-slate-800">{{ $krs->mahasiswa->prodi->nama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Angkatan</span>
                        <span class="font-medium text-slate-800">{{ $krs->mahasiswa->angkatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tahun Akademik</span>
                        <span class="font-medium text-slate-800">{{ $krs->tahunAkademik->tahun ?? '-' }} {{ $krs->tahunAkademik->semester ?? '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Total SKS</span>
                        <span class="font-bold text-indigo-600 text-lg">{{ $totalSks }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-slate-500">Status KRS</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium capitalize
                            {{ $krs->status == 'approved' ? 'bg-emerald-100 text-emerald-800' : 
                               ($krs->status == 'pending' ? 'bg-amber-100 text-amber-800' : 
                               ($krs->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-800')) }}">
                            {{ $krs->status }}
                        </span>
                    </div>

                    @if($krs->status === 'pending')
                    <div class="flex gap-2">
                        <form action="{{ url('admin/krs-approval/' . $krs->id . '/approve') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-emerald-500 text-white rounded-xl font-medium hover:bg-emerald-600 transition">
                                ✓ Approve
                            </button>
                        </form>
                        <form action="{{ url('admin/krs-approval/' . $krs->id . '/reject') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition">
                                ✕ Reject
                            </button>
                        </form>
                    </div>
                    @endif
                </div>

                <a href="{{ url('admin/krs-approval') }}" class="mt-4 block text-center text-sm text-slate-500 hover:text-indigo-600">
                    ← Kembali ke daftar
                </a>
            </div>
        </div>

        <!-- Course List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Mata Kuliah Diambil</h3>
                    <p class="text-sm text-slate-500">{{ $krs->krsDetail->count() }} mata kuliah</p>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($krs->krsDetail as $detail)
                    <div class="p-4 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ $detail->kelas->nama_kelas ?? '-' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-800">{{ $detail->kelas->mataKuliah->nama_mk ?? '-' }}</p>
                            <p class="text-sm text-slate-500">{{ $detail->kelas->mataKuliah->kode_mk ?? '-' }} • {{ $detail->kelas->dosen->user->name ?? '-' }}</p>
                        </div>
                        <div class="text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-indigo-100 text-indigo-800 font-bold">
                                {{ $detail->kelas->mataKuliah->sks ?? 0 }}
                            </span>
                            <p class="text-xs text-slate-500 mt-1">SKS</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
