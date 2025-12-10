<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\Kelas;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\TahunAkademik;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Nilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // ADMIN USER
        // ==========================================
        User::create([
            'name' => 'Administrator SIAKAD',
            'email' => 'admin@siakad.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // ==========================================
        // TAHUN AKADEMIK
        // ==========================================
        $ta2023Ganjil = TahunAkademik::create(['tahun' => '2023/2024', 'semester' => 'Ganjil', 'is_active' => false]);
        $ta2023Genap = TahunAkademik::create(['tahun' => '2023/2024', 'semester' => 'Genap', 'is_active' => false]);
        $ta2024Ganjil = TahunAkademik::create(['tahun' => '2024/2025', 'semester' => 'Ganjil', 'is_active' => true]);

        // ==========================================
        // FAKULTAS
        // ==========================================
        $ftek = Fakultas::create(['nama' => 'Fakultas Teknik']);
        $feb = Fakultas::create(['nama' => 'Fakultas Ekonomi dan Bisnis']);
        $fmipa = Fakultas::create(['nama' => 'Fakultas Matematika dan IPA']);

        // ==========================================
        // PROGRAM STUDI
        // ==========================================
        $ti = Prodi::create(['nama' => 'Teknik Informatika', 'fakultas_id' => $ftek->id]);
        $si = Prodi::create(['nama' => 'Sistem Informasi', 'fakultas_id' => $ftek->id]);
        $te = Prodi::create(['nama' => 'Teknik Elektro', 'fakultas_id' => $ftek->id]);
        $mn = Prodi::create(['nama' => 'Manajemen', 'fakultas_id' => $feb->id]);
        $ak = Prodi::create(['nama' => 'Akuntansi', 'fakultas_id' => $feb->id]);
        $mtk = Prodi::create(['nama' => 'Matematika', 'fakultas_id' => $fmipa->id]);

        // ==========================================
        // MATA KULIAH - TEKNIK INFORMATIKA
        // ==========================================
        $mkTI = [
            ['kode_mk' => 'TI101', 'nama_mk' => 'Algoritma dan Pemrograman', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'TI102', 'nama_mk' => 'Struktur Data', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'TI103', 'nama_mk' => 'Basis Data', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'TI104', 'nama_mk' => 'Pemrograman Web', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'TI105', 'nama_mk' => 'Pemrograman Berorientasi Objek', 'sks' => 3, 'semester' => 2],
            ['kode_mk' => 'TI201', 'nama_mk' => 'Jaringan Komputer', 'sks' => 3, 'semester' => 4],
            ['kode_mk' => 'TI202', 'nama_mk' => 'Sistem Operasi', 'sks' => 3, 'semester' => 4],
            ['kode_mk' => 'TI203', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'sks' => 3, 'semester' => 5],
            ['kode_mk' => 'TI204', 'nama_mk' => 'Kecerdasan Buatan', 'sks' => 3, 'semester' => 5],
            ['kode_mk' => 'TI205', 'nama_mk' => 'Machine Learning', 'sks' => 3, 'semester' => 6],
            ['kode_mk' => 'TI301', 'nama_mk' => 'Keamanan Informasi', 'sks' => 3, 'semester' => 6],
            ['kode_mk' => 'TI302', 'nama_mk' => 'Cloud Computing', 'sks' => 3, 'semester' => 7],
        ];

        $mkSI = [
            ['kode_mk' => 'SI101', 'nama_mk' => 'Pengantar Sistem Informasi', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'SI102', 'nama_mk' => 'Analisis dan Desain Sistem', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'SI103', 'nama_mk' => 'Manajemen Proyek TI', 'sks' => 3, 'semester' => 5],
            ['kode_mk' => 'SI104', 'nama_mk' => 'Enterprise Resource Planning', 'sks' => 3, 'semester' => 5],
            ['kode_mk' => 'SI105', 'nama_mk' => 'Business Intelligence', 'sks' => 3, 'semester' => 6],
        ];

        $mkMN = [
            ['kode_mk' => 'MN101', 'nama_mk' => 'Pengantar Manajemen', 'sks' => 3, 'semester' => 1],
            ['kode_mk' => 'MN102', 'nama_mk' => 'Manajemen Keuangan', 'sks' => 3, 'semester' => 3],
            ['kode_mk' => 'MN103', 'nama_mk' => 'Manajemen Pemasaran', 'sks' => 3, 'semester' => 4],
            ['kode_mk' => 'MN104', 'nama_mk' => 'Manajemen SDM', 'sks' => 3, 'semester' => 5],
        ];

        foreach ($mkTI as $mk) { MataKuliah::create($mk); }
        foreach ($mkSI as $mk) { MataKuliah::create($mk); }
        foreach ($mkMN as $mk) { MataKuliah::create($mk); }

        // ==========================================
        // DOSEN (dengan data realistis Indonesia)
        // ==========================================
        $dosenData = [
            ['name' => 'Dr. Ir. Ahmad Fauzi, M.Kom.', 'email' => 'ahmad.fauzi@siakad.com', 'nidn' => '0012056701', 'prodi_id' => $ti->id],
            ['name' => 'Dr. Budi Santoso, M.T.', 'email' => 'budi.santoso@siakad.com', 'nidn' => '0015077802', 'prodi_id' => $ti->id],
            ['name' => 'Siti Aminah, S.Kom., M.Cs.', 'email' => 'siti.aminah@siakad.com', 'nidn' => '0020088503', 'prodi_id' => $ti->id],
            ['name' => 'Drs. Hendra Wijaya, M.M.', 'email' => 'hendra.wijaya@siakad.com', 'nidn' => '0025097604', 'prodi_id' => $si->id],
            ['name' => 'Prof. Dr. Ratna Dewi, M.Si.', 'email' => 'ratna.dewi@siakad.com', 'nidn' => '0001056505', 'prodi_id' => $si->id],
            ['name' => 'Dr. Eko Prasetyo, M.B.A.', 'email' => 'eko.prasetyo@siakad.com', 'nidn' => '0008048006', 'prodi_id' => $mn->id],
        ];

        $dosenModels = [];
        foreach ($dosenData as $d) {
            $user = User::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]);
            $dosenModels[] = Dosen::create([
                'user_id' => $user->id,
                'nidn' => $d['nidn'],
                'prodi_id' => $d['prodi_id'],
            ]);
        }

        // ==========================================
        // KELAS
        // ==========================================
        $kelasData = [];
        $mataKuliahList = MataKuliah::all();
        
        foreach ($mataKuliahList as $index => $mk) {
            // Assign dosen based on prodi
            $dosenForProdi = collect($dosenModels)->filter(fn($d) => $d->prodi_id == $mk->prodi_id)->first();
            if (!$dosenForProdi) {
                $dosenForProdi = $dosenModels[0]; // fallback
            }
            
            $kelasData[] = Kelas::create([
                'mata_kuliah_id' => $mk->id,
                'dosen_id' => $dosenForProdi->id,
                'nama_kelas' => chr(65 + ($index % 3)), // A, B, C
                'kapasitas' => 40,
            ]);
        }

        // ==========================================
        // MAHASISWA (dengan data realistis Indonesia)
        // ==========================================
        $mahasiswaData = [
            // Teknik Informatika 2021
            ['name' => 'Muhammad Rizky Pratama', 'email' => 'rizky.pratama@student.siakad.com', 'nim' => '2021101001', 'prodi_id' => $ti->id, 'angkatan' => 2021],
            ['name' => 'Dewi Sartika Putri', 'email' => 'dewi.sartika@student.siakad.com', 'nim' => '2021101002', 'prodi_id' => $ti->id, 'angkatan' => 2021],
            ['name' => 'Andi Wijaya Kusuma', 'email' => 'andi.wijaya@student.siakad.com', 'nim' => '2021101003', 'prodi_id' => $ti->id, 'angkatan' => 2021],
            ['name' => 'Farah Nabila Zahra', 'email' => 'farah.nabila@student.siakad.com', 'nim' => '2021101004', 'prodi_id' => $ti->id, 'angkatan' => 2021],
            ['name' => 'Bagus Setiawan', 'email' => 'bagus.setiawan@student.siakad.com', 'nim' => '2021101005', 'prodi_id' => $ti->id, 'angkatan' => 2021],
            
            // Teknik Informatika 2022
            ['name' => 'Cindy Aurelia Putri', 'email' => 'cindy.aurelia@student.siakad.com', 'nim' => '2022101001', 'prodi_id' => $ti->id, 'angkatan' => 2022],
            ['name' => 'Dimas Ardiansyah', 'email' => 'dimas.ardi@student.siakad.com', 'nim' => '2022101002', 'prodi_id' => $ti->id, 'angkatan' => 2022],
            ['name' => 'Eka Safitri', 'email' => 'eka.safitri@student.siakad.com', 'nim' => '2022101003', 'prodi_id' => $ti->id, 'angkatan' => 2022],
            ['name' => 'Farhan Maulana', 'email' => 'farhan.maulana@student.siakad.com', 'nim' => '2022101004', 'prodi_id' => $ti->id, 'angkatan' => 2022],
            ['name' => 'Gita Permata Sari', 'email' => 'gita.permata@student.siakad.com', 'nim' => '2022101005', 'prodi_id' => $ti->id, 'angkatan' => 2022],
            
            // Teknik Informatika 2023
            ['name' => 'Haikal Ramadhan', 'email' => 'haikal.ramadhan@student.siakad.com', 'nim' => '2023101001', 'prodi_id' => $ti->id, 'angkatan' => 2023],
            ['name' => 'Indah Permatasari', 'email' => 'indah.permata@student.siakad.com', 'nim' => '2023101002', 'prodi_id' => $ti->id, 'angkatan' => 2023],
            ['name' => 'Joko Susilo', 'email' => 'joko.susilo@student.siakad.com', 'nim' => '2023101003', 'prodi_id' => $ti->id, 'angkatan' => 2023],
            ['name' => 'Kartika Dewi', 'email' => 'kartika.dewi@student.siakad.com', 'nim' => '2023101004', 'prodi_id' => $ti->id, 'angkatan' => 2023],
            ['name' => 'Lukman Hakim', 'email' => 'lukman.hakim@student.siakad.com', 'nim' => '2023101005', 'prodi_id' => $ti->id, 'angkatan' => 2023],
            
            // Sistem Informasi 2022
            ['name' => 'Maya Anggraini', 'email' => 'maya.anggraini@student.siakad.com', 'nim' => '2022102001', 'prodi_id' => $si->id, 'angkatan' => 2022],
            ['name' => 'Naufal Hidayat', 'email' => 'naufal.hidayat@student.siakad.com', 'nim' => '2022102002', 'prodi_id' => $si->id, 'angkatan' => 2022],
            ['name' => 'Olivia Rahma', 'email' => 'olivia.rahma@student.siakad.com', 'nim' => '2022102003', 'prodi_id' => $si->id, 'angkatan' => 2022],
            
            // Manajemen 2022
            ['name' => 'Putra Aditya', 'email' => 'putra.aditya@student.siakad.com', 'nim' => '2022201001', 'prodi_id' => $mn->id, 'angkatan' => 2022],
            ['name' => 'Queen Maharani', 'email' => 'queen.maharani@student.siakad.com', 'nim' => '2022201002', 'prodi_id' => $mn->id, 'angkatan' => 2022],
        ];

        $mahasiswaModels = [];
        foreach ($mahasiswaData as $m) {
            $user = User::create([
                'name' => $m['name'],
                'email' => $m['email'],
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
            ]);
            
            // Assign Dosen PA from same prodi
            $dosenPa = collect($dosenModels)->filter(fn($d) => $d->prodi_id == $m['prodi_id'])->first();
            
            $mahasiswaModels[] = Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $m['nim'],
                'prodi_id' => $m['prodi_id'],
                'dosen_pa_id' => $dosenPa?->id,
                'angkatan' => $m['angkatan'],
                'status' => 'aktif',
            ]);
        }

        // ==========================================
        // KRS & NILAI (Sample untuk beberapa mahasiswa)
        // ==========================================
        $allKelas = Kelas::all();
        
        // KRS untuk mahasiswa TI angkatan 2021 dan 2022 (sudah approved, ada nilai)
        $approvedMahasiswa = collect($mahasiswaModels)->filter(fn($m) => 
            $m->prodi_id == $ti->id && in_array($m->angkatan, [2021, 2022])
        );

        foreach ($approvedMahasiswa as $mhs) {
            // Semester lalu (2023/2024 Genap) - sudah ada nilai
            $krs = Krs::create([
                'mahasiswa_id' => $mhs->id,
                'tahun_akademik_id' => $ta2023Genap->id,
                'status' => 'approved',
            ]);

            // Ambil 5 mata kuliah
            $selectedKelas = $allKelas->take(5);
            foreach ($selectedKelas as $kelas) {
                KrsDetail::create([
                    'krs_id' => $krs->id,
                    'kelas_id' => $kelas->id,
                ]);

                // Generate nilai realistis
                $nilaiAngka = $this->generateRealisticGrade($mhs->angkatan);
                Nilai::create([
                    'mahasiswa_id' => $mhs->id,
                    'kelas_id' => $kelas->id,
                    'nilai_angka' => $nilaiAngka,
                    'nilai_huruf' => $this->convertToLetter($nilaiAngka),
                ]);
            }
        }

        // KRS untuk mahasiswa TI angkatan 2023 (pending/draft)
        $pendingMahasiswa = collect($mahasiswaModels)->filter(fn($m) => 
            $m->prodi_id == $ti->id && $m->angkatan == 2023
        );

        foreach ($pendingMahasiswa as $mhs) {
            $krs = Krs::create([
                'mahasiswa_id' => $mhs->id,
                'tahun_akademik_id' => $ta2024Ganjil->id,
                'status' => 'pending', // Menunggu approval dari Dosen PA
            ]);

            // Ambil 6 mata kuliah
            $selectedKelas = $allKelas->take(6);
            foreach ($selectedKelas as $kelas) {
                KrsDetail::create([
                    'krs_id' => $krs->id,
                    'kelas_id' => $kelas->id,
                ]);
            }
        }

        $this->command->info('✅ Database seeded successfully with realistic data!');
        $this->command->info('');
        $this->command->info('📋 Login Credentials:');
        $this->command->info('   Admin    : admin@siakad.com / password');
        $this->command->info('   Dosen    : ahmad.fauzi@siakad.com / password');
        $this->command->info('   Mahasiswa: rizky.pratama@student.siakad.com / password');
    }

    private function generateRealisticGrade(int $angkatan): int
    {
        // Senior students tend to have better grades
        $baseChance = $angkatan <= 2021 ? 75 : ($angkatan == 2022 ? 70 : 65);
        $random = rand(0, 100);
        
        if ($random < 30) return rand($baseChance, 100);
        if ($random < 60) return rand($baseChance - 15, $baseChance + 10);
        if ($random < 85) return rand(60, $baseChance);
        return rand(50, 70);
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
