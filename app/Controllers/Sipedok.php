<?php

namespace App\Controllers;

class Sipedok extends BaseController
{
    public function index()
    {
        $dokumen = [
            ['kode' => 'A', 'nama' => 'SKP Tahunan – Penetapan', 'total' => 0, 'melapor' => 0],
            ['kode' => 'B', 'nama' => 'SKP Periodik', 'total' => 0, 'melapor' => 0],
            ['kode' => 'C', 'nama' => 'SKP Tahunan – Penilaian', 'total' => 0, 'melapor' => 0],
            ['kode' => 'D', 'nama' => 'SKP Tahunan – Dokumen Evaluasi', 'total' => 0, 'melapor' => 0],
            ['kode' => 'E', 'nama' => 'Laporan Pekerjaan Pimpinan', 'total' => 0, 'melapor' => 0],
            ['kode' => 'F', 'nama' => 'PAK (1 Set 3 Dokumen) Tahunan', 'total' => 0, 'melapor' => 0],
            ['kode' => 'G', 'nama' => 'PAK Lainnya', 'total' => 0, 'melapor' => 0],
            ['kode' => 'H', 'nama' => 'BPE SPT Pajak – Coretax (di Simpeg)', 'total' => 0, 'melapor' => 0],
            ['kode' => 'I', 'nama' => 'SKP Tahunan Penetapan (SKP, di Simpeg)', 'total' => 0, 'melapor' => 0],
            ['kode' => 'J', 'nama' => 'SKP Tahunan Penilaian (PPK, di Simpeg)', 'total' => 0, 'melapor' => 0],
        ];

        return view('sipedok/index', [
            'title' => 'SIPEDOK',
            'dokumen' => $dokumen,
            'totalPegawai' => 0,
            'sudahMelapor' => 0,
            'belumMelapor' => 0,
            'persentase' => 0,
        ]);
    }

    public function dataPegawai()
    {
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));
        $direktorat = $this->request->getGet('direktorat') ?? '';

        return view('sipedok/data_pegawai', [
            'judul' => 'Data Pegawai',
            'tahun' => $tahun,
            'direktorat' => $direktorat,
            'totalPegawai' => 0,
            'daftarDirektorat' => [],
            'rekapPegawai' => [],
        ]);
    }

    public function monitoringDokumen() 
    {
        return view('sipedok/monitoring_dokumen', [
            'judul' => 'Monitoring Dokumen',
        ]);
    }

    public function tindakLanjut()
    {
        return view('sipedok/tindak_lanjut', [
            'judul' => 'Tindak Lanjut',
        ]);
    }
}