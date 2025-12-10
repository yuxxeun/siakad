<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\TahunAkademik;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Nilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HaikalSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // SETUP: Get or create required data
        // ==========================================
        
        // Tahun Akademik
        $ta2023Ganjil = TahunAkademik::firstOrCreate(
            ['tahun' => '2023/2024', 'semester' => 'Ganjil'],
            ['is_active' => false]
        );
        $ta2023Genap = TahunAkademik::firstOrCreate(
            ['tahun' => '2023/2024', 'semester' => 'Genap'],
            ['is_active' => false]
        );
        $ta2024Ganjil = TahunAkademik::firstOrCreate(
            ['tahun' => '2024/2025', 'semester' => 'Ganjil'],
            ['is_active' => true]
        );

        // Prodi Teknik Informatika
        $ti = Prodi::where('nama', 'Teknik Informatika')->first();
        if (!$ti) {
            $this->command->error('Prodi Teknik Informatika tidak ditemukan! Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        // Dosen PA
        $dosenPa = Dosen::whereHas('prodi', fn($q) => $q->where('nama', 'Teknik Informatika'))->first();

        // ==========================================
        // CREATE/UPDATE HAIKAL RAMADHAN
        // ==========================================
        $user = User::updateOrCreate(
            ['email' => 'haikal.ramadhan@student.siakad.com'],
            [
                'name' => 'Haikal Ramadhan',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]
        );

        $haikal = Mahasiswa::updateOrCreate(
            ['nim' => '2023101001'],
            [
                'user_id' => $user->id,
                'prodi_id' => $ti->id,
                'dosen_pa_id' => $dosenPa?->id,
                'angkatan' => 2023,
                'status' => 'aktif',
            ]
        );

        // ==========================================
        // MATA KULIAH SEMESTER 1 - Teknik Informatika
        // ==========================================
        $mkSem1 = [
            ['kode_mk' => 'TI1101', 'nama_mk' => 'Algoritma dan Pemrograman', 'sks' => 4, 'semester' => 1],
            ['kode_mk' => 'TI1102', 'nama_mk' => 'Matematika Diskrit', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'TI1103', 'nama_mk' => 'Pengantar Teknologi Informasi', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'TI1104', 'nama_mk' => 'Kalkulus I', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'TI1105', 'nama_mk' => 'Bahasa Inggris I', 'sks' => 2, 'semester' => 1],
            ['kode_mk' => 'TI1106', 'nama_mk' => 'Pendidikan Pancasila', 'sks' => 2, 'semester' => 1],
            ['kode_mk' => 'TI1107', 'nama_mk' => 'Fisika Dasar', 'sks' => 3, 'semester' => 1],
        ]; // Total 20 SKS

        // ==========================================
        // MATA KULIAH SEMESTER 2 - Teknik Informatika
        // ==========================================
        $mkSem2 = [
            ['kode_mk' => 'TI1201', 'nama_mk' => 'Struktur Data', 'sks' => 4, 'semester' => 2],
            ['kode_mk' => 'TI1202', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 4, 'semester' => 2],
            ['kode_mk' => 'TI1203', 'nama_mk' => 'Kalkulus II', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'TI1204', 'nama_mk' => 'Statistika dan Probabilitas', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'TI1205', 'nama_mk' => 'Bahasa Inggris II', 'sks' => 2, 'semester' => 2],
            ['kode_mk' => 'TI1206', 'nama_mk' => 'Kewarganegaraan', 'sks' => 2, 'semester' => 2],
            ['kode_mk' => 'TI1207', 'nama_mk' => 'Aljabar Linear', 'sks' => 3, 'semester' => 2],
        ]; // Total 21 SKS

        // ==========================================
        // MATA KULIAH SEMESTER 3 - Teknik Informatika
        // ==========================================
        $mkSem3 = [
            ['kode_mk' => 'TI2101', 'nama_mk' => 'Basis Data', 'sks' => 4, 'semester' => 3],
            ['kode_mk' => 'TI2102', 'nama_mk' => 'Pemrograman Web', 'sks' => 4, 'semester' => 3],
            ['kode_mk' => 'TI2103', 'nama_mk' => 'Sistem Operasi', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'TI2104', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'TI2105', 'nama_mk' => 'Interaksi Manusia Komputer', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'TI2106', 'nama_mk' => 'Bahasa Indonesia', 'sks' => 2, 'semester' => 3],
        ]; // Total 19 SKS

        // ==========================================
        // CREATE MATA KULIAH, KELAS, AND KRS
        // ==========================================
        
        // Nilai Semester 1 - IPS 3.65 (Mahasiswa baru, semangat tinggi)
        $nilaiSem1 = [
            'TI1101' => 85,  // A - Algoritma dan Pemrograman
            'TI1102' => 88,  // A - Matematika Diskrit
            'TI1103' => 90,  // A - Pengantar TI
            'TI1104' => 78,  // B - Kalkulus I
            'TI1105' => 85,  // A - Bahasa Inggris I
            'TI1106' => 82,  // B+ - Pendidikan Pancasila
            'TI1107' => 75,  // B - Fisika Dasar
        ];

        // Nilai Semester 2 - IPS 3.52 (Semester berat, sedikit turun)
        $nilaiSem2 = [
            'TI1201' => 85,  // A - Struktur Data
            'TI1202' => 88,  // A - PBO
            'TI1203' => 72,  // C+ - Kalkulus II
            'TI1204' => 80,  // B+ - Statistika
            'TI1205' => 87,  // A - Bahasa Inggris II
            'TI1206' => 85,  // A - Kewarganegaraan
            'TI1207' => 78,  // B - Aljabar Linear
        ];

        // Create Semester 1 KRS
        $this->createSemesterData($haikal, $ta2023Ganjil, $mkSem1, $nilaiSem1, $dosenPa);
        
        // Create Semester 2 KRS
        $this->createSemesterData($haikal, $ta2023Genap, $mkSem2, $nilaiSem2, $dosenPa);
        
        // Create Semester 3 KRS (Current - pending approval)
        $this->createCurrentSemester($haikal, $ta2024Ganjil, $mkSem3, $dosenPa);

        // ==========================================
        // OUTPUT
        // ==========================================
        $this->command->info('✅ Haikal Ramadhan seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Data Mahasiswa:');
        $this->command->info('   Nama     : Haikal Ramadhan');
        $this->command->info('   NIM      : 2023101001');
        $this->command->info('   Prodi    : Teknik Informatika');
        $this->command->info('   Angkatan : 2023');
        $this->command->info('');
        $this->command->info('📊 Riwayat Akademik:');
        $this->command->info('   Semester 1 (2023/2024 Ganjil): 20 SKS - IPS ~3.65');
        $this->command->info('   Semester 2 (2023/2024 Genap):  21 SKS - IPS ~3.52');
        $this->command->info('   Semester 3 (2024/2025 Ganjil): 19 SKS - KRS Pending');
        $this->command->info('');
        $this->command->info('🔐 Login: haikal.ramadhan@student.siakad.com / password');
    }

    private function createSemesterData($mahasiswa, $tahunAkademik, $mataKuliahList, $nilaiList, $dosen)
    {
        // Create KRS (approved)
        $krs = Krs::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $tahunAkademik->id],
            ['status' => 'approved']
        );

        foreach ($mataKuliahList as $mkData) {
            // Create Mata Kuliah
            $mk = MataKuliah::updateOrCreate(
                ['kode_mk' => $mkData['kode_mk']],
                ['nama_mk' => $mkData['nama_mk'], 'sks' => $mkData['sks'], 'semester' => $mkData['semester']]
            );

            // Create Kelas
            $kelas = Kelas::updateOrCreate(
                ['mata_kuliah_id' => $mk->id, 'nama_kelas' => 'A'],
                ['dosen_id' => $dosen->id, 'kapasitas' => 40]
            );

            // Create KRS Detail
            KrsDetail::updateOrCreate(
                ['krs_id' => $krs->id, 'kelas_id' => $kelas->id]
            );

            // Create Nilai
            $nilaiAngka = $nilaiList[$mkData['kode_mk']] ?? 75;
            Nilai::updateOrCreate(
                ['mahasiswa_id' => $mahasiswa->id, 'kelas_id' => $kelas->id],
                ['nilai_angka' => $nilaiAngka, 'nilai_huruf' => $this->convertToLetter($nilaiAngka)]
            );
        }
    }

    private function createCurrentSemester($mahasiswa, $tahunAkademik, $mataKuliahList, $dosen)
    {
        // Create KRS (pending)
        $krs = Krs::updateOrCreate(
            ['mahasiswa_id' => $mahasiswa->id, 'tahun_akademik_id' => $tahunAkademik->id],
            ['status' => 'pending']
        );

        foreach ($mataKuliahList as $mkData) {
            // Create Mata Kuliah
            $mk = MataKuliah::updateOrCreate(
                ['kode_mk' => $mkData['kode_mk']],
                ['nama_mk' => $mkData['nama_mk'], 'sks' => $mkData['sks'], 'semester' => $mkData['semester']]
            );

            // Create Kelas
            $kelas = Kelas::updateOrCreate(
                ['mata_kuliah_id' => $mk->id, 'nama_kelas' => 'A'],
                ['dosen_id' => $dosen->id, 'kapasitas' => 40]
            );

            // Create KRS Detail (no nilai yet)
            KrsDetail::updateOrCreate(
                ['krs_id' => $krs->id, 'kelas_id' => $kelas->id]
            );
        }
    }

    private function convertToLetter(int $nilai): string
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 80) return 'B+';
        if ($nilai >= 75) return 'B';
        if ($nilai >= 70) return 'C+';
        if ($nilai >= 65) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
