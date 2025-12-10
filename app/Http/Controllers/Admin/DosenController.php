<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Nilai;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::with(['user', 'prodi.fakultas'])
            ->withCount('kelas');

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nidn', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by prodi
        if ($prodiId = $request->get('prodi_id')) {
            $query->where('prodi_id', $prodiId);
        }

        $dosen = $query->orderBy('nidn')->paginate(config('siakad.pagination', 15));
        $prodiList = Prodi::with('fakultas')->get();

        return view('admin.dosen.index', compact('dosen', 'prodiList'));
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['user', 'prodi.fakultas', 'kelas.mataKuliah', 'kelas.krsDetail']);
        
        // Calculate teaching load
        $teachingLoad = $dosen->kelas->map(function ($kelas) {
            $studentCount = $kelas->krsDetail->count();
            $gradedCount = Nilai::where('kelas_id', $kelas->id)->count();
            
            return [
                'kelas' => $kelas,
                'student_count' => $studentCount,
                'graded_count' => $gradedCount,
                'grading_progress' => $studentCount > 0 ? round(($gradedCount / $studentCount) * 100) : 0,
            ];
        });

        $totalSks = $dosen->kelas->sum(fn($k) => $k->mataKuliah->sks);
        $totalStudents = $dosen->kelas->sum(fn($k) => $k->krsDetail->count());

        return view('admin.dosen.show', compact('dosen', 'teachingLoad', 'totalSks', 'totalStudents'));
    }
}
