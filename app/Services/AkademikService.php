<?php

namespace App\Services;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\TahunAkademik;

class AkademikService
{
    // --- Fakultas ---
    public function getAllFakultas() { return Fakultas::all(); }
    public function createFakultas($data) { return Fakultas::create($data); }
    
    // --- Prodi ---
    public function getAllProdi() { return Prodi::with('fakultas')->get(); }
    public function createProdi($data) { return Prodi::create($data); }

    // --- Mata Kuliah ---
    public function getAllMataKuliah() { return MataKuliah::all(); }
    public function createMataKuliah($data) { return MataKuliah::create($data); }

    // --- Tahun Akademik ---
    public function getActiveTahun() { return TahunAkademik::where('is_active', true)->first(); }
    public function activateTahun($id)
    {
        TahunAkademik::query()->update(['is_active' => false]); // Deactivate all
        return TahunAkademik::where('id', $id)->update(['is_active' => true]);
    }

    // --- Kelas ---
    public function createKelas($data) {
        $data['kapasitas'] = $data['kapasitas'] ?? config('siakad.kelas_kapasitas_default');
        return Kelas::create($data);
    }
}
