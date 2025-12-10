<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'mata_kuliah_id',
        'dosen_id',
        'nama_kelas',
        'kapasitas',
        'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function krsDetail()
    {
        return $this->hasMany(KrsDetail::class);
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalKuliah::class);
    }

    public function isFull(): bool
    {
        return $this->krsDetail()->count() >= $this->kapasitas;
    }
}

