<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pelaporan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // ==========================================
    // DAFTAR JENIS DOKUMEN
    // ==========================================

    private function daftarDokumen()
    {
        return [
            'A' => 'SKP Tahunan - Penetapan',
            'B' => 'SKP Periodik',
            'C' => 'SKP Tahunan - Penilaian',
            'D' => 'SKP Tahunan - Dokumen Evaluasi',
            'E' => 'Laporan Pekerjaan Pimpinan',
            'F' => 'PAK (1 Set 3 Dokumen) Tahunan',
            'G' => 'PAK Lainnya',
            'H' => 'BPE SPT Pajak - Coretax',
            'I' => 'SKP Tahunan Penetapan (SKP)',
            'J' => 'SKP Tahunan Penilaian (PPK)'
        ];
    }

    // ==========================================
    // MENAMPILKAN HALAMAN PELAPORAN
    // ==========================================

    public function index()
    {
        if (session()->get('role') !== 'pegawai') {
            return redirect()->to('/login');
        }

        $nip = session()->get('nip');

        $laporan = $this->db->table('laporan_dokumen')
            ->where('nip', $nip)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'judul' => 'Pelaporan Dokumen',
            'dokumen' => $this->daftarDokumen(),
            'laporan' => $laporan,
            'activeTab' => $this->request->getGet('tab') ?? 'form'
        ];

        return view('pegawai/pelaporan', $data);
    }

    // ==========================================
    // MENYIMPAN LAPORAN DOKUMEN
    // ==========================================

    public function simpan()
    {
        if (session()->get('role') !== 'pegawai') {
            return redirect()->to('/login');
        }

        $kode = strtoupper(trim(
            $this->request->getPost('kode_dokumen') ?? ''
        ));

        $tahun = trim(
            $this->request->getPost('tahun') ?? ''
        );

        $periode = trim(
            $this->request->getPost('periode') ?? ''
        );

        $link = trim(
            $this->request->getPost('link_onedrive') ?? ''
        );

        $pembetulan = $this->request->getPost('pembetulan');

        $statusPengesahan = $this->request->getPost(
            'status_pengesahan'
        );

        $daftarDokumen = $this->daftarDokumen();

        // --------------------------------------
        // VALIDASI JENIS DOKUMEN
        // --------------------------------------

        if (!isset($daftarDokumen[$kode])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jenis dokumen tidak valid.');
        }

        // --------------------------------------
        // VALIDASI TAHUN
        // --------------------------------------

        if (
            !ctype_digit($tahun) ||
            !in_array((int) $tahun, range(2023, 2029), true)
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tahun dokumen tidak valid.');
        }

        // --------------------------------------
        // VALIDASI PERIODE
        // --------------------------------------

        $periodeValid = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
            'Triwulan 1',
            'Triwulan 2',
            'Triwulan 3',
            'Triwulan 4',
            'Tahunan'
        ];

        if (!in_array($periode, $periodeValid, true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Periode dokumen tidak valid.');
        }

        // --------------------------------------
        // VALIDASI LINK ONEDRIVE
        // --------------------------------------

        $urlValid = filter_var($link, FILTER_VALIDATE_URL);
        $host = $urlValid ? strtolower(parse_url($link, PHP_URL_HOST)) : '';

        $linkDiizinkan = false;

        if ($host !== '') {
            $linkDiizinkan =
                $host === '1drv.ms' ||
                $host === 'www.1drv.ms' ||
                $host === 'onedrive.live.com' ||
                $host === 'www.onedrive.live.com' ||
                preg_match('/(^|\.)sharepoint\.com$/i', $host);
        }

        if (
            !$urlValid ||
            strtolower(parse_url($link, PHP_URL_SCHEME) ?? '') !== 'https' ||
            !$linkDiizinkan
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Masukkan tautan OneDrive atau SharePoint yang valid.');
        }

        // --------------------------------------
        // VALIDASI PEMBETULAN
        // --------------------------------------

        if (
            $pembetulan === null ||
            !in_array((string) $pembetulan, ['0', '1', '2', '3', '4'], true)
        ) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Pilih tingkat pembetulan 0 sampai 4.');
        }

        // --------------------------------------
        // VALIDASI STATUS PENGESAHAN
        // --------------------------------------

        $statusValid = [
            'Sudah Disahkan',
            'Belum Disahkan'
        ];

        if (!in_array($statusPengesahan, $statusValid, true)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Status pengesahan tidak valid.');
        }

        // --------------------------------------
        // SIMPAN DATA KE DATABASE
        // --------------------------------------

        $dataLaporan = [
            'user_id' => session()->get('user_id'),
            'nip' => session()->get('nip'),
            'kode_dokumen' => $kode,
            'nama_dokumen' => $daftarDokumen[$kode],
            'tahun' => (int) $tahun,
            'periode' => $periode,
            'link_onedrive' => $link,
            'pembetulan' => (int) $pembetulan,
            'status_pengesahan' => $statusPengesahan,
            'status_verifikasi' => 'Menunggu Verifikasi'
        ];

        $simpan = $this->db->table('laporan_dokumen')
            ->insert($dataLaporan);

        if (!$simpan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Laporan gagal disimpan. Silakan coba kembali.');
        }

        return redirect()->to('/pegawai/pelaporan?tab=riwayat')
            ->with('success', 'Dokumen berhasil dilaporkan.');
    }

    // ==========================================
    // RIWAYAT PELAPORAN
    // ==========================================

    public function riwayat()
    {
        if (session()->get('role') !== 'pegawai') {
            return redirect()->to('/login');
        }

        return redirect()->to('/pegawai/pelaporan?tab=riwayat');
    }
}
