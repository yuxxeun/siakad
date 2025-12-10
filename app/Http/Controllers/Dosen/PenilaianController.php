<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Services\PenilaianService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    protected $penilaianService;

    public function __construct(PenilaianService $penilaianService)
    {
        $this->penilaianService = $penilaianService;
    }

    public function index()
    {
        $dosen = Auth::user()->dosen;
        // Get classes taught by this lecturer
        $kelasAjar = $dosen->kelas()->with(['mataKuliah', 'nilai.mahasiswa', 'krsDetail.krs.mahasiswa'])->get();
        return view('dosen.penilaian.index', compact('kelasAjar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'kelas_id'     => 'required|exists:kelas,id',
            'nilai_angka'  => 'required|numeric|min:0|max:100',
        ]);

        try {
            $this->penilaianService->inputNilai(
                $request->mahasiswa_id,
                $request->kelas_id,
                $request->nilai_angka
            );
            return redirect()->back()->with('success', 'Nilai berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
