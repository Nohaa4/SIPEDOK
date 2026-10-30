```php
<?= $this->include('layouts/header') ?>

<style>
.monitoring-page {
    padding: 28px;
    background: #f4f7fb;
    min-height: calc(100vh - 70px);
    color: #173653;
}

.monitoring-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 16px;
    margin-bottom: 24px;
}

.monitoring-heading .eyebrow {
    color: #7188a2;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
}

.monitoring-heading h1 {
    font-size: 29px;
    font-weight: 750;
    margin: 0 0 7px;
    color: #153653;
}

.monitoring-heading p {
    color: #7a8fa7;
    font-size: 13px;
    margin: 0;
}

.monitoring-back {
    border: 1px solid #cbd9e8;
    color: #315575;
    background: white;
    padding: 8px 13px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 12px;
    white-space: nowrap;
}

.monitoring-notice {
    display: flex;
    align-items: center;
    gap: 13px;
    background: #edf6ff;
    border: 1px solid #d6e7f8;
    padding: 13px 15px;
    border-radius: 7px;
    margin-bottom: 18px;
}

.monitoring-notice .notice-icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
    display: grid;
    place-items: center;
    border-radius: 50%;
    background: #d5eafa;
    color: #3978a7;
    font-size: 12px;
    font-weight: 700;
}

.monitoring-notice strong {
    display: block;
    font-size: 12px;
    margin-bottom: 3px;
}

.monitoring-notice p {
    margin: 0;
    color: #718aa5;
    font-size: 11px;
}

.monitoring-card {
    background: white;
    border: 1px solid #e0e8f0;
    border-radius: 9px;
    padding: 22px 19px;
    box-shadow: 0 2px 8px rgba(24, 55, 84, .025);
}

.monitoring-card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 18px;
}

.monitoring-card-head h2 {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 7px;
}

.monitoring-card-head p {
    font-size: 11px;
    color: #8295aa;
    margin: 0;
}

.monitoring-filters {
    display: flex;
    gap: 10px;
}

.monitoring-filter label {
    display: block;
    font-size: 10px;
    color: #71849a;
    margin-bottom: 5px;
}

.monitoring-filter select {
    min-width: 130px;
    height: 37px;
    padding: 0 10px;
    border: 1px solid #d6e0eb;
    border-radius: 5px;
    background: white;
    color: #294765;
    font-size: 12px;
}

.monitoring-table-wrap {
    overflow-x: auto;
}

.monitoring-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
    min-width: 720px;
}

.monitoring-table thead {
    background: #f1f5f8;
}

.monitoring-table th {
    color: #58718b;
    font-weight: 500;
    font-size: 10px;
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid #e1e9f0;
}

.monitoring-table td {
    padding: 12px;
    border-bottom: 1px solid #e7edf3;
    color: #3d5b78;
    vertical-align: middle;
}

.monitoring-table tbody tr:hover {
    background: #fafcff;
}

.document-code {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 18px;
    height: 20px;
    background: #edf3f8;
    color: #316b9b;
    border-radius: 4px;
    font-weight: 700;
    font-size: 10px;
}

.progress-cell {
    min-width: 155px;
}

.progress-number {
    display: block;
    font-weight: 600;
    color: #183a59;
    margin-bottom: 5px;
}

.progress-track {
    width: 150px;
    height: 6px;
    background: #eaf0f4;
    border-radius: 10px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    border-radius: 10px;
}

.status-pill {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 10px;
    white-space: nowrap;
}

.status-pill::before {
    content: "";
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
    background: currentColor;
}

.status-complete {
    color: #21865a;
    background: #e5f6ed;
}

.status-progress {
    color: #c47a15;
    background: #fff3df;
}

.status-near {
    color: #d34b53;
    background: #ffebec;
}

.btn-view-employee {
    display: inline-block;
    text-decoration: none;
    border: 1px solid #c5d8eb;
    color: #315e86;
    background: white;
    padding: 7px 11px;
    border-radius: 5px;
    white-space: nowrap;
    font-size: 10px;
}

.btn-view-employee:hover,
.monitoring-back:hover {
    background: #edf5fc;
    color: #1b4f79;
}

.monitoring-empty {
    padding: 30px !important;
    text-align: center;
    color: #8295aa !important;
}

@media (max-width: 768px) {
    .monitoring-page {
        padding: 18px 12px;
    }

    .monitoring-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .monitoring-heading h1 {
        font-size: 24px;
    }

    .monitoring-card {
        padding: 16px 12px;
    }

    .monitoring-filters {
        width: 100%;
    }

    .monitoring-filter {
        flex: 1;
        min-width: 0;
    }

    .monitoring-filter select {
        width: 100%;
        min-width: 0;
    }
}
</style>

<?php
$dokumenMonitoring = [
    ['kode' => 'A', 'nama' => 'SKP Tahunan – Penetapan', 'progres' => 92],
    ['kode' => 'B', 'nama' => 'SKP Periodik', 'progres' => 68],
    ['kode' => 'C', 'nama' => 'SKP Tahunan – Penilaian', 'progres' => 84],
    ['kode' => 'D', 'nama' => 'SKP Tahunan – Dokumen Evaluasi', 'progres' => 44],
    ['kode' => 'E', 'nama' => 'Laporan Pekerjaan Pimpinan', 'progres' => 100],
    ['kode' => 'F', 'nama' => 'PAK (1 Set 3 Dokumen) Tahunan', 'progres' => 75],
    ['kode' => 'G', 'nama' => 'PAK Lainnya', 'progres' => 55],
    ['kode' => 'H', 'nama' => 'BPE SPT Pajak – Coretax (di Simpeg)', 'progres' => 80],
    ['kode' => 'I', 'nama' => 'SKP Tahunan Penetapan (SKP, di Simpeg)', 'progres' => 100],
    ['kode' => 'J', 'nama' => 'SKP Tahunan Penilaian (PPK, di Simpeg)', 'progres' => 60],
];

$tahunDipilih = (string) (service('request')->getGet('tahun') ?? date('Y'));
$statusDipilih = (string) (service('request')->getGet('status') ?? '');
?>

<div class="monitoring-page">
    <div class="monitoring-heading">
        <div>
            <div class="eyebrow">PENGELOLAAN DATA</div>
            <h1>Monitoring Dokumen</h1>
            <p>Kemajuan pelaporan untuk setiap jenis dokumen</p>
        </div>

        <a href="<?= site_url('dashboard') ?>" class="monitoring-back">
            &larr; Kembali ke dashboard
        </a>
    </div>

    <section class="monitoring-card">
        <div class="monitoring-card-head">
            <div>
                <h2>Daftar Jenis Dokumen</h2>
                <p>Gunakan filter untuk meninjau data.</p>
            </div>

            <form method="get" action="<?= site_url('monitoring-dokumen') ?>"
                  class="monitoring-filters">
                <div class="monitoring-filter">
                    <label for="filter-tahun">Tahun</label>
                    <select id="filter-tahun" name="tahun" onchange="this.form.submit()">
                        <?php for ($t = (int) date('Y') - 2; $t <= (int) date('Y') + 1; $t++): ?>
                            <option value="<?= $t ?>" <?= $tahunDipilih === (string) $t ? 'selected' : '' ?>>
                                <?= $t ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="monitoring-filter">
                    <label for="filter-status">Status</label>
                    <select id="filter-status" name="status" onchange="this.form.submit()">
                        <option value="" <?= $statusDipilih === '' ? 'selected' : '' ?>>Semua Status</option>
                        <option value="complete" <?= $statusDipilih === 'complete' ? 'selected' : '' ?>>Lengkap</option>
                        <option value="near" <?= $statusDipilih === 'near' ? 'selected' : '' ?>>Hampir selesai</option>
                        <option value="progress" <?= $statusDipilih === 'progress' ? 'selected' : '' ?>>Dalam proses</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="monitoring-table-wrap">
            <table class="monitoring-table">
                <thead>
                    <tr>
                        <th style="width: 7%">Kode</th>
                        <th style="width: 32%">Jenis Dokumen</th>
                        <th style="width: 25%">Kemajuan</th>
                        <th style="width: 17%">Warna Status</th>
                        <th style="width: 19%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $jumlahTampil = 0;
                    foreach ($dokumenMonitoring as $dokumen):
                        $progres = $dokumen['progres'];

                        if ($progres >= 100) {
                            $status = 'complete';
                            $labelStatus = 'Lengkap';
                            $warna = '#2879c7';
                        } elseif ($progres >= 80) {
                            $status = 'near';
                            $labelStatus = 'Hampir selesai';
                            $warna = '#248d59';
                        } else {
                            $status = 'progress';
                            $labelStatus = 'Dalam proses';
                            $warna = '#d9a126';
                        }

                        if ($statusDipilih !== '' && $statusDipilih !== $status) {
                            continue;
                        }

                        $jumlahTampil++;
                    ?>
                    <tr>
                        <td><span class="document-code"><?= esc($dokumen['kode']) ?></span></td>
                        <td><?= esc($dokumen['nama']) ?></td>
                        <td>
                            <div class="progress-cell">
                                <span class="progress-number"><?= $progres ?>%</span>
                                <div class="progress-track">
                                    <div class="progress-fill"
                                         style="width: <?= $progres ?>%; background: <?= $warna ?>;"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-pill status-<?= esc($status) ?>">
                                <?= esc($labelStatus) ?>
                            </span>
                        </td>
                        <td>
                            <a class="btn-view-employee"
                               href="<?= site_url('data-pegawai') ?>">
                                Lihat pegawai &rarr;
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if ($jumlahTampil === 0): ?>
                    <tr>
                        <td colspan="5" class="monitoring-empty">
                            Tidak ada dokumen untuk status yang dipilih.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<?= $this->include('layouts/footer') ?>
```