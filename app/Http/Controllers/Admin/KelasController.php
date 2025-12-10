<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AkademikService;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $akademikService;

    public function __construct(AkademikService $akademikService)
    {
        $this->akademikService = $akademikService;
    }

    public function index()
    {
        $kelas = \App\Models\Kelas::with(['mataKuliah', 'dosen'])->get();
        $mataKuliah = $this->akademikService->getAllMataKuliah();
        $dosen = \App\Models\Dosen::with('user')->get();
        return view('admin.kelas.index', compact('kelas', 'mataKuliah', 'dosen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'dosen_id'       => 'required|exists:dosen,id',
            'nama_kelas'     => 'required|string',
            'kapasitas'      => 'nullable|integer|min:1',
        ]);
        $this->akademikService->createKelas($validated);
        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan');
    }

    public function update(Request $request, \App\Models\Kelas $kelas)
    {
        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'dosen_id'       => 'required|exists:dosen,id',
            'nama_kelas'     => 'required|string',
            'kapasitas'      => 'nullable|integer|min:1',
        ]);
        $kelas->update($validated);
        return redirect()->back()->with('success', 'Kelas berhasil diupdate');
    }

    public function destroy(\App\Models\Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus');
    }
}
