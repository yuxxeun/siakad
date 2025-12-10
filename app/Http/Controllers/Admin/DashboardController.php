<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\Nilai;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $stats = [
            'fakultas' => Fakultas::count(),
            'prodi' => Prodi::count(),
            'mahasiswa' => Mahasiswa::count(),
            'dosen' => Dosen::count(),
            'mata_kuliah' => MataKuliah::count(),
            'kelas' => Kelas::count(),
        ];

        // KRS Status breakdown
        $krsStatus = [
            'draft' => Krs::where('status', 'draft')->count(),
            'pending' => Krs::where('status', 'pending')->count(),
            'approved' => Krs::where('status', 'approved')->count(),
            'rejected' => Krs::where('status', 'rejected')->count(),
        ];

        // Grade distribution (all grades)
        $gradeDistribution = Nilai::selectRaw('nilai_huruf, COUNT(*) as count')
            ->groupBy('nilai_huruf')
            ->pluck('count', 'nilai_huruf')
            ->toArray();

        // Recent activities (KRS submissions)
        $recentKrs = Krs::with(['mahasiswa.user', 'tahunAkademik'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Active academic year
        $activeYear = TahunAkademik::where('is_active', true)->first();

        // Per-prodi student count
        $prodiStats = Prodi::withCount('mahasiswa')
            ->orderBy('mahasiswa_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'stats', 'krsStatus', 'gradeDistribution', 
            'recentKrs', 'activeYear', 'prodiStats'
        ));
    }
}
