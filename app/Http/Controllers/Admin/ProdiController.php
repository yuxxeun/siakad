<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AkademikService;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    protected $akademikService;

    public function __construct(AkademikService $akademikService)
    {
        $this->akademikService = $akademikService;
    }

    public function index()
    {
        $fakultas = \App\Models\Fakultas::with(['prodi' => function($q) {
            $q->withCount(['mahasiswa', 'dosen']);
        }])->get();
        
        return view('admin.prodi.index', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama'        => 'required|string|max:255',
        ]);
        $this->akademikService->createProdi($validated);
        return redirect()->back()->with('success', 'Prodi berhasil ditambahkan');
    }

    public function update(Request $request, \App\Models\Prodi $prodi)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama'        => 'required|string|max:255',
        ]);
        $prodi->update($validated);
        return redirect()->back()->with('success', 'Prodi berhasil diupdate');
    }

    public function destroy(\App\Models\Prodi $prodi)
    {
        $prodi->delete();
        return redirect()->back()->with('success', 'Prodi berhasil dihapus');
    }
}
