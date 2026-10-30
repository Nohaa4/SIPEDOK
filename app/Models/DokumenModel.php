<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    public function getKategori()
    {
        return [
            'A' => 'SKP Tahunan - Penetapan',
            'B' => 'SKP Periodik',
            'C' => 'SKP Tahunan - Penilaian',
            'D' => 'SKP Tahunan - Dokumen Evaluasi',
            'E' => 'Laporan Pekerjaan Pimpinan',
            'F' => 'PAK (1 Set 3 Dokumen) Tahunan',
            'G' => 'PAK Lainnya',
            'H' => 'BPE SPT Pajak - Coretax (di Simpeg)',
            'I' => 'SKP Tahunan Penetapan (SKP, di Simpeg)',
            'J' => 'SKP Tahunan Penilaian (PPK, di Simpeg)',
        ];
    }

    public function daftarDokumen()
    {
        return [];
    }
}
