
<?= $this->include('layouts/header') ?>

<!-- HEADER HALAMAN -->
<header class="page-header">
    <div class="page-heading">
        <h1>Laporan</h1>
        <p>Rekapitulasi pelaporan dokumen pegawai berdasarkan tahun dan periode.</p>
    </div>
</header>

<!-- PANEL LAPORAN -->
<section class="panel table-panel">

    <div class="panel-heading">
        <div>
            <h2>
                <i class="bi bi-file-earmark-bar-graph"></i>
                Laporan Dokumen Pegawai
            </h2>
            <p>Informasi jumlah pegawai wajib lapor, realisasi pelaporan, dan status kelengkapan dokumen.</p>
        </div>
    </div>

    <div class="p-4">

        <!-- FILTER -->
        <form action="<?= site_url('laporan') ?>" method="get"
              class="filter-form">

            <div class="filter-field">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <?php
                    $tahunTerpilih = (int) ($_GET['tahun'] ?? date('Y'));
                    foreach (range(2023, 2029) as $th):
                    ?>
                        <option value="<?= $th ?>"
                            <?= $tahunTerpilih === $th ? 'selected' : '' ?>>
                            <?= $th ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-field">
                <label for="periode">Periode</label>
                <select name="periode" id="periode" class="form-select">
                    <?php $periodeTerpilih = $_GET['periode'] ?? 'semua'; ?>
                    <option value="semua" <?= $periodeTerpilih === 'semua' ? 'selected' : '' ?>>Semua Periode</option>
                    <option value="triwulan1" <?= $periodeTerpilih === 'triwulan1' ? 'selected' : '' ?>>Triwulan I</option>
                    <option value="triwulan2" <?= $periodeTerpilih === 'triwulan2' ? 'selected' : '' ?>>Triwulan II</option>
                    <option value="triwulan3" <?= $periodeTerpilih === 'triwulan3' ? 'selected' : '' ?>>Triwulan III</option>
                    <option value="triwulan4" <?= $periodeTerpilih === 'triwulan4' ? 'selected' : '' ?>>Triwulan IV</option>
                </select>
            </div>

            <button type="submit" class="btn-apply">
                <i class="bi bi-funnel-fill"></i>
                Terapkan
            </button>

        </form>

        <!-- INFORMASI PERIODE DAN AKSI -->
        <div class="report-toolbar">
            <div class="report-period">
                <span class="report-period-label">Periode laporan</span>
                <strong>
                    Tahun <?= esc($tahunTerpilih) ?> ·
                    <?php
                    $namaPeriode = [
                        'semua' => 'Semua Periode',
                        'triwulan1' => 'Triwulan I',
                        'triwulan2' => 'Triwulan II',
                        'triwulan3' => 'Triwulan III',
                        'triwulan4' => 'Triwulan IV'
                    ];
                    echo esc($namaPeriode[$periodeTerpilih] ?? 'Semua Periode');
                    ?>
                </strong>
            </div>

            <div class="report-actions">
                <button type="button" class="btn-report btn-export" onclick="exportLaporanCSV()">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    Export CSV
                </button>

                <button type="button" class="btn-report btn-print" onclick="window.print()">
                    <i class="bi bi-printer"></i>
                    Cetak Laporan
                </button>
            </div>
        </div>

        <!-- TABEL LAPORAN -->
        <div class="table-responsive mt-3" id="areaLaporan">
            <table class="table monitoring-table" id="tabelLaporan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis Dokumen</th>
                        <th>Total Wajib Lapor</th>
                        <th>Sudah Melapor</th>
                        <th>Belum Melapor</th>
                        <th>Kemajuan</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $dokumen = [
                        'SKP Tahunan – Penetapan',
                        'SKP Periodik',
                        'SKP Tahunan – Penilaian',
                        'SKP Tahunan – Dokumen Evaluasi',
                        'Laporan Pekerjaan Pimpinan',
                        'PAK (1 Set 3 Dokumen) Tahunan',
                        'PAK Lainnya',
                        'BPE SPT Pajak – Coretax (di Simpeg)',
                        'SKP Tahunan Penetapan (SKP, di Simpeg)',
                        'SKP Tahunan Penilaian (PPK, di Simpeg)',
                    ];
                    ?>

                    <?php foreach ($dokumen as $index => $nama): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($nama) ?></td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>
                                <div class="table-progress">
                                    <div class="progress-track">
                                        <div class="progress-bar-empty"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-label">Belum ada data</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="report-footnote">
            <i class="bi bi-info-circle"></i>
            Data laporan ditampilkan berdasarkan tahun dan periode yang dipilih.
        </div>

    </div>
</section>

<footer class="page-footer">
    SIPEDOK — Sistem Informasi Pelaporan Dokumen Pegawai
</footer>

<style>
.report-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-top: 25px;
    padding: 15px 17px;
    background: #f7f9fc;
    border: 1px solid #edf1f5;
    border-radius: 10px;
}

.report-period {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.report-period-label {
    color: #8793a3;
    font-size: 11px;
}

.report-period strong {
    color: #183b56;
    font-size: 13px;
}

.report-actions {
    display: flex;
    gap: 9px;
}

.btn-report {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 9px 13px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.btn-export {
    color: #218566;
    background: #e9f7f1;
    border: 1px solid #d5eee3;
}

.btn-export:hover {
    background: #d9f0e6;
}

.btn-print {
    color: #fff;
    background: #173d59;
    border: 1px solid #173d59;
}

.btn-print:hover {
    background: #245573;
}

.report-footnote {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-top: 16px;
    color: #8994a3;
    font-size: 11px;
}

@media(max-width: 576px) {
    .report-toolbar {
        align-items: flex-start;
        flex-direction: column;
    }

    .report-actions {
        width: 100%;
    }

    .btn-report {
        flex: 1;
    }
}

@media print {
    .sidebar,
    .page-footer,
    .filter-form,
    .report-actions,
    .report-footnote {
        display: none !important;
    }

    .report-toolbar {
        background: white;
        border: none;
        padding: 10px 0;
    }

    .panel {
        box-shadow: none !important;
        border: none !important;
    }

    body {
        background: white !important;
    }
}
</style>

<script>
function exportLaporanCSV() {
    const table = document.getElementById('tabelLaporan');
    const rows = table.querySelectorAll('tr');

    let csv = [];

    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');

        const data = Array.from(cells).map(cell => {
            let value = cell.innerText.trim().replace(/\s+/g, ' ');
            return '"' + value.replace(/"/g, '""') + '"';
        });

        csv.push(data.join(';'));
    });

    const csvContent = '\uFEFF' + csv.join('\n');
    const blob = new Blob([csvContent], {
        type: 'text/csv;charset=utf-8;'
    });

    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);

    link.href = url;
    link.download = 'Laporan_SIPEDOK_<?= esc($tahunTerpilih) ?>.csv';

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    URL.revokeObjectURL(url);
}
</script>

<?= $this->include('layouts/footer') ?>
