<?php

namespace App\Controllers;
use App\Models\DokumenModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $tahun = (int) ($this->request->getGet('tahun') ?? 2026);

        if ($tahun < 2023 || $tahun > 2029) {
            $tahun = 2026;
        }

        $periode = $this->request->getGet('periode') ?? 'semua';

        $daftarPeriode = [
            'semua',
            'triwulan1',
            'triwulan2',
            'triwulan3',
            'triwulan4',
        ];

        if (! in_array($periode, $daftarPeriode, true)) {
            $periode = 'semua';
        }

        $model = new DokumenModel();

        $data = [
            'judul' => 'SIPEDOK',
            'tahun' => $tahun,
            'periode' => $periode,

            'ringkasan' => [
                'total' => 0,
                'sudah' => 0,
                'belum' => 0,
                'persentase' => 0,
            ],

            'dokumen' => $model->daftarDokumen(),
            'tahunGrafik' => range(2023, 2029),
            'dataGrafik' => [0, 0, 0, 0, 0, 0, 0],
        ];

        return view('dashboard/index', $data);
    }
}