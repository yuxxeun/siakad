<x-app-layout>
    <x-slot name="header">
        Data Kelas
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-siakad-secondary">Kelola data kelas dalam sistem</p>
        </div>
        <button onclick="document.getElementById('createModal').classList.remove('hidden')" class="btn-primary-saas px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Kelas
        </button>
    </div>

    <!-- Table Card -->
    <div class="card-saas overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-saas">
                <thead>
                    <tr class="bg-siakad-light/30">
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider w-16">#</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Kelas</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Mata Kuliah</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Dosen</th>
                        <th class="text-left py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider">Kapasitas</th>
                        <th class="text-right py-3 px-5 text-xs font-semibold text-siakad-secondary uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $index => $k)
                    <tr class="border-b border-siakad-light/50">
                        <td class="py-4 px-5 text-sm text-siakad-secondary">{{ $index + 1 }}</td>
                        <td class="py-4 px-5">
                            <span class="inline-flex px-3 py-1.5 text-sm font-semibold bg-siakad-primary text-white rounded-lg">{{ $k->nama_kelas }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <div>
                                <span class="text-sm font-medium text-siakad-dark">{{ $k->mataKuliah->nama_mk ?? '-' }}</span>
                                <span class="block text-xs text-siakad-secondary font-mono">{{ $k->mataKuliah->kode_mk ?? '' }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="text-sm text-siakad-secondary">{{ $k->dosen->user->name ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-siakad-secondary/10 text-siakad-secondary rounded-full">{{ $k->kapasitas }} mhs</span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editKelas({{ $k->id }}, '{{ $k->nama_kelas }}', {{ $k->mata_kuliah_id }}, {{ $k->dosen_id }}, {{ $k->kapasitas }})" class="p-2 text-siakad-secondary hover:text-siakad-primary hover:bg-siakad-primary/10 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-siakad-secondary hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-siakad-light/50 rounded-xl flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-siakad-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                                </div>
                                <p class="text-siakad-secondary text-sm">Belum ada data kelas</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-md animate-fade-in">
            <div class="px-6 py-4 border-b border-siakad-light">
                <h3 class="text-lg font-semibold text-siakad-dark">Tambah Kelas</h3>
            </div>
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="input-saas w-full px-4 py-2.5 text-sm" placeholder="Contoh: A" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Mata Kuliah</label>
                        <select name="mata_kuliah_id" class="input-saas w-full px-4 py-2.5 text-sm" required>
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliah as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Dosen Pengampu</label>
                        <select name="dosen_id" class="input-saas w-full px-4 py-2.5 text-sm" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosen as $d)
                            <option value="{{ $d->id }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Kapasitas</label>
                        <input type="number" name="kapasitas" min="1" class="input-saas w-full px-4 py-2.5 text-sm" placeholder="40" required>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-siakad-light flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')" class="btn-ghost-saas px-4 py-2 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="btn-primary-saas px-4 py-2 rounded-lg text-sm font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-md animate-fade-in">
            <div class="px-6 py-4 border-b border-siakad-light">
                <h3 class="text-lg font-semibold text-siakad-dark">Edit Kelas</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="editNama" class="input-saas w-full px-4 py-2.5 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Mata Kuliah</label>
                        <select name="mata_kuliah_id" id="editMK" class="input-saas w-full px-4 py-2.5 text-sm" required>
                            @foreach($mataKuliah as $mk)
                            <option value="{{ $mk->id }}">{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Dosen Pengampu</label>
                        <select name="dosen_id" id="editDosen" class="input-saas w-full px-4 py-2.5 text-sm" required>
                            @foreach($dosen as $d)
                            <option value="{{ $d->id }}">{{ $d->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-siakad-dark mb-2">Kapasitas</label>
                        <input type="number" name="kapasitas" id="editKapasitas" min="1" class="input-saas w-full px-4 py-2.5 text-sm" required>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-siakad-light flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn-ghost-saas px-4 py-2 rounded-lg text-sm font-medium">Batal</button>
                    <button type="submit" class="btn-primary-saas px-4 py-2 rounded-lg text-sm font-medium">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editKelas(id, nama, mkId, dosenId, kapasitas) {
            document.getElementById('editForm').action = `/admin/kelas/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editMK').value = mkId;
            document.getElementById('editDosen').value = dosenId;
            document.getElementById('editKapasitas').value = kapasitas;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
