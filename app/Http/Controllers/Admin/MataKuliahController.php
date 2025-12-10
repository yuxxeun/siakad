<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AkademikService;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    protected $akademikService;

    public function __construct(AkademikService $akademikService)
    {
        $this->akademikService = $akademikService;
    }

    public function index()
    {
        $mataKuliah = $this->akademikService->getAllMataKuliah();
        return view('admin.mata-kuliah.index', compact('mataKuliah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk'  => 'required|string|unique:mata_kuliah,kode_mk',
            'nama_mk'  => 'required|string',
            'sks'      => 'required|integer|min:1',
            'semester' => 'required|integer|min:1',
        ]);
        $this->akademikService->createMataKuliah($validated);
        return redirect()->back()->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    public function update(Request $request, \App\Models\MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk'  => 'required|string|unique:mata_kuliah,kode_mk,' . $mataKuliah->id,
            'nama_mk'  => 'required|string',
            'sks'      => 'required|integer|min:1',
            'semester' => 'required|integer|min:1',
        ]);
        $mataKuliah->update($validated);
        return redirect()->back()->with('success', 'Mata Kuliah berhasil diupdate');
    }

    public function destroy(\App\Models\MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->back()->with('success', 'Mata Kuliah berhasil dihapus');
    }
}
