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

    return view('dashboard/index', [
        'judul' => 'Dashboard Admin',
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

    public function detailPegawai($kode = null)
    {
        $daftarDokumen = [
            'A' => 'SKP Tahunan – Penetapan',
            'B' => 'SKP Periodik',
            'C' => 'SKP Tahunan – Penilaian',
            'D' => 'SKP Tahunan – Dokumen Evaluasi',
            'E' => 'Laporan Pekerjaan Pimpinan',
            'F' => 'PAK (1 Set 3 Dokumen) Tahunan',
            'G' => 'PAK Lainnya',
            'H' => 'BPE SPT Pajak – Coretax (di Simpeg)',
            'I' => 'SKP Tahunan Penetapan (SKP, di Simpeg)',
            'J' => 'SKP Tahunan Penilaian (PPK, di Simpeg)',
        ];

        if (!isset($daftarDokumen[$kode])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));

        return view('sipedok/detail_pegawai', [
            'judul' => 'Detail Monitoring Pegawai',
            'namaDokumen' => $daftarDokumen[$kode],
            'kodeDokumen' => $kode,
            'tahun' => $tahun,

            // Akan diisi dari database pada tahap integrasi
            'pegawaiSudah' => [],
            'pegawaiBelum' => [],
        ]);
    }

    public function tindakLanjut()
    {
        return view('sipedok/tindak_lanjut', [
            'judul' => 'Tindak Lanjut',
        ]);
    }

    public function laporan()
    {
        return view('sipedok/laporan', [
            'judul' => 'Laporan',
        ]);
    }

    public function dashboardPegawai()
{
    if (session()->get('role') !== 'pegawai') {
        return redirect()->to('/login');
    }

    $tahun = $this->request->getGet('tahun') ?? date('Y');

    $data = [
        'judul' => 'Dashboard Pegawai',
        'tahun' => $tahun,
        'sudahDilaporkan' => 0,
        'dokumen' => [
            ['kode' => 'A', 'nama' => 'SKP Tahunan – Penetapan', 'status' => 'belum'],
            ['kode' => 'B', 'nama' => 'SKP Periodik', 'status' => 'belum'],
            ['kode' => 'C', 'nama' => 'SKP Tahunan – Penilaian', 'status' => 'belum'],
            ['kode' => 'D', 'nama' => 'SKP Tahunan – Dokumen Evaluasi', 'status' => 'belum'],
            ['kode' => 'E', 'nama' => 'Laporan Pekerjaan Pimpinan', 'status' => 'belum'],
            ['kode' => 'F', 'nama' => 'PAK (1 Set 3 Dokumen) Tahunan', 'status' => 'belum'],
            ['kode' => 'G', 'nama' => 'PAK Lainnya', 'status' => 'belum'],
            ['kode' => 'H', 'nama' => 'BPE SPT Pajak – Coretax', 'status' => 'belum'],
            ['kode' => 'I', 'nama' => 'SKP Tahunan Penetapan (SKP)', 'status' => 'belum'],
            ['kode' => 'J', 'nama' => 'SKP Tahunan Penilaian (PPK)', 'status' => 'belum'],
        ],
    ];

    return view('pegawai/dashboard', $data);
}
}