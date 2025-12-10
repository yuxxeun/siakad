<x-app-layout>
    <x-slot name="header">
        Detail Dosen - {{ $dosen->user->name }}
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="text-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                        {{ strtoupper(substr($dosen->user->name, 0, 1)) }}
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $dosen->user->name }}</h3>
                    <p class="text-slate-500">{{ $dosen->nidn }}</p>
                </div>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Email</span>
                        <span class="font-medium text-slate-800">{{ $dosen->user->email }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Prodi</span>
                        <span class="font-medium text-slate-800">{{ $dosen->prodi->nama }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Fakultas</span>
                        <span class="font-medium text-slate-800">{{ $dosen->prodi->fakultas->nama }}</span>
                    </div>
                </div>
            </div>

            <!-- Teaching Summary -->
            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl p-6 text-white">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <p class="text-3xl font-bold">{{ $dosen->kelas->count() }}</p>
                        <p class="text-sm opacity-80">Kelas Diampu</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold">{{ $totalSks }}</p>
                        <p class="text-sm opacity-80">Total SKS</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-3xl font-bold">{{ $totalStudents }}</p>
                        <p class="text-sm opacity-80">Total Mahasiswa</p>
                    </div>
                </div>
            </div>

            <a href="{{ url('admin/dosen') }}" class="block text-center text-sm text-slate-500 hover:text-indigo-600">
                ← Kembali ke daftar
            </a>
        </div>

        <!-- Teaching Load -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">Beban Mengajar</h3>
                    <p class="text-sm text-slate-500">Progress penilaian per kelas</p>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($teachingLoad as $load)
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ $load['kelas']->nama_kelas }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $load['kelas']->mataKuliah->nama_mk }}</p>
                                    <p class="text-sm text-slate-500">{{ $load['kelas']->mataKuliah->kode_mk }} • {{ $load['kelas']->mataKuliah->sks }} SKS</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-800">{{ $load['student_count'] }} Mahasiswa</p>
                                <p class="text-sm text-slate-500">{{ $load['graded_count'] }} dinilai</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $load['grading_progress'] == 100 ? 'bg-emerald-500' : 'bg-amber-500' }}" 
                                     style="width: {{ $load['grading_progress'] }}%"></div>
                            </div>
                            <span class="text-sm font-medium {{ $load['grading_progress'] == 100 ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $load['grading_progress'] }}%
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-slate-500">Belum ada kelas yang diampu</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
